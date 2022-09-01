$(document).on('click', '#teacher-profile-update', function(){
    let validate = new Validation();

    //this function will return a FormData
    let v = validate.checkEmpty(
        validate.getValue('#teacher-profile-first-name', 'string', 'First Name', 'first_name'),
        validate.getValue('#teacher-profile-last-name', 'string', 'Last Name', 'last_name'),
        validate.getValue('#teacher-profile-identification-number', 'int', 'Identification Number', 'identification_number'),
        validate.getValue('#teacher-profile-gender', 'int', 'Gender', 'gender'),
        validate.getValue('#teacher-profile-dob', 'datedashstandard', 'Date Of Birth', 'dob'),
        validate.getValue('#teacher-profile-sob', 'int', 'State Of Birth', 'sob'),
        validate.getValue('#teacher-profile-marital-status', 'int', 'Marital Status', 'marital_status')
    );

    //pass to controller and run ajax
    TeacherProfileSettingsController.updateProfile({
        url: 'teacher/settings/profile/update',
        data: v,
    });
});

Dropzoneinit.initAll('.teacher-profile-picture', '.jpg,.jpeg,.png', function(data){
    let url =  Common.getUrl() + '/' + data.data;
    $('#main-profile-picture').attr('src', url);
    $('#user-profile-picture').attr('src', url);
});

$(document).on('click', '#add-institution-modal', function(){
    ModalUI.modal({
        selector: '#institution-modal',
        mode: 'show',
        color: 'modal-success',
        label: 'Add Institution',
        buttonMode: [
            {
                selector: '#profile-institution-add',
                show: true,
            },
            {
                selector: '#profile-institution-edit',
                show: false,
            }
        ]
    });
});

$(document).on('click', '.profile-institution-edit', function(){
    let id = $(this).closest('tr').attr('data-institution-id');
    $('#institution-id').val(id);
    ModalUI.modal({
        selector: '#institution-modal',
        mode: 'show',
        color: 'modal-warning',
        label: 'Edit Institution',
        buttonMode: [
            {
                selector: '#profile-institution-add',
                show: false,
            },
            {
                selector: '#profile-institution-edit',
                show: true,
            },
        ],
        callback: function(){
            let v = Common.emptyRequest();
            v.append('id', id);
            Ajax.runAjax({
                url: 'teacher/settings/profile/institution/get-institution',
                data: v,
                func: function(data){
                    $('#profile-institution-name').val(data.data.name);
                    $('#profile-institution-date-start').val(data.data.date_start);
                    $('#profile-institution-date-end').val(data.data.date_end);
                }
            });
        }
    });
});

$(document).on('click', '#profile-institution-add, #profile-institution-edit', function(){
   let validate = new Validation();
   let curThis = $(this);
   let trigger = '';

    let v = validate.checkEmpty(
        validate.getValue('#profile-institution-name', 'string', 'Name', 'institution_name'),
        validate.getValue('#profile-institution-date-start', 'datedashstandard', 'Start Date', 'date_start'),
        validate.getValue('#profile-institution-date-end', 'datedashstandard', 'End Date', 'date_end')
    );

    if(curThis.is('#profile-institution-add')){
        v.append('trigger', 0);
        trigger = 0;
    }else{
        v.append('trigger', 1);
        v.append('institution_id', $('#institution-id').val());
        trigger = 1;
    }

    TeacherProfileSettingsController.storeUpdateInstitution({
        url: 'teacher/settings/profile/institution/store-update',
        data: v,
        trigger: trigger
    });
});

$(document).on('click', '.profile-institution-activate', function(){
    let id = $(this).closest('tr').attr('data-institution-id');
    let curThis = $(this);
    let trigger = '';

    if(curThis.hasClass('btn-outline-success')){
        curThis.removeClass('btn-outline-success').addClass('btn-outline-danger');
        trigger = 0;
    }else if(curThis.hasClass('btn-outline-danger')){
        curThis.removeClass('btn-outline-danger').addClass('btn-outline-success');
        trigger = 1;
    }

    let v = Common.emptyRequest();
    v.append('id', id);

    TeacherProfileSettingsController.activateInstitution({
        url: 'teacher/settings/profile/institution/activate',
        data: v,
        trigger: trigger
    });
});

$(document).on('click', '.profile-institution-delete', function (){
    let id = $(this).closest('tr').attr('data-institution-id');
    let data = Common.emptyRequest();
    data.append('id', id);

    TeacherProfileSettingsController.deleteInstitution({
        url: 'teacher/settings/profile/institution/delete',
        data: data,
    });
});
