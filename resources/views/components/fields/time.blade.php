<div class="form-group col-md-{{ $col }}">
    <label>{{ $label }}</label>
    <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
        <input type="time" 
                class="form-control datetimepicker-input" 
                data-target="#reservationdatetime"
                name="{{ $name }}"
                @if(isset($disabled)) disabled @endif />
    </div>
</div>