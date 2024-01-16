import { TableCustomView } from "./TableCustomView";
import { View } from './View';
import { ReorderTable } from "../helpers/ReorderTable";
import { SpinnerController } from '../controllers/SpinnerController'

export class TableView extends View {

    constructor(table, form) {

        super();

        this._table = table;
        this._spinner = new SpinnerController();
        this._form = form;
        this._customView = new TableCustomView;
        this.reorderHelper = new ReorderTable(this._table);

        this.loadTable(this);
    }

    reloadTable (_table) {
        let table = $( this._table ).DataTable();

        if(_table)
            table = $( _table ).DataTable()

        table.ajax.reload().responsive.recalc();
    }

    loadTable ( self ) {

        this._ths = this._table.querySelectorAll('thead th');

        if ( $.fn.dataTable.isDataTable( this._table ) == false ) {
            let columns = this.createColumnsName( self._ths );
            let table = $(this._table);
            let url = this._table.getAttribute('data-url');
            let lenguage = this.lenguage;
            let reorder = this.reorderHelper.hasReorder();
            let order = ( this._table.hasAttribute('data-order-by') ) ? this._table.getAttribute('data-order-by').split(', ') : [ 0, 'desc'];

            let _table = table.DataTable({
                rowReorder: reorder,
                searching: false,
                processing: true,
                serverSide: true,
                language: lenguage,
                responsive: true,
                ajax: {
                    url: url,
                    type: "POST",
                    data :  e => {
                        return this.setfilterForm ( e );
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: columns,
                order: [parseInt(order[0]), order[1]],

                columnDefs: [ {
                    orderable: false,
                    className: '',
                    targets:   0
                } ],

                select: {
                    style:    'os',
                    selector: 'td:first-child'
                },

                createdRow: function (row, data, dataIndex) {
                    
                    self.setHighlight(row, data, dataIndex);
                },

                rowCallback: function ( row, data ) {

                    $('table').unbind('click');

                    let tds = row.querySelectorAll( 'td' );
                    let actives = row.querySelectorAll('.dt-active input');
                    let checkboxes = row.querySelectorAll('.dt-checkbox-dynamic input');

                    self.setModalsButtons(self);
                    
                    self.setConfirmAction(self);

                    self.setDeleteButtons(self);

                    self.setActivesCheckboxes(actives, self);

                    self.setCheckboxes(checkboxes)
                    
                },

                deferRender: true,

                "sDom": "<'row'<'col-md-6 col-xs-12 'l><'col-md-6 col-xs-12 toolbar-cont'f>r>t<'row'<'col-md-4 col-xs-12'i><'col-md-8 col-xs-12'p>>",
                
                initComplete: ( setting, json ) => {

                    let description = '';
                    let color = '';
                    let size = '';

                    if ( this._table.getAttribute('data-btn') ) {

                        description = this._table.getAttribute('btn-description');
                        color = this._table.getAttribute('btn-color');
                        size = this._table.getAttribute('btn-size');
                        let button = `<button type="button" class="btn ${ color } ${ size } float-right ${ this._table.getAttribute('data-btn') }"><i class="${ this._table.getAttribute('btn-icon')}"></i> ${ description }</button>`;

                        if (this._table.getAttribute('data-btn') == 'link')
                            button = `<a href="${ this._table.getAttribute('btn-url') }" class="btn ${ color } ${ size } float-right ${ this._table.getAttribute('data-btn') }"><i class="${ this._table.getAttribute('btn-icon')}"></i> ${ description }</a>`;

                        if (this._table.getAttribute('data-btn') == 'modal')
                            button = `<button type="button" 
                                            class="btn ${ color } ${ size } float-right" 
                                            data-toggle="modal" 
                                            data-target="#${ this._table.getAttribute('btn-modal') }"
                                            title="${ this._table.getAttribute('btn-title') }">
                                            <i class="${ this._table.getAttribute('btn-icon')}""></i> ${ description }
                                        </button>`;
                        
                        let div = this._table.parentNode;

                        $(div).find(".toolbar-cont").html(button);

                        if (this._table.getAttribute('data-btn') == 'export') {
                            this.exportExcel();
                        }
                    }
                },
            });

            if ( reorder ) {

                this.reorderHelper.reorderTable( _table, this._table.getAttribute('reorder-url'), this._table.getAttribute('reorder-fields').split(',') );
            }

        } else
            this.reloadTable();
    }

    setCheckboxes(checkboxes) {

        checkboxes.forEach((checkbox, i) => {

            checkbox.addEventListener('change', function() {

                if (!confirm(`Deseja realmente executar essa ação?`))
                    return;
                
                axios.post(this.getAttribute('data-url'), { ...JSON.parse(this.getAttribute('data-json')), value: this.checked })
                    .then(response => {

                        if (response.data)
                            $(document).Toasts('create', {
                                    class: 'bg-success-default',
                                    title: 'Ação executada com sucesso.',
                                    body: `&nbsp; ${ this.getAttribute('data-msg') }`,
                                    icon: 'fa-solid fa-check',
                                    delay: 6000,
                                    autohide: true,
                                    animation: true,
                                });
                        else
                            $(document).Toasts('create', {
                                class: 'bg-danger-default',
                                title: 'Ocorreu um erro!',
                                body: `&nbsp; ${ error.response.data.message }.`,
                                icon: 'fa-solid fa-xmark',
                                delay: 6000,
                                autohide: true,
                                animation: true,
                            });
                    }).catch(error => {
                        $(document).Toasts('create', {
                            class: 'bg-danger-default',
                            title: 'Ocorreu um erro!',
                            body: `&nbsp; ${ error.response.data.message }.`,
                            icon: 'fa-solid fa-xmark',
                            delay: 6000,
                            autohide: true,
                            animation: true,
                        });
                    });
            });
        });
    }

    setActivesCheckboxes(inputs, self) {

        inputs.forEach(( checkbox, i ) => {

            checkbox.addEventListener('change', function() {

                let action = (this.checked) ? ['ativar', 'ativado(a)'] : ['inativar', 'inativado(a)'];

                if (!confirm(`Deseja realmente ${ action[0] } este item?`))
                    return;
    
                self._spinner.show();

                axios.post(this.getAttribute('data-url'), {  id: this.getAttribute('data-id'), active: this.checked })
                        .then(response => {

                            this.parentNode.querySelector('label').innerText = ((this.checked) ? 'Ativo' : 'Inativo');

                            if (response.data)
                                $(document).Toasts('create', {
                                    class: 'bg-success-default',
                                    title: 'Ação executada com sucesso.',
                                    body: `&nbsp; ${ this.getAttribute('data-msg') } ${ action[1] } com sucesso!`,
                                    icon: 'fa-solid fa-check',
                                    delay: 6000,
                                    autohide: true,
                                    animation: true,
                                });
                            else
                                $(document).Toasts('create', {
                                    class: 'bg-danger-default',
                                    title: 'Ocorreu um erro!',
                                    body: `&nbsp; ${ error.response.data.message }.`,
                                    icon: 'fa-solid fa-xmark',
                                    delay: 6000,
                                    autohide: true,
                                    animation: true,
                                });
                        }).catch(error => {
                            this.checked = true;
                            $(document).Toasts('create', {
                                class: 'bg-danger-default',
                                title: 'Ocorreu um erro!',
                                body: `&nbsp; ${ error.response.data.message }.`,
                                icon: 'fa-solid fa-xmark',
                                delay: 6000,
                                autohide: true,
                                animation: true,
                            });
                        }).then(response => self._spinner.hide());
            })
        });
    }

    setConfirmAction(self) {

        $("table").on('click', 'a[confirm="true"]', function () {
        
            if (confirm(`${this.getAttribute('confirm-message')} ${ this.getAttribute('data-msg') }?`)) {

                self._spinner.show();

                let json = JSON.parse(this.getAttribute('data-json'));

                axios.post(this.getAttribute('url'), {  id: json[this.getAttribute('field')] })
                    .then(response => {

                        if (response.data.status == 'success')
                            $(document).Toasts('create', {
                                class: 'bg-success-default',
                                title: 'Ação executada com sucesso.',
                                body: `&nbsp; ${ response.data.message }`,
                                icon: 'fa-solid fa-check',
                                delay: 6000,
                                autohide: true,
                                animation: true,
                            });
                        else
                            $(document).Toasts('create', {
                                class: 'bg-danger-default',
                                title: 'Ocorreu um erro!',
                                body: `&nbsp; ${ response.data.message }.`,
                                icon: 'fa-solid fa-xmark',
                                delay: 6000,
                                autohide: true,
                                animation: true,
                            });

                            self.reloadTable(self.getParentTable(this, 'table'));

                    }).catch(error => {
                        this.checked = true;
                        $(document).Toasts('create', {
                            class: 'bg-danger-default',
                            title: 'Ocorreu um erro!',
                            body: `&nbsp; ${ error.response.data.message }.`,
                            icon: 'fa-solid fa-xmark',
                            delay: 6000,
                            autohide: true,
                            animation: true,
                        });
                    }).then(response => self._spinner.hide());
            }
        });
    }

    getParentTable(el, tagName) {
        tagName = tagName.toLowerCase();
      
        while (el && el.parentNode) {
          el = el.parentNode;
          if (el.tagName && el.tagName.toLowerCase() == tagName) {
            return el;
          }
        }
      
        // Many DOM methods return null if they don't 
        // find the element they are searching for
        // It would be OK to omit the following and just
        // return undefined
        return null;
      }

    setDeleteButtons(self) {

        $("table").on('click', 'a.delete', function () {
            if (confirm(`Deseja realmente remover este(a) ${ this.getAttribute('data-msg') }?`) == false)
                return

                self._spinner.show();
        
                self.removeItem(this.getAttribute('url'))
                    .then(response => {
                        $(document).Toasts('create', {
                            class: 'bg-success-default',
                            title: 'Ação executada com sucesso.',
                            body: `&nbsp; ${ this.getAttribute('data-msg') } removido(a) com sucesso.`,
                            icon: 'fa-solid fa-check',
                            delay: 6000,
                            autohide: true,
                            animation: true,
                        });
                        self.reloadTable(self.getParentTable(this, 'table'));
                    }).catch(error => {
                        $(document).Toasts('create', {
                            class: 'bg-danger-default',
                            title: 'Ocorreu um erro!',
                            body: `&nbsp; Ocorreu um erro ao remover o(a) ${ this.getAttribute('data-msg') }.`,
                            icon: 'fa-solid fa-xmark',
                            delay: 6000,
                            autohide: true,
                            animation: true,
                        });
                    }).then(response => self._spinner.hide());
        });
    }

    setModalsButtons(self) {

        $("table").on('click', 'a.modal-edit', function () {
            document.querySelector(this.getAttribute('modal-id'))
                    .setAttribute('data-json', this.getAttribute('data-json').replace(/\'/g, '’'));
                
            $(this.getAttribute('modal-id')).modal('show');
        });        
    }

    setHighlight(row, data, index) {

        let isPriority = this._table.hasAttribute('row-highlight');

        if (isPriority == true) {

            let field = this._table.getAttribute('row-highlight');
            
            if (data[field]) {

                $(row).addClass('bg-red');
            }
        }
    }
    
    exportExcel() {

        document.querySelector('.export').addEventListener('click', () => {

            this.showSpinner();

            const formData = new FormData();
            const object = this.setfilterForm( { export: true } );
            Object.keys(object).forEach(key => 
                {
                    console.log(key);
                    if(Array.isArray(object[key]) == true){
                        object[key].forEach(field => formData.append(key, field))
                    } else
                        formData.append(key, object[key])
                });

            axios.post(this._table.getAttribute('btn-url'), formData, { responseType: 'blob' })
                .then(response => {
                    
                    const type = response.headers['content-type']
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(new Blob([response.data]));
                    const fileName = response.headers['content-disposition'].match(/filename=(.+)/);
                    link.download = fileName[1];
                    document.body.appendChild(link);
                    link.click();
                    link.remove();

                }).catch( (error) => {
                    alert('Erro ao gerar excel, valide os filtros.');
                }).then(response => {
                    this.hideSpinner();
                })
        });
    }

    createColumnsName ( ths ) {
        var columns = [];

        for ( var i=0; i < ths.length; i++ ) {
            let type = ths[i].getAttribute('data-type');
            let order = ths[i].getAttribute('data-order') || true;

            if ( type ) {
                columns.push( this._customView.setCustomization( type, ths[i], this._table ) );
            } else {
                let column = ths[i].getAttribute('column');
                columns.push({ 
                                data: column, 
                                className: 'td_', 
                                class: ths[i].getAttribute('data-class'), 
                                orderable: String(order) == 'true' 
                            });
            }
        }

        return columns;
    }

    get lenguage () {
        
        return  {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        };
    }

    setfilterForm ( _obj ) {

        if( !this._form )
            return Object.assign( {}, _obj, {'_token': document.querySelector('[name="_token"]').value} );

        let inputs = this._form.querySelectorAll('input, select');

        let obj = {};

        for ( var i = 0; i < inputs.length; i++ ) {

            if ( !inputs[i].getAttribute('name') )
                continue;
            
            let key = inputs[i].getAttribute('name').replace('filter-', '');

            if (!key.includes('[]'))
                obj[key] = inputs[i].value;
            else {

                if (inputs[i].hasAttribute('multiple') == false){
                    if (typeof(obj[key]) != "object") 
                        obj[key] = [];

                    obj[key].push(inputs[i].value);
                } else {
                    obj[key] = $(inputs[i]).val();
                }
            }
        }

        return Object.assign({}, _obj, obj );
    }

}