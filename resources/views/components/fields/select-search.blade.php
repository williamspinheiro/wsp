@php
    $hasError = $errors->has($name);
    $propeties = isset($props) == true ? $props : [];
@endphp

<div class="form-group col-md-{{ $col }}" 
    style="{{ $style ?? '' }}" 
    id="{{ $id ?? 'select-' . Str::slug($label . '-' . $name) }}">
    <label class="col-form-label" for="{{ $id ?? 'select-' . Str::slug($label . '-' . $name) }}">
        @if ($hasError == true)
            <i class="far fa-times-circle"></i>
        @endif
        {{ $label }}
    </label>
    <select
        class="form-control {{ $class ?? 'select-ajax' }} select2-default-color @if ($hasError == true) is-invalid @endif"
        name="{{ $name }}" 
        data-term="{{ $term ?? 'name' }}"
        url="{{ $url }}" 
        id="{{ $id ?? 'select-' . Str::slug($label . '-' . $name) }}"
        method="{{ $method ?? 'GET' }}"
        @if (isset($multiple)) 
            multiple="true"
        @endif 
        @foreach ($propeties as $key => $prop) {{ $key }}="{{ $prop }}" @endforeach>
        @if (isset($option) && empty($option) == false)
            <option value="{{ $option[$optionValue ?? 'value'] }}" @if (inputValue($value, $name) == $option[$optionValue ?? 'value']) selected @endif>
                {{ $option[$optionText ?? 'text'] }}
            </option>
        @endif
    </select>

    @if ($hasError == true)
        <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @endif

    <small>{{ $description ?? '' }}</small>
</div>
