import $ from 'jquery';

/**
 * Unprotected Get Json from a url
 * @param {string} url to access
*/
export async function uGetJson(url, retry = -1, retry_timeout = 30000, callback = undefined) {
    let data = undefined;
    
    while (data == undefined && (retry > 0 || retry == -1)) {
        data = await $.get(url, async function (data) {
            if (callback !== undefined)
                callback(data);
        })
        .catch(async _ => {
            console.error(`[REQUEST:uGetJson] Failed to access "${url}". Retry count: ${retry}`);
            retry--;
            await new Promise(r => setTimeout(r, retry_timeout));
        });
    }

    return data;
}


/**
 * Protected Get Json from a url
 * @param {string} url to access
 */
export async function pGetJson(url, bearer_token, retry = -1, retry_timeout = 30000, callback = undefined) {

    var result = undefined;
    while (result == undefined && (retry > 0 || retry == -1)) {
        result = await $.ajax({
            type: 'GET',
            url: url,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + bearer_token);
            },
            success: function (data) {
                if (callback !== undefined)
                    callback(data);

                return data;
            },
            error: async function () {
                console.error(`[REQUEST:pGetJson] Failed to access "${url}". Retry count: ${retry}`);
                retry--;
                await new Promise(r => setTimeout(r, retry_timeout));
            }
        })
            .catch(_ => {
                console.error(`[REQUEST:pGetJson] Failed to access "${url}". Retry count: ${retry}`);
            });
    }

    return result;
}

/**
 * Protected Post Json to a url
 * @param {string} url to access
 */
export async function pPostJson(url, bearer_token, body, retry = -1, retry_timeout = 30000, callback = undefined) {

    var result = undefined;
    while (result == undefined && (retry > 0 || retry == -1)) {
        result = await $.ajax({
            type: 'POST',
            url: url,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + bearer_token);
                xhr.setRequestHeader("Content-Type", "application/json");
            },
            success: function (data) {
                if (callback !== undefined)
                    callback(data);

                return data;
            },
            data: JSON.stringify(body),
            error: async function () {
                console.error(`[REQUEST:pPostJson] Failed to access "${url}". Retry count: ${retry}`);
                retry--;
                await new Promise(r => setTimeout(r, retry_timeout));

            }
        })
            .catch(_ => {
                console.error(`[REQUEST:pPostJson] Failed to access "${url}". Retry count: ${retry}`);
            });
    }

    return result;
}

/**
 * Protected Post Json to a url w/o body
 * @param {string} url to access
 */
 export async function pPost(url, bearer_token, retry = -1, retry_timeout = 30000, callback = undefined) {

    var result = undefined;
    result = await $.ajax({
        type: 'POST',
        url: url,
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + bearer_token
        },
        // beforeSend: function (xhr) {
        //     xhr.setRequestHeader("Authorization", "Bearer " + bearer_token);
        //     xhr.setRequestHeader("Content-Type", "application/json");
        // },
        success: function (data) {
            if (callback !== undefined)
                callback(data);

            return data;
        },
        error: async function () {

            console.error(`[REQUEST:pPost] Failed to access "${url}". Retry count: ${retry}`);
            retry--;
            await new Promise(r => setTimeout(r, retry_timeout));

        }
        })
            .catch(e => {
                console.error(e);
                console.error(`[REQUEST:pPost] Failed to access "${url}". Retry count: ${retry}`);
            });

    console.debug(result);
    return result;
}

/**
 * Protected Delete to a url
 * @param {string} url to access
 */
 export async function pDelete(url, bearer_token, retry = -1, retry_timeout = 30000, callback = undefined) {

    var result = undefined;
    while (result == undefined && (retry > 0 || retry == -1)) {
        result = await $.ajax({
            type: 'DELETE',
            url: url,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + bearer_token);
            },
            success: function (data) {
                if (callback !== undefined)
                    callback(data);

                return data;
            },
            error: async function () {
                console.error(`[REQUEST:pDelete] Failed to access "${url}". Retry count: ${retry}`);
                retry--;
                await new Promise(r => setTimeout(r, retry_timeout));

            }
        })
            .catch(_ => {
                console.error(`[REQUEST:pDelete] Failed to access "${url}". Retry count: ${retry}`);
            });
    }

    return result;
}

/**
 * Protected Put Json to a url
 * @param {string} url to access
 */
 export async function pPutJson(url, bearer_token, body, retry = -1, retry_timeout = 30000, callback = undefined) {

    var result = undefined;
    while (result == undefined && (retry > 0 || retry == -1)) {
        result = await $.ajax({
            type: 'PUT',
            url: url,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + bearer_token);
                xhr.setRequestHeader("Content-Type", "application/json");
            },
            data: JSON.stringify(body),
            success: function (data) {
                if (callback !== undefined)
                    callback(data);

                return data;
            },
            error: async function () {
                console.error(`[REQUEST:pPut] Failed to access "${url}". Retry count: ${retry}`);
                retry--;
                await new Promise(r => setTimeout(r, retry_timeout));

            }
        })
            .catch(_ => {
                console.error(`[REQUEST:pPut] Failed to access "${url}". Retry count: ${retry}`);
            });
    }

    return result;
}

export async function uPostBasicAuth (url, username, password, retry = -1, retry_timeout = 30000) {

    var result = undefined;
    while (result == undefined && (retry > 0 || retry == -1)) {
        result = await $.ajax({
            type: 'POST',
            url: url,
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Basic " + btoa(`${username}:${password}`));
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            },
            data: {
                "grant_type": "client_credentials"
            },
            success: function (data) {

                return data;
            },
            error: async function () {
                console.error(`[REQUEST:uPostBasicAuth] Failed to access "${url}". Retry count: ${retry}`);
                retry--;
                await new Promise(r => setTimeout(r, retry_timeout));

            }
        })
            .catch(_ => {
                console.error(`[REQUEST:uPostBasicAuth] Failed to access "${url}". Retry count: ${retry}`);
            });
    }

    return result;
}