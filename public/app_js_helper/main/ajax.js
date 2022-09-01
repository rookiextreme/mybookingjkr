class Ajax extends Common{
    static runAjax({url, data, func}){
        $.ajax({
            type:'POST',
            url: this.getUrl() + '/' + url,
            data:data,
            dataType: "json",
            processData: false,
            contentType: false,
            context: this,
            success: function(data) {
                if(data != '' || typeof data != 'undefined'){
                    func(Ajax.parseData(data));
                }else{
                    func();
                }
            },
            error: function (e){
                ToastAlert.toasting('WHOOPS!', e.responseJSON, 'error');
            }
        });
    }

    static parseData(data){
        return {
            success: data.success,
            data: data.data
        };
    }
}
