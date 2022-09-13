class BilikController extends Ajax{
    static storeUpdateBilik({url, data, trigger}){
        this.runAjax({
            url : url,
            data: data,
            func: function(success){
                ToastAlert.toasting('Success', trigger == 0 ? 'Bilik Ditambah' : 'Bilik Dikemaskini', 'success');
                DatatableUI.reloadTable('.bilik-table');
                $('#bilik-modal').modal('hide');
            }
        });
    }

    static activateBilik({url, data, trigger}){
        this.runAjax({
            url: url,
            data: data,
            func: function(success){
                if(trigger == 0){
                    ToastAlert.toasting('Deactivated', 'Bilik Dinyahaktifkan', 'error');
                }else{
                    ToastAlert.toasting('Success', 'Bilik Diaktifkan', 'success');
                }
            }
        });
    }

    static deleteBilik({url, data}){
        SwalUI.init({
            title: 'Adakah Anda Pasti?',
            subtitle: 'Bilik Akan Dipadam!',
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
                            title: 'Bilik Dipadam!',
                            subtitle: 'Tindakan Tidak Boleh Dipadam!'
                        });
                        DatatableUI.reloadTable('.bilik-table');
                    }
                });
            }
        });
    }
}
