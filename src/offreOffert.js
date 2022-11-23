
import { uGetJson, pPost } from './request';
import { getPaypalToken, getPaypalOrderDetails } from './helper';
import { DATA_MAPPER, BASE_URL } from './constants';

// move this to a constant.js file
const PAYPAL_BASE_URL = "https://api-m.sandbox.paypal.com";

export async function main() {
    const getDemandesOffres = async (idOffre, idUsager) => { // put this in its own helper file/class
        let demandes = await uGetJson(BASE_URL + "/DemandeOffre/userDemande?" + `IdOffre=${idOffre}&IdUsager=${idUsager}`, 1, 1000);

        console.debug(demandes);

        return demandes;
    }

    const getAuthorizationIdFromOrder = async (token, orderId) => {

        // get authorization id
        let orderDetail = await getPaypalOrderDetails(token, orderId);
        let authorizationId = orderDetail.purchase_units[0].payments.authorizations[0].id; // no need to iterate through authorization payments since we only have on type of item, but could be more dynamic

        return authorizationId;
    };

    const capturePaypalPaymentAuthorization = async (token, authorizationId) => {

    };

    const voidPaypalPaymentAuthorization = async (token, authorizationId) =>
        await pPost(PAYPAL_BASE_URL + `/v2/payments/authorizations/${authorizationId}/void`, token);


    $("button[name='refuser']").on("click", async event => {

        const btnClicked = event.delegateTarget;
        let offreId = $("#offreId").val();
        let userId = btnClicked.value;

        // get information about demande
        let myDemande = await getDemandesOffres(offreId, userId);
        if (myDemande == null)
            return;

        let paypalTokenResponse = await getPaypalToken(
            "AV4HNPW8uvWfXoYHp_Y87XxThHgavnPD4sMPCIRsqLh7q4fwlDLz5jElXH0x21ISF2mYHctp7FuClCF_",
            "EKQmfFtUip_NECPdXT1LMyYZhzBTr8FhkwMjtbP0HaH389dtPt_0PYzaVGWEckkWM6wulTHDFqSK8dUn"
        );
        let paypalToken = paypalTokenResponse.access_token;
    
        let orderAuthId = await getAuthorizationIdFromOrder(paypalToken, myDemande.orderId);
        console.debug(`OrderAuthId=${orderAuthId}`);
        
        await voidPaypalPaymentAuthorization(paypalToken, orderAuthId)
    });


}




