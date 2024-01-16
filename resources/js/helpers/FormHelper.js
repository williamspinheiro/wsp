export class FormHelper {

    constructor(form) {
        this._form = form;
    }
    
    clearForm (callback) {

        let inputs = this._form.querySelectorAll('input, select');
        let hasValue = false;

        for( var i=0; i<inputs.length; i++ ){
            let option = inputs[i].querySelectorAll('option');

            if( inputs[i].getAttribute('type') != 'hidden' ){

                if( inputs[i].value.length > 0 )
                    hasValue = true;

                if( option ){
                    $(inputs[i]).val(null).trigger('change');
                    const event = new Event('change');
                    inputs[i].dispatchEvent(event);
                } else
                    inputs[i].value = '';
            }
        }

        if( hasValue == true && typeof callback == 'function')
            try{ callback(); } catch(err) { console.error(err) };
    }
}