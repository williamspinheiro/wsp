@extends('layouts.app')

<!-- breadcrumb section -->
@section('breadcrumb')
    @php
        $breadcrumbs = [
                'Configurações',
                ['text' => 'Usuários', 'url' => action([App\Http\Controllers\UserController::class, 'index'])],
                ((empty($user->id)) ? 'Cadastro' : 'Edição'),
            ];
    @endphp
    @component('components.breadcrumb', ['breadcrumbs' => $breadcrumbs])@endcomponent
@stop

<!-- content section -->
@section('content')

    @php
        //change the variable to the one received by the page
        if(empty($user->id) == true){
            $cardTitle = 'Cadastro - ';
        } else {
            $cardTitle = 'Edição - ';
        }
        
        //change the string to change the card title
        $cardTitle .= 'Usuário';
    @endphp
    
    <!-- form encompasses the entire card for the footer button to work -->
    <form method="POST" class="form-request" action="{{ URL::action([App\Http\Controllers\UserController::class, 'store']) }}">
        @csrf

        <!-- edit component -->
        @component('components.card.edit', ['cardTitle' => $cardTitle])

            <!-- card header dropdow section -->
            @section('edit-card-header-dropdow')
                @php
                    //change the string to change the dropdow title
                    $dropdowTitle = 'Usuários';

                    //change string options to change dropdown options
                    $dropdowLink = [
                    ['permission' => Auth::user()->can('create', App\Model\User::class), 
                        'text' => 'Cadastrar Novo', 
                        'url' => action([App\Http\Controllers\UserController::class, 'create'])
                    ],

                    ['permission' => Auth::user()->can('index', App\Model\User::class), 
                        'text' => 'Lista', 
                        'url' => action([App\Http\Controllers\UserController::class, 'index'])
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
                            @if (empty($user->id) == false && Auth::user()->profile_id == 1)
                                <li class="nav-item">
                                    <a class="nav-link" id="login-url-tab" data-toggle="pill" href="#login-url" role="tab" aria-controls="login-url" aria-selected="false">Login</a>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <!-- card body tabs -->
                    <div class="card-body">
                        <div class="tab-content" id="tabContent">
                            <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-7">
                                        @if (empty($user->id) == false)
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                        @endif
                                        
                                        <div class="form-row">

                                            @component('components.fields.input', ['col' => 9,
                                                                                    'name' => 'name',
                                                                                    'value' => $user,
                                                                                    'placeholder' => 'Nome completo',
                                                                                    'label' => 'Nome',
                                                                                ])@endcomponent

                                            @component('components.fields.select', ['col' => 3,
                                                                                    'name' => 'active',
                                                                                    'value' => $user,
                                                                                    'label' => 'Status',
                                                                                    'options' => [
                                                                                            [ 'text' => 'Ativo', 'value' => 1 ],
                                                                                            [ 'text' => 'Inativo', 'value' => 0 ],
                                                                                        ],
                                                                                ])@endcomponent

                                            @component('components.fields.input', ['col' => 6,
                                                                                    'name' => 'email',
                                                                                    'value' => $user,
                                                                                    'label' => 'E-mail',
                                                                                    'type' => 'email'
                                                                                ])@endcomponent

                                            @component('components.fields.select-search', ['col' => 6,
                                                                                            'name' => 'profile_id',
                                                                                            'value' => $user,
                                                                                            'label' => 'Grupo de Acesso',
                                                                                            'option' => $user->profile,
                                                                                            'optionText' => 'name', 
                                                                                            'optionValue' => 'id', 
                                                                                            'url' => 'profiles/list/filter'
                                                                                        ])@endcomponent

                                            @component('components.fields.input', ['col' => 12,
                                                                                    'name' => 'password',
                                                                                    'value' => $user,
                                                                                    'label' => 'Senha',
                                                                                    'type' => 'password',
                                                                                    'description' => 'Senha deve ter mais de 8 caracteres, deve conter pelo menos 1 maiúscula, 1 minúscula, 1 numérico e 1 caractere especial(#?!@$%^&*-).'
                                                                                ])@endcomponent

                                            @component('components.fields.input', ['col' => 12,
                                                                                    'name' => 'password_confirmation',
                                                                                    'value' => $user,
                                                                                    'label' => 'Confirme a Senha',
                                                                                    'type' => 'password',
                                                                                ])@endcomponent

                                            @component('components.fields.checkbox', ['col' => 12,
                                                                                        'name' => 'password_temporary',
                                                                                        'value' => 1,
                                                                                        'checked' => $user,
                                                                                        'label' => 'Forçar Alteração de Senha no Próximo Login',
                                                                                    ])@endcomponent

                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-row">
                                            @component('components.fields.file-input', ['col' => 12,
                                                                                            'name' => 'photo',
                                                                                            'id' => 'photo',
                                                                                            'label' => 'Foto',
                                                                                            'icon' => 'fa-solid fa-image',
                                                                                            'preview' => true,
                                                                                            'accept' => '.jpg,.jpeg,.png',
                                                                                            'description' => 'Extensão permitida - png | jpg | jpeg',
                                                                                        ])@endcomponent

                                            <div class="form-group col-md-12">
                                                <label for="inputState">Preview Foto</label>
                                                <picture>
                                                    <source srcset="..." type="image/png+jpg+jpeg">
                                                    <img id="img-preview" 
                                                        class="img-fluid img-thumbnail rounded mx-auto d-block"
                                                        style="max-width: 100%; max-height:250px"
                                                        src="@if (empty($user->photo) == false) {{ asset('storage/' . $user->photo) }} @else {{ asset('img/no_image.png') }} @endif">
                                                </picture>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (empty($user->id) == false && Auth::user()->profile_id == 1)
                                <div class="tab-pane col-md-12" id="login-url">
                                    @php
                                        $password = Hash::make(buildTokenByUser($user));
                                    @endphp

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="">Token:</label>
                                            <textarea onclick="myFunction(this)" class="form-control">{{ url('/users/login/' . $user->id ) . '?token='.urlencode($password) }}</textarea>
                                        </div>
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
        @endcomponent
    </form>
@endsection
