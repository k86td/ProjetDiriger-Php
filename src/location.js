// js file for /location.php

import TimeAgo from 'javascript-time-ago';
import fr from 'javascript-time-ago/locale/fr';
import { uGetJson, pGetJson, pPostJson, pDelete } from './request';
import { GetTemplate, JqueryDateFormat } from './helper';
const Mustache = require('mustache');
import { Toast } from 'bootstrap';

TimeAgo.addDefaultLocale(fr);
const timeAgo = new TimeAgo("fr");

const BASE_URL = 'https://localhost:7103/api';
const TEMPLATES_PATH = {
    "erreur": "http://localhost:8000/templates/erreur.mustache",
    "offres": "http://localhost:8000/templates/offres.mustache",
    "basicToast": "http://localhost:8000/templates/basic_toast.mustache"
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
            "dateDebut": new Date(elem.dateDebut).toISOString(),
            "dateFin": new Date(elem.dateFin).toISOString(),
            "prix": elem.prix
        };
    },
    "demandesOffres": function (elem) {
        /*
        {"idOffre":5,"idUsager":1,"date":"2022-10-04T17:15:32.6333333","accepter":false}
        */

        return {
            "idOffre": elem.idOffre,
            "accepter": elem.accepter,
            "button": {
                "name": elem.accepter ? "cancelLocation" : "cancelRequest",
                "texte": elem.accepter ? "Annuler la location" : "Annuler la demande",
            }
        };
    }
}

async function RenderOffres(querySelector = ".main-content") {

    let template = await GetTemplate(TEMPLATES_PATH.offres);

    const _data = {};
    let connected = false;

    let user_token = $("#user_token").val();
    if (user_token !== undefined && user_token !== "")
        connected = true;

    const getOffres = async () => {
        let offres = await uGetJson(BASE_URL + "/Offre", 1, 10000);
        console.debug(`[LOCATION] Offres: ${JSON.stringify(offres)}`)
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

    let offres = await getOffres();


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
        _data["erreur"] = "Impossible d'acceder aux offres"
    }
    else {
        _data.offres = offres;
        console.debug(`[LOCATION] Offres: ${JSON.stringify(_data)}`);
    }

    _data.connected = connected;

    var templateHtml = Mustache.render(template, _data)
    $(querySelector).html(templateHtml);

    // set the events handlers if connected
    if (connected) {
        const newDemandeOffreModal = document.getElementById('newDemandeOffreModal');
        newDemandeOffreModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget

            // get the button data
            let offreId = button.getAttribute("data-bs-offreid");
            let dateDebut = button.getAttribute("data-bs-offredatedebut");
            let dateFin = button.getAttribute("data-bs-offredatefin");


            // update the modal content 

            // 1- set min/max of the date picker
            const datePicker = $("#newDemandeOffreModal_Dates");
            datePicker.attr("min", JqueryDateFormat(dateDebut));
            datePicker.attr("max", JqueryDateFormat(dateFin));
            datePicker.attr("value", JqueryDateFormat(Date.now()));

            // 2- set the offre id in the modal
            $("#newDemandeOffreModal_Id").val(offreId);

        });

        $('input[name="range_datepicker"]').daterangepicker();

        $('#sendRequest').click(event => { // envoyer demande de location

            let offreId = $("#newDemandeOffreModal_Id").val();
            let chosenDate = $("#newDemandeOffreModal_Dates").val();

            const api_path = "/Offre/Rent/" + offreId;

            $("#newDemandeOffreModal_Dates").val(JqueryDateFormat(Date.now()));
            $("#newDemandeOffreModal_Id").val("");

            pPostJson(BASE_URL + api_path, user_token, { "Date": chosenDate }, 1, 10000, _ => {
                RenderOffres();
            });
        });

        $("button[name='cancelRequest']").on('click', event => { // annuler demande de location
            let offreId = event.target.id.split("_")[1];

            console.debug("OffreId is " + offreId);

            const api_path = "/Offre/Rent/" + offreId;

            pDelete(BASE_URL + api_path, user_token, 1, 10000, _ => {
                RenderOffres();
            });
        });
    } else {
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
RenderOffres();

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

export function main() {
    // get TypeOffre

    // GenCheckboxFromApi("https://localhost:7103/api/TypeOffre",
    //     ".type-categorie-content",
    //     mappingFunc("type"),
    //     _ => {
    //         // add event listener
    //         let chk = $("input[type='checkbox'][name='type-filter']")

    //         chk.click(_ => {
    //             let selectedIds = "";
    //             let checked = $("input[type='checkbox'][name='type-filter']")
    //                 .filter(":checked");

    //             let checkedIds = $.map(checked, c => {
    //                 return c.value;
    //             });

    //             RefreshCategoryOffre(checkedIds);
    //         });
    //     });

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
