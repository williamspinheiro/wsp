export class TableCustomView {

    constructor() {

    }

    setCustomization(type, th, table) {

        this._table = table;
        this._th = th;
        this._type = type;
        this._msg = table.getAttribute('data-msg')

        if (type == 'action') {
            return this.setButtons();
        } else if (type == 'active') {
            return this.setActive(th);
        } else if (type == 'date') {
            return this.setDate(th);
        } else if (type == 'icon-check') {
            return this.setIcon(th);
        } else if (type == 'reorder') {
            return this.setReorder(th);
        } else if (type == 'orderable') {
            return this.setWithOrderable(th)
        } else if (type == 'checkbox') {
            return this.setCheckbox(th)
        } else if (type == 'yes-or-not') {
            return this.setYesOrNot(th)
        } else if (type == 'service-provider-type') {
            return this.setServiceProviderType(th);
        } else if (type == 'ticket-status') {
            return this.setTicketStatus(th);
        } else if (type == 'image') {
            return this.setImage(th);
        }
    }

    setImage(th) {
        return { 
            data : th.getAttribute('column'),
            mRender: ( data, type, row, e ) => {

                    return `<img class="img-fluid" src="${ row[th.getAttribute('column')] }" />`;
                }, 
            class: 'text-center'
        }
    }

    setTicketStatus(th) {
        return { 
            data : th.getAttribute('column'),
            mRender: ( data, type, row, e ) => {

                    let types = {                                
                                    no_scheduled: 'Não agendada',
                                    started: 'Iniciada',
                                    moved: 'Movida',
                                    completed: 'Concluída',
                                    suspended: 'uspensa',
                                    canceled: 'Cancelada',
                                    rescheduled: 'Reagendada',
                                    not_done: 'Não concluída',
                                    in_progress: 'Não agendada',
                            }

                    return `${ types[row[th.getAttribute('column')]] }`;
                }, 
            class: 'text-center'
        }
    }

    setServiceProviderType(th) {

        return { 
            data : th.getAttribute('column'),
            mRender: ( data, type, row, e ) => {

                    let types = {
                                'default': 'Eletromidia',
                                'franchise': 'Franquia',
                                'outsource_company': 'Terceira',
                            }

                    return `${ types[row[th.getAttribute('column')]] }`;
                }, 
            class: 'text-center'
        }
    }

    setYesOrNot(th) {

        return { 
            data : th.getAttribute('column'),
            mRender: ( data, type, row, e ) => {

                    return `${ row[th.getAttribute('column')] ? 'Sim' : 'Não' }`;
                }, 
            class: 'text-center'
        }
    }

    setWithOrderable(th) {

        return { 
            data : th.getAttribute('column'),
            orderable: JSON.parse(th.getAttribute('orderable').toLowerCase()),
            mRender: ( data, type, row, e ) => {

                    return `${ row[th.getAttribute('column')] }`;
                }, 
            class: 'text-center'
        }
    }

    setReorder(th) {
        return { 
            data : th.getAttribute('column'),
            orderable: true,
            mRender: ( data, type, row, e ) => {

                    return `${e.row}`;
                }, 
            class: 'text-center'
        }
    }

    setIcon(th) {
        return { 
            data : th.getAttribute('column'),
            orderable: false,
            mRender: ( data, type, row, e ) => {
                    let button = '<i class="far fa-do-not-enter"></i>';

                    if (row[th.getAttribute('column')])
                        button = `<i class="fas fa-check-circle"></i>`;
                    
                    return `<center class="aired">${ button }</center>`;
                },
            class: 'text-center'
        }
    }

    setDate(th) {
        return { 
            data : th.getAttribute('column'),
            orderable: true,
            mRender: ( data, type, row, e ) => {

                    if (!row[th.getAttribute('column')])
                        return "-";

                    return moment(row[th.getAttribute('column')]).format('DD/MM/YYYY HH:mm');
                }, class: 'text-center'
        }
    }

    setButtons() {

        return { 
                data : this._th.getAttribute('column'),
                orderable: false,
                mRender: ( data, type, row, e ) => {
                    
                    if (!this._th.hasAttribute('actions'))
                        return;

                    let actions = JSON.parse(JSON.stringify(eval("(" + this._th.getAttribute('actions') + ")")));
                    let buttons = '';
                    let disabled = false;
                    let url = '';

                    actions.forEach(action => {

                        disabled = false;
                        url = action.url;

                        if (action.field && !action.is_modal)
                            url = url.replace(/\%s/g, row[action.field]);

                        buttons += this.setButton(e, url, disabled, row, action);
                    });

                    return buttons;
                }, 
                class: 'text-center'
            };
    }

    canShowButton(conditions, separator = '&&',  json) {

        if (!conditions)
            return false;
        
        let response = '';

        conditions.forEach((condition, i) => {

            if (!condition.value)
                response += `${ condition.operator }json['${ condition.field }']`;
            else
                response += `json['${ condition.field }'] ${ condition.operator } ${ condition.value }`;

            if (conditions.length > 1 && (i + 1) < conditions.length)
                response += ` ${ separator } `;
        });

        return !eval(response);
    }

    setButton (e, url, disabled = false, json = {}, action) {

        let urlAtrribute = url;
        let _class = action.class;
        let permission = action.permission ?? action.class;
        let conditions = action.conditions;
        let conditionSeparator = action.condition_separator ?? '&&';
        let modalId = action.modal_id;
        
        if (this.canShowButton(conditions, conditionSeparator, json))
            return "";

        if (!this.can(e, permission))
            return "";

        if (action.method == 'POST' || modalId)
            url = 'javascript:;';

        if (permission == 'delete' || !url)
            url = 'javascript:;'

        action.target = (action.target) ? (action.target) : '_self';

        disabled = (disabled) ? 'disabled' : '';
        
        return `<a href="${ (disabled) ? 'javascript:;' : url }" url="${ urlAtrribute }" style="color:#3d3d3d;margin-right:5px;" 
                data-json=\'${ JSON.stringify(json).replace(/\'/g, '’') }\'
                modal-id="${ modalId }"
                data-toggle="tooltip" 
                data-msg="${ this._msg }" 
                field="${ action.field }" 
                confirm="${ action.confirm }"
                confirm-message="${ action.confirm_message }"
                title="${ action.description } ${ this._msg }" 
                class="${ _class }"
                target="${ action.target }" 
                disabled="${ disabled }">
                <i class="${ action.icon } text-dark"></i></a>`;
    }

    setActive(th) {

        return { 
            data : th.getAttribute('column'),
            orderable: false,
            mRender: ( data, type, row, e ) => {

                    if (!this.can(e, 'active')) {
                        return (row.active == 1) ? "Ativo" : "Inativo";
                    }

                    let checked = '';
                    let label = '';

                    if (row.active == 1)
                        checked = 'checked="checked"';
                        label = (row.active == 1) ? "Ativo" : "Inativo"

                    return `<span class="kt-switch kt-switch--success dt-active">
                            <div class="custom-control custom-checkbox">
                            <input class="custom-control-input custom-control-input-default-color" type="checkbox" id="${ row.id }" ${ checked } data-id="${ row.id }" data-url="${ th.getAttribute('data-url') }" data-msg="${ this._msg }">
                            <label for="${ row.id }" class="custom-control-label">${ label }</label>
                            </div>
                        </span>`;
                }, 
                class: 'text-center'
        }
    }

    setCheckbox(th) {

        return { 
            data : th.getAttribute('column'),
            orderable: false,
            mRender: ( data, type, row, e ) => {

                    let columns = th.getAttribute('columns').split(',');
                    let checked = '';
                    let _data = {};

                    columns.forEach(column => {
                                _data[column] = row[column] ?? '';
                            });

                    if (row[th.getAttribute('column')] == 1)
                        checked = 'checked="checked"';

                    return `<span class="kt-switch kt-switch--success dt-checkbox-dynamic">
                            <label>
                                <input type="checkbox" ${ checked } data-json=\'${ JSON.stringify(_data) }\' data-url="${ th.getAttribute('data-url') }" data-msg="${ this._msg }">
                                <span></span>
                            </label>
                        </span>`;
                },
            class: 'text-center'
        }
    }
    
    can(e, action) {

        return e.settings.json.permissions[action] == true;
    }
}