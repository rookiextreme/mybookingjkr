$(document).on('click', '#add-stud-level-modal', function(){
    ModalUI.modal({
        selector: '#stud-level-modal',
        mode: 'show',
        color: 'modal-success',
        label: 'Add Student Level',
        buttonMode: [
            {
                selector: '#stud-level-add',
                show: true,
            },
            {
                selector: '#stud-level-edit',
                show: false,
            }
        ]
    });
});

$(document).on('click', '.stud-level-edit', function(){
    let id = $(this).closest('tr').attr('data-stud-level-id');
    $('#stud-level-id').val(id);
    ModalUI.modal({
        selector: '#stud-level-modal',
        mode: 'show',
        color: 'modal-warning',
        label: 'Edit Student Level',
        buttonMode: [
            {
                selector: '#stud-level-add',
                show: false,
            },
            {
                selector: '#stud-level-edit',
                show: true,
            },
        ],
        callback: function(){
            let v = Common.emptyRequest();
            v.append('id', id);
            Ajax.runAjax({
                url: 'teacher/class/settings/student-levels/get-student-level',
                data: v,
                func: function(data){
                    $('#stud-level-name').val(data.data.name);
                }
            });
        }
    });
});

$(document).on('click', '#stud-level-add, #stud-level-edit', function(){
   let validate = new Validation();
   let curThis = $(this);
   let trigger = '';

    let v = validate.checkEmpty(
        validate.getValue('#stud-level-name', 'mix', 'Name', 'stud_level_name')
    );

    if(curThis.is('#stud-level-add')){
        v.append('trigger', 0);
        trigger = 0;
    }else{
        v.append('trigger', 1);
        v.append('stud_level_id', $('#stud-level-id').val());
        trigger = 1;
    }

    TeacherClassSettingStudentLevelController.storeUpdateStudLevel({
        url: 'teacher/class/settings/student-levels/store-update',
        data: v,
        trigger: trigger
    });
});

$(document).on('click', '.stud-level-activate', function(){
    let id = $(this).closest('tr').attr('data-stud-level-id');
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

    TeacherClassSettingStudentLevelController.activateStudLevel({
        url: 'teacher/class/settings/student-levels/activate',
        data: v,
        trigger: trigger
    });
});

$(document).on('click', '.stud-level-delete', function (){
    let id = $(this).closest('tr').attr('data-stud-level-id');
    let data = Common.emptyRequest();
    data.append('id', id);

    TeacherClassSettingStudentLevelController.deleteStudLevel({
        url: 'teacher/class/settings/student-levels/delete',
        data: data,
    });
});
