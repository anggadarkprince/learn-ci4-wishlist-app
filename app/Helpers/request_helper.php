<?php

if (!function_exists('get_url_param')) {
    /**
     * Helper get query string value.
     * @param $key
     * @param string $default
     * @return string
     */
    function get_url_param($key, $default = '')
    {
        if (isset($_GET[$key]) && ($_GET[$key] != '' && $_GET[$key] != null)) {
            if($key == 'redirect') {
                return str_replace('redirect=', '', get_if_exist($_SERVER, 'REDIRECT_QUERY_STRING', ''));
            }
            return is_array($_GET[$key]) ? $_GET[$key] : urldecode($_GET[$key]);
        }
        return $default;
    }
}

if (!function_exists('set_url_param')) {

    /**
     * Update page value in query params.
     * @param array $setParams
     * @param null $query
     * @param bool $returnArray
     * @return string|array
     */
    function set_url_param($setParams = [], $query = null, $returnArray = false)
    {
        $queryString = empty($query) ? $_SERVER['QUERY_STRING'] : $query;
        $params = explode('&', $queryString);

        $builtParam = [];

        // mapping to key->value array
        for ($i = 0; $i < count($params); $i++) {
            $param = explode('=', $params[$i]);
            if (!empty($param[0])) {
                $builtParam[$param[0]] = key_exists(1, $param) ? $param[1] : '';
            }
        }

        // set params
        foreach ($setParams as $key => $value) {
            $builtParam[$key] = $value;
        }

        if ($returnArray) {
            return $builtParam;
        }

        // convert to string
        $baseQuery = '';
        foreach ($builtParam as $key => $value) {
            $baseQuery .= (empty($baseQuery) ? '' : '&') . ($key . '=' . $value);
        }

        return $baseQuery;
    }
}

if (!function_exists('get_current_url')) {
    /**
     * Helper get current url  string value.
     * @param bool $withQueryString
     * @return string
     */
    function get_current_url($withQueryString = true)
    {
        if ($withQueryString) {
            return site_url(uri_string(), false) . '?' . $_SERVER['QUERY_STRING'];
        }
        return site_url(uri_string(), false);
    }
}