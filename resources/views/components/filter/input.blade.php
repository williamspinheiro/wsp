@php
$propeties = (isset($props) == true) ? $props : [];
@endphp

<div class="form-group col-md-{{ $col }}">
    <label class="col-form-label" for="input-{{ Str::slug($label . '-' . $name) }}">
        {{ $label }}
    </label>
    <input type="{{ $type ?? 'text' }}" 
            name="@if(isset($removeNameFilter) == false)filter-@endif{{ $name }}"
            class="form-control {{ $class ?? '' }}" 
            id="{{ $id ?? 'input-' . Str::slug($label . '-' . $name) }}" 
            placeholder="{{ $placeholder ?? $label }}"
            @foreach($propeties as $key => $prop) {{ $key }}="{{ $prop }}" @endforeach
            @if(isset($type) == true && $type == 'number')
                min="1"
            @endif
        >
        @if (empty($message) == false) 
            <small>{{ $message }}</small>
        @endif
</div>