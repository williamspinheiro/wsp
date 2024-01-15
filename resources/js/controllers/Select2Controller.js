export class Select2Controller {

    constructor(selector) {

        this._selects = document.querySelectorAll(selector);
        this._multiple = false;
        this._tags = false;
        this._type_of_search = 'name';
        this._id = 'id';

        if (this._selects)
            this.init();

            this.initMultiselect();

            this.initSelect();

            this.initSelectClear();
    }

    initMultiselect() {
        $('.select-multiple').select2({ 
            multiple: true, 
            closeOnSelect: false, 
            scrollAfterSelect: true,
            width: '100%',
            language: "pt-BR",
            containerCssClass: "select2-orange-red",
            dropdownCssClass: "select2-orange-red"
        });
    }

    initSelect() {
        $('.select-research').select2({ 
            placeholder: "Selecione",
            multiple: false, 
            closeOnSelect: true, 
            scrollAfterSelect: true,
            width: '100%',
            language: "pt-BR",
            containerCssClass: "select2-orange-red",
            dropdownCssClass: "select2-orange-red"
        }).on('select2:select', function (e) {
            const event = new Event('change');
            e.currentTarget.dispatchEvent(event);
        });   
    }

    initSelectClear() {
        $('.select-research-clear').select2({ 
            placeholder: "Selecione",
            multiple: false, 
            closeOnSelect: true, 
            scrollAfterSelect: true,
            width: '100%',
            language: "pt-BR",
            allowClear: true,
            containerCssClass: "select2-orange-red",
            dropdownCssClass: "select2-orange-red"
        }).on('select2:select', function (e) {
            const event = new Event('change');
            e.currentTarget.dispatchEvent(event);
        });   
    }

    init() {

        document.addEventListener ( 'DOMContentLoaded', event => {

            this._selects.forEach(select => {     
                
                let method = select.getAttribute('method') ?? 'GET';

                if (method == 'GET')
                    this.get(select);
                else
                    this.post(select);
            });

        });
    }

    post(select) {

        $(select).select2({
            placeholder: 'Selecione',
            minimumInputLength: 3,
            dataType: 'json',
            language: "pt-BR",
            multiple: select.hasAttribute('multiple'),
            allowClear: true,
            tags: select.getAttribute('tags'),
            delay: 250,
            dataSrc: "",
            width: '100%',
            containerCssClass: "select2-orange-red",
            dropdownCssClass: "select2-orange-red",
            ajax: {
                url: params => {
                     return select.getAttribute('url');
                },
                type: "POST",
                dataType: 'json',
                contentType:"application/json; charset=utf-8",
                headers: {
                    'X-CSRF-Token': $('[name="_token"]').val(),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                data: terms => {
                   
                    let params = { name: terms.term };

                    if (select.hasAttribute('filter-regions') == true) 
                        params.ragions = this.getPermissionValues(select.getAttribute('filter-regions'), true);

                    if (select.getAttribute('filter-squares') == true)
                        params.squares = this.getPermissionValues(select.getAttribute('filter-squares'), true);

                    return (JSON.stringify(params));
                },
                processResults: (data, params) => {

                    return {
                        results: $.map(data.data, item => {
                            return this.getReturn( select.getAttribute('data-term') ?? 'name', item, select)
                        })
                    };
                },
                cache: true
            }
        }).on( "change", function(e) {
            var st = $(this).select2('val');
            var text = e.currentTarget.textContent;

            var input = document.querySelector(this.getAttribute('selector-text'));

            if ( input )
                input.value = text.trim();
        });
    }

    get(select) {

        $(select).select2({
            placeholder: 'Selecione',
            minimumInputLength: 3,
            dataType: 'json',
            language: "pt-BR",
            multiple: select.hasAttribute('multiple'),
            allowClear: true,
            tags: select.getAttribute('tags'),
            delay: 250,
            dataSrc: "",
            width: '100%',
            containerCssClass: "select2-orange-red",
            dropdownCssClass: "select2-orange-red",
            ajax: {
                url: params => {
                     return `/${ select.getAttribute('url') }/${ params.term }`;
                },
                data: params => {
                    return {
                        term: params,
                    };
                },
                processResults: (data, params) => {
                    return {
                        results: $.map(data.data, item => {
                            return this.getReturn( select.getAttribute('data-type') ?? 'name', item, select )
                        })
                    };
                },
                cache: true
            }
        }).on( "change", function(e) {
            var st = $(this).select2('val');
            var text = e.currentTarget.textContent;

            var input = document.querySelector(this.getAttribute('selector-text'));

            if ( input )
                input.value = text.trim();
        });
    }

    
    getPermissionValues(json, onlyJson = false) {
        
        let permission = JSON.parse(json);

        if (onlyJson)
            return Object.values(permission);

        if (permission.allowed.length > 0) 
            return Object.values(permission.allowed)
        
        return Object.values(permission.not_allowed);
    }

    getReturn ( type = 'name', item, select ) {
		return { text: item[type], id: item[select.getAttribute('data-id') ?? 'id'] }
	}

}