<?php

namespace App\Services;

use App\Models\Type;
use DBTypes;
use Illuminate\Support\Facades\Log;

class TypeService extends Type
{

    public function getIdWithCode($code)
    {
        return $this->newQuery()->where('code', $code)->first()->id;
    }
}
