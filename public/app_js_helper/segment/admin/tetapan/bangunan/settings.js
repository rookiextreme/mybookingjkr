DatatableUI.init({
    selector: '.bangunan-table',
    columnList: [
        { data: 'nama' },
        { data: 'lokasi' },
        { data: 'action' },
    ],
    url: '/admin/tetapan/bangunan/get-list',
    buttons: [
        {
            text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Tambah Bangunan',
            className: 'btn btn-primary',
            attr: {
                'id': 'add-bangunan-modal'
            },
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        }
    ],
    columnDef: [
        {
            // Actions
            targets: -1,
            title: 'Actions',
            orderable: false,
            render: function (data, type, full, meta) {
                let activate = full.flag;
                let activateStat = activate == 0 ? 'btn-outline-danger' : 'btn-outline-success' + '';
                return (
                    '<div class="btn-group" role="group" aria-label="Basic example">' +
                        '<button type="button" class="btn '+ activateStat +' bangunan-activate" data-bs-toggle="tooltip" data-bs-placement="top" title="Pengaktifan">' + feather.icons['power'].toSvg() +'</button>' +
                        '<button type="button" class="btn btn-outline-warning bangunan-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Kemaskini Bangunan">' + feather.icons['edit-3'].toSvg() +'</button>' +
                        '<button type="button" class="btn btn-outline-danger bangunan-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Padam">' + feather.icons['trash-2'].toSvg() +'</button>' +
                    '</div>'
                );
            }
        }
    ],
    label: 'List Bangunan'
});

Select2init.initAll();
