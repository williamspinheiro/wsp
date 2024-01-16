<div class="row justify-content-center mt-4">
    <div class="col-md-12">
        <div class="card card-outline card-default-color shadow mb-4">
            <div class="card-header">
                <div class="d-flex flex-row align-items-center justify-content-between">
                    <h6 class="mt-1 mb-1 font-weight-bold">{{ $cardTitle }}</h6>
                    @yield('table-card-header-sort-button')
                    @yield('table-card-header-dropdow')
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    @yield('table-card-body')
                </div>
            </div>

            <div class="card-footer clearfix">
                @yield('table-card-footer')
            </div>
        </div>
    </div>
</div>