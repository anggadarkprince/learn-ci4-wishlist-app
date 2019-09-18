<?php

if (!function_exists('auth')) {
    /**
     * Get auth data.
     * @param string $key
     * @param string $default
     * @return mixed
     */
    function auth($key = null, $default = '')
    {
        return \App\Models\AuthModel::loginData($key, $default);
    }
}