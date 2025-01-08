<?php

namespace App\Services;

use App\Constants\DBTypes;
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
                $query->addSelect(DB::raw("*, CONCAT('" . config('app.url') . "/', directories, '/', filename) as url"))
                    ->whereHas('transtype', function ($query) {
                        $query->where('code', DBTypes::FileProfilePic);
                    });
            },
        ]);
    }
}
