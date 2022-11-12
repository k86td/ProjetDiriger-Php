// js file for /location.php

import TimeAgo from 'javascript-time-ago';
import fr from 'javascript-time-ago/locale/fr';
import { uGetJson, pGetJson, pPostJson, pDelete, pPutJson } from './request';
import { GetTemplate, JqueryDateFormat, getCurrentPositionAsync, parseCoordinate } from './helper';
const Mustache = require('mustache');
import { Toast } from 'bootstrap';
import $ from 'jquery';
import loadGoogleMapsApi from 'load-google-maps-api';
import { faCar } from '@fortawesome/free-solid-svg-icons';
import { loadScript } from "@paypal/paypal-js";

TimeAgo.addDefaultLocale(fr);
const timeAgo = new TimeAgo("fr");


const BASE_URL = 'https://localhost:7103/api';
const TEMPLATE_BASE_URL = "http://localhost:8000";
const TEMPLATES_PATH = {
    "erreur": TEMPLATE_BASE_URL + "/templates/erreur.mustache",
    "offres": TEMPLATE_BASE_URL + "/templates/offres.mustache",
    "basicToast": TEMPLATE_BASE_URL + "/templates/basic_toast.mustache",
    "locationFilter": TEMPLATE_BASE_URL + "/templates/location_filter.mustache"
}
const DATA_MAPPER = {
    "offres": function (elem) {
        /*
        {"id":3,"nom":"Jeep Wrangler","idVendeur":1,"prix":130,"date":"2022-10-04T17:39:52.7266667",
        "coordonner":"+73,-23","idCategorieOffre":null,"idTypeOffre":1}
        */

        return {
            "id": elem.id,
            "nom": elem.nom,
            "idVendeur": elem.idVendeur,
            "dateDebut": new Date(elem.dateDebut).toISOString(),
            "dateFin": new Date(elem.dateFin).toISOString(),
            "prix": elem.prix,
            "coordonner": elem.coordonner
        };
    },
    "demandesOffres": function (elem) {
        /*
        {"idOffre":5,"idUsager":1,"date":"2022-10-04T17:15:32.6333333","accepter":false}
        */

        let templatePayload = {
            "idOffre": elem.idOffre,
            "accepter": elem.accepter,
        };

        if (elem.accepter) {
            templatePayload['button'] = {
                "name": "cancelLocation",
                "texte": "Annuler la location",
                "date": elem.date
            };
        }
        else {
            templatePayload['shortDate'] = elem.date.split("T")[0];
            templatePayload['editButton'] = {
                "name": "editRequest",
                "texte": "Modifier la demande de location",
                "iconClass": "bi bi-pencil-square"
            };
            templatePayload['button'] = {
                "name": "cancelRequest",
                "texte": "Annuler la demande",
                "date": elem.date
            };
        }

        return templatePayload;
    },
    "usagerPublicInfo": function (elem) {
        /*
        {"nom":"Lepine","prenom":"Tristan","email":"tristanlepine14@gmail.com","telephone":"5148828118"}
        */

        return {
            "fullName": `${elem.prenom} ${elem.nom}`
        };
    }
}

