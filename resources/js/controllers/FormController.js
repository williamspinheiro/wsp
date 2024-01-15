import { SpinnerController } from './SpinnerController';

export class FormController {
    
    constructor(modules) {

        this.forms = document.querySelectorAll('form.form-request');
        this.spinner = new SpinnerController;
        this.modules = modules;

        if (this.forms)
            this.init(this);
    }

    init(self) {

        this.forms.forEach(form => {

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                self.spinner.show();

                let formData = new FormData(event.target);
                let properties = [ ...new Set(Array.from(formData.keys())) ];
                let header = {};
                let ax = null;

                self.clearErrors(this, properties);

                if (this.hasAttribute('export'))
                    header = { responseType: 'blob' };

                if (this.getAttribute('method') == 'DELETE')
                    ax = axios.delete(this.getAttribute('action'), formData);
                else
                    ax = axios.post(this.getAttribute('action'), formData);

                ax.then(response => {

                        self.export(this, response);

                        if (response.data.status == 'success') {
                            $(document).Toasts('create', {
                                        class: 'bg-success-default',
                                        title: 'Ação executada com sucesso.',
                                        body: `${ response.data.message }`,
                                        icon: 'fa-solid fa-check',
                                        delay: 6000,
                                        autohide: true,
                                        animation: true,
                                    });

                            self.redirect(this, response);
                            self.closeModal(this, response);
                            self.reloadTable(this);

                            console.log(response.data)
                        }
                        
                    }).catch(errors => {
                        console.error(errors.response);

                        if (errors.response && errors.response.data.errors)
                            Object.keys(errors.response.data.errors).forEach(property => {
                                
                                    self.defineError(form, errors.response.data.errors, property);
                                });
                        else if (errors.response.data.message)
                            $(document).Toasts('create', {
                                class: 'bg-danger-default',
                                title: 'Os dados fornecidos são inválidos.',
                                body: `&nbsp; ${ errors.response.data.message }`,
                                icon: 'fa-solid fa-xmark',
                                delay: 6000,
                                autohide: true,
                                animation: true,
                            });
                        else
                            alert('Os dados fornecidos são inválidos.');
                    }).then(response => {
                        self.spinner.hide();
                    });
            }, true);
        });
    }

    reloadTable (form) {

        if (form.hasAttribute('table') == false)
            return;

        let table = $( form.getAttribute('table') ).DataTable();
        table.ajax.reload().responsive.recalc();
    }

    closeModal(form, response) {
        if (form.hasAttribute('modal') == false)
            return;

        $(form.getAttribute('modal')).modal('hide');
    }

    redirect(form, response) {
        if (response.data.options && response.data.options.redirect_to) {
            let state = {
                            Title: 'Edição',
                            Url: response.data.options.redirect_to,
                        };
            window.history.pushState(state, state.Title, state.Url);
            
            let properties = [ ...new Set(Array.from(new FormData(form).keys())) ];

            if (properties.includes('id') == false) {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id';
                input.value = response.data.response.id;
                form.appendChild(input)
            }
        } else if (response.data.options && response.data.options.redirect) {
            window.location.href = response.data.options.redirect;
        }
    }

    clearErrors(form, properties) {

        properties.forEach (property => {
            let input = form.querySelector(`[name="${ property }"]`);

            if (input && input.classList.contains('is-invalid'))
                input.classList.remove('is-invalid');
        })
    }

    defineError(form, errors, property) {

        let input = form.querySelector(`[name="${ property }"]`);

        if (input) {
            let div = document.createElement('div');
            div.classList.add('invalid-feedback');
            div.innerText = errors[property];

            if (input.classList.contains('is-invalid') == false)
                input.classList.add('is-invalid')
            
            if (!input.parentNode.querySelector('div.invalid-feedback'))
                input.parentNode.appendChild(div)
        }

        $(document).Toasts('create', {
            class: 'bg-danger-default',
            title: 'Os dados fornecidos são inválidos.',
            body: `&nbsp; ${ errors[property] }`,
            icon: 'fa-solid fa-xmark',
            delay: 6000,
            autohide: true,
            animation: true,
        });
    }

    export(form, response) {

        if (form.hasAttribute('export')) {

            let type = form.getAttribute('export');
            const fileName = response.headers['content-disposition'].match(/filename=(.+)/);

            if (type == 'pdf') {
                window.open(window.URL.createObjectURL(new Blob([response.data], {type: 'application/pdf'})))
            } else if (type == 'excel') {               
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(new Blob([response.data]));
                link.download = fileName[1];
                document.body.appendChild(link);
                link.click();
                link.remove();
            }
        }
    }
}