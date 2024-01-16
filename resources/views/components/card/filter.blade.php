@if(isset($filterQuality) == true) 
    <form id="filter-form-quality" method="GET">
@else
    <form id="filter-form">   
@endif
    @csrf

    <div class="card card-outline card-default-color shadow mb-4 @if(isset($collapsed) == false) collapsed-card @endif">
        <div class="card-header" type="button" data-card-widget="collapse" data-toggle="collapse" data-target="#filter-accordion">
            <div class="d-flex flex-row align-items-center justify-content-between">
                <h6 class="mt-1 mb-1 font-weight-bold">Filtros</h6>            
                <div class="mr-n1 card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        @if(isset($collapsed) == false)
                            <i class="fas fa-chevron-right text-dark"></i>
                        @else
                            <i class="fas fa-chevron-down text-dark"></i>
                        @endif
                    </button>
                </div>
            </div>
        </div>
    
        <div class="card-body">
            @if(isset($formRow) == false) 
                <div class="form-row">
            @endif
                    @yield('filter-card-body')
            @if(isset($formRow) == false) 
                </div>
            @endif
        </div>
        <div class="card-footer clearfix">
            @yield('filter-card-footer')
        </div>
    </div> 
</form>