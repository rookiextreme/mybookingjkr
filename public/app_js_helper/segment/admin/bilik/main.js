$(document).on('click', '#add-bilik-modal', function(){
    ModalUI.modal({
        selector: '#bilik-modal',
        mode: 'show',
        color: 'modal-success',
        label: 'Tambah Bilik',
        buttonMode: [
            {
                selector: '#bilik-add',
                show: true,
            },
            {
                selector: '#bilik-edit',
                show: false,
            }
        ]
    });
});

$(document).on('click', '.bilik-edit', function(){
    let id = $(this).closest('tr').attr('data-bilik-id');
    $('#bilik-id').val(id);
    ModalUI.modal({
        selector: '#bilik-modal',
        mode: 'show',
        color: 'modal-warning',
        label: 'Kemaskini Bilik',
        buttonMode: [
            {
                selector: '#bilik-add',
                show: false,
            },
            {
                selector: '#bilik-edit',
                show: true,
            },
        ],
        callback: function(){
            let v = Common.emptyRequest();
            v.append('id', id);
            Ajax.runAjax({
                url: 'admin/bilik/get-bilik',
                data: v,
                func: function(data){
                    $('#bilik-name').val(data.data.nama);
                    $('#bilik-lokasi').val(data.data.lokasi_id).trigger('change');
                    $('#bilik-aras').val(data.data.aras);
                    $('#bilik-kapasiti').val(data.data.kapasiti);
                    $('#bilik-bangunan').val(data.data.bangunan_id).prop('selected', true).trigger('change');
                }
            });
        }
    });
});

$(document).on('click', '#bilik-add, #bilik-edit', function(){
   let validate = new Validation();
   let curThis = $(this);
   let trigger = '';

    let v = validate.checkEmpty(
        validate.getValue('#bilik-name', 'mix', 'Nama', 'bilik_name'),
        validate.getValue('#bilik-lokasi', 'int', 'Lokasi', 'bilik_lokasi'),
        validate.getValue('#bilik-bangunan', 'int', 'Bangunan', 'bilik_bangunan'),
        validate.getValue('#bilik-aras', 'int', 'Aras', 'bilik_aras'),
        validate.getValue('#bilik-kapasiti', 'int', 'Kapasiti', 'bilik_kapasiti')
    );

    if(curThis.is('#bilik-add')){
        v.append('trigger', 0);
        trigger = 0;
    }else{
        v.append('trigger', 1);
        v.append('bilik_id', $('#bilik-id').val());
        trigger = 1;
    }

    BilikController.storeUpdateBilik({
        url: 'admin/bilik/store-update',
        data: v,
        trigger: trigger
    });
});

$(document).on('click', '.bilik-activate', function(){
    let id = $(this).closest('tr').attr('data-bilik-id');
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

    BilikController.activateBilik({
        url: 'admin/bilik/activate',
        data: v,
        trigger: trigger
    });
});

$(document).on('click', '.bilik-delete', function (){
    let id = $(this).closest('tr').attr('data-bilik-id');
    let data = Common.emptyRequest();
    data.append('id', id);

    BilikController.deleteBilik({
        url: 'admin/bilik/delete',
        data: data,
    });
});
