$(document).on('click', '#add-bangunan-modal', function(){
    ModalUI.modal({
        selector: '#bangunan-modal',
        mode: 'show',
        color: 'modal-success',
        label: 'Tambah Bangunan',
        buttonMode: [
            {
                selector: '#bangunan-add',
                show: true,
            },
            {
                selector: '#bangunan-edit',
                show: false,
            }
        ]
    });
});

$(document).on('click', '.bangunan-edit', function(){
    let id = $(this).closest('tr').attr('data-bangunan-id');
    $('#bangunan-id').val(id);
    ModalUI.modal({
        selector: '#bangunan-modal',
        mode: 'show',
        color: 'modal-warning',
        label: 'Kemaskini Bangunan',
        buttonMode: [
            {
                selector: '#bangunan-add',
                show: false,
            },
            {
                selector: '#bangunan-edit',
                show: true,
            },
        ],
        callback: function(){
            let v = Common.emptyRequest();
            v.append('id', id);
            Ajax.runAjax({
                url: 'admin/tetapan/bangunan/get-bangunan',
                data: v,
                func: function(data){
                    $('#bangunan-name').val(data.data.nama);
                    $('#bangunan-lokasi').val(data.data.lokasi_id).trigger('change');
                }
            });
        }
    });
});

$(document).on('click', '#bangunan-add, #bangunan-edit', function(){
   let validate = new Validation();
   let curThis = $(this);
   let trigger = '';

    let v = validate.checkEmpty(
        validate.getValue('#bangunan-name', 'mix', 'Nama', 'bangunan_name'),
        validate.getValue('#bangunan-lokasi', 'int', 'Lokasi', 'bangunan_lokasi')
    );

    if(curThis.is('#bangunan-add')){
        v.append('trigger', 0);
        trigger = 0;
    }else{
        v.append('trigger', 1);
        v.append('bangunan_id', $('#bangunan-id').val());
        trigger = 1;
    }

    BangunanController.storeUpdateBangunan({
        url: 'admin/tetapan/bangunan/store-update',
        data: v,
        trigger: trigger
    });
});

$(document).on('click', '.bangunan-activate', function(){
    let id = $(this).closest('tr').attr('data-bangunan-id');
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

    BangunanController.activateBangunan({
        url: 'admin/tetapan/bangunan/activate',
        data: v,
        trigger: trigger
    });
});

$(document).on('click', '.bangunan-delete', function (){
    let id = $(this).closest('tr').attr('data-bangunan-id');
    let data = Common.emptyRequest();
    data.append('id', id);

    BangunanController.deleteBangunan({
        url: 'admin/tetapan/bangunan/delete',
        data: data,
    });
});
