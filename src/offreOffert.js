
import { uGetJson, pPost } from './request';
import { paypalVoidWorkflow, paypalCaptureWorkflow } from './helper';

// move this to a constant.js file
export async function main() {

    $("button[name='refuser']").on("click", async event => {
        // void payment

        const btnClicked = event.delegateTarget;
        let offreId = $("#offreId").val();
        let userId = btnClicked.value;

        paypalVoidWorkflow(userId, offreId);
    });

    $("button[name='accepter']").on("click", async event => {
        // capture payment

        const btnClicked = event.delegateTarget;
        let offreId = $("#offreId").val();
        let userId = btnClicked.value;

        paypalCaptureWorkflow(userId, offreId);
    });
}




