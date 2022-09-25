// js file for /location.php

const GenCheckboxFromApi = (endpoint, dataPath, mappingFunc, additionalFunc) => {
    $.get(endpoint, function (data) {
        // convert data to html format
        data = data.map(mappingFunc);

        $(dataPath).html("");

        data.forEach(e => {
            $(dataPath).append(e[0]);
            $(dataPath).append(e[1]);
        });

        if (additionalFunc != undefined)
            additionalFunc();
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
    let label = `<label for="${filterName}_${d.id}">${d.nom}</label>`;
    let checkbox = `<input name="${filterName}-filter" type="checkbox" id="${filterName}_${d.id}" value="${d.id}">`;

    return [label, checkbox];
}

const LoadMainContent = (queryString = "") => {
    const parser = (json) => {
        return json.map(j => {
            console.log(j);
           return `<div class="uk-card uk-card-default"><h3 class="uk-card-title">${j.nom}</h3><div class="uk-card-body"><p>${j.prix}$ / jour</p></div></div>`;
        });
    };
    
    const DATA_PATH = ".main-content";
    const API_PATH = "https://localhost:7103/api/Offre";

    $.get(API_PATH + queryString, function(data) {
        let parsedData = parser(data);

        console.log(parsedData);

        $(DATA_PATH).html(parsedData);
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
            })
            
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
        LoadMainContent(queryString);
    });
            
    // Get main content
    LoadMainContent();
}

window.addEventListener('load', main)