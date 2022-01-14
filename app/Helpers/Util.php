<?php

use App\Models\Option;
use App\Models\Post;

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

function getOption($key, $default = null)
{
    $option = Option::where('name', $key)->first();

    return $option->value ?? $default;
}

function safeUndefined($var, $default = '')
{
    return $var ?? $default;
}

function image($src, int $height = null, int $width = null)
{
    if ($height || $width) {
        $srcSumber = str_replace(['http://', 'https://'], '', $src);
        $src = "https://i0.wp.com/$srcSumber?resize=$width,$height";
    }

    return $src;
}

function footerWidget()
{
    return Post::where('type', 'widget_footer')->get();
}


function adjustBrightness($hexCode, $adjustPercent)
{
    if (strpos($hexCode, '#') === false) return $hexCode;
    $hexCode = ltrim($hexCode, '#');


    if (strlen($hexCode) == 3) {
        $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
    }

    $hexCode = array_map('hexdec', str_split($hexCode, 2));

    foreach ($hexCode as &$color) {
        $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
        $adjustAmount = ceil($adjustableLimit * $adjustPercent);

        $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
    }

    return '#' . implode($hexCode);
}
