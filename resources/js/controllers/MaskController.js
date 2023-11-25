export class MaskController {

    constructor(selector) {
        this.inputs = document.querySelectorAll(selector);

        if (this.inputs.length > 0)
            this.inputs.forEach(input => {
                this.init(input);
            });
    }

    init(el) {

        this.el = el;

        if (this.el) {
            this.applyMaxLength(this.el.getAttribute('mask-type'));
            
            el.addEventListener('input', input => {
                input.target.value = this.applyMask(input.target.value, input.target.getAttribute('mask-type'))
            });
        }
    }

    applyMaxLength(type) {
        switch (type) {
            case 'cpf': 
                this.el.setAttribute('maxlength', 14);
                break;

            case 'taxvat':
                this.el.setAttribute('maxlength', 18);
                break;

            case 'phone':
                this.el.setAttribute('maxlength', 15);
                break;

            case 'zipcode':
                this.el.setAttribute('maxlength', 9);
                break;
                
            case 'credit-card':
                this.el.setAttribute('maxlength', 19);
                break;

            case 'money':
                this.el.setAttribute('maxLength', 20);
                break;

            case 'security-code':
                this.el.setAttribute('maxLength', 3);
                break;

            case 'card-expiring-date':
                this.el.setAttribute('maxLength', 2);
        }
    }

    applyMask(value, type) {

        switch (type) {
            case 'cpf':
            case 'taxvat':
                value = value.replace(/\D/g, '');
                if (value.length <= 11) value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, '$1.$2.$3-$4');
                else value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/g, '$1.$2.$3/$4-$5');
                break;

            case 'phone':
                value = value.replace(/\D/g, '');
                if (value.length <= 8) value = value.replace(/(\d{4})(\d{4})/g, '$1-$2');
                else if (value.length == 9) value = value.replace(/(\d{5})(\d{4})/g, '$1-$2');
                else if (value.length == 10) value = value.replace(/(\d{2})(\d{4})(\d{4})/g, '($1) $2-$3');
                else if (value.length == 11) value = value.replace(/(\d{2})(\d{5})(\d{4})/g, '($1) $2-$3');
                break;

            case 'card-expiring-date':
                value = value.replace(/\D/g, '');
                if (value.length <= 2) value = value.replace(/(\d{2})/g, '$1');
                break;

            case 'security-code':
                value = value.replace(/\D/g, '');
                if (value.length <= 3) value = value.replace(/(\d{3})/g, '$1');
                break;

            case 'zipcode':
                value = value.replace(/\D/g, '');
                value = value.replace(/(\d{5})(\d{3})/g, '$1-$2');
                break;
            
            case 'money':
                value = value.replace('.', '').replace(',', '').replace(/\D/g, '')
                const options = { minimumFractionDigits: 2 }
                value = new Intl.NumberFormat('pt-BR', options).format( parseFloat(value) / 100);
                break;

            case 'credit-card':
                value = value.replace(/\D/g, '');
                if (value.length === 13) value = value.replace(/(\d{1})(\d{4})(\d{4})(\d{4})/g, '$1.$2.$3.$4');
                else if (value.length == 14) value = value.replace(/(\d{4})(\d{6})(\d{4})/g, '$1.$2.$3');
                else if (value.length == 15) value = value.replace(/(\d{5})(\d{4})(\d{5})(\d{1})/g, '$1.$2.$3.$4');
                else if (value.length == 16) value = value.replace(/(\d{4})(\d{4})(\d{4})(\d{4})/g, '$1.$2.$3.$4');

                break;
        }

        return value;
    }

}