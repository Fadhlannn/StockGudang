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
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-house"></i>
                    <p>{{ __("dashboard") }}</p>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasRole('Admin') || auth()->user()->hasAccessTo('Konfigurasi'))
                <li class="nav-item @if($activePage == 'Konfigurasi') active @endif">
                    <a class="nav-link" data-toggle="collapse" href="#Konfigurasi">
                        <i class="fa-solid fa-sliders "></i>
                        </i>
                        <p>
                            {{ __('Konfigurasi') }}
                            <b class="caret"></b>
                        </p>
                    </a>

                    <div class="collapse" id="Konfigurasi">
                        <ul class="nav">
                            @if(auth()->user()->hasAccessTo('Menu'))
                                <li class="nav-item @if($activePage == 'Menu') active @endif">
                                    <a class="nav-link" href="{{ route('index.menu') }}">
                                        <i class="fa-solid fa-bars"></i>
                                        <p>{{ __("Menu") }}</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasAccessTo('Role'))
                                <li class="nav-item @if($activePage == 'Role') active @endif">
                                    <a class="nav-link" href="{{ route('index.role') }}">
                                        <i class="fa-solid fa-registered"></i>
                                        <p>{{ __("Role") }}</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasAccessTo('Permission'))
                                <li class="nav-item @if($activePage == 'permission') active @endif">
                                    <a class="nav-link" href="{{ route('konfigurasi.permission') }}">
                                        <i class="fa-solid fa-peseta-sign"></i>
                                        <p>{{ __("Permission") }}</p>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->hasAccessTo('Hak-Akses'))
                                <li class="nav-item @if($activePage == 'hakakses') active @endif">
                                    <a class="nav-link" href="{{ route('hakakses') }}">
                                        <i class="fa-solid fa-users-gear"></i>
                                        <p>{{ __("Hak Akses") }}</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif
            @if(auth()->user()->hasAccessTo('Bus'))
            <li class="nav-item @if($activePage == 'Bus') active @endif">
                <a class="nav-link" href="{{route('Bus')}}">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <p>{{ __("Bus") }}</p>
                </a>
            </li>
            @endif

            <li class="nav-item @if($activePage == 'Pengemudi') active @endif">
                <a class="nav-link" href="{{route('Pengemudi')}}">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <p>{{ __("Pengemudi") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'Route') active @endif">
                <a class="nav-link" href="{{route('Route')}}">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <p>{{ __("Route") }}</p>
                </a>
            </li>

            @if(auth()->user()->hasAccessTo('Sparepart'))
            <li class="nav-item @if($activePage == 'Sparepart') active @endif">
                <a class="nav-link" href="{{ route('Sparepart') }}">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <p>{{ __("Sparepart") }}</p>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasAccessTo('Stok'))
            <li class="nav-item @if($activePage == 'stok') active @endif">
                <a class="nav-link" href="{{ route('stok.index') }}">
                    <i class="fa-solid fa-cubes"></i>
                    <p>{{ __("stok") }}</p>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasAccessTo('DataMasuk'))
            <li class="nav-item @if($activePage == 'DataMasuk') active @endif">
                <a class="nav-link" href="{{ route('DataMasuk') }}">
                    <i class="fa-solid fa-house"></i>
                    <p>{{ __("DataMasuk") }}</p>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasAccessTo('Spk'))
            <li class="nav-item @if($activePage == 'Spk') active @endif">
                <a class="nav-link" href="{{ route('Spk') }}">
                    <i class="fa-solid fa-house"></i>
                    <p>{{ __("Spk") }}</p>
                </a>
            </li>
            @endif

            <li class="nav-item @if($activePage == 'LogOut') active @endif">
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-power-off"></i>
                    <p>{{ __("LogOut") }}</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