async function RenderMapFilter(querySelector = "#filterContainer", queryOptions = {}) {
    let clientPos = await getCurrentPositionAsync();
    console.debug(`[LOCATION:RenderMapFilter] Client position: lat:${JSON.stringify(clientPos.coords.latitude)} lon:${clientPos.coords.longitude}`);

    // generate the template
    let template = await GetTemplate(TEMPLATES_PATH.locationFilter);

    let templateHtml = Mustache.render(template, {
        "latitude": clientPos.coords.latitude,
        "longitude": clientPos.coords.longitude
    });

    $(querySelector).append(templateHtml);

    const currentPosition = {
        lat: parseFloat(clientPos.coords.latitude),
        lng: parseFloat(clientPos.coords.longitude)
    };

    console.debug(currentPosition);

    // fetching offres qui sont proches
    const getNearOffres = async (lat, lon, range = 10) => {
        if ("range" in queryOptions)
            range = queryOptions["range"];

        if (lat == undefined || lon == undefined || range == undefined)
            return [];

        console.debug(`Url is: ${BASE_URL}/offre?latCent=${lat}&lonCent=${lon}&range=${range}`)
        let nearOffres = await uGetJson(BASE_URL + `/offre?latCent=${lat}&lonCent=${lon}&range=${range}`);

        if (nearOffres !== undefined || nearOffres !== [])
            nearOffres = nearOffres.map(DATA_MAPPER.offres);

        return nearOffres;
    };

    // get near offres
    let nearOffres = await getNearOffres(currentPosition.lat, currentPosition.lng);
    console.debug(`[LOCATION:RenderMapFilter] Near offres: ${JSON.stringify(nearOffres)}`);

    loadGoogleMapsApi({
        key: 'AIzaSyD81DrP2OP8glBYbP9CKweHbs7cRk5W3wI'
    })
        .then(maps => {
            console.debug("[LOCATION:RenderMapFilter] Creating map")
            const filterMap = new maps.Map(document.getElementById("locationFilter_Map"), {
                center: currentPosition,
                zoom: 10
            });
            filterMap.setOptions({
                gestureHandling: "auto",
                disableDefaultUI: true,
                zoomControl: true
            });

            // set markers
            if (nearOffres !== undefined || nearOffres !== []) {

                const createMarkersAsync = async () => {

                    console.debug("Creating the markers async");
                    return new Promise((resolve, reject) => {
                        const infoWindow = new google.maps.InfoWindow();
                        nearOffres.forEach(offre => {
                            console.debug(`Creating Markers: coordinate: ${JSON.stringify(parseCoordinate(offre.coordonner))}`)

                            let carIcon = {
                                fillColor: "#0d6efd",
                                scale: 0.050,
                                fillOpacity: 1,
                                anchor: new google.maps.Point(
                                    faCar.icon[0] / 2,
                                    faCar.icon[1]
                                ),
                                strokeColor: "#0d6efd",
                                path: faCar.icon[4]
                            }

                            const marker = new maps.Marker({
                                position: parseCoordinate(offre.coordonner),
                                title: offre.nom,
                                map: filterMap,
                                icon: carIcon
                            });

                            marker.addListener("click", () => {
                                infoWindow.close();
                                infoWindow.setContent(marker.getTitle());
                                infoWindow.open(marker.getMap(), marker);
                            });
                        });

                        resolve();
                    });
                };

                createMarkersAsync();
            }

            // set circle
            const createRadiusCircle = async () => {
                return new Promise((resolve, reject) => {
                    const circle = new google.maps.Circle({
                        strokeColor: "#0d6efd",
                        strokeOpacity: 0.8,
                        strokeWeight: 1,
                        fillColor: "#0d6efd",
                        fillOpacity: 0.2,
                        map: filterMap,
                        center: currentPosition,
                        radius: "range" in queryOptions ? queryOptions["range"] : 10000
                    });

                    // set handler
                    $("#locationFilter_Range").on("input", async event => {
                        let radius = event.target.value;

                        circle.setRadius(radius * 1000);
                    });

                    resolve();
                });
            };
            createRadiusCircle();

            // set render handler
            $("#locationFilter_Submit").on("click", _ => {
                let rangeValue = $("#locationFilter_Range").val();

                RenderOffres(
                    ".main-content",
                    `?latCent=${currentPosition.lat}&lonCent=${currentPosition.lng}&range=${rangeValue}`
                );
            });

        })
        .catch(e => {
            console.error(`Got an error while creating the map`);
            console.error(e);
        });
}

