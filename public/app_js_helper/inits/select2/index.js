class Select2init {
    static initAll(){
        $('.select2').each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                dropdownAutoWidth: true,
                width: '100%',
                dropdownParent: $this.parent()
            });
        });
    }

    static penggunaSearch({selector}){
        $(selector).wrap('<div class="position-relative"></div>').select2({
            dropdownAutoWidth: true,
            dropdownParent: $(selector).parent(),
            width: '100%',
            language: {
                inputTooShort: function(){
                    return 'Sekurang-kurangnya mengisi satu huruf...';
                },
                searching: function(){
                    return 'Sedang Mencari Pengguna...';
                }
            },
            ajax: {
                url: Common.getUrl() + '/common/pengguna-carian',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    let parseData = data.data;
                    return {
                        results: parseData,
                        pagination: {
                            more: params.page * 30 < parseData.length
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Sila Isi Nama Pengguna',
            minimumInputLength: 1,
        });
    }
}
