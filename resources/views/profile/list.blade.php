@extends('layouts.app')

<!-- breadcrumb section -->
@section('breadcrumb')
    @php
        $breadcrumbs = [
                'Configurações',
                'Grupos de Acessos'
            ];
    @endphp
    @component('components.breadcrumb', ['breadcrumbs' => $breadcrumbs])@endcomponent
@stop

<!-- content section -->
@section('content')

    <!-- filter component -->
    @component('components.card.filter')

        <!-- filter card body section -->
        @section('filter-card-body')
            
            @component('components.filter.input', ['col' => '2',
                                                    'type' => 'number',
                                                    'name' => 'id', 
                                                    'label' => 'ID'
                                                ])@endcomponent

            @component('components.filter.select', ['col' => '8',
                                                    'selectAjax' => true,
                                                    'name' => 'name',
                                                    'label' => 'Nome',
                                                    'url' => 'profiles/list/filter',
                                                ])@endcomponent

            @component('components.filter.select', ['col' => '2',   
                                                    'name' => 'active',
                                                    'label' => 'Status',
                                                    'options' => [
                                                            [ 'text' => 'Ativo', 'value' => '1' ],
                                                            [ 'text' => 'Inativo', 'value' => '0' ],
                                                        ],
                                                ])@endcomponent
        @stop

        <!-- filter card footer section -->
        @section('filter-card-footer')
            @component('components.filter.buttons')@endcomponent
        @stop

    @endcomponent

    @php    
        //change the string to change the card title
        $cardTitle = 'Grupos de Acessos';
    @endphp

    <!-- table component -->
    @component('components.card.table', ['cardTitle' => $cardTitle])

        <!-- card header dropdow section -->
        @section('table-card-header-dropdow')
            @php
                //change the string to change the dropdow title
                $dropdowTitle = 'Grupos de Acessos';

                //change string options to change dropdown options
                $dropdowLink = [
                ['permission' => Auth::user()->can('create', App\Model\Profile::class), 
                    'text' => 'Cadastrar Novo', 
                    'url' => action([App\Http\Controllers\ProfileController::class, 'create'])
                ],

                ];
            @endphp
            @component('components.dropdow', ['dropdowTitle' => $dropdowTitle, 'dropdows' => $dropdowLink])@endcomponent
        @stop
        
        <!-- table card body section -->
        @section('table-card-body')
            <table class="table-sm table-striped table-bordered" 
                    id="table-default" 
                    data-url="{{ action([\App\Http\Controllers\ProfileController::class, 'getList']) }}" 
                    data-msg="Grupo de Acessos" 
                    width="100%"
                    >
                <thead>
                    <tr>
                    <th column="id" width="5%" data-class="text-center">ID</th>
                    <th column="name">Nome</th>
                    <th column="active" width="7%" data-type="active" data-url="{{ action([\App\Http\Controllers\ProfileController::class, 'active']) }}">Status</th>
                    <th column="active" width="7%" data-type="action" actions="[{ description: 'Editar', url: 'profiles/%s/edit', field: 'id', icon: 'fas fa-edit', class: 'edit' }, { description: 'Remover', url: 'profiles/%s', field: 'id', icon: 'fas fa-trash-alt', class: 'delete' }]">Ações</th>
                    </tr>
                </thead>
            </table>
        @stop
    @endcomponent
@endsection