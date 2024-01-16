<?php

use Illuminate\Support\Collection;

if (!function_exists('buildTokenByUser')) {
    function buildTokenByUser($user)
    {
        return date('YmdH') . $user->created_at . '-' . $user->password . '-' . $user->alias . '-' . $user->public_key . '-' . $user->sync_id . '-' . $user->email;
    }
}

if (!function_exists('formatDatetimePickerRange')) {
    function formatDatetimePickerRange($period, 
                                        $formatStartDate = 'Y-m-d 00:00:00', 
                                        $formatEndDate = 'Y-m-d 23:59:00', 
                                        $fromFormat = 'd/m/Y')
    {
        $response = [
                        'start_date' => null,
                        'end_date' => null
                    ];

        if (empty($period) == false) {
            $dates = explode('-', $period);

            if (is_array($dates) == true) {

                if (isset($dates[0]) == true) {
                    $response['start_date'] = formatDate(preg_replace('/\s+/','',$dates[0]), $formatStartDate, $fromFormat);
                }
                
                if (isset($dates[1]) == true) {                    
                    $response['end_date'] = formatDate(preg_replace('/\s+/','',$dates[1]), $formatEndDate, $fromFormat);
                }
            }
        }

        return $response;
    }
}

if (!function_exists('setMinutesToDate')) {
    function setMinutesToDate($minutes)
    {
        $dt = \Carbon\Carbon::now()->addMinutes($minutes);
        $dt_old = \Carbon\Carbon::now();
        $days = $dt->diffInDays($dt_old);
        $dt = $dt->subDays($days);
        $hours = $dt->diffInHours($dt_old);
        $dt = $dt->subHours($hours);
        $minutes = $dt->diffInMinutes($dt_old);

        return $days . ' dia(s) ' . $hours . ' h ' . $minutes . ' m';
    }
}

if (!function_exists('inputValue')) {
    function inputValue($model, $field, $format = null, $type = 'date')
    {
        if (isset($model->{$field}) && is_null($format)) {
            return $model->{$field};
        } elseif (!is_null($format) && !empty($model->{$field}) && $type == 'date') {
            return $model->{$field}->format($format);
        } elseif (!is_null($format) && !empty($model->{$field}) && $type == 'money') {
            return number_format((float)$model->{$field}, $format[0], $format[1], $format[2]);
        }
        
        return old($field);
    }
}

if (!function_exists('salutation')) {
    function salutation() 
    {
        date_default_timezone_set('America/Sao_Paulo');
        $hour = date('H');

        if ( $hour >= 6 && $hour <= 12 ) {
            return 'Bom dia';
        } else if ( $hour > 12 && $hour <= 18  ) {
            return 'Boa tarde';
        }
        
        return 'Boa noite';
    }
}

if (!function_exists('formatToFloat')) {
    function formatToFloat($number)
    {
        return preg_replace('/\,/', '.', preg_replace('/\./', '', $number));
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date, $format, $fromFormat = null)
    {
        if (empty($date) == true) {
            return;
        }
       
        if (empty($fromFormat) == false) {
            return \Carbon\Carbon::createFromFormat($fromFormat, $date)->format($format);
        }

        return \Carbon\Carbon::parse($date)->format($format);
    }
}

if (!function_exists('formatPostman')) {
    function formatPostman($array, $parent = '')
    {
        $string = '';

        foreach ($array as $key => $item) {
            
            if (is_array($item) && $parent == '') {
                $string .= formatPostman($item, $key);
            } else if (is_array($item)) {
                $string .= formatPostman($item, $parent . '[' . $key . ']');
            } else if (!is_array($item) && !empty($parent)) {
                $string .= $parent . '[' . $key . ']' .':' . $item . '<br>';
            } else if (!is_array($item) && empty($parent)) {
                $string .=  $key .':' . $item . '<br>';
            }
        }

        return $string;
    }
}

if (!function_exists('formtArrayToString')) {
    function formtArrayToString($array, $prop = '')
    {
        if (is_string($array) == true || isset($array[$prop]) == false) {
            return $array;
        }

        $response = [];

        foreach($array[$prop] as $property) {
            $response[] = implode(' | ', $property);
        }

        return implode('; ', $response);
    }
}
