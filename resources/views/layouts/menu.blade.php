<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('img/anon_red.png') }}" class="img-circle elevation-2" alt="{{ Auth::user()->name }}">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Pesquisar" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Divider -->
    <div class="user-panel my-2"></div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column text-sm" data-widget="treeview" role="menu"
            data-accordion="false">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ URL::route('home') }}">
                    <i class="nav-icon fa-solid fa-chart-line"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <!-- Divider -->
            <div class="user-panel my-2"></div>

            <!-- Nav Item - Configurações -->
            <li class="nav-item">
                <a href="#" class="nav-link" data-parent="#accordionSidebar">
                    <i class="fa-solid fa-gears nav-icon"></i>
                    <p>
                        Configurações
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">                   
                    <!-- Nav Item - Usuários -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa-solid fa-users-gear"></i>
                            <p>
                                Usuários
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: none;">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa-solid fa-user-gear"></i>
                                    <p>Grupo de Acessos</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa-solid fa-user-tie"></i>
                                    <p>Usuários</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <!-- Divider -->
            <div class="user-panel my-2"></div>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->

