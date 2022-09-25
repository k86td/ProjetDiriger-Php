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
        mappingFunc
    );
};

const mappingFunc = (d) => {
    let label = `<label for="type_${d.id}">${d.nom}</label>`;
    let checkbox = `<input name="type-filter" type="checkbox" id="type_${d.id}" value="${d.id}">`;

    return [label, checkbox];
}

function main() {
    // get TypeOffre
    GenCheckboxFromApi("https://localhost:7103/api/TypeOffre", 
    ".type-categorie-content", 
    mappingFunc,
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
       
            
    // Get main content
}

window.addEventListener('load', main)