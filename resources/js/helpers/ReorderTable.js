import Axios from "axios";

export class ReorderTable {
    
    constructor(table) {

        this.table = table;
    }
    
    hasReorder ( table ) {
        let hasReorder = this.table.getAttribute('data-reorder');

        if ( hasReorder && hasReorder == 'true' )
            return {
                update: false
            };

        return false;
    }

    reorderTable ( table, url, fields = []) {
        let self = this;

        table.on( 'row-reorder', function ( e, diff, edit ) {

            if (diff.length == 0)
                return;

            let params = { new_position: [], old_position: [] };

            fields.forEach(field => {
                params[field] = [];
            });

            for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
                let rowData = table.row( diff[i].node ).data();

                fields.forEach(field => {
                    params[field].push(rowData[field]);
                });

                params.new_position.push(diff[i].newPosition);
                params.old_position.push(diff[i].oldPosition);
            }

            Axios.post(url, params)
                .then(response => {
                    
                    if ( response.data.status == true )
                        $.notify(response.data.response, "success");
                    else
                        $.notify(response.data.response);
                }).catch(error => {
                    $.notify(response.data.response);
                });
        });
    }
}