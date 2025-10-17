<?php

if (! function_exists('setting')) {
    /**
     * Get a setting value by key
     *
     * @param string $key The setting key
     * @param mixed $default Default value if setting not found
     * @return mixed
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return App\Models\Setting::get($key, $default);
    }
}
