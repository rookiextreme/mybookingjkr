$(document).on('click', '#add-tempahan-bilik-modal', function(){
    ModalUI.modal({
        selector: '#tempahan-bilik-modal',
        mode: 'show',
        color: 'modal-success',
        label: 'Tempahan Baru',
        buttonMode: [
            {
                selector: '#tempahan-bilik-add',
                show: false,
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
                    $('.tempahan-info').attr('style', '');
                    $('#tempahan-bilik-perkara').val(data.data.nama);
                    $('#tempahan-bilik-urusetia').val(data.data.lokasi_id);
                    $('#tempahan-bilik-notel-urusetia').val(data.data.aras);
                    $('#tempahan-bilik-pengerusi').val(data.data.kapasiti);
                    $('#tempahan-bilik-agensi').val(data.data.bangunan_id);
                    $('#tempahan-bilik-agensi-l').val(data.data.lokasi_id);
                    $('#tempahan_masa_mula').val(data.data.aras);
                    $('#tempahan_masa_tamat').val(data.data.kapasiti);
                    $('#tempahan_nota').val(data.data.bangunan_id);
                    $('#tempahan_bilik_bilik').val(data.data.bangunan_id);
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
        validate.getValue('#tempahan-bilik-perkara', 'mix', 'Perkara', 'tempahan_bilik_perkara'),
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


$(document).on('click', '.tempahan-view', function(){
    let id = $(this).closest('tr').attr('data-tempahan-id');
    $('#tempahan-id').val(id);
    ModalUI.modal({
        selector: '#tempahan-modal',
        mode: 'show',
        color: 'modal-warning',
        label: 'Lihat Tempahan Bilik',
        callback: function(){
            console.log(data);
            let v = Common.emptyRequest();
            v.append('id', id);
            Ajax.runAjax({
                url: 'pengguna/tempahan/bilik/get-view-tempahan-bilik',
                data: v,
                func: function(data){
                    $('#status_tempahan').html(data.data.tempahan.status_tempahan);
                    $('#no_ruj').html(data.data.tempahan.no_ruj);
                    $('#tempah-pada').html(data.data.tempahan.tempahan);
                    $('#tempah-masa-mula').html(data.data.tempahan.masa_mula);
                    $('#tempah-masa-tamat').html(data.data.tempahan.masa_tamat);
                    $('#tempah-nama-bilik').html(data.data.tempahan.bilik);

                    $('#tempah-tujuan').html(data.data.maklumat.nama);
                    $('#tempah-urusetia').html(data.data.maklumat.urusetia);
                    $('#tempah-pengerusi').html(data.data.maklumat.pengerusi);
                    $('#tempah-agensi-d').html(data.data.maklumat.bil_agensi_d);
                    $('#tempah-agensi-l').html(data.data.maklumat.bil_agensi_l);
                    $('#nota').html(data.data.maklumat.nota);

                    let fasiliti = data.data.tempahan.fasiliti;
                    let curString = '';
                    if(fasiliti.length > 0){
                        fasiliti.forEach(function(v){
                            curString += v.nama + ' - Kuantiti: ' + v.kuantiti + '<br>';
                        });
                    }

                    $('#tempah-bilik-fasiliti').html(curString);
                }
            });
        }
    });
});

$(document).on('click', '#tempahan-view', function(){
    let curThis = $(this);
    let trigger = '';

    let data = Common.emptyRequest();
    data.append('status', curThis.attr('data-status'));
    data.append('id', $('#tempahan-id').val());

     FasilitiController.lulusTempahan({
         url: 'admin/tempahan/bilik/lulus',
         data: data,
         trigger: trigger
     });
 });
