class Flatpickrinit{
    static initAll(...selector){
        selector.forEach(function(x){
            $(x).flatpickr({
                dateFormat: 'd-m-Y'
            });
        });
    }

    static initWithTime(selector){
        $(selector).flatpickr({
            dateFormat: 'd-m-Y H:i',
            enableTime: true
        });
    }
}
