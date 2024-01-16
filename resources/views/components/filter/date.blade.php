<datetime-picker    col="{{ $col }}"
                    label="{{ $label }}"
                    name="{{ $name }}"
                    @if (empty($range) == false) 
                        :range="true"
                    @endif
                    format="dd/MM/yyyy @if (isset($hour)) HH:mm @endif"
                    @if (empty($maxRange) == false) 
                        max-range="{{ $maxRange }}" 
                    @endif
                    @if (empty($minDate) == false) 
                        :min-date="new Date('{{ $minDate }}')" 
                    @endif
                    @if (empty($maxDate) == false) 
                        :max-date="new Date('{{ $maxDate }}')" 
                    @endif
                    @if (empty($value) == false)
                        :val="new Date('{{ $value }}')" 
                    @endif
                    @if (empty($message) == false) 
                        message="{{ $message }}" 
                    @endif
                    >
</datetime-picker>