<div class="sidebar" >
    {{-- data-image="{{ asset('light-bootstrap/img/sidebar-5.jpg') }}" --}}
    <!--
Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

Tip 2: you can also add an image using data-image tag
-->
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="" class="simple-text">
                {{ __("Stock Gudang") }}
            </a>
        </div>
        <ul class="nav">
            @if(auth()->user()->hasAccessTo('Dashboard'))
            <li class="nav-item @if($activePage == 'dashboard') active @endif">
                <a class="nav-link" href="{{ route('Dashboard') }}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>{{ __("dashboard") }}</p>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasAccessTo('Konfigurasi'))
                <li class="nav-item @if($activePage == 'Konfigurasi') active @endif">
                    <a class="nav-link" data-toggle="collapse" href="#laravelExamples">
                        <i>
                            <img src="{{ asset('light-bootstrap/img/laravel.svg') }}" style="width:25px">
                        </i>
                        <p>
                            {{ __('Konfigurasi') }}
                            <b class="caret"></b>
                        </p>
                    </a>

                    <div class="collapse" id="laravelExamples">
                        <ul class="nav">
                            @if(auth()->user()->hasAccessTo('Menu'))
                                <li class="nav-item @if($activePage == 'Menu') active @endif">
                                    <a class="nav-link" href="{{ route('index.menu') }}">
                                        <i class="nc-icon nc-single-02"></i>
                                        <p>{{ __("Menu") }}</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasAccessTo('Role'))
                                <li class="nav-item @if($activePage == 'Role') active @endif">
                                    <a class="nav-link" href="{{ route('index.role') }}">
                                        <i class="nc-icon nc-circle-09"></i>
                                        <p>{{ __("Role") }}</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasAccessTo('Permission'))
                                <li class="nav-item @if($activePage == 'Permission') active @endif">
                                    <a class="nav-link" href="{{ route('konfigurasi.permission') }}">
                                        <i class="nc-icon nc-single-02"></i>
                                        <p>{{ __("Permission") }}</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasAccessTo('Hak-Akses'))
                                <li class="nav-item @if($activePage == 'Hak-Akses') active @endif">
                                    <a class="nav-link" href="{{ route('hakakses') }}">
                                        <i class="nc-icon nc-single-02"></i>
                                        <p>{{ __("Hak Akses") }}</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif

            {{-- <li class="nav-item @if($activePage == 'table') active @endif">
                <a class="nav-link" href="">
                    <i class="nc-icon nc-notes"></i>
                    <p>{{ __("Table List") }}</p>
                </a>
            </li> --}}

            <li class="nav-item @if($activePage == 'LogOut') active @endif">
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nc-icon nc-button-power"></i>
                    <p>{{ __("LogOut") }}</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
