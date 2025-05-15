<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('light-bootstrap/img/apple-icon.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('light-bootstrap/img/default-avatar') }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>{{ $title }}</title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

        <!-- CSS Files -->
        <link href="{{ asset('light-bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('light-bootstrap/css/light-bootstrap-dashboard.css?v=2.0.0') }} " rel="stylesheet" />

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- CSS for demo purposes -->
        <link href="{{ asset('light-bootstrap/css/demo.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Google Maps JS (hanya satu kali) -->
        <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

        <!-- CSS Toastr -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

    </head>

    <body>
        <div class="wrapper @if (!auth()->check() || request()->route()->getName() == "") wrapper-full-page @endif">
            @if (auth()->check() && request()->route()->getName() != "")
                @include('layouts.navbars.sidebar')
            @endif

            <div class="@if (auth()->check() && request()->route()->getName() != "") main-panel @endif">
                @include('layouts.navbars.navbar')
                @yield('content')
            </div>
        </div>

        @stack('scripts')

        <!-- Core JS Files -->
        <script src="{{ asset('light-bootstrap/js/core/popper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('light-bootstrap/js/core/bootstrap.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('light-bootstrap/js/plugins/jquery.sharrre.js') }}"></script>
        <!-- Plugin for Switches -->
        <script src="{{ asset('light-bootstrap/js/plugins/bootstrap-switch.js') }}"></script>

        <!-- Chartist Plugin -->
        <script src="{{ asset('light-bootstrap/js/plugins/chartist.min.js') }}"></script>

        <!-- Notifications Plugin -->
        <script src="{{ asset('light-bootstrap/js/plugins/bootstrap-notify.js') }}"></script>

        <!-- Light Bootstrap Dashboard Control Center -->
        <script src="{{ asset('light-bootstrap/js/light-bootstrap-dashboard.js?v=2.0.0') }}" type="text/javascript"></script>

        <!-- Light Bootstrap Dashboard Demo methods -->
        <script src="{{ asset('light-bootstrap/js/demo.js') }}"></script>

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- JS Toastr -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

        @stack('js')

        <script>
            // Inisialisasi Select2 pada elemen select yang diinginkan
            $(document).ready(function() {
                $('#select-id').select2();  // Ganti '#select-id' dengan ID elemen select Anda
            });

            // Contoh lainnya untuk social share buttons (jika diperlukan)
            $(document).ready(function () {
                $('#facebook').sharrre({
                    share: { facebook: true },
                    enableHover: false,
                    enableTracking: false,
                    enableCounter: false,
                    click: function(api, options) {
                        api.simulateClick();
                        api.openPopup('facebook');
                    },
                    template: '<i class="fab fa-facebook-f"></i> Facebook',
                    url: 'https://light-bootstrap-dashboard-laravel.creative-tim.com/login'
                });

                $('#google').sharrre({
                    share: { googlePlus: true },
                    enableCounter: false,
                    enableHover: false,
                    enableTracking: true,
                    click: function(api, options) {
                        api.simulateClick();
                        api.openPopup('googlePlus');
                    },
                    template: '<i class="fab fa-google-plus"></i> Google',
                    url: 'https://light-bootstrap-dashboard-laravel.creative-tim.com/login'
                });

                $('#twitter').sharrre({
                    share: { twitter: true },
                    enableHover: false,
                    enableTracking: false,
                    enableCounter: false,
                    buttons: { twitter: { via: 'CreativeTim' } },
                    click: function(api, options) {
                        api.simulateClick();
                        api.openPopup('twitter');
                    },
                    template: '<i class="fab fa-twitter"></i> Twitter',
                    url: 'https://light-bootstrap-dashboard-laravel.creative-tim.com/login'
                });
            });
        </script>
    </body>
</html>
