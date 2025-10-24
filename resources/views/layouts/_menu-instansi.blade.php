@php
    use App\Components\Helper;
@endphp

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">MENU UTAMA</li>
        <li class="nav-item">
            <a href="{{ url('/layanan/index') }}" class="nav-link {{ Helper::isMenuActive('layanan/index') }}">
                <i class="fas fa-edit nav-icon"></i>
                <p>Layanan</p>
            </a>
        </li>

        <li class="nav-header">MENU LAINNYA</li>
        <li class="nav-item">
            <a href="{{ url('/user/change-password') }}" class="nav-link {{ Helper::isMenuActive('user/change-password') }}">
                <i class="fas fa-key nav-icon"></i>
                <p>Ganti Password</p>
            </a>
        </li>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        
        <li class="nav-item">
            <a href="#" class="nav-link" 
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt nav-icon"></i>
                <p>Logout</p>
            </a>
        </li>
    </ul>
</nav>