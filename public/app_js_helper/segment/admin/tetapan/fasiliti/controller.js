class FasilitiController extends Ajax{
    static storeUpdateFasiliti({url, data, trigger}){
        this.runAjax({
            url : url,
            data: data,
            func: function(success){
                ToastAlert.toasting('Success', trigger == 0 ? 'Fasiliti Ditambah' : 'Fasiliti Dikemaskini', 'success');
                DatatableUI.reloadTable('.fasiliti-table');
                $('#fasiliti-modal').modal('hide');
            }
        });
    }

    static activateFasiliti({url, data, trigger}){
        this.runAjax({
            url: url,
            data: data,
            func: function(success){
                if(trigger == 0){
                    ToastAlert.toasting('Deactivated', 'Fasiliti Dinyahaktifkan', 'error');
                }else{
                    ToastAlert.toasting('Success', 'Fasiliti Diaktifkan', 'success');
                }
            }
        });
    }

    static deleteFasiliti({url, data}){
        SwalUI.init({
            title: 'Adakah Anda Pasti?',
            subtitle: 'Fasiliti Akan Dipadam!',
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
                            title: 'Fasiliti Dipadam!',
                            subtitle: 'Tindakan Tidak Boleh Dipadam!'
                        });
                        DatatableUI.reloadTable('.fasiliti-table');
                    }
                });
            }
        });
    }
}
