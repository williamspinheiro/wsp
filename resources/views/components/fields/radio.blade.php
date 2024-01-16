@php
$hasError = $errors->has($name);
@endphp

<div class="form-group clearfix col-md-{{ $col }}">
    <label>
        @if($hasError == true)
            <i class="far fa-times-circle"></i>
        @endif 
        {{ $label }}
    </label>
    
    <div class="custom-control custom-radio">
        @foreach($items as $item)
            <div class="icheck-primary ">
                <input class="custom-control-input" 
                        type="radio" 
                        id="radio-{{ Str::slug($label . '-' . $item['text']) }}" 
                        value="{{ $item['value'] }}"
                        name="{{ $name }}"
                        @if ($item['checked']) checked @endif>
                <label class="custom-control-label"
                    for="radio-{{ Str::slug($label . '-' . $item['text']) }}">
                    {{ $item['text'] }}
                </label>
            </div>
        @endforeach
    </div>
</div>