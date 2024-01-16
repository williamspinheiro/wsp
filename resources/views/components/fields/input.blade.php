@php
$hasError = $errors->has($name);
$propeties = (isset($props) == true) ? $props : [];
@endphp

<div class="form-group col-md-{{ $col }}" style="" id="{{ $id ?? 'input-' . Str::slug($label . '-' . $name) }}">
    <label class="col-form-label" for="input-{{ Str::slug($label . '-' . $name) }}">
        @if($hasError == true)
        <i class="far fa-times-circle"></i>
        @endif
        {{ $label }}
    </label>
    <input type="{{ $type ?? 'text' }}" 
            name="{{ $name }}"
            class="form-control @if($hasError == true) is-invalid @endif {{ $class ?? '' }}" 
            id="input-{{ Str::slug($label . '-' . $name) }}" 
            placeholder="{{ $placeholder ?? $label }}"
            @if ($name != 'password') value="{{ inputValue($value, $name) }}" @endif
            @if(isset($disabled)) disabled @endif
            @foreach($propeties as $key => $prop) {{ $key }}="{{ $prop }}" @endforeach
        >

        @if($hasError == true)
            <div class="invalid-feedback">{{ $errors->first($name) }}</div>
        @endif

        @if (isset($description)) 
            <small>{{ $description }}</small>
        @endif
</div>