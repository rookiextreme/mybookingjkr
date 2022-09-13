$(document).on('click', '#add-fasiliti-modal', function(){
    ModalUI.modal({
        selector: '#fasiliti-modal',
        mode: 'show',
        color: 'modal-success',
        label: 'Tambah Fasiliti',
        buttonMode: [
            {
                selector: '#fasiliti-add',
                show: true,
            },
            {
                selector: '#fasiliti-edit',
                show: false,
            }
        ]
    });
});

$(document).on('click', '.fasiliti-edit', function(){
    let id = $(this).closest('tr').attr('data-fasiliti-id');
    $('#fasiliti-id').val(id);
    ModalUI.modal({
        selector: '#fasiliti-modal',
        mode: 'show',
        color: 'modal-warning',
        label: 'Kemaskini Fasiliti',
        buttonMode: [
            {
                selector: '#fasiliti-add',
                show: false,
            },
            {
                selector: '#fasiliti-edit',
                show: true,
            },
        ],
        callback: function(){
            let v = Common.emptyRequest();
            v.append('id', id);
            Ajax.runAjax({
                url: 'admin/tetapan/fasiliti/get-fasiliti',
                data: v,
                func: function(data){
                    $('#fasiliti-name').val(data.data.nama);
                }
            });
        }
    });
});

$(document).on('click', '#fasiliti-add, #fasiliti-edit', function(){
   let validate = new Validation();
   let curThis = $(this);
   let trigger = '';

    let v = validate.checkEmpty(
        validate.getValue('#fasiliti-name', 'mix', 'Nama', 'fasiliti_name')
    );

    if(curThis.is('#fasiliti-add')){
        v.append('trigger', 0);
        trigger = 0;
    }else{
        v.append('trigger', 1);
        v.append('fasiliti_id', $('#fasiliti-id').val());
        trigger = 1;
    }

    FasilitiController.storeUpdateFasiliti({
        url: 'admin/tetapan/fasiliti/store-update',
        data: v,
        trigger: trigger
    });
});

$(document).on('click', '.fasiliti-activate', function(){
    let id = $(this).closest('tr').attr('data-fasiliti-id');
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

    FasilitiController.activateFasiliti({
        url: 'admin/tetapan/fasiliti/activate',
        data: v,
        trigger: trigger
    });
});

$(document).on('click', '.fasiliti-delete', function (){
    let id = $(this).closest('tr').attr('data-fasiliti-id');
    let data = Common.emptyRequest();
    data.append('id', id);

    FasilitiController.deleteFasiliti({
        url: 'admin/tetapan/fasiliti/delete',
        data: data,
    });
});
