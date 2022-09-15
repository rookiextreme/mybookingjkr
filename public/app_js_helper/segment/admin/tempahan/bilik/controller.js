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

    static lulusTempahan({url, data}){
        this.runAjax({
            url : url,
            data: data,
            func: function(data){
                let status = data.data.status;

                if(status == 1){
                    ToastAlert.toasting('Lulus', 'Tempahan Diluluskan', 'success');
                }else if(status == 2){
                    ToastAlert.toasting('Tidak Lulus', 'Tempahan Dibatalkan', 'error');
                }

                DatatableUI.reloadTable('.tempahan-table');
                $('#tempahan-modal').modal('hide');
            }
        });
    }
}
