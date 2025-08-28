@extends('layouts/app', [
    'activePage' => 'welcome',
    'title' => 'Welcome'
])

@section('content')
    <div class="full-page section-image"
         data-color="black"
         data-image="{{ asset('light-bootstrap/img/gambar_primajasa.jpg') }}">
        <div class="content">
            <div class="container text-center mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <h1 class="text-white text-center">
                            {{ __('Selamat Datang Di Stok Gudang Primajasa') }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            demo.checkFullPageBackgroundImage();

            setTimeout(function () {
                // After 700 ms we remove the 'card-hidden' class from any card
                $('.card').removeClass('card-hidden');
            }, 700);
        });
    </script>
@endpush
