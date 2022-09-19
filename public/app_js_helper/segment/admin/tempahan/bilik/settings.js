DatatableUI.init({
    selector: '.tempahan-table',
    columnList: [
        { data: 'nama' },
        { data: 'maklumat' },
        { data: 'tempoh' },
        { data: 'status_tempahan' },
        { data: 'action' },
    ],
    url: '/admin/tempahan/bilik/get-list',
    columnDef: [
        {
            // Actions
            targets: -1,
            title: 'Actions',
            orderable: false,
            render: function (data, type, full, meta) {
                let activate = full.status;

                let val = '';
                if(activate !== 0){
                    val = '-';
                }else{
                    val = '<div class="btn-group" role="group" aria-label="Basic example">' +
                        '<button type="button" class="btn btn-outline-primary tempahan-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Kelulusan">' + feather.icons['edit-3'].toSvg() +'</button>' +
                        '</div>';
                }


                return val;
            }
        }
    ],
    label: 'List Lokasi'
});
