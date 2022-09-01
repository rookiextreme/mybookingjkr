class Flatpickrinit{
    static initAll(...selector){
        selector.forEach(function(x){
            $(x).flatpickr({
                dateFormat: 'd-m-Y'
            });
        });

    }
}
