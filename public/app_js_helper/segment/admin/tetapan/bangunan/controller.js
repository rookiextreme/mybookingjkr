class BangunanController extends Ajax{
    static storeUpdateBangunan({url, data, trigger}){
        this.runAjax({
            url : url,
            data: data,
            func: function(success){
                ToastAlert.toasting('Success', trigger == 0 ? 'Bangunan Ditambah' : 'Bangunan Dikemaskini', 'success');
                DatatableUI.reloadTable('.bangunan-table');
                $('#bangunan-modal').modal('hide');
            }
        });
    }

    static activateBangunan({url, data, trigger}){
        this.runAjax({
            url: url,
            data: data,
            func: function(success){
                if(trigger == 0){
                    ToastAlert.toasting('Deactivated', 'Bangunan Dinyahaktifkan', 'error');
                }else{
                    ToastAlert.toasting('Success', 'Bangunan Diaktifkan', 'success');
                }
            }
        });
    }

    static deleteBangunan({url, data}){
        SwalUI.init({
            title: 'Adakah Anda Pasti?',
            subtitle: 'Bangunan Akan Dipadam!',
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
                            title: 'Bangunan Dipadam!',
                            subtitle: 'Tindakan Tidak Boleh Dipadam!'
                        });
                        DatatableUI.reloadTable('.bangunan-table');
                    }
                });
            }
        });
    }
}
