<?php

if (!function_exists('numerical')) {
    /**
     * Helper get decimal value if needed.
     * @param $number
     * @param int $precision
     * @param bool $trimmed
     * @param string $dec_point
     * @param string $thousands_sep
     * @return int|string
     */
    function numerical($number, $precision = 3, $trimmed = true, $dec_point = ',', $thousands_sep = '.')
    {
        if (empty($number)) {
            return 0;
        }
        $formatted = number_format($number, $precision, $dec_point, $thousands_sep);

        if (!$trimmed) {
            return $formatted;
        }

        // Trim unnecessary zero after comma: (2,000 -> 2) or (3,200 -> 3,2)
        return strpos($formatted, $dec_point) !== false ? rtrim(rtrim($formatted, '0'), $dec_point) : $formatted;;

        /* Trim only zero after comma: (2,000 -> 2) but (3,200 -> 3,200)
        $decimalString = '';
        for ($i = 0; $i < $precision; $i++) {
            $decimalString .= '0';
        }
        $trimmedNumber = str_replace($dec_point . $decimalString, "", (string)$formatted);
        return $trimmedNumber;
        */
    }
}

if (!function_exists('if_empty')) {
    /**
     * Helper get decimal value if needed.
     * @param $value
     * @param string $default
     * @param string $prefix
     * @param string $suffix
     * @param bool $strict
     * @return array|string
     */
    function if_empty($value, $default = '', $prefix = '', $suffix = '', $strict = false)
    {
        if (is_null($value) || empty($value)) {
            return $default;
        }

        if ($strict) {
            if ($value == '0' || $value == '-' || $value == '0000-00-00' || $value == '0000-00-00 00:00:00') {
                return $default;
            }
        }

        if (is_array($value)) {
            return $value;
        }

        return is_null($default) ? $value : $prefix . $value . $suffix;
    }
}


if (!function_exists('get_if_exist')) {
    /**
     * Helper get decimal value if needed.
     * @param $data
     * @param string $key
     * @param string $default
     * @return array|object|string
     */
    function get_if_exist($data, $key = '', $default = '')
    {
        if (is_array($data) && key_exists($key, if_empty($data, []))) {
            if (!empty($data[$key])) {
                return $data[$key];
            }
        }

        if (is_object($data) && property_exists($data, $key)) {
            if (!empty($data->$key)) {
                return $data->$key;
            }
        }

        return $default;
    }
}

if (!function_exists('format_date')) {
    /**
     * Helper get date with formatted value.
     * @param $value
     * @param string $format
     * @return string
     */
    function format_date($value, $format = 'Y-m-d')
    {
        if (empty($value) || $value == '0000-00-00' || $value == '0000-00-00 00:00:00') {
            return '';
        }
        $dateParts = explode('/', $value);
        if (count($dateParts) == 3) {
            $value = $dateParts['1'] . '/' . $dateParts['0'] . '/' . $dateParts['2'];
        }
        try {
            return (new DateTime($value))->format($format);
        } catch (Exception $e) {
            return '';
        }
    }
}

if (!function_exists('relative_time')) {

    /**
     * Convert string to relative time format.
     *
     * @param $ts
     * @return false|string
     */
    function relative_time($ts)
    {
        if (!ctype_digit($ts)) {
            $ts = strtotime($ts);
        }
        $diff = time() - $ts;
        if ($diff == 0) {
            return 'now';
        } elseif ($diff > 0) {
            $day_diff = floor($diff / 86400);
            if ($day_diff == 0) {
                if ($diff < 60) return 'just now';
                if ($diff < 120) return '1 minute ago';
                if ($diff < 3600) return floor($diff / 60) . ' minutes ago';
                if ($diff < 7200) return '1 hour ago';
                if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
            }
            if ($day_diff == 1) {
                return 'Yesterday';
            }
            if ($day_diff < 7) {
                return $day_diff . ' days ago';
            }
            if ($day_diff < 31) {
                return ceil($day_diff / 7) . ' weeks ago';
            }
            if ($day_diff < 60) {
                return 'last month';
            }
            return date('F Y', $ts);
        } else {
            $diff = abs($diff);
            $day_diff = floor($diff / 86400);
            if ($day_diff == 0) {
                if ($diff < 120) {
                    return 'in a minute';
                }
                if ($diff < 3600) {
                    return 'in ' . floor($diff / 60) . ' minutes';
                }
                if ($diff < 7200) {
                    return 'in an hour';
                }
                if ($diff < 86400) {
                    return 'in ' . floor($diff / 3600) . ' hours';
                }
            }
            if ($day_diff == 1) {
                return 'Tomorrow';
            }
            if ($day_diff < 4) {
                return date('l', $ts);
            }
            if ($day_diff < 7 + (7 - date('w'))) {
                return 'Next week';
            }
            if (ceil($day_diff / 7) < 4) {
                return 'in ' . ceil($day_diff / 7) . ' weeks';
            }
            if (date('n', $ts) == date('n') + 1) {
                return 'Next month';
            }
            return date('F Y', $ts);
        }
    }
}

if (!function_exists('difference_date')) {
    /**
     * Helper get difference by two dates.
     * @param $firstDate
     * @param $secondDate
     * @param string $format
     * @return string
     */
    function difference_date($firstDate, $secondDate, $format = '%R%a')
    {
        $date1 = date_create($firstDate);
        $date2 = date_create($secondDate);
        $diff = date_diff($date1, $date2);
        $diffInFormat = $diff->format($format);

        return intval($diffInFormat);
    }
}

if (!function_exists('extract_number')) {
    /**
     * Extract number from value.
     * @param $value
     * @return null|string|string[]
     */
    function extract_number($value)
    {
        $value = preg_replace("/[^0-9-,\/]/", "", $value);
        $value = preg_replace("/,/", ".", $value);
        return $value;
    }
}


if (!function_exists('text_to_link')) {
    /**
     * Convert text to link when detect url.
     * @param $text
     * @return string|string[]|null
     */
    function text_to_link($text)
    {
        return preg_replace('/(https?:\/\/[\w\-\.!~#?&=+\*\'"(),\/]+|[\w\-\.!~#?&=+\*\'"(),\/]+.com)/', '<a href="/visit?url=$0">$0</a>', $text);
    }
}

