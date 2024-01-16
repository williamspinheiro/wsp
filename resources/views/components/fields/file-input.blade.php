<div class="form-group col-lg-{{ $col }}" style="" id="{{ 'file-input-' . Str::slug($label . '-' . $name) }}">
    <label class="col-form-label" for="file-input-{{ Str::slug($label . '-' . $name) }}">{{ $label }}</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="{{ $icon ?? 'fa-solid fa-file' }}"></i></span>
        </div>
        <div class="custom-file">
            <input type="file" 
                    class="custom-file-input" 
                    id="{{ $id ?? 'id-file-input-' . Str::slug($label . '-' . $name) }}"
                    name="{{ $name }}"
                    @if(isset($required))
                        required="required"
                    @endif
                    @if(isset($accept))
                        accept="{{ $accept }}"
                    @endif/>
            <label class="custom-file-label" for="{{ $id ?? 'id-file-input-' . Str::slug($label . '-' . $name) }}">{{ $placeholder ?? 'Escolher Arquivo' }}</label>
        </div>
    </div>
    @if (isset($description)) 
        <small>{{ $description }}</small>
    @endif
</div>