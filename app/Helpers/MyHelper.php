<?php

namespace App\Helpers;

class MyHelper
{

    public static function resource($action, $params = null, $returnAsRoute = true)
    {
        $fullRoute = explode('.', request()->route()->getName());
        array_pop($fullRoute);
        $resource = implode('.', $fullRoute);
        return $returnAsRoute ? route("{$resource}.{$action}", $params) : "{$resource}.{$action}";
    }

    public static function route($action, $params = [])
    {
        $fullRoute = explode('.', request()->route()->getName());
        array_pop($fullRoute);
        $resource = implode('.', $fullRoute);
        return route("{$resource}.{$action}", $params);
    }

    public static function replaceBrackets($str, $with = '')
    {
        return rtrim(str_replace("[", ".", str_replace("][", ".", $str)), "]");
    }

    public static function resourceMethodIs($method)
    {
        $fullRoute = explode('.', request()->route()->getName());
        return end($fullRoute) === strtolower($method);
    }

    public static function resourceMethodIn($methods)
    {
        $fullRoute = explode('.', request()->route()->getName());
        return in_array(end($fullRoute), $methods);
    }

    public static function photoPlaceholder()
    {
        return 'data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22200%22%20height%3D%22200%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20200%20200%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_160da7765fc%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_160da7765fc%22%3E%3Crect%20width%3D%22200%22%20height%3D%22200%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2274.4296875%22%20y%3D%22104.65%22%3E200x200%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E';
    }

}
