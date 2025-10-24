@php
    use App\Components\Helper;
    use App\Constants\UserConstant;
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
        <li class="nav-item {{ Helper::isMenuActive(['penilaian-aspek/*', 'penilaian-kelompok/*', 'penilaian-indikator/*']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Helper::isMenuActive(['penilaian-aspek/*', 'penilaian-kelompok/*', 'penilaian-indikator/*']) }}">
                <i class="fas fa-folder-open nav-icon"></i>
                <p>
                    Referensi
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('/penilaian-aspek/index') }}" class="nav-link {{ Helper::isMenuActive('penilaian-aspek/*') }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pemicu Layanan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/penilaian-indikator/index') }}" class="nav-link {{ Helper::isMenuActive('penilaian-indikator/*') }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Teknis Layanan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/penilaian-indikator/index') }}" class="nav-link {{ Helper::isMenuActive('penilaian-indikator/*') }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Penerima Manfaat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/penilaian-indikator/index') }}" class="nav-link {{ Helper::isMenuActive('penilaian-indikator/*') }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Produk Layanan</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ url('/instansi/index') }}" class="nav-link {{ Helper::isMenuActive('instansi/index') }}">
                <i class="fas fa-building nav-icon"></i>
                <p>Perangkat Daerah</p>
            </a>
        </li>
        <li class="nav-item has-treeview {{ Helper::isMenuActive('user/index') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Helper::isMenuActive('user/index') }}">
                <i class="fas fa-users nav-icon"></i>
                <p>
                    User
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @php
                    $userRoles = [
                        ['label' => 'Admin', 'link' => '/user/index?id_role=' . UserConstant::ROLE_ADMIN],
                        ['label' => 'Perangkat Daerah', 'link' => '/user/index?id_role=' . UserConstant::ROLE_INSTANSI],
                    ];
                @endphp

                @foreach($userRoles as $role)
                <li class="nav-item">
                    <a href="{{ url($role['link']) }}" class="nav-link {{ Helper::isMenuActive($role['link']) }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ $role['label'] }}</p>
                    </a>
                </li>
                @endforeach
            </ul>
        </li>
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
