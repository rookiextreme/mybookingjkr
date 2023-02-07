$(document).on('click', '.pengguna-peranan', function(){
    let id = $(this).closest('tr').attr('data-id');
    let name = $(this).closest('tr').find('td:first').text();
    $('#pengguna-id').val(id);
    ModalUI.modal({
        selector: '#pengguna-modal',
        mode: 'show',
        color: 'modal-warning',
        label: 'Kemaskini Peranan: '+ name,
        buttonMode: [
            {
                selector: '#pengguna-add',
                show: false,
            },
            {
                selector: '#pengguna-edit',
                show: true,
            },
        ],
        callback: function(){
            let v = Common.emptyRequest();
            v.append('id', id);
            Ajax.runAjax({
                url: 'admin/pengguna/get-pengguna',
                data: v,
                func: function(data){
                    $('.check-peranan').each(function(){
                        $(this).prop('checked', false);
                    });
                    let roles = data.data.roles;

                    if(roles.length > 0){
                        roles.forEach(function (v){
                            $('.check-peranan[data-id='+ v +']').prop('checked', true);
                        });
                    }
                }
            });
        }
    });
});

$(document).on('click', '#pengguna-edit', function(){
    let validate = new Validation();
    let curThis = $(this);
    let trigger = '';
    let v = Common.emptyRequest();
    let pass = 0;

    let peranan = [];

    $('.check-peranan').each(function(){
        let curThis = $(this);
        if(curThis.prop('checked')){
            peranan.push(curThis.attr('data-id'));
            pass++;
        }
    });

    if(pass == 0){
        ToastAlert.toasting('Success', 'Sila Pilih Peranan', 'warning');
        return false;
    }

    v.append('peranan', JSON.stringify(peranan));
    v.append('user_id', $('#pengguna-id').val());


    PenggunaController.storeUpdatePeranan({
        url: 'admin/pengguna/store-update',
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

