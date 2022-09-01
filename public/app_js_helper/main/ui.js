class UiSet{
    static setValue(data){
        if(data.length > 0){
            data.forEach(function(val){
                let select = val[0];
                let value = val[1];
                let type = val[2];

                switch(type){
                    case 'textbox':
                        $(select).val(value);
                        break;
                    case 'dropdown':
                        $(select).val(value).trigger('change');
                        break;
                    default:
                        console.log('Jesus is here');
                }
            });
        }
    }
}
