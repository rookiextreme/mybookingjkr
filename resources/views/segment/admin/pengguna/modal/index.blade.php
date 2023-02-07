<div class="modal fade" id="pengguna-modal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input check-peranan" data-id="1" type="checkbox" id="admin-check" value=""/>
                                <label class="form-check-label" for="inlineCheckbox1">Admin</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input check-peranan" data-id="2" type="checkbox" id="pengguna-check" value=""/>
                                <label class="form-check-label" for="inlineCheckbox1">Pengguna</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="pengguna-add">Tambah</button>
                <button type="button" class="btn btn-warning" id="pengguna-edit">Kemaskini</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="pengguna-id" value="">
