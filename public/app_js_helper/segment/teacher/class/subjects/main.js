$(document).on('click', '#add-subject-modal', function(){
    ModalUI.modal({
        selector: '#subject-modal',
        mode: 'show',
        color: 'modal-success',
        label: 'Add Subject',
        buttonMode: [
            {
                selector: '#subject-add',
                show: true,
            },
            {
                selector: '#subject-edit',
                show: false,
            }
        ]
    });
});

$(document).on('click', '.subject-edit', function(){
    let id = $(this).closest('tr').attr('data-subject-id');
    $('#subject-id').val(id);
    ModalUI.modal({
        selector: '#subject-modal',
        mode: 'show',
        color: 'modal-warning',
        label: 'Edit Subject',
        buttonMode: [
            {
                selector: '#subject-add',
                show: false,
            },
            {
                selector: '#subject-edit',
                show: true,
            },
        ],
        callback: function(){
            let v = Common.emptyRequest();
            v.append('id', id);
            Ajax.runAjax({
                url: 'teacher/class/subjects/get-subject',
                data: v,
                func: function(data){
                    $('#subject-name').val(data.data.name);
                }
            });
        }
    });
});

$(document).on('click', '#subject-add, #subject-edit', function(){
   let validate = new Validation();
   let curThis = $(this);
   let trigger = '';

    let v = validate.checkEmpty(
        validate.getValue('#subject-name', 'string', 'Name', 'subject_name'),
    );

    if(curThis.is('#subject-add')){
        v.append('trigger', 0);
        trigger = 0;
    }else{
        v.append('trigger', 1);
        v.append('subject_id', $('#subject-id').val());
        trigger = 1;
    }

    TeacherClassSubjectController.storeUpdateSubject({
        url: 'teacher/class/subjects/store-update',
        data: v,
        trigger: trigger
    });
});

$(document).on('click', '.subject-activate', function(){
    let id = $(this).closest('tr').attr('data-subject-id');
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

    TeacherClassSubjectController.activateSubject({
        url: 'teacher/class/subjects/activate',
        data: v,
        trigger: trigger
    });
});

$(document).on('click', '.subject-delete', function (){
    let id = $(this).closest('tr').attr('data-subject-id');
    let data = Common.emptyRequest();
    data.append('id', id);

    TeacherClassSubjectController.deleteSubject({
        url: 'teacher/class/subjects/delete',
        data: data,
    });
});
