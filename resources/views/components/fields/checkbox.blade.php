@php
$hasError = $errors->has($name);
@endphp

<div class="form-group col-md-{{ $col }}">
    <div class="custom-control custom-checkbox">
        <input class="custom-control-input" 
                type="checkbox" 
                id="checkbox-{{ Str::slug($label . '-' . $name) }}" 
                value="{{ $value }}"
                name="{{ $name }}"
                @if (inputValue($checked, $name) == $value) checked @endif>
        <label class="custom-control-label"
            for="checkbox-{{ Str::slug($label . '-' . $name) }}">
            @if($hasError == true)
                <i class="far fa-times-circle"></i>
            @endif 
            {{ $label }}
        </label>
    @if($hasError == true)
        <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @endif
    </div>
</div>