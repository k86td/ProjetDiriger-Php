// define global constants here

export const DATA_MAPPER = {
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
            "coordonner": elem.coordonner,
            "image": elem.image
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

export const BASE_URL = 'https://localhost:7103/api';
export const TEMPLATE_BASE_URL = "http://localhost:8000";
