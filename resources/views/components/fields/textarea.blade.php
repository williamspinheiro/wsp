@php
$hasError = $errors->has($name);
@endphp

<div class="form-group col-md-{{ $col }}" style="" id="{{ $id ?? 'textarea-' . Str::slug($label . '-' . $name) }}">
    <label class="col-form-label" for="textarea-{{ Str::slug($label . '-' . $name) }}">
        @if($hasError == true)
        <i class="far fa-times-circle"></i>
        @endif
        {{ $label }}
    </label>
    <textarea class="form-control 
            @if($hasError == true) is-invalid @endif" 
            rows="{{ $rows ?? 3 }}" 
            name="{{ $name }}" 
            id="{{ $id ?? 'textarea-' . Str::slug($label . '-' . $name) }}" 
            placeholder="{{ $placeholder ?? $label }}"
            @if(isset($disabled)) disabled @endif>{{ inputValue($value, $name) }}</textarea>

    @if($hasError == true)
    <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @endif
    <small>{{ $description ?? '' }}</small>
</div>