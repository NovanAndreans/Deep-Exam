<?php

use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

function activeMenu($routeName)
{
    return request()->routeIs($routeName) ? 'active' : '';
}

function activeParentMenu($routeName)
{
    return str_contains(request()->url(), strtolower($routeName)) ? 'active show' : '';
}

function activeParentMenuExpand($routeName)
{
    return str_contains(request()->url(), strtolower($routeName)) ? 'true' : 'false';
}

function activeParentMenuExpanded($routeName)
{
    return str_contains(request()->url(), strtolower($routeName)) ? 'show' : '';
}

function myType(int $myType){
    if (!$myType) {
        return null;
    }
    $type = new Type();
    return $type->find($myType)->name;
}
