
import { main as mainLocation } from './location';
import { main as mainOffre } from './offreOffert';

let currentUrl = document.URL;
if (currentUrl.includes("location.php")) {
    window.addEventListener('load', mainLocation)
}
else if (currentUrl.includes("offreOfferts.php")) {
    window.addEventListener('load', mainOffre);
}
