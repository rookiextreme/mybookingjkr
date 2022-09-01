 var isRtl = $('html').attr('data-textdirection') === 'rtl',
	 clearToastObj;

class ToastAlert{
    static toasting(title, message, toastType){
        toastr[toastType](message, title, {
            showMethod: 'slideDown',
            hideMethod: 'slideUp',
            timeOut: 4000,
            rtl: isRtl
        });
    }
}
