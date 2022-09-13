$(document).on('click', '#add-tempahan-bilik-modal', function(){
    ModalUI.modal({
        selector: '#tempahan-bilik-modal',
        mode: 'show',
        color: 'modal-success',
        label: 'Tempahan Baru',
        buttonMode: [
            {
                selector: '#tempahan-bilik-add',
                show: true,
            },
            {
                selector: '#tempahan-bilik-edit',
                show: false,
            }
        ]
    });
});

$(document).on('click', '.tempahan-bilik-edit', function(){
    let id = $(this).closest('tr').attr('data-tempahan-bilik-id');
    $('#bilik-id').val(id);
    ModalUI.modal({
        selector: '#tempahan-bilik-modal',
        mode: 'show',
        color: 'modal-warning',
        label: 'Kemaskini Tempahan',
        buttonMode: [
            {
                selector: '#tempahan-bilik-add',
                show: false,
            },
            {
                selector: '#tempahan-bilik-edit',
                show: true,
            },
        ],
        callback: function(){
            let v = Common.emptyRequest();
            v.append('id', id);
            Ajax.runAjax({
                url: 'pengguna/tempahan/bilik/get-tempahan-bilik',
                data: v,
                func: function(data){
                    console.log(data);
                    // $('#bilik-name').val(data.data.nama);
                    // $('#bilik-lokasi').val(data.data.lokasi_id).trigger('change');
                    // $('#bilik-aras').val(data.data.aras);
                    // $('#bilik-kapasiti').val(data.data.kapasiti);
                    // $('#bilik-bangunan').val(data.data.bangunan_id).prop('selected', true).trigger('change');
                }
            });
        }
    });
});

$(document).on('click', '#tempahan-bilik-add, #tempahan-bilik-edit', function(){
   let validate = new Validation();
   let curThis = $(this);
   let trigger = '';

    let v = validate.checkEmpty(
        validate.getValue('#tempahan-bilik-name', 'mix', 'Nama Tempahan', 'tempahan_bilik_name'),
        validate.getValue('#tempahan-bilik-urusetia', 'mix', 'Urusetia', 'tempahan_bilik_urusetia'),
        validate.getValue('#tempahan-bilik-notel-urusetia', 'int', 'No. Telefon Urusetia', 'tempahan_bilik_notel_urusetia'),
        validate.getValue('#tempahan-bilik-pengerusi', 'mix', 'Pengerusi', 'tempahan_bilik_pengerusi'),
        validate.getValue('#tempahan-bilik-agensi', 'int', 'Agensi', 'tempahan_bilik_agensi'),
        validate.getValue('#tempahan-bilik-agensi-l', 'int', 'Agensi L', 'tempahan_bilik_agensi_l')
    );

    v.append('tempahan_masa_mula', $('#tempahan-bilik-masa-mula').val());
    v.append('tempahan_masa_tamat', $('#tempahan-bilik-masa-tamat').val());
    v.append('tempahan_nota', $('#tempahan-bilik-nota').val());
    v.append('tempahan_bilik_bilik', $('#tempahan-bilik-bilik').val());

    if(curThis.is('#tempahan-bilik-add')){
        v.append('trigger', 0);
        trigger = 0;
    }else{
        v.append('trigger', 1);
        v.append('tempahan_bilik_id', $('#tempahan-bilik-id').val());
        trigger = 1;
    }

    TempahanBilikController.storeUpdateTempahanBilik({
        url: 'pengguna/tempahan/bilik/store-update',
        data: v,
        trigger: trigger
    });
});

$(document).on('click', '.tempahan-bilik-delete', function (){
    let id = $(this).closest('tr').attr('data-tempahan-bilik-id');
    let data = Common.emptyRequest();
    data.append('id', id);

    TempahanBilikController.deleteTempahanBilik({
        url: 'pengguna/tempahan/bilik/delete',
        data: data,
    });
});
