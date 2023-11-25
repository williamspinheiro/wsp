<div class="card-tools">
    <div class="dropdown no-arrow">
        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v text-dark"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
            <div class="dropdown-header"><b>{{ $dropdowTitle }}</b></div>
            <div class="dropdown-divider my-1"></div>
            @foreach($dropdows as $dropdow)
                @if ($dropdow['permission'])
                    <a class="dropdown-item" href="{{ $dropdow['url'] }}">{{ $dropdow['text'] }}</a>
                @endif
            @endforeach
        </div>
    </div>
</div>