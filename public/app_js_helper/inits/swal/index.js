class SwalUI{
    static init(
        {
            title = 'Are You Sure?',
            subtitle = "You won't be able to revert this!",
            icon,
            confirmText,
            confirmButtonClass = 'btn btn-primary',
            cancelButtonClass = 'btn btn-warning',
            callback = function (){}
        }
    ){
        Swal.fire({
            title: title,
            text: subtitle,
            icon: icon,
            showCancelButton: true,
            confirmButtonText: confirmText,
            customClass: {
                confirmButton: confirmButtonClass,
                cancelButton: cancelButtonClass
            },
        }).then(function (result) {
            if (result.value) {
                callback();

            }
        });
    }

    static fireSwal(
        {
            icon,
            title,
            subtitle,
        }
    ){
        Swal.fire({
            icon: icon,
            title: title,
            text: subtitle,
            customClass: {
                confirmButton: 'btn btn-primary'
            }
        });
    }
}
