class Validation extends Common{
    checkEmpty(...values){
        let data = new FormData();
        data.append('_token', Common.getToken());
        let validateInput = new ValidateInput();
        let pass = true;
        let l = values.length;
        if(l !== 0){
            values.forEach(function(v){
                let selector = v.selector;
                let value = v.value;
                let label = v.label;
                let key = v.key;

                let ve = Validation.verifyEmpty(value);
                if(ve === true){
                    Validation.addInvalidUI(selector, label);
                    pass = false;
                }else{
                    Validation.removeInvalidUI(selector);
                    let check = validateInput.operateValidate(v);
                    if(pass){
                        pass = check;
                    }

                    data.append(key, value);
                }
            });

            if(pass === true){
                return data;
            }else{
                throw new Error("Data Not Enough");
            }
        }
        throw new Error("No Value Specified");
    }

    static verifyEmpty(value){
        return value === '' || typeof value == 'undefined';
    }

    getValue(selector, type, label, key){
        return {
            selector : selector,
            label : label,
            type : type,
            value : $(selector).val(),
            key : key
        };
    }

    static addInvalidUI(selector, label, empty = true){
        $(selector).addClass('is-invalid').closest('.form-group').find('.invalid-feedback').html(empty === true ? label + ' Cannot Be Empty' : label).attr('style', 'display:block');
    }

    static removeInvalidUI(selector){
        $(selector).removeClass('is-invalid').closest('.form-group').find('.invalid-feedback').html('');
    }
}

class ValidateInput{
    operateValidate(io){
        let selector = io.selector;
        let type = io.type;
        let value = io.value;
        let label = io.label;
        let pass = true;

        let reg = ValidateInput.getRegex(type);
        return type === 'mix' ? pass : ValidateInput.testReg(reg, selector, value);
    }

    static getRegex(type, selector){
        let reObject;
        switch (type) {
            case 'mix':
                Validation.removeInvalidUI(selector);
                break;
            case 'string':
                reObject = {
                    regex: /^([a-zA-Z]+\s)*[a-zA-Z]+$/,
                    label: 'Must Only Contain Characters And Alphabets Only',
                };
                break;
            case 'int':
                reObject = {
                    regex: /^\d+$/,
                    label: 'Must Only Contain Digits',
                };
                break;
            case 'double':
                reObject = {
                    regex: /[^\.].+/,
                    label: 'Must Only Be In Double Format. Eg: 10.0',
                };
                break;
            case 'email':
                reObject = {
                    regex: /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/,
                    label: 'Must Be In Corrent Email Format. Eg: aaa@aaa.com',
                };
                break;
            case 'datedash':
                reObject = {
                    regex: /^\d{4}-\d{2}-\d{2}$/,
                    label: 'Must Be In The Correct Date Format DD-MM-YYYY',
                };
                break;
            case 'datedashstandard':
                reObject = {
                    regex: /^\d{2}-\d{2}-\d{4}$/,
                    label: 'Must Be In The Correct Date Format DD-MM-YYYY',
                };
                break;
            case 'intdoublemix':
                reObject = {
                    regex: /^[+-]?\d+(\.\d+)?$/,
                    label: 'Must Only Be In Double Format Or Integer',
                };
                break;
            case 'datetime':
                reObject = {
                    regex: /^\d{2}-\d{2}-\d{4} (2[0-3]|[01][0-9]):[0-5][0-9]/,
                    label: 'Must Only Be In Date And Time Format',
                };
                break;


        }
        return reObject;
    }

    static testReg(reg, selector, value){
        let pass = true;
        if(!reg.regex.test(value)){
            pass = false;
            Validation.addInvalidUI(selector, reg.label, false);
        }else{
            Validation.removeInvalidUI(selector);
        }
        return pass;
    }
}
