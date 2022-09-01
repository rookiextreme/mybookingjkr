class ModalUI{
    static modal({
        selector,
        label = false,
        mode = false,
        color = 'primary',
        callback = function (){},
        size = false,
        buttonMode = false
    }){
        $(selector).modal(mode);
        $(selector).addClass(color);
        if(label){
            $(selector).find('.modal-title').html(label);
        }
        if(size){
            $(selector).find('.modal-dialog').addClass(size);
        }

        if(buttonMode){
            buttonMode.forEach(function (val){
                let select = val.selector;
                let show = val.show;
                if(show){
                    $(select).attr('style', 'display:block');
                }else{
                    $(select).attr('style', 'display:none');
                }
            });
        }

        callback();
    }
}
