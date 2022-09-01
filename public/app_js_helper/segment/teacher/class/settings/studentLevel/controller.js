class TeacherClassSettingStudentLevelController extends Ajax{
    static storeUpdateStudLevel({url, data, trigger}){
        this.runAjax({
            url : url,
            data: data,
            func: function(success){
                ToastAlert.toasting('Success', trigger == 0 ? 'Student Level Has Been Added' : 'Student Level Has Been Updated', 'success');
                DatatableUI.reloadTable('.ht-stud-level-table');
                $('#stud-level-modal').modal('hide');
            }
        });
    }

    static activateStudLevel({url, data, trigger}){
        this.runAjax({
            url: url,
            data: data,
            func: function(success){
                if(trigger == 0){
                    ToastAlert.toasting('Deactivated', 'Student Level Deactivated', 'error');
                }else{
                    ToastAlert.toasting('Success', 'Student Level Activated', 'success');
                }
            }
        });
    }

    static deleteStudLevel({url, data}){
        SwalUI.init({
            title: 'Are You Sure?',
            subtitle: 'Student Level Will Be Deleted!',
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
                            title: 'Student Level Deleted!',
                            subtitle: 'Action Cannot Be Reverted!'
                        });
                        DatatableUI.reloadTable('.ht-stud-level-table');
                    }
                });
            }
        });
    }
}
