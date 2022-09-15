<div class="modal fade" id="bangunan-modal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                            <label class="form-label" for="basicInput">Lokasi</label>
                            <select class="select2 form-select form-control" id="bangunan-lokasi">
                                <option value="">Sila Pilih</option>
                                @foreach($lokasiList as $l)
                                    <option value="{{ $l->id }}">{{ $l->nama }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput">Name</label>
                            <input type="text" class="form-control" id="bangunan-name" value=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="bangunan-add">Tambah</button>
                <button type="button" class="btn btn-warning" id="bangunan-edit">Kemaskini</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="bangunan-id" value="">
