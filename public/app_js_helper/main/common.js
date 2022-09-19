class Common{
    static getUrl(){
        return window.location.origin;
    }

    static getToken(){
        return $('#_token').val();
    }

    static emptyRequest(){
        let data = new FormData();
        data.append('_token', this.getToken());

        return data;
    }

    static postEmptyFields(fieldArray){
        for(var x = 0;x<fieldArray.length;x++){
            var inputClass = fieldArray[x][0];
            var inputType = fieldArray[x][1];

            if(inputType == 'text'){
                $(inputClass).val('').closest('.form-group').find('.invalid-feedback').html('');
            }else if(inputType == 'textarea'){
                $(inputClass).html('').closest('.form-group').find('.invalid-feedback').html('');
            }else if(inputType == 'dropdown'){
                $(inputClass).val('').trigger('change').closest('.form-group').find('.invalid-feedback').html('');
            }else if(inputType == 'photo'){
                $(inputClass).attr('style', '');
            }else if(inputType == 'checkbox'){
                $(inputClass).each(function(i, obj) {
                    var check = $(this).prop('checked');
                    if(check){
                        $(this).prop('checked', false);
                    }
                });
            }
        }
    }
}
