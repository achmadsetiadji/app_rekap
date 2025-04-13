<nav class="navbar navbar-danger col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo text-white fw-bold text-decoration-none" style="font-size: 0.9rem; font-weight: bold" href="{{ route('dashboard') }}">
            Dashboard Monitoring <br>
            Pelaporan BPR/BPRS KOJT
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">
          <img src="{{ asset('images/ojk_logo.png') }}" alt="logo" />
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-left">
            <li class="nav-item">
                <span class="navbar-text text-white">
                </span>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item dropdown">
                <span class="navbar-text text-white">
                    {{ auth()->user()->name }}
                </span>
            </li>
            <li class="nav-item nav-profile d-none d-lg-flex">
                @php
                    $image = auth()->user()->avatar
                        ? load_file($data->avatar)
                        : asset('assets/img/avatar-placeholder.png');
                @endphp
                {{-- <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}background=0D8ABC&color=ff"
                    alt="profile" /> --}}
                {{-- <a href="{{ route('front.profile') }}"><img src="{{ $image }}" alt="profile" /></a>                 --}}
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <i class="icon-ellipsis"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('user.show_form_profil') }}">
                        <i class="fa-solid fa-user text-primary"></i>
                        Profil
                    </a>
                    @impersonating($guard = null)
                        <a class="dropdown-item" href="{{ route('impersonate.leave') }}">
                            <i class="fa-solid fa-person-walking-arrow-right text-primary"></i>
                            Kembali ke Akun Utama
                        </a>
                    @endImpersonating
                    <a class="dropdown-item" onclick="document.querySelector('.form-logout').submit()">
                        <i class="fa-solid fa-right-from-bracket text-primary"></i>
                        Logout
                    </a>

                    <form action="{{ route('logout') }}" method="post" class="d-none form-logout">
                        @csrf
                    </form>
                </div>
            </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
