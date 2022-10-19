// js file for /location.php

import * as $ from 'jquery';
import * as Mustache from 'mustache';

const BASE_URL = 'https://localhost:7103/api';

async function test () {
    const url1 = 'http://localhost:8000/templates/test.mustache';
    const response = await fetch(url1);
    const data = await response.text();


    console.log(mustache.Mustache.render(data, { "test": "This is a test string" }));
    
}
test();

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
        },30000);
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

function main() {
    // get TypeOffre
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
        let typeCategoriesSelected = $("input:checked[type='checkbox'][name='type-filter']");
        let categoriesSelected = $("input:checked[type='checkbox'][name='categories-filter']");
       
        typeCategoriesSelected = $.map(typeCategoriesSelected, t => "typeId=" + t.value);
        categoriesSelected = $.map(categoriesSelected, c => "categorieId=" + c.value);

        typeCategoriesSelected;
        categoriesSelected;

        queryString = "?" + typeCategoriesSelected.concat(categoriesSelected).join("&");
        LoadMainContent(queryString, defaultCardMaker);
    });
            
    // Get main content
    LoadMainContent("", defaultCardMaker);
}

window.addEventListener('load', main)