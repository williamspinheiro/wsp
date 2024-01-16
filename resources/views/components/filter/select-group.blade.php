@php
    $propeties = isset($props) == true ? $props : [];
@endphp

<div class="form-group col-md-{{ $col }}">
    <label class="col-form-label" for="{{ $id ?? 'select-' . Str::slug($label . '-' . $name) }}">
        {{ $label }}
    </label>
    <select class="form-control 
        @if(isset($multiselect) == true) 
            select-multiple
        @else 
            select-research 
        @endif 
        select2-default-color"
        name="@if(isset($removeNameFilter) == false)filter-@endif{{ $name }}@if(isset($multiselect) == true)[]@endif" 
        id="{{ $id ?? 'select-' . Str::slug($label . '-' . $name) }}"
        @if(isset($multiselect) == true) 
            multiple="multiple"
        @endif
        @foreach ($propeties as $key => $prop) {{ $key }}="{{ $prop }}" @endforeach
        >
        @if(isset($multiselect) == false)
            <option value="">Selecione</option>
        @endif
        @foreach ($groups as $group)
            <optgroup label="{{ $group[$groupLabel ?? 'label'] }}">
                @foreach ($group[$groupOptions] as $groupOption)
                    <option value="{{ $groupOption[$groupOptionValue ?? 'value'] }}" @if (inputValue($value ?? '', $name) == $groupOption[$groupOptionValue ?? 'value']) selected @endif>
                        {{ $groupOption[$groupOptionText ?? 'text'] }}
                    </option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
    @if (empty($message) == false) 
        <small>{{ $message }}</small>
    @endif
</div>