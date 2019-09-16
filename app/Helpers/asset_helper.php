<?php

if (!function_exists('get_asset')) {
    /**
     * Get manifest data.
     * @param string $key
     * @return mixed
     */
    function get_asset($key = null)
    {
        $rawManifest = file_get_contents('./assets/manifest.json');
        $manifest = json_decode($rawManifest, true);

        if (!is_null($key)) {
            if (key_exists($key, $manifest)) {
                return $manifest[$key];
            }
            return null;
        }
        return $manifest;
    }
}