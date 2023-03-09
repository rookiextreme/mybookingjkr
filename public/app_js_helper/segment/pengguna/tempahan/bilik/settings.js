DatatableUI.init({
    selector: '.tempahan-bilik-table',
    columnList: [
        { data: 'bilik' },
        { data: 'maklumat' },
        { data: 'tempoh' },
        { data: 'status_label' },
        { data: 'action' },
    ],
    url: '/pengguna/tempahan/bilik/get-list',
    buttons: [
        {
            text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Tempahan Baru',
            className: 'btn btn-primary',
            attr: {
                'id': 'add-tempahan-bilik-modal'
            },
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
            }
        }
    ],
    columnDef: [
        {
            // Actions
            targets: -1,
            title: 'Tindakan',
            orderable: false,
            render: function (data, type, full, meta) {
                let status = full.status;
                if(status == 1 || status == 2){
                    return (
                        '<div class="btn-group" role="group" aria-label="Basic example">' +
                            '<button type="button" class="btn btn-outline-primary tempahan-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Tempahan">' + feather.icons['edit-3'].toSvg() +'</button>'  +
                        '</div>'
                    );
                }else{
                    return (
                        '<div class="btn-group" role="group" aria-label="Basic example">' +
                            '<button type="button" class="btn btn-outline-warning tempahan-bilik-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Kemaskini Tempahan">' + feather.icons['edit-3'].toSvg() +'</button>' +
                            '<button type="button" class="btn btn-outline-danger tempahan-bilik-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Padam">' + feather.icons['trash-2'].toSvg() +'</button>' +
                        '</div>'
                    );
                }

            }
        }
    ],
    label: 'List Tempahan'
});

Select2init.initAll();

Flatpickrinit.initWithTimeFuture('#tempahan-bilik-masa-mula');
Flatpickrinit.initWithTimeFuture('#tempahan-bilik-masa-tamat');

$(document).on('change', '#bilik-lokasi', function(){
    let self = $(this);
    let toChange = $('#bilik-bangunan');
    let data = Common.emptyRequest();
    data.append('lokasi_id', self.val());

    if(self.val() == '' || typeof self.val() == 'undefined'){
        toChange.empty().append('<option value="">Sila Pilih</option>');
        toChange.prop("disabled", true);
    }

    Ajax.runAjax({
        url: 'common/get-bangunan',
        data: data,
        func: function(data){
            let length = data.length;

            toChange.empty().append('<option value="">Sila Pilih</option>');
            if(length == 0){
                toChange.prop("disabled", true);
            }else{
                let currentData = data.data;
                let append = '';

                currentData.forEach(function(val){
                    append += '<option value="'+ val.value +'" selected>'+ val.label +'</option>';
                });

                toChange.append(append);
                toChange.prop("disabled", false);
            }
        }
    });
});

$(document).on('click', '#tempahan-bilik-tengok-kosong', function(){
    let validate = new Validation();

    let v = validate.checkEmpty(
        validate.getValue('#tempahan-bilik-masa-mula', 'datetime', 'Masa Mula', 'tempahan_bilik_masa_mula'),
        validate.getValue('#tempahan-bilik-masa-tamat', 'datetime', 'Masa Tamat', 'tempahan_bilik_masa_tamat'),
        validate.getValue('#tempahan-bilik-bilik', 'int', 'Bilik', 'tempahan_bilik_bilik')
    );

    TempahanBilikController.tengokKosong({
        url: 'pengguna/tempahan/bilik/tengok-kosong',
        data: v,
    });
});

Select2init.penggunaSearch({
    selector: '#tempahan-bilik-urusetia'
});

$(document).on('change', '#tempahan-bilik-urusetia', function(){
    let curThis = $(this);

    let data = Common.emptyRequest();
    data.append('nokp', curThis.val());

    Ajax.runAjax({
        url: 'common/pengguna-telefon',
        data: data,
        func: function(data){
            let tel = data.data;
            $('#tempahan-bilik-notel-urusetia').val(tel);
        }
    });
});

