class TeacherClassSubjectController extends Ajax{
    static storeUpdateSubject({url, data, trigger}){
        this.runAjax({
            url : url,
            data: data,
            func: function(success){
                ToastAlert.toasting('Success', trigger == 0 ? 'Subject Has Been Added' : 'Subject Has Been Updated', 'success');
                DatatableUI.reloadTable('.ht-subject-table');
                $('#subject-modal').modal('hide');
            }
        });
    }

    static activateSubject({url, data, trigger}){
        this.runAjax({
            url: url,
            data: data,
            func: function(success){
                if(trigger == 0){
                    ToastAlert.toasting('Deactivated', 'Subject Deactivated', 'error');
                }else{
                    ToastAlert.toasting('Success', 'Subject Activated', 'success');
                }
            }
        });
    }

    static deleteSubject({url, data}){
        SwalUI.init({
            title: 'Are You Sure?',
            subtitle: 'Subject Will Be Deleted!',
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
                            title: 'Subject Deleted!',
                            subtitle: 'Action Cannot Be Reverted!'
                        });
                        DatatableUI.reloadTable('.ht-subject-table');
                    }
                });
            }
        });
    }
}
