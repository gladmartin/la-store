<?php

function rupiah($angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function isMenuActive($routeName)
{
    return request()->routeIs($routeName) ? 'active' : '';
}