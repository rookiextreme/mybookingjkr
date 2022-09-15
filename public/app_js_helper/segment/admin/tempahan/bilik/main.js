$(document).on('click', '.tempahan-edit', function(){
    let id = $(this).closest('tr').attr('data-tempahan-id');
    $('#tempahan-id').val(id);
    ModalUI.modal({
        selector: '#tempahan-modal',
        mode: 'show',
        color: 'modal-warning',
        label: 'Tempahan Bilik',
        callback: function(){
            let v = Common.emptyRequest();
            v.append('id', id);
            Ajax.runAjax({
                url: 'admin/tempahan/bilik/get-tempahan',
                data: v,
                func: function(data){
                    $('#tempah-pada').html(data.data.tempahan.tempahan);
                    $('#tempah-masa-mula').html(data.data.tempahan.masa_mula);
                    $('#tempah-masa-tamat').html(data.data.tempahan.masa_tamat);
                    $('#tempah-nama-bilik').html(data.data.tempahan.bilik);

                    $('#tempah-tujuan').html(data.data.maklumat.nama);
                    $('#tempah-urusetia').html(data.data.maklumat.urusetia);
                    $('#tempah-pengerusi').html(data.data.maklumat.pengerusi);
                    $('#tempah-agensi-d').html(data.data.maklumat.bil_agensi_d);
                    $('#tempah-agensi-l').html(data.data.maklumat.bil_agensi_l);
                }
            });
        }
    });
});

$(document).on('click', '#tempahan-edit', function(){
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
