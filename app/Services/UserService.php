<?php

namespace App\Services;

use App\Constant\DBTypes;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService extends User
{
    public function getQuery()
    {
        return $this->newQuery()->with([
            'roles' => function ($query) {
                $query->select('id', 'name');
            },
            'gender' => function ($query) {
                $query->select('id', 'name');
            },
            'photoProfile' => function ($query) {
                $query->addSelect(DB::raw("*, CONCAT('" . asset('storage') . "/', directories, '/', filename) as url"))
                    ->whereHas('transtype', function ($query) {
                        $query->where('code', DBTypes::FileProfilePic);
                    });
            },
        ]);
    }
}
