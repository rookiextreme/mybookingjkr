Select2init.initAll();
Flatpickrinit.initAll('#teacher-profile-dob', '#profile-institution-date-start', '#profile-institution-date-end' );
DatatableUI.init({
    selector: '.ht-institution-table',
    columnList: [
        { data: 'name' },
        { data: 'date_start' },
        { data: 'date_end' },
        { data: 'action' },
    ],
    url: '/teacher/settings/profile/institution/get-list',
    buttons: [
        {
            text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Add New Institution',
            className: 'btn btn-primary',
            attr: {
                'data-bs-toggle': 'modal',
                'data-bs-target': '#modals-slide-in',
                'id': 'add-institution-modal'
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
                        '<button type="button" class="btn '+ activateStat +' profile-institution-activate" data-bs-toggle="tooltip" data-bs-placement="top" title="Activation">' + feather.icons['power'].toSvg() +'</button>' +
                        '<button type="button" class="btn btn-outline-warning profile-institution-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">' + feather.icons['edit-3'].toSvg() +'</button>' +
                        '<button type="button" class="btn btn-outline-danger profile-institution-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">' + feather.icons['trash-2'].toSvg() +'</button>' +
                    '</div>'
                );
            }
        }
    ],
    label: 'List'
});

Ajax.runAjax({
    url:  'common/get-user-profile',
    data: Common.emptyRequest(),
    func: function(parseData){
        UiSet.setValue([
            ['#teacher-profile-first-name', parseData.data.first_name, 'textbox'],
            ['#teacher-profile-last-name', parseData.data.last_name, 'textbox'],
            ['#teacher-profile-identification-number', parseData.data.ic_no, 'textbox'],
            ['#teacher-profile-gender', parseData.data.genders_id, 'dropdown'],
            ['#teacher-profile-dob', parseData.data.dob, 'textbox'],
            ['#teacher-profile-sob', parseData.data.sob_id, 'dropdown'],
            ['#teacher-profile-marital-status', parseData.data.marital_statuses, 'dropdown'],
        ]);
    }
});
