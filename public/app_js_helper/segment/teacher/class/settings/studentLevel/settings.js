DatatableUI.init({
    selector: '.ht-stud-level-table',
    columnList: [
        { data: 'name' },
        { data: 'action' },
    ],
    url: '/teacher/class/settings/student-levels/get-list',
    buttons: [
        {
            text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Add New Student Level',
            className: 'btn btn-primary',
            attr: {
                'id': 'add-stud-level-modal'
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
                        '<button type="button" class="btn '+ activateStat +' stud-level-activate" data-bs-toggle="tooltip" data-bs-placement="top" title="Activation">' + feather.icons['power'].toSvg() +'</button>' +
                        '<button type="button" class="btn btn-outline-warning stud-level-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">' + feather.icons['edit-3'].toSvg() +'</button>' +
                        '<button type="button" class="btn btn-outline-danger stud-level-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">' + feather.icons['trash-2'].toSvg() +'</button>' +
                    '</div>'
                );
            }
        }
    ],
    label: 'Subject List'
});
