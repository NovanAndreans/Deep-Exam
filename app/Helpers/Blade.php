<?php

use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

function activeMenu($routeName)
{
    return request()->routeIs($routeName) ? 'active' : '';
}

function myType(int $myType){
    if (!$myType) {
        return null;
    }
    $type = new Type();
    return $type->find($myType)->name;
}
