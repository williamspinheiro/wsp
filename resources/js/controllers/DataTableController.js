import { TableView } from '../views/TableView';
import 'datatables.net-responsive-bs4';

export class DataTableController {

    constructor() {

        this._table = document.querySelector('#table-default');
        this._tables = document.querySelectorAll('.data-table-default')

        if (this._table)
            this.init();

        if (this._tables)
            this.initTables()

        this.showBsTab();
        this.showBsCollapse();
    }

    initTables() {

        this._tables.forEach(table => {
            this._table = table;

            this._form = document.querySelector(table.getAttribute('filter-selector'));

            this._tableDefault = new TableView( this._table, this._form );
    
            this._setButtonsFilter()
        });
    }

    init() {

        this._form = document.querySelector('#filter-form');
        this._tableDefault = new TableView( this._table, this._form );

        this._setButtonsFilter()
    }

    _setButtonsFilter () {

        let btnFilter = document.querySelector('#btn-filter');
        let btnClearForm = document.querySelector('#btn-clear');

        if ( btnFilter )
            btnFilter.addEventListener('click', () => {
                this._tableDefault.loadTable( this );
            });

        if ( btnClearForm )
            btnClearForm.addEventListener('click', () => {
                if ( this._form )
                    this.clearForm();
            });
    }

    dropTable () {
        let table = $( this._table ).DataTable();
        table.destroy();
    }
   
   clearForm () {
        let inputs = this._form.querySelectorAll('input, select');
        let hasValue = false;

        for( var i=0; i<inputs.length; i++ ){
            let option = inputs[i].querySelectorAll('option');

            if( inputs[i].getAttribute('type') != 'hidden' ){

                if( inputs[i].value.length > 0 )
                    hasValue = true;

                if( option )
                    $(inputs[i]).val('').trigger('change');
                else
                    inputs[i].value = '';
            }
        }

        if( hasValue == true )
            this._tableDefault.loadTable();
    }

    showBsTab () {
        $("a[data-toggle=pill]").on("shown.bs.tab", function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust()
            .responsive.recalc();
        });
    }

    showBsCollapse () {
        $(".collapse").on("shown.bs.collapse", function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust()
            .responsive.recalc();
        });
    }
}