class DatatableUI{
    static init({selector, columnList, columnDef = [], url = '', buttons = [], label = false}){

        $(''+ selector +' thead tr').clone(true).appendTo(''+ selector +' thead');
        $(''+ selector +' thead tr:eq(1) th').each(function (i) {
            var title = $(this).text();
            $(this).html('<input type="text" class="form-control form-control-sm" placeholder="Search ' + title + '" />');

            $('input', this).on('keyup change', function () {
                if (dt_filter.column(i).search() !== this.value) {
                    dt_filter.column(i).search(this.value).draw();
                }
            });
        });

        var dt_filter = $(selector).DataTable({
            serverSide: true,
            processing: true,
            lengthChange:true,
            ajax: Common.getUrl() + url,
            columns: columnList,
            columnDefs: columnDef,
            buttons: buttons,
            dom: buttons.length == 0 ? '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>' :'<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            orderCellsTop: true,
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            }
        });
        if(label){
            $('div.head-label').html('<h6 class="mb-0">'+ label +'</h6>');
        }
    }

    static reloadTable(selector){
        $(selector).DataTable().ajax.reload(null, false);
    }
}


