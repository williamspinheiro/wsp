@php
    $hasError = $errors->has($name);
    $propeties = isset($props) == true ? $props : [];
@endphp
<div class="form-group col-md-{{ $col }}" style="" id="{{ $divId ?? 'select-' . Str::slug($label . '-' . $name) }}">
    <label class="col-form-label" for="{{ $id ?? 'select-' . Str::slug($label . '-' . $name) }}">
        @if ($hasError == true)
            <i class="far fa-times-circle"></i>
        @endif
        {{ $label }}
    </label>
    <select class="form-control 
        @if (isset($selectClear)) 
            select-research-clear 
        @else 
            select-research 
        @endif 
        select2-default-color {{ $class ?? '' }} @if ($hasError == true) is-invalid @endif"
        name="{{ $name }}" id="{{ $id ?? 'select-' . Str::slug($label . '-' . $name) }}"
        @foreach ($propeties as $key => $prop) {{ $key }}="{{ $prop }}" @endforeach>
        @if (isset($hasAll))
            <option value="">Todos</option>
        @else
            <option value="">Selecione</option>
        @endif

        @foreach ($options as $option)
            @if (is_array($option) == true)
                <option value="{{ $option[$optionValue ?? 'value'] }}" @if (inputValue($value, $name) == $option[$optionValue ?? 'value']) selected @endif>
                    {{ $option[$optionText ?? 'text'] }}
                </option>
            @else
                <option value="{{ $option }}" @if (inputValue($value, $name) == $option) selected @endif>
                    {{ $option }}
                </option>
            @endif
        @endforeach
    </select>

    @if ($hasError == true)
        <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @endif

    <small>{{ $message ?? '' }}</small>
</div>
