<?php

use App\Models\AuthModel;

if (!function_exists('auth')) {
    /**
     * Get auth data.
     * @param string $key
     * @param string $default
     * @return mixed
     */
    function auth($key = null, $default = '')
    {
        return AuthModel::loginData($key, $default);
    }
}

if (!function_exists('is_authorized')) {
    /**
     * Check authorized data.
     * @param null $permissions
     * @param null $userId
     * @return mixed
     */
    function is_authorized($permissions = null, $userId = null)
    {
        return AuthModel::isAuthorized($permissions, $userId);
    }
}

if (!function_exists('must_authorized')) {
    /**
     * Check authorized data.
     * @param null $permissions
     * @param null $redirect
     * @return mixed
     */
    function must_authorized($permissions = null, $redirect = null)
    {
        return AuthModel::mustAuthorized($permissions, $redirect);
    }
}