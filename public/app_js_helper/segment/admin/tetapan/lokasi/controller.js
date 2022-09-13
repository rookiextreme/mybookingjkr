class LokasiController extends Ajax{
    static storeUpdateLokasi({url, data, trigger}){
        this.runAjax({
            url : url,
            data: data,
            func: function(success){
                ToastAlert.toasting('Success', trigger == 0 ? 'Lokasi Ditambah' : 'Lokasi Dikemaskini', 'success');
                DatatableUI.reloadTable('.lokasi-table');
                $('#lokasi-modal').modal('hide');
            }
        });
    }

    static activateLokasi({url, data, trigger}){
        this.runAjax({
            url: url,
            data: data,
            func: function(success){
                if(trigger == 0){
                    ToastAlert.toasting('Deactivated', 'Lokasi Dinyahaktifkan', 'error');
                }else{
                    ToastAlert.toasting('Success', 'Lokasi Diaktifkan', 'success');
                }
            }
        });
    }

    static deleteLokasi({url, data}){
        SwalUI.init({
            title: 'Adakah Anda Pasti?',
            subtitle: 'Lokasi Akan Dipadam!',
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
                            title: 'Lokasi Dipadam!',
                            subtitle: 'Tindakan Tidak Boleh Dipadam!'
                        });
                        DatatableUI.reloadTable('.lokasi-table');
                    }
                });
            }
        });
    }
}
