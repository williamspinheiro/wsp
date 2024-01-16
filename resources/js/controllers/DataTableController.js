import { TableView } from '../views/TableView';
import { FormHelper } from '../helpers/FormHelper';
import 'datatables.net-responsive-bs4';
import 'datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css';

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

            this.formHelper = new FormHelper(this._form);

            this._tableDefault = new TableView( this._table, this._form );
    
            this._setButtonsFilter()
        });
    }

    init() {

        this._form = document.querySelector('#filter-form');
        this._tableDefault = new TableView( this._table, this._form );

        this.formHelper = new FormHelper(this._form);

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
                    this.formHelper.clearForm(() => { this._tableDefault.loadTable(this) });
            });
    }

    dropTable () {
        let table = $( this._table ).DataTable();
        table.destroy();
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