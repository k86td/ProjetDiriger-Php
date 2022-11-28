
import { pGetJson, uPostBasicAuth, uGetJson, pPost } from './request';
import { BASE_URL } from './constants';

export async function GetTemplate(template_url) {
    // store templates by path in session storage to save request

    const template_path = template_url;
    const template = await fetch(template_path)
        .then(async response => await response.text());

    // console.debug(`[HELPER:GetTemplate] Template src: ${template}`);

    return template;
}

export function SetStorageJson(key, json) {
    sessionStorage.setItem(key, JSON.stringify(json));
}

export function GetStorageJson(key) {
    return JSON.parse(sessionStorage.getItem(key));
}

export function JqueryDateFormat(date) {

    if (!(date instanceof Date))
        date = new Date(date);

    let year = date.getFullYear();
    let month = date.getMonth() + 1;
    let day = date.getDate().toString().padStart(2, "0");

    return `${year}-${month}-${day}`;
}

export function getCurrentPositionAsync() {
    return new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(
            pos => resolve(pos),
            err => reject(err));
    });
}

export function parseCoordinate(coords) {
    coords = coords.split(/, ?/);
    return {
        lat: parseFloat(coords[0]),
        lng: parseFloat(coords[1])
    };
}

// move this to a constant.js file
const PAYPAL_BASE_URL = "https://api-m.sandbox.paypal.com";

export async function getPaypalToken (user, pass) {
    return await uPostBasicAuth(PAYPAL_BASE_URL + "/v1/oauth2/token", user, pass);
}

export async function getPaypalOrderDetails (token, orderId) {
    return await pGetJson(PAYPAL_BASE_URL + "/v2/checkout/orders/" + orderId, token);
}

// deprecated
export async function paypalDemandeOffreOrderAuthenticationWorkflow (userId, offreId, callback) {
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

    console.debug(`Paypal Worflow. userId:${userId}, offreId:${offreId}, callback:${typeof callback}`);

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

    console.debug("Running callback...");
    callback(paypalToken, orderAuthId);
}

// TODO upgrade
export async function paypalVoidWorkflow (userId, offreId) {
    const getDemandesOffres = async (idOffre, idUsager) => { // put this in its own helper file/class
        let demandes = await uGetJson(BASE_URL + "/DemandeOffre/userDemande?" + `IdOffre=${idOffre}&IdUsager=${idUsager}`, 1, 1000);

        console.debug(demandes);

        return demandes;
    }

    const getAuthorizationIdFromOrder = async (token, orderId) => {

        // get authorization id
        let orderDetail = await getPaypalOrderDetails(token, orderId);

        console.debug(orderDetail);

        let authorizationId = orderDetail.purchase_units[0].payments.authorizations[0].id; // no need to iterate through authorization payments since we only have on type of item, but could be more dynamic

        return authorizationId;
    };

    console.debug(`Paypal Void Worflow. userId:${userId}, offreId:${offreId}, callback:${typeof callback}`);

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

    const voidPaypalPaymentAuthorization = async (token, authorizationId) =>
        await pPost(PAYPAL_BASE_URL + `/v2/payments/authorizations/${authorizationId}/void`, token);
    
    voidPaypalPaymentAuthorization(paypalToken, orderAuthId);
}

// TODO upgrade
export async function paypalCaptureWorkflow (userId, offreId) {
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

    console.debug(`Paypal Capture Worflow. userId:${userId}, offreId:${offreId}, callback:${typeof callback}`);

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

    const capturePaypalPaymentAuthorization = async (token, authorizationId) =>
        await pPost(PAYPAL_BASE_URL + `/v2/payments/authorizations/${authorizationId}/capture`, token);

    capturePaypalPaymentAuthorization(paypalToken, orderAuthId);
}