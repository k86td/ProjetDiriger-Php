
import { uPostBasicAuth } from './request';

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

export async function getPaypalToken (user, pass) {
    let paypalToken = await uPostBasicAuth("https://api-m.sandbox.paypal.com/v1/oauth2/token", user, pass);
    return paypalToken;
}