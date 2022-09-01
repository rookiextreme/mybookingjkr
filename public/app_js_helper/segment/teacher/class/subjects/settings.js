DatatableUI.init({
    selector: '.ht-subject-table',
    columnList: [
        { data: 'name' },
        { data: 'action' },
    ],
    url: '/teacher/class/subjects/get-list',
    buttons: [
        {
            text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Add New Subject',
            className: 'btn btn-primary',
            attr: {
                'id': 'add-subject-modal'
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
                        '<button type="button" class="btn '+ activateStat +' subject-activate" data-bs-toggle="tooltip" data-bs-placement="top" title="Activation">' + feather.icons['power'].toSvg() +'</button>' +
                        '<button type="button" class="btn btn-outline-warning subject-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">' + feather.icons['edit-3'].toSvg() +'</button>' +
                        '<button type="button" class="btn btn-outline-danger subject-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">' + feather.icons['trash-2'].toSvg() +'</button>' +
                    '</div>'
                );
            }
        }
    ],
    label: 'Subject List'
});
