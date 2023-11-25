import { DualListbox } from 'dual-listbox';

export class DualBoxController {

    constructor(selector) {

        let hasSelect = document.querySelector(selector);

        if (!hasSelect)
            return;
        
        let dualListbox = new DualListbox(selector, {
                                    addEvent: function (value) {
                                        // Should use the event listeners
                                        console.log(value);
                                        
                                    },
                                    removeEvent: function (value) {
                                        // Should use the event listeners
                                        console.log(value);
                                    },
                                    searchPlaceholder: 'Pesquisar',
                                    availableTitle: 'Não selecionados',
                                    selectedTitle: 'Selecionados',
                                    addButtonText: ">",
                                    removeButtonText: "<",
                                    addAllButtonText: ">>",
                                    removeAllButtonText: "<<",
                                
                                    sortable: true,
                                    upButtonText: "ᐱ",
                                    downButtonText: "ᐯ",
                                
                                    draggable: true,
                                
                                    options: this.getSelected(hasSelect),
                                });
    }

    getSelected(select) {

        let selecteds = [];
        let selectedIds = JSON.parse(select.getAttribute('selecteds'));

        Array.prototype.forEach.call(select.options, (option, i) => {
            
            if (selectedIds.includes(parseInt(option.value)))
                select.options[i].setAttribute('selected', 'selected');
        });

        return selecteds;
    }
}