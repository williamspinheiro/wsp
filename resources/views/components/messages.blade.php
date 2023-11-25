@if ($errors->any())
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach ($errors->all() as $error)
                $(document).Toasts('create', {
                    class: 'bg-danger-default',
                    title: 'Os dados fornecidos são inválidos.',
                    body: '&nbsp; {{ $error }}',
                    icon: 'fa-solid fa-xmark',
                    delay: 6000,
                    autohide: true,
                    animation: true,
                });
            @endforeach
        });
    </script>
@stop
@endif

@if(Session::has('alert-success'))
    
    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $(document).Toasts('create', {
                    class: 'bg-success-default',
                    title: 'Ação executada com sucesso.',
                    body: '{{ Session::get('alert-success') }}',
                    icon: 'fa-solid fa-check',
                    delay: 6000,
                    autohide: true,
                    animation: true,
                });
        });
    </script>
@stop
    @php
        Session::forget('alert-success');
    @endphp
@endif