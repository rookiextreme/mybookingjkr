<div class="modal fade" id="tempahan-bilik-modal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput">Masa Mula</label>
                            <input type="text" class="form-control" id="tempahan-bilik-masa-mula" value=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput">Masa Tamat</label>

                            <input type="text" class="form-control" id="tempahan-bilik-masa-tamat" value=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput">Bilik</label>
                            <select class="select2 form-select form-control" id="tempahan-bilik-bilik">
                                <option value="">Sila Pilih</option>
                                @foreach($bangunanBilik as $bb)
                                    <option value="{{ $bb->id }}">{{ $bb->bilikBangunan->nama.', Tingkat '.$bb->aras.', '.$bb->nama.', '.$bb->kapasiti.' orang' }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12">
                        <button style="width:100%" type="button" class="btn btn-primary" id="tempahan-bilik-tengok-kosong">Tengok Kekosongan</button>
                    </div>
                </div>
                <hr>
                <div class="row tempahan-info" style="display: none">
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput">Name</label>
                            <input type="text" class="form-control" id="tempahan-bilik-name" value=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-6">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput">Urusetia</label>
                            <select class="form-control" id="tempahan-bilik-urusetia"></select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-6">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput">No. Telefon Urusetia</label>
                            <input type="text" class="form-control" id="tempahan-bilik-notel-urusetia" value=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput">Pengerusi</label>
                            <input type="text" class="form-control" id="tempahan-bilik-pengerusi" value=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput">Bil. Pegawai Agensi</label>
                            <input type="text" class="form-control" id="tempahan-bilik-agensi" value=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput">Bil. Pegawai</label>
                            <input type="text" class="form-control" id="tempahan-bilik-agensi-l" value=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="mb-1 form-group">
                            <label class="form-label" for="basicInput">Nota</label>
                            <textarea id="tempahan-bilik-nota" class="form-control" id="tempahan-bilik-nota"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="tempahan-bilik-add">Add</button>
                <button type="button" class="btn btn-warning" id="tempahan-bilik-edit">Edit</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="tempahan-bilik-id" value="">
