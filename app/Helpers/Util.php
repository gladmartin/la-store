<?php

use App\Models\Option;

function rupiah($angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function isMenuActive($routeName)
{
    return request()->routeIs($routeName) ? 'active' : '';
}

function webOption()
{
    try {
        $options = Option::all();
        $data = new stdClass;
        foreach ($options as $item) {
            $data->{$item->name} = $item->value;
        }

        return $data;
    } catch (\Throwable $th) {
        $data = new stdClass;
        return $data;
    }
}

function safeUndefined($var, $default = '')
{
    return $var ?? $default;
}