async function RenderOffres(querySelector = ".main-content", queryString = "") {

    // TODO add icons to see if the offer was paid or not

    let template = await GetTemplate(TEMPLATES_PATH.offres);

    const _data = {};
    let connected = false;

    let user_token = $("#user_token").val();
    if (user_token !== undefined && user_token !== "")
        connected = true;

    const getOffres = async (queryString) => {
        let offres = await uGetJson(BASE_URL + "/Offre" + queryString, 1, 10000);

        if (offres !== undefined)
            offres = offres.map(DATA_MAPPER.offres);

        console.debug("[LOCATION:RenderOffres] Offre (with potential mapper): " + JSON.stringify(offres));
        return offres;
    }

    const getDemandesOffres = async () => {
        let demandes = await pGetJson(BASE_URL + "/DemandeOffre", user_token, 1, 1000);
        if (demandes !== undefined)
            demandes = demandes.map(DATA_MAPPER.demandesOffres);

        return demandes;
    }

    const appendUsagerPublicInfo = async (offres) => {
        if (offres == undefined)
            return;

        for (let x = 0; x < offres.length; x++) {
            let offre = offres[x];

            let idVendeur = offre.idVendeur;

            let infoVendeur = await uGetJson(BASE_URL + "/usager/info/" + idVendeur);

            if (infoVendeur == undefined)
                continue;

            console.debug("[LOCATION:getUsagerPublicInfo] Info vendeur: " + JSON.stringify(infoVendeur));
            offre["infoVendeur"] = DATA_MAPPER.usagerPublicInfo(infoVendeur);
        }

        return offres;
    };

    let offres = await getOffres(queryString);
    offres = await appendUsagerPublicInfo(offres);

    if (connected) {
        let demandes = await getDemandesOffres();

        console.debug("[LOCATION:GetDemandes] Demandes: " + JSON.stringify(demandes));

        if (offres !== undefined && demandes !== undefined) {
            offres = offres.map(elem => {
                let demandeOffre = demandes.filter(d => d.idOffre == elem.id)[0];
                if (demandeOffre !== undefined)
                    elem.demandes = demandeOffre;

                return elem;
            });
        }
    }


    if (offres == undefined || offres.length == 0) {
        console.debug("[LOCATION:RenderOffres] Impossible to fetch offres");

        template = await GetTemplate(TEMPLATES_PATH.erreur);
        _data["erreur"] = "Il n'y a aucune offre pour les filtres que vous avez utiliser. Soit l'api est hors ligne, ou aucune offre existe avec les filtres que vous avez choisis!"
    }
    else {
        _data.offres = offres;
        console.debug(`[LOCATION] Offres: ${JSON.stringify(_data)}`);
    }

    _data.connected = connected;

    var templateHtml = Mustache.render(template, _data)

    $(querySelector).html(templateHtml);

    console.debug("Iterating inside RenderOffres");

    // set the events handlers if connected
    if (connected) {
        const newDemandeOffreModal = document.getElementById('newDemandeOffreModal');
        $("#cancelRequest").on("click", event => {
            const container = document.getElementById("paypal-button-container");
            container.innerHTML = "";
        });
        $(".louer-btn").on("click", event => {

            const button = event.delegateTarget

            // get the button data
            let offreId = button.getAttribute("data-bs-offreid");
            let dateDebut = button.getAttribute("data-bs-offredatedebut");
            let dateFin = button.getAttribute("data-bs-offredatefin");
            let prix = button.getAttribute("data-bs-prix");
            console.debug(prix);

            // update the modal content 

            // 1- set min/max of the date picker
            const datePicker = $("#newDemandeOffreModal_Dates");
            datePicker.attr("min", JqueryDateFormat(dateDebut));
            datePicker.attr("max", JqueryDateFormat(dateFin));
            datePicker.attr("value", JqueryDateFormat(Date.now()));

            // 2- set the offre id in the modal
            $("#newDemandeOffreModal_Id").val(offreId);

            // reset payment button
            $("#paypal-button-container").html("");

            loadScript({
                "client-id": "AV4HNPW8uvWfXoYHp_Y87XxThHgavnPD4sMPCIRsqLh7q4fwlDLz5jElXH0x21ISF2mYHctp7FuClCF_",
                "currency": "CAD",
                "intent": "authorize"
            })
                .then((paypal) => {
                    let payButton = paypal.Buttons({
                        style: {
                            layout: 'vertical',
                            color: 'gold',
                            tagline: false,
                            height: 40
                        },
                        createOrder: function (data, actions) {

                            let date = $("#newDemandeOffreModal_Dates").val();

                            // 3- Set up the transaction
                            return actions.order.create({
                                intent: "AUTHORIZE",
                                purchase_units: [{
                                    description: "Receipt for your location request for the " + date,
                                    amount: {
                                        currency_code: 'CAD',
                                        value: prix,
                                    }
                                }]
                            });
                        },
                        onApprove: function (data, actions) {

                            let offreId = $("#newDemandeOffreModal_Id").val();
                            let chosenDate = $("#newDemandeOffreModal_Dates").val();

                            const api_path = "/Offre/Rent/" + offreId;

                            $("#newDemandeOffreModal_Dates").val(JqueryDateFormat(Date.now()));
                            $("#newDemandeOffreModal_Id").val("");

                            pPostJson(BASE_URL + api_path, user_token, { "Date": chosenDate }, 1, 10000, _ => {
                                RenderOffres();
                            });

                            console.debug("Approving the location request, the seller must accept your request now!");

                            // close the modal
                            $(".btn-close").trigger("click");

                        }
                    });

                    payButton.render('#paypal-button-container');
                })
                .catch((err) => {
                    console.error("failed to load the PayPal JS SDK script", err);
                });
        });

        // deprecated
        // $('#sendRequest').click(event => { // envoyer demande de location

        //     let offreId = $("#newDemandeOffreModal_Id").val();
        //     let chosenDate = $("#newDemandeOffreModal_Dates").val();

        //     const api_path = "/Offre/Rent/" + offreId;

        //     $("#newDemandeOffreModal_Dates").val(JqueryDateFormat(Date.now()));
        //     $("#newDemandeOffreModal_Id").val("");

        //     pPostJson(BASE_URL + api_path, user_token, { "Date": chosenDate }, 1, 10000, _ => {
        //         RenderOffres();
        //     });
        // });

        $("button[name='cancelRequest']").on('click', event => { // annuler demande de location
            let offreId = event.target.id.split("_")[1];

            console.debug("OffreId is " + offreId);

            const api_path = "/Offre/Rent/" + offreId;

            pDelete(BASE_URL + api_path, user_token, 1, 10000, _ => {
                RenderOffres();
            });
        });

        let editDemandeOffreModal = document.getElementById("editDemandeOffreModal");
        editDemandeOffreModal.addEventListener("show.bs.modal", event => {

            let button = event.relatedTarget;

            let dateDebut = $(button).attr('data-bs-offreDateDebut');
            let dateFin = $(button).attr('data-bs-offreDateFin');
            let idOffre = $(button).attr('data-bs-offreId');
            let date = $(button).attr('data-bs-demandeOffreDate');

            // 1- set min/max of the date picker
            const datePicker = $("#editDemandeOffre_Dates");
            // should check if the min is actually between (dateDebut || Date.now) and dateFin
            datePicker.attr("min", JqueryDateFormat(dateDebut));
            datePicker.attr("max", JqueryDateFormat(dateFin));
            datePicker.attr("value", JqueryDateFormat(date));

            $("#editDemandeOffre_Id").val(idOffre);
        });

        $("#editRequest").on('click', event => {
            // gather modal data

            let idOffre = $("#editDemandeOffre_Id").val();
            let date = $("#editDemandeOffre_Dates").val();

            pPutJson(BASE_URL + "/Offre/Rent/" + idOffre, $("#user_token").val(), date, 1, 5000, _ => {
                RenderOffres();
            });
        });

        // TODO add event listener to cancel location
    } else if (offres !== undefined) {
        // if not connected send an alert saying the user is not connected
        let basicToastTemplate = await GetTemplate(TEMPLATES_PATH.basicToast);

        var toastHtml = Mustache.render(basicToastTemplate, {
            "text": "Vous n'etes pas connecter!",
            "id": "notConnectedToast"
        });
        $("#mainBody").append(toastHtml);
        new Toast(document.getElementById("notConnectedToast")).show();
    }
}

