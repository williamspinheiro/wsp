@extends('layouts.app')

<!-- breadcrumb section -->
@section('breadcrumb')
    @php
        $breadcrumbs = [
                'Dados Pessoais'
            ];
    @endphp
    @component('components.breadcrumb', ['breadcrumbs' => $breadcrumbs])@endcomponent
@stop

<!-- content section -->
@section('content')

    @php
        //change the string to change the card title
        $cardTitle = 'Dados Pessoais';
    @endphp
    
    <!-- form encompasses the entire card for the footer button to work -->
    <form method="POST" class="form-request" action="{{ URL::action([\App\Http\Controllers\UserController::class, 'saveProfile']) }}">
        @csrf

        <!-- edit component -->
        @component('components.card.edit', ['cardTitle' => $cardTitle])

            <!-- card body section -->
            @section('edit-card-body')
                    
                <div class="row">

                        @if(Auth::user()->password_temporary == 1)
                        <div class="col-md-12">
                            <div class="message">
                                <div class="alert alert-default-danger">
                                    É necessario efetuar a troca da senha para continuar utilizando o sistema!
                                </div>
                            </div>
                        </div>

                        <input type="hidden" value="{{ \Auth::user()->password_temporary }}" name="password_temporary">
                    @endif

                    <input type="hidden" value="{{ \Auth::user()->id }}" name="id">
                    <input type="hidden" value="{{ \Auth::user()->profile_id }}" name="profile_id">
                    <input type="hidden" value="{{ \Auth::user()->active }}" name="active">

                    <div class="col-md-7">
                        <div class="form-row">
                             @component('components.fields.input', ['col' => 12,
                                                                    'name' => 'name',
                                                                    'value' => $user,
                                                                    'placeholder' => 'Nome completo',
                                                                    'label' => 'Nome',
                                                                ])@endcomponent

                            @component('components.fields.input', ['col' => 12,
                                                                    'name' => 'email',
                                                                    'value' => $user,
                                                                    'label' => 'E-mail',
                                                                    'type' => 'email'
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
            @stop

            <!-- card footer section -->
            @section('edit-card-footer')
                <div class="text-right">
                    <button type="submit" class="btn btn-default-color btn-sm"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
                </div>
            @stop
        @endcomponent
    </form>
@endsection