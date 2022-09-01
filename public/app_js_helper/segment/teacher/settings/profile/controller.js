class TeacherProfileSettingsController extends Ajax{
    static updateProfile({url, data}){
        this.runAjax({
            url : url,
            data: data,
            func: function(success){
                ToastAlert.toasting('Success', 'Profile Has Been Updated', 'success');
            }
        });
    }

    static storeUpdateInstitution({url, data, trigger}){
        this.runAjax({
            url : url,
            data: data,
            func: function(success){
                ToastAlert.toasting('Success', trigger == 0 ? 'Institution Has Been Added' : 'Institution Has Been Updated', 'success');
                DatatableUI.reloadTable('.ht-institution-table');
                $('#institution-modal').modal('hide');
            }
        });
    }

    static activateInstitution({url, data, trigger}){
        this.runAjax({
            url: url,
            data: data,
            func: function(success){
                if(trigger == 0){
                    ToastAlert.toasting('Danger', 'Institution Deactivated', 'error');
                }else{
                    ToastAlert.toasting('Success', 'Institution Activated', 'success');
                }
            }
        });
    }

    static deleteInstitution({url, data}){
        SwalUI.init({
            title: 'Are You Sure?',
            subtitle: 'Institution Will Be Deleted!',
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
                            title: 'Institution Deleted!',
                            subtitle: 'Action Cannot Be Reverted!'
                        });
                        DatatableUI.reloadTable('.ht-institution-table');
                    }
                });
            }
        });
    }
}