const GenCheckboxFromApi = (endpoint, dataPath, mappingFunc, additionalFunc) => {
    $.get(endpoint, function (data) {
        // convert data to html format
        data = data.map(mappingFunc);

        $(dataPath).html("");

        data.forEach(e => {
            $(dataPath).append(e);
        });

        if (additionalFunc != undefined)
            additionalFunc();
    })
        .fail(function () {
            setTimeout(function () {
                // if cannot access api, wait 30 seconds, then try to fetch again
                GenCheckboxFromApi(endpoint, dataPath, mappingFunc, additionalFunc);
            }, 30000);
        });
};

const RefreshCategoryOffre = (ids) => {
    if (ids.length == 0)
        $(".categorie-content").html("");

    ids = ids.map(i => "id=" + i);
    ids = ids.join("&");

    GenCheckboxFromApi(
        "https://localhost:7103/api/CategorieOffre/ids?" + ids,
        ".categorie-content",
        mappingFunc("categories")
    );
};

const mappingFunc = (filterName) => (d) => {
    let label = ``;
    let checkbox = `<label for="${filterName}_${d.id}"><input name="${filterName}-filter" type="checkbox" id="${filterName}_${d.id}" value="${d.id}">${d.nom}</label>`;

    return [checkbox];
}

const defaultCardMaker = async (j) => {

    // check to see if there's an offer detail for that location
    // var payload = await $.ajax({
    //     url: BASE_URL + "/Voiture",
    //     type: 'GET'
    // });
    // console.log(JSON.stringify(payload));

    // var demandeOffre = await $.ajax({
    //     url: BASE_URL + "/DemandeOffre/"
    // });

    return `<div class="card" style="width: 18rem;"><div class="card-body"><h3 class="card-title">${j.nom}</h3><p>${j.prix}$ / jour</p></div></div>`;
}

