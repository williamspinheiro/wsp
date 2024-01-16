@php
    $propeties = isset($props) == true ? $props : [];
@endphp

<div class="form-group col-md-{{ $col }}">
    <label class="col-form-label" for="{{ $id ?? 'select-' . Str::slug($label . '-' . $name) }}">
        {{ $label }}
    </label>
    <select class="form-control 
        @if(isset($profileFilter) == true)
            component-profile-filter
        @endif
        @if(isset($multiselect) == true) 
            select-multiple
        @elseif(isset($selectAjax) == true) 
            select-ajax
        @elseif(isset($selectNoClear) == true) 
            select-research
        @else
            select-research-clear
        @endif 
        select2-default-color"
        name="@if(isset($removeNameFilter) == false)filter-@endif{{ $name }}@if(isset($multiselect) == true)[]@endif"
        @if(isset($profileFilter) == true)
            data-name="{{ $name }}"
            input-hidden="#{{Str::slug($label . '-' . $name)}}-input-hidden"
        @endif
        @if(isset($selectAjax) == true)
            type="name"
            tags="true"
            method="{{ $method ?? 'GET' }}"
            url="{{ $url }}"
            @if (empty($dataId) == false) 
                data-id="id"
            @else
                data-id="name"   
            @endif 
        @endif
        @if(isset($json) == true) 
            json="{{ json_encode($json) }}"
            prop="id" 
        @endif 
        id="{{ $id ?? 'select-' . Str::slug($label . '-' . $name) }}"
        @if(isset($multiselect) == true) 
            multiple="multiple"
        @endif
        @foreach ($propeties as $key => $prop) {{ $key }}="{{ $prop }}" @endforeach
        >
        @if(isset($selectAjax) == false && isset($json) == false)
            @if(isset($multiselect) == false)
                <option value="">Selecione</option>
            @endif
            @foreach ($options as $option)
                @if (is_array($option) == true)
                    <option value="{{ $option[$optionValue ?? 'value'] }}" @if (inputValue($value ?? '', $name) == $option[$optionValue ?? 'value']) selected @endif>
                        {{ $option[$optionText ?? 'text'] }}
                    </option>
                @else
                    <option value="{{ $option }}" @if (inputValue($value ?? '', $name) == $option) selected @endif>
                        {{ $option }}
                    </option>
                @endif
            @endforeach
        @endif
    </select>
    @if(isset($profileFilter) == true)
        <div id="{{Str::slug($label . '-' . $name)}}-input-hidden"></div>
    @endif
    @if (empty($message) == false) 
        <small>{{ $message }}</small>
    @endif
</div>