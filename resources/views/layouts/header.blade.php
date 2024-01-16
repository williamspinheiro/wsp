<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light bg-default-color">
                
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href=" " role="button"><i class="fa-solid fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">                
        
        <!-- Nav Item - Alerts -->
        
        <li class="nav-item">
            <div class="theme-switch-wrapper nav-link">
                <label class="theme-switch" for="checkbox" title="Dark Mode">
                    <input type="checkbox" id="checkbox">
                    <i class="fa-solid fa-moon"></i>
                </label>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" title="Fullscreen" href="javascript:;" role="button">
                <i class="fa-solid fa-maximize"></i>
            </a>
        </li>

        <li class="nav-item mr-n2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="nav-link" title="Sair" onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="mr-2 fa-solid fa-right-from-bracket"></i>
                </a>
            </form>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-default-color elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/home') }}" class="brand-link logo-switch">
        <!-- Small brand logo -->
        <img src="{{ asset('img/logo_mini.png') }}" alt="WSP" class="brand-image-xl logo-xs" style="left: 25px; top: 7px">
        <!-- Large brand logo -->
        <img src="{{ asset('img/logo.png') }}" alt="WSP" class="brand-image-xl logo-xl" style="left: 25px; top: 7px; width: 185px">
    </a>

    @include('layouts.menu')
</aside>