DatatableUI.init({
    selector: '.bilik-table',
    columnList: [
        { data: 'nama' },
        { data: 'lokasi_bangunan_aras' },
        { data: 'action' },
    ],
    url: '/admin/bilik/get-list',
    buttons: [
        {
            text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + 'Tambah Bilik',
            className: 'btn btn-primary',
            attr: {
                'id': 'add-bilik-modal'
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
            title: 'Actions',
            orderable: false,
            render: function (data, type, full, meta) {
                let activate = full.flag;
                let activateStat = activate == 0 ? 'btn-outline-danger' : 'btn-outline-success' + '';
                return (
                    '<div class="btn-group" role="group" aria-label="Basic example">' +
                        '<button type="button" class="btn '+ activateStat +' bilik-activate" data-bs-toggle="tooltip" data-bs-placement="top" title="Pengaktifan">' + feather.icons['power'].toSvg() +'</button>' +
                        '<button type="button" class="btn btn-outline-warning bilik-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Kemaskini Bangunan">' + feather.icons['edit-3'].toSvg() +'</button>' +
                        '<button type="button" class="btn btn-outline-danger bilik-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Padam">' + feather.icons['trash-2'].toSvg() +'</button>' +
                    '</div>'
                );
            }
        }
    ],
    label: 'List Bilik'
});

Select2init.initAll();

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

$(document).on('change', '#bilik-kemudahan', function(){
   let curThis = $(this);
   let val = curThis.val();
   let label = curThis.text();
   if(val != '' && typeof val != undefined){
       let append = getKemudahanAppend(label, val);

       $('#bilik-kemudahan-list').append(append);
   }
});

$(document).on('click', '.padam-item', function(){
    let parent_id = $(this).closest('.parent-item').attr('data-id');

    if(parent_id != '' && typeof parent_id != 'undefined'){
        let data = Common.emptyRequest();

        data.append('id', parent_id);
        Ajax.runAjax({
            url: 'admin/bilik/delete-item',
            data: data,
            func: function(){}
        });
    }

    $(this).closest('.parent-item').remove();
});

function getKemudahanAppend(label, fasiliti_id, kuantiti= '', mainId = ''){
    return '<div class="col-xl-6 col-md-6 col-12 parent-item" data-id="'+ mainId +'">' +
                '<div class="mb-1 form-group">' +
                    '<label class="form-label" for="basicInput">'+ label +'</label>' +
                    '<div class="row">' +
                        '<div class="col-md-9 bilik-kemudahan-main" data-item-parent="'+ fasiliti_id +'">' +
                            '<input type="text" class="form-control bilik-kemudahan-item" value="'+ kuantiti +'" placeholder="Kuantiti"/>' +
                            '<div class="invalid-feedback"></div>' +
                        '</div>' +
                    '<div class="col-md-3">' +
                        '<button type="button" class="btn btn-icon btn-danger padam-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Padam Kemudahan">' +
                        feather.icons['trash-2'].toSvg() +
                        '</button>' +
                    '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';
}
