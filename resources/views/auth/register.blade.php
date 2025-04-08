@extends('layouts.app', ['activePage' => 'register', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION'])

@section('content')
    <div class="full-page section-image" data-color="black" data-image="{{ asset('light-bootstrap/img/full-screen-image-2.jpg') }}">
        <div class="content pt-5">
            <div class="container mt-5">
                <div class="col-md-4 col-sm-6 ml-auto mr-auto">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="card card-register card-hidden">
                            <div class="card-header ">
                                <h3 class="header text-center">{{ __('Register') }}</h3>
                            </div>
                            <div class="card-body ">
                                <div class="card card-plain">
                                    <div class="content">
                                        <div class="form-group">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>
                                        </div>

                                        <div class="form-group">   {{-- is-invalid make border red --}}
                                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter email" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="password" name="password" placeholder="Password" class="form-control" required >
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_confirmation" placeholder="Password Confirmation" class="form-control" required autofocus>
                                        </div>

                                        <div class="footer text-center">
                                            <div class="container text-center" >
                                                <button type="submit" class="btn btn-warning btn-wd">{{ __('Create Free Account') }}</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();

            setTimeout(function() {
                // after 1000 ms we add the class animated to the login/register card
                $('.card').removeClass('card-hidden');
            }, 700)
        });
    </script>
@endpush
