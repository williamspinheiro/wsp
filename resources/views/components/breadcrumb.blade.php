 <!-- Content Header (Page header) -->
 <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="m-0">{{ $title ?? '' }}</h3>
            </div>
            
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a class="breadcrumb-item active" href="{{ url('/home') }}">Dashboard</a></li>
                    @foreach($breadcrumbs as $breadcrumb)
                        @if (is_array($breadcrumb))
                            <li class="breadcrumb-item active" aria-current="page">
                                <a class="breadcrumb-item active" href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['text'] }} </a>
                            </li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">
                                <a class="breadcrumb-item active" href="javascript:;">{{ $breadcrumb }}</a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content-header -->
