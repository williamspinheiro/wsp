import Axios from "axios";

export class View {

    constructor() {
        
    }

    removeItem(url) {
        return Axios.delete(url);
    }

    showSpinner() {

        let spinner = document.querySelector('#spinner-global');

        if (spinner && spinner.classList.contains('d-none')) {
            spinner.classList.remove('d-none');
        }
    }

    hideSpinner() {
        let spinner = document.querySelector('#spinner-global');

        if (spinner && !spinner.classList.contains('d-none')) {
            spinner.classList.add('d-none');
        }
    }
}