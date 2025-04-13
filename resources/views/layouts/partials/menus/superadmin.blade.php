@php
    $manajemen_user_condition = request()->is('superadmin/user*') || request()->is('superadmin/role*');
    $detail_laporan = request()->is('rekap_detail/laporan_berkala*') || request()->is('rekap_detail/laporan_insidental*');
@endphp

{{-- <li class="nav-item @if ($manajemen_user_condition) active @endif">
    <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
        <i class="fa-solid fa-user mr-2"></i>
        <span class="menu-title">MANAJEMEN USER</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="collapse @if ($manajemen_user_condition) show @endif" id="auth">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link @if (request()->is('superadmin/user*')) active @endif"
                    href="{{ route('superadmin.user.index') }}">DATA USER</a></li>
            <li class="nav-item"><a class="nav-link @if (request()->is('superadmin/role*')) active @endif"
                    href="{{ route('superadmin.role.index') }}">HAK AKSES</a></li>
        </ul>
    </div>
</li> --}}

<li class="nav-item @if (request()->is('rekap_laporan*')) active @endif">
    <a class="nav-link single-menu" href="{{ route('rekap_laporan.index') }}">
        <i class="fa-solid fa-paper-plane mr-2"></i>
        <span class="menu-title">Rekap Laporan</span>
    </a>
</li>

<li class="nav-item @if ($detail_laporan) active @endif">
    <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
        <i class="fa-solid fa-file mr-2"></i>
        <span class="menu-title">Ketentuan</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="collapse @if ($detail_laporan) show @endif" id="auth">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link @if (request()->is('rekap_detail/laporan_berkala*')) active @endif"
                    href="{{ route('rekap_laporan.detail.berkala.index') }}">Berkala</a></li>
            <li class="nav-item"><a class="nav-link @if (request()->is('rekap_detail/laporan_insidental*')) active @endif"
                    href="{{ route('rekap_laporan.detail.insidental.index') }}">Insidental</a></li>
        </ul>
    </div>
</li>