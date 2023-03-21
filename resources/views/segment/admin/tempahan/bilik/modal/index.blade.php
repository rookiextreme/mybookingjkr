<div class="modal fade" id="tempahan-modal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput"><b>Status:</b>&nbsp<span id="status_tempahan"></span></label>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput"><b>No.Rujukan:</b>&nbsp<span id="no_ruj"></span></label>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput"><b>Ditempah Pada:</b> &nbsp<span id="tempah-pada"></span></label>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput"><b>Masa Mula:</b> <span id="tempah-masa-mula"></span></label>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput"><b>Masa Tamat:</b> <span id="tempah-masa-tamat"></span></label>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput"><b>Bilik:</b> <span id="tempah-nama-bilik"></span></label>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput"><b>Fasiliti/Kemudahan:</b><br> <span id="tempah-bilik-fasiliti"></span></label>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput"><b>Perkara:</b> <span id="tempah-tujuan"></span></label>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput"><b>Urusetia:</b> <span id="tempah-urusetia"></span></label>
                            <label class="form-label" for="basicInput"><b>[<span id="tel-urusetia"></span>]</b> </label>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput"><b>Pengerusi:</b> <span id="tempah-pengerusi"></span></label>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput"><b>Bil.Pegawai Agensi:</b> <span id="tempah-agensi-d"></span></label>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput"><b>Bil.Pegawai Luar:</b> <span id="tempah-agensi-l"></span></label>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput"><b>Penerangan:</b> <span id="nota"></span></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="tempahan-edit" data-status="1">Lulus</button>
                <button type="button" class="btn btn-danger" id="tempahan-edit" data-status="2">Tidak Lulus</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="tempahan-id" value="">
