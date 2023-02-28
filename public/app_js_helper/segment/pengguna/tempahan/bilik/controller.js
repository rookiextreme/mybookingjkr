class TempahanBilikController extends Ajax{
    static storeUpdateTempahanBilik({url, data, trigger}){
        this.runAjax({
            url : url,
            data: data,
            func: function(data){
                let success = data.success;
                console.log(data);
                if(success !=2){
                    ToastAlert.toasting('Success', trigger == 0 ? 'Tempahan Ditambah' : 'Tempahan Dikemaskini', 'success');
                    DatatableUI.reloadTable('.tempahan-bilik-table');
                    $('#tempahan-bilik-modal').modal('hide');
                }else{
                    ToastAlert.toasting('Error', 'Bilangan Orang Melebihi Kapasiti Bilik', 'error');
                }
            }
        });
    }

    static deleteTempahanBilik({url, data}){
        SwalUI.init({
            title: 'Adakah Anda Pasti?',
            subtitle: 'Tempahan Akan Dipadam!',
            icon: 'error',
            confirmText: 'Delete',
            confirmButtonClass: 'btn btn-danger',
            callback: function (){
                Ajax.runAjax({
                    url: url,
                    data: data,
                    func: function () {
                        SwalUI.fireSwal({
                            icon: 'error',
                            title: 'Tempahan Dipadam!',
                            subtitle: 'Tindakan Tidak Boleh Dipadam!'
                        });
                        DatatableUI.reloadTable('.tempahan-bilik-table');
                    }
                });
            }
        });
    }

    static tengokKosong({url, data}){
        this.runAjax({
            url : url,
            data: data,
            func: function(data){
                let avail = data.data;
                if(avail === 0){
                    ToastAlert.toasting('Success', 'Ada Slot', 'success');
                    $('.tempahan-info').attr('style', 'display:compact');
                    $('#tempahan-bilik-add').attr('style', '');
                }else{
                    ToastAlert.toasting('Whoops!', 'Slot Ini Sudah Diambil', 'error');
                    $('.tempahan-info').attr('style', 'display:none');
                    $('#tempahan-bilik-add').attr('style', 'display:none');
                }

            }
        });
    }
}
