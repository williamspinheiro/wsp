export class SpinnerController {

    constructor() {
        this.spinner = document.querySelector('#spinner-global');
    }

    show() {

        if (this.spinner && this.spinner.classList.contains('d-none'))
            this.spinner.classList.remove('d-none');
    }

    hide() {

        if (this.spinner && !this.spinner.classList.contains('d-none'))
            this.spinner.classList.add('d-none');
    }
}