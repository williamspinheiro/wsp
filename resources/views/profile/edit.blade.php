@extends('layouts.app')

<!-- breadcrumb section -->
@section('breadcrumb')
    @php
        $breadcrumbs = [
                'Configurações',
                ['text' => 'Grupos de Acessos', 'url' => action([App\Http\Controllers\ProfileController::class, 'index'])],
                ((empty($profile->id)) ? 'Cadastro' : 'Edição'),
            ];
    @endphp
    @component('components.breadcrumb', ['breadcrumbs' => $breadcrumbs])@endcomponent
@stop

<!-- content section -->
@section('content')

    @php
        //change the variable to the one received by the page
        if(empty($profile->id) == true){
            $cardTitle = 'Cadastro - ';
        } else {
            $cardTitle = 'Edição - ';
        }
        
        //change the string to change the card title
        $cardTitle .= 'Grupo de Acessos';
    @endphp

    <!-- form encompasses the entire card for the footer button to work -->
    <form method="POST" class="form-request" action="{{ URL::action([App\Http\Controllers\ProfileController::class, 'store']) }}">
        @csrf
        
        <!-- edit component -->
        @component('components.card.edit', ['cardTitle' => $cardTitle])

            <!-- card header dropdow section -->
            @section('edit-card-header-dropdow')
                @php
                    //change the string to change the dropdow title
                    $dropdowTitle = 'Grupos de Acessos';

                    //change string options to change dropdown options
                    $dropdowLink = [
                    ['permission' => Auth::user()->can('create', App\Model\Profile::class), 
                        'text' => 'Cadastrar Novo', 
                        'url' => action([App\Http\Controllers\ProfileController::class, 'create'])
                    ],
                    ['permission' => Auth::user()->can('index', App\Models\Profile::class), 
                        'text' => 'Lista', 
                        'url' => action([App\Http\Controllers\ProfileController::class, 'index'])
                    ],

                    ];
                @endphp
                @component('components.dropdow', ['dropdowTitle' => $dropdowTitle, 'dropdows' => $dropdowLink])@endcomponent
            @stop

            <!-- card body section -->
            @section('edit-card-body')
                <div class="card card-default-color card-outline card-outline-tabs mb-0">
                    <!-- card header tabs -->
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="pill" href="#home" role="tab" aria-controls="home" aria-selected="true">Informações</a>
                            </li>
                            @if (empty($profile->id) == false)
                                <li class="nav-item">
                                    <a class="nav-link" id="permissions-tab" data-toggle="pill" href="#permissions" role="tab" aria-controls="permissions" aria-selected="false">Permissões</a>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <!-- card body tabs -->
                    <div class="card-body">
                        <div class="tab-content" id="tabContent">
                            <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="col-md-12">
                                    @if (empty($profile->id) == false)
                                        <input type="hidden" name="id" value="{{ $profile->id }}">
                                    @endif
                                    
                                    <div class="form-row">
                                        @component('components.fields.input', ['col' => 10,
                                                                                'name' => 'name',
                                                                                'value' => $profile,
                                                                                'label' => 'Nome do Grupo de Acessos',
                                                                            ])@endcomponent
        
                                        @component('components.fields.select', ['col' => 2,
                                                                                'name' => 'active',
                                                                                'value' => $profile,
                                                                                'label' => 'Status',
                                                                                'options' => [
                                                                                        [ 'text' => 'Ativo', 'value' => 1 ],
                                                                                        [ 'text' => 'Inativo', 'value' => 0 ],
                                                                                    ],
                                                                            ])@endcomponent

                                        @component('components.fields.textarea', ['col' => 12,
                                                                                    'name' => 'description',
                                                                                    'value' => $profile,
                                                                                    'label' => 'Descrição',
                                                                                ])@endcomponent
                         
                                    </div>
                                </div>
                            </div>

                            @if (empty($profile->id) == false)
                            
                                @php
                                    $permissionIds = $profile->permissions()->pluck('id');
                                @endphp

                                <div class="tab-pane fade" id="permissions" role="tabpanel" aria-labelledby="permissions-tab">
                                    <div class="col-md-12">
                                        <select multiple="multiple" 
                                                name="permission_ids[]" 
                                                class="permissions-list form-control"
                                                selecteds="{{ $permissionIds->toJson() }}">
                                            @foreach($permissions as $permission)
                                                <option value="{{ $permission->id }}" @if(in_array($permission->id, $permissionIds->toArray())) selected="selected" @endif>{{ $permission->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- card footer tabs -->
                    <div class="card-footer clearfix">
                        <div class="text-right">
                            <button type="submit" class="btn btn-default-color btn-sm"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
                        </div>  
                    </div>
                </div>
            @stop
            <!-- card footer section -->
            @section('edit-card-footer')
                
            @stop
        @endcomponent
    </form>
@endsection
