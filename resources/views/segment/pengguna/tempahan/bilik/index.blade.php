@extends('segment.layouts.main')

@section('CSS')
    @include('segment.layouts.custom_view_links.toast.css.index')
    @include('segment.layouts.custom_view_links.datatable.css.index')
    @include('segment.layouts.custom_view_links.swal.css.index')
    @include('segment.layouts.custom_view_links.select2.css.index')
    @include('segment.layouts.custom_view_links.datepicker.flatpickr.css.index')
@endsection

@section('customCSS')
@endsection

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Tempahan</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Bilik</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="tempahan-bilik-table table">
                    <thead>
                    <tr>
                        <th>Bilik</th>
                        <th>Maklumat Tempahan</th>
                        <th>Tempoh</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Bilik</th>
                            <th>Maklumat Tempahan</th>
                            <th>Tempoh</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@include('segment.pengguna.tempahan.bilik.modal.index')
@include('segment.pengguna.tempahan.bilik.view-tempahan.index')
@endsection

@section('JS')
    @include('segment.layouts.custom_view_links.datepicker.flatpickr.js.index')
    @include('segment.layouts.custom_view_links.toast.js.index')
    @include('segment.layouts.custom_view_links.datatable.js.index')
    @include('segment.layouts.custom_view_links.modals.js.index')
    @include('segment.layouts.custom_view_links.swal.js.index')
    @include('segment.layouts.custom_view_links.select2.js.index')
@endsection

@section('customJS')
    @include('segment.layouts.custom_view_links.customjavascript.index')
    <script src="{{ asset('app_js_helper/segment/pengguna/tempahan/bilik/settings.js') }}"></script>
    <script src="{{ asset('app_js_helper/segment/pengguna/tempahan/bilik/controller.js') }}"></script>
    <script src="{{ asset('app_js_helper/segment/pengguna/tempahan/bilik/main.js') }}"></script>
@endsection
