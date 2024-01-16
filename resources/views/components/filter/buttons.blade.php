<div class="text-right">

    @if(empty($filterButton) == true)
        <button type="{{ $type ?? 'button' }}" id="btn-filter" class="btn btn-secondary btn-sm @if(empty($cleanButton) == true) mr-2 @endif" data-toggle="tooltip" data-original-title="Filtrar"><i class="fa fa-filter"></i> FILTRAR</button>
    @endif

    @if(empty($cleanButton) == true)
        <button type="button" id="btn-clear" class="btn btn-danger btn-sm" data-toggle="tooltip" data-original-title="Limpar Formulário"><i class="fa fa-trash-can" ></i> LIMPAR</button>
    @endif

</div>