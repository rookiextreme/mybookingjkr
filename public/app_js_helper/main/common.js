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
}
