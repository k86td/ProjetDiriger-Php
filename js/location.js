// js file for /location.php

const BASE_URL = 'https://localhost:7103/api';

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
    var payload = await $.ajax({
        url: BASE_URL + "/Voiture",
        type: 'GET'
    });

    console.log(JSON.stringify(payload));

    return `<div class="card" style="width: 18rem;"><div class="card-body"><h3 class="card-title">${j.nom}</h3><p>${j.prix}$ / jour</p></div></div>`;
}

const LoadMainContent = async (queryString = "", makerFunc) => {
    if (makerFunc == undefined) {
        console.log("LoadMainContent.makeFunc cannot be undefined!");
        throw new Error("makerFunc cannot be undefined");
    }

    const parser = async (json) => {
        return await Promise.all(json.map(async j => {
            var payload = await $.ajax({
                url: BASE_URL + "/Voiture/" + j["id"],
                type: 'GET'
            });

            let description = "";
            if (payload !== undefined) {
                description = `<a href="offre.php?id=${j["id"]}">Description</a>`;
            }

            return `<div class="card" style="width: 18rem;"><div class="card-body"><h3 class="card-title">${j["nom"]}</h3><p>${j["prix"]}$ / jour</p><br>${description}</div></div>`;
        }));
    };


    
    const DATA_PATH = ".main-content";
    const API_PATH = "https://localhost:7103/api/Offre";

    $.get(API_PATH + queryString, async function(data) {
        let parsedData = await parser(data);

        console.log(JSON.stringify(parsedData));

        $(DATA_PATH).html(parsedData);
    })
    .fail(function () {
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