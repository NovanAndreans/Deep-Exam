<?php

namespace Database\Seeders;

use App\Constants\DBTypes;
use App\Models\Feature;
use App\Models\Permission;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type = new Type();
        $feature = new Feature();
        $permission = new Permission();

        $role = $type->getIdByCode(DBTypes::RoleSuperAdmin);
        $features = $feature->all();

        foreach ($features as $key => $value) {
            $permission->create([
                'role' => $role,
                'permisfeatid' => $value->id
            ]);
        }
    }
}