const LoadMainContent = async (queryString = "", makerFunc) => {
    if (makerFunc == undefined) {
        console.log("LoadMainContent.makerFunc cannot be undefined!");
        throw new Error("makerFunc cannot be undefined");
    }

    let user_token = $("#user_token").val();

    // this is the function that creates the cards
    const parser = async (json) => {
        return await Promise.all(json.map(async j => {
            console.debug("Debugging 'j': " + JSON.stringify(j));

            let boutonAjouterDemandeOffre = "";
            if (user_token !== undefined) {
                try {
                    var demandeOffre = await $.ajax({
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader("Authorization", "Bearer " + user_token);
                        },
                        url: BASE_URL + "/DemandeOffre/" + j["id"],
                        type: 'GET'
                    });

                    boutonAjouterDemandeOffre = `<button name="rent_button" type="buton" class="btn btn-primary" id="rent_${j["id"]}">Louer</button>`;
                    if (demandeOffre !== undefined) {
                        boutonAjouterDemandeOffre = `<button type="buton" class="btn btn-outline-primary" disabled>Deja louer</button>`;
                    }
                }
                catch {
                    console.error("Impossible to access that url. Re-login");
                }
            }

            console.log(`Result for Offre[${j["id"]}] => ${demandeOffre}`)

            var payload = await $.ajax({
                url: BASE_URL + "/Voiture/" + j["id"],
                type: 'GET'
            });

            let description = "";
            if (payload !== undefined) {
                description = `<a href="offre.php?id=${j["id"]}">Description</a>`;
            }

            return `<div id="location_${j["id"]}" class="card" style="width: 18rem;"><div class="card-body"><h3 class="card-title">${j["nom"]}</h3><p>${j["prix"]}$ / jour</p><br>${description}<br>${boutonAjouterDemandeOffre}</div></div>`;
        }));
    };

    const DATA_PATH = ".main-content";
    const API_PATH = "https://localhost:7103/api/Offre";

    $.get(API_PATH + queryString, async function (data) {
        console.debug("Got data!");

        let parsedData = await parser(data);

        // setup the handlers for all the "Louer" buttons
        $(DATA_PATH).html(parsedData);

        $("button[name='rent_button']").click(({ target }) => {
            // call api to try to rent
            $.ajax({
                type: 'POST',
                url: BASE_URL + "/Offre/Rent/" + target.id.split("_")[1], // get offre id
                beforeSend: function (xhr) {
                    xhr.setRequestHeader("Authorization", "Bearer " + user_token);
                },
                success: function () {
                    target = $("#" + target.id);
                    target.attr("disabled", true);
                    target.removeClass("btn-primary");
                    target.addClass("btn-outline-primary");
                    target.html("Deja louer");
                },
                error: function () {
                    target = $("#" + target.id);
                    target.attr("disabled", false);
                    target.removeClass("btn-primary");
                    target.addClass("btn-outline-danger");
                }
            });
        });
    })
        .fail(function () {
            console.debug("Failed to load content")
            setTimeout(function () {
                LoadMainContent(queryString, makerFunc);
            }, 10000);
        });
};

export async function main() {
    // get TypeOffre

    RenderOffres();
    RenderMapFilter();

    GenCheckboxFromApi("https://localhost:7103/api/TypeOffre",
        ".type-categorie-content",
        mappingFunc("type"),
        _ => {
            // add event listener
            let chk = $("input[type='checkbox'][name='type-filter']")

            chk.click(_ => {
                let selectedIds = "";
                let checked = $("input[type='checkbox'][name='type-filter']")
                    .filter(":checked");

                let checkedIds = $.map(checked, c => {
                    return c.value;
                });

                RefreshCategoryOffre(checkedIds);
            });
        });

    $("#btn_appliquer").click(_ => {
        let queryString = "";

        let typeCategoriesSelected = $("input:checked[type='checkbox'][name='type-filter']");
        let categoriesSelected = $("input:checked[type='checkbox'][name='categories-filter']");

        typeCategoriesSelected = $.map(typeCategoriesSelected, t => "typeId=" + t.value);
        categoriesSelected = $.map(categoriesSelected, c => "categorieId=" + c.value);

        queryString = "?" + typeCategoriesSelected.concat(categoriesSelected).join("&");

        RenderOffres(undefined, queryString == "?" ? "" : queryString);
    });

    // $("#btn_appliquer").click(_ => {
    //     let typeCategoriesSelected = $("input:checked[type='checkbox'][name='type-filter']");
    //     let categoriesSelected = $("input:checked[type='checkbox'][name='categories-filter']");

    //     typeCategoriesSelected = $.map(typeCategoriesSelected, t => "typeId=" + t.value);
    //     categoriesSelected = $.map(categoriesSelected, c => "categorieId=" + c.value);

    //     typeCategoriesSelected;
    //     categoriesSelected;

    //     queryString = "?" + typeCategoriesSelected.concat(categoriesSelected).join("&");
    //     LoadMainContent(queryString, defaultCardMaker);
    // });

    // // Get main content
    // LoadMainContent("", defaultCardMaker);
}
