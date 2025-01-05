<?php

use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

function activeMenu($uri = '')
{
    $uri = Str::lower($uri);
    $active = '';
    if (str_contains(url()->current(), $uri)) {
        $active = 'active';
    }
    return $active;
}

function myRole(int $role){
    if (!$role) {
        return null;
    }
    $type = new Type();
    return $type->find($role)->name;
}

function myMBTI() {
    $mbti_id = Auth::user()->mbti_id;
    if (!$mbti_id) {
        return null;
    }
    $type = new Type();
    return $type->find($mbti_id)->name;
}
