@extends('layouts.app')

<!-- breadcrumb section -->
@section('breadcrumb')
    @php
        $breadcrumbs = [
                'Configurações',
                'Usuários'
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
                                                    'url' => 'users/list/filter',
                                                ])@endcomponent

            @component('components.filter.select', ['col' => '2',   
                                                    'name' => 'active',
                                                    'label' => 'Status',
                                                    'options' => [
                                                            [ 'text' => 'Ativo', 'value' => '1' ],
                                                            [ 'text' => 'Inativo', 'value' => '0' ],
                                                        ],
                                                ])@endcomponent

            @component('components.filter.select', ['col' => '6',
                                                    'selectAjax' => true,
                                                    'name' => 'profile_id',
                                                    'label' => 'Grupo de Acessos',
                                                    'url' => 'profiles/list/filter',
                                                    'dataId' => true
                                                ])@endcomponent

            @component('components.filter.input', ['col' => '6',
                                                    'name' => 'email', 
                                                    'label' => 'E-mail'
                                                ])@endcomponent
        @stop

        <!-- filter card footer section -->
        @section('filter-card-footer')
            @component('components.filter.buttons')@endcomponent
        @stop

    @endcomponent

    @php    
        //change the string to change the card title
        $cardTitle = 'Usuários';
    @endphp

    <!-- table component -->
    @component('components.card.table', ['cardTitle' => $cardTitle])

        <!-- card header dropdow section -->
        @section('table-card-header-dropdow')
            @php
                //change the string to change the dropdow title
                $dropdowTitle = 'Usuários';

                //change string options to change dropdown options
                $dropdowLink = [
                ['permission' => Auth::user()->can('create', App\Model\User::class), 
                    'text' => 'Cadastrar Novo', 
                    'url' => action([App\Http\Controllers\UserController::class, 'create'])
                ],

                ];
            @endphp
            @component('components.dropdow', ['dropdowTitle' => $dropdowTitle, 'dropdows' => $dropdowLink])@endcomponent
        @stop
        
        <!-- table card body section -->
        @section('table-card-body')
            <table class="table-sm table-striped table-bordered" 
                    id="table-default" 
                    data-url="{{ action([\App\Http\Controllers\UserController::class, 'getList']) }}" 
                    data-msg="Usuário" 
                    width="100%"
                    >
                <thead>
                    <tr>
                    <th column="id" width="5%" data-class="text-center">ID</th>
                    <th column="photo" width="7%" data-order="0" data-type="photo-user" >Foto</th>
                    <th column="name">Nome</th>
                    <th column="email">E-mail</th>
                    <th column="profile_id" width="15%" data-class="text-center">Grupo de Acessos</th>
                    <th column="active" width="7%" data-type="active" data-url="{{ action([\App\Http\Controllers\UserController::class, 'active']) }}">Status</th>
                    <th column="active" width="7%" data-type="action" actions="[{ description: 'Editar', url: 'users/%s/edit', field: 'id', icon: 'fas fa-edit', class: 'edit' }, { description: 'Remover', url: 'users/%s', field: 'id', icon: 'fas fa-trash-alt', class: 'delete' }]">Ações</th>
                    </tr>
                </thead>
            </table>
        @stop
    @endcomponent
@endsection