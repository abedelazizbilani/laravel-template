<?php

if (!function_exists('currentRoute')) {
    function currentRoute($route)
    {
        return request()->url() == route($route) ? ' class=current' : '';
    }
}

if (!function_exists('currentRouteBootstrap')) {
    function currentRouteBootstrap($route)
    {
        return request()->url() == route($route) ? ' class=active' : '';
    }
}

if (!function_exists('user')) {
    function user($id)
    {
        return \App\Models\User::findOrFail($id);
    }
}

if (!function_exists('locales')) {
    function locales()
    {
        $file = resolve(\Illuminate\Filesystem\Filesystem::class);
        $locales = [];
        $results = $file->directories(resource_path('lang'));
        foreach ($results as $result) {
            $name = $file->name($result);
            if ($name !== 'vendor') {
                $locales[$name] = $name;
            }
        }
        return $locales;
    }
}

if (!function_exists('timezones')) {
    function timezones()
    {
        $zones_array = [];
        $timestamp = time();
        foreach (timezone_identifiers_list() as $zone) {
            date_default_timezone_set($zone);
            $zones_array[$zone] = 'UTC' . date('P', $timestamp);
        }
        return $zones_array;
    }
}

if (!function_exists('setTabActive')) {
    function setTabActive()
    {
        return request()->has('page') ? request('page') : 1;
    }
}

if (!function_exists('thumb')) {
    function thumb($url)
    {
        return \App\Services\Thumb::makeThumbPath($url);
    }
}

if (!function_exists('link_to')) {
    /**
     * Generate a HTML link.
     *
     * @param string $url
     * @param string $title
     * @param array $attributes
     * @param bool $secure
     * @param bool $escape
     *
     * @return string
     */
    function link_to($url, $title = null, $attributes = [], $secure = null, $escape = true)
    {
        return app('html')->link($url, $title, $attributes, $secure, $escape);
    }
}

if (!function_exists('link_to_asset')) {
    /**
     * Generate a HTML link to an asset.
     *
     * @param string $url
     * @param string $title
     * @param array $attributes
     * @param bool $secure
     *
     * @return string
     */
    function link_to_asset($url, $title = null, $attributes = [], $secure = null)
    {
        return app('html')->linkAsset($url, $title, $attributes, $secure);
    }
}

if (!function_exists('link_to_route')) {
    /**
     * Generate a HTML link to a named route.
     *
     * @param string $name
     * @param string $title
     * @param array $parameters
     * @param array $attributes
     *
     * @return string
     */
    function link_to_route($name, $title = null, $parameters = [], $attributes = [])
    {
        return app('html')->linkRoute($name, $title, $parameters, $attributes);
    }
}

if (!function_exists('link_to_action')) {
    /**
     * Generate a HTML link to a controller action.
     *
     * @param string $action
     * @param string $title
     * @param array $parameters
     * @param array $attributes
     *
     * @return string
     */
    function link_to_action($action, $title = null, $parameters = [], $attributes = [])
    {
        return app('html')->linkAction($action, $title, $parameters, $attributes);
    }
}
