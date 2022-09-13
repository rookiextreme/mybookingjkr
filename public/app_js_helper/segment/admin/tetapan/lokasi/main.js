$(document).on('click', '#add-lokasi-modal', function(){
    ModalUI.modal({
        selector: '#lokasi-modal',
        mode: 'show',
        color: 'modal-success',
        label: 'Tambah Lokasi',
        buttonMode: [
            {
                selector: '#lokasi-add',
                show: true,
            },
            {
                selector: '#lokasi-edit',
                show: false,
            }
        ]
    });
});

$(document).on('click', '.lokasi-edit', function(){
    let id = $(this).closest('tr').attr('data-lokasi-id');
    $('#lokasi-id').val(id);
    ModalUI.modal({
        selector: '#lokasi-modal',
        mode: 'show',
        color: 'modal-warning',
        label: 'Kemaskini Lokasi',
        buttonMode: [
            {
                selector: '#lokasi-add',
                show: false,
            },
            {
                selector: '#lokasi-edit',
                show: true,
            },
        ],
        callback: function(){
            let v = Common.emptyRequest();
            v.append('id', id);
            Ajax.runAjax({
                url: 'admin/tetapan/lokasi/get-lokasi',
                data: v,
                func: function(data){
                    $('#lokasi-name').val(data.data.nama);
                }
            });
        }
    });
});

$(document).on('click', '#lokasi-add, #lokasi-edit', function(){
   let validate = new Validation();
   let curThis = $(this);
   let trigger = '';

    let v = validate.checkEmpty(
        validate.getValue('#lokasi-name', 'mix', 'Nama', 'lokasi_name')
    );

    if(curThis.is('#lokasi-add')){
        v.append('trigger', 0);
        trigger = 0;
    }else{
        v.append('trigger', 1);
        v.append('lokasi_id', $('#lokasi-id').val());
        trigger = 1;
    }

    LokasiController.storeUpdateLokasi({
        url: 'admin/tetapan/lokasi/store-update',
        data: v,
        trigger: trigger
    });
});

$(document).on('click', '.lokasi-activate', function(){
    let id = $(this).closest('tr').attr('data-lokasi-id');
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

    LokasiController.activateLokasi({
        url: 'admin/tetapan/lokasi/activate',
        data: v,
        trigger: trigger
    });
});

$(document).on('click', '.lokasi-delete', function (){
    let id = $(this).closest('tr').attr('data-lokasi-id');
    let data = Common.emptyRequest();
    data.append('id', id);

    LokasiController.deleteLokasi({
        url: 'admin/tetapan/lokasi/delete',
        data: data,
    });
});
