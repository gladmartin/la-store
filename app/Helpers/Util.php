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
    $data = [];
    try {
        $options = Option::all();
        foreach ($options as $item) {
            $data[$item->name] = $item->value;
        }
    } catch (\Throwable $th) {
    }
    
    $option = new WebOption($data);
    return $option;
}

function safeUndefined($var, $default = '')
{
    return $var ?? $default;
}

// thanks https://stackoverflow.com/a/45614957
class WebOption
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function get($path = '', $default = null)
    {
        if (!is_string($path)) {
            return $default;
        }
        // There's a dot in the path, traverse the array
        if (false !== strpos('.', $path)) {
            // Find the segments delimited by dot
            $segments = explode('.', $path);
            $result = $this->data;
            foreach ($segments as $segment) {
                if (isset($result[$segment])) {
                    // We have the segment
                    $result = $result[$segment];
                } else {
                    // The segment isn't there, return default value
                    return $default;
                }
            }
            return $result;
        }
        // The above didn't yield a result, check if the key exists in the array and if not - return default
        return isset($this->data[$path]) ? $this->data[$path] : $default;
    }
}

