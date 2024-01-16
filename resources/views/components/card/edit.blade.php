<div class="card card-outline card-default-color shadow mb-4">
    <div class="card-header">
        <div class="d-flex flex-row align-items-center justify-content-between">
            <h6 class="mt-1 mb-1 font-weight-bold">{{ $cardTitle }}</h6>
            @yield('edit-card-header-dropdow')
        </div>
    </div>

    <div class="card-body">
        @yield('edit-card-body')
    </div>

    <div class="card-footer clearfix">
        @yield('edit-card-footer')
    </div>
</div>