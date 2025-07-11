<?php

namespace Database\Seeders;

use App\Constants\DBTypes;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    protected $types = [
        [
            'code' => DBTypes::UserRole,
            'name' => 'User Role',
            'children' => [
                [
                    'name' => 'Super Admin',
                    'desc' => 'important',
                    'code' => DBTypes::RoleSuperAdmin
                ],
                [
                    'name' => 'Admin',
                    'code' => DBTypes::RoleAdmin
                ],
                [
                    'name' => 'Guru Premium',
                    'code' => DBTypes::RoleGuruPrem
                ],
                [
                    'name' => 'Siswa Premium',
                    'code' => DBTypes::RoleSiswaPrem
                ],
                [
                    'name' => 'Guru',
                    'code' => DBTypes::RoleGuru
                ],
                [
                    'name' => 'Siswa',
                    'code' => DBTypes::RoleSiswa
                ]
            ]
        ],
        [
            'code' => DBTypes::userClass,
            'name' => 'User Class',
            'children' => [
                [
                    'name' => '1',
                    'code' => DBTypes::UserClass1
                ],
                [
                    'name' => '2',
                    'code' => DBTypes::UserClass2
                ],
                [
                    'name' => '3',
                    'code' => DBTypes::UserClass3
                ],
                [
                    'name' => '4',
                    'code' => DBTypes::UserClass4
                ],
                [
                    'name' => '5',
                    'code' => DBTypes::UserClass5
                ],
                [
                    'name' => '6',
                    'code' => DBTypes::UserClass6
                ],
                [
                    'name' => '7',
                    'code' => DBTypes::UserClass7
                ],
                [
                    'name' => '8',
                    'desc' => 'important',
                    'code' => DBTypes::UserClass8
                ],
                [
                    'name' => '9',
                    'code' => DBTypes::UserClass9
                ],
                [
                    'name' => '10',
                    'code' => DBTypes::UserClass10
                ],
            ]
        ],
        [
            'code' => DBTypes::QuizType,
            'name' => 'Quiz Type',
            'children' => [
                [
                    'name' => 'Quiz Type 2',
                    'desc' => 'important',
                    'code' => DBTypes::QuizType2
                ],
                [
                    'name' => 'Quiz Type 3',
                    'desc' => 'important',
                    'code' => DBTypes::QuizType3
                ],
                [
                    'name' => 'Quiz Type 4',
                    'desc' => 'important',
                    'code' => DBTypes::QuizType4
                ],
            ]
        ],
        [
            'code' => DBTypes::UserGender,
            'name' => 'User Gender',
            'children' => [
                [
                    'name' => 'Laki - Laki',
                    'desc' => 'important',
                    'code' => DBTypes::UserGenderM
                ],
                [
                    'name' => 'Perempuan',
                    'desc' => 'important',
                    'code' => DBTypes::UserGenderF
                ]
            ]
        ],
        [
            'code' => DBTypes::FileTypes,
            'name' => 'File Type',
            'children' => [
                [
                    'name' => 'Type Picture',
                    'desc' => 'important',
                    'code' => DBTypes::FileTypePic
                ],
                [
                    'name' => 'Profile Picture',
                    'desc' => 'important',
                    'code' => DBTypes::FileProfilePic
                ]
            ]
        ],
        [
            'code' => DBTypes::LessonStatus,
            'name' => 'Lesson Status',
            'children' => [
                [
                    'name' => 'Active',
                    'desc' => 'important',
                    'code' => DBTypes::LessonStatusActive
                ],
                [
                    'name' => 'Non-Active',
                    'desc' => 'important',
                    'code' => DBTypes::LessonStatusNonActive
                ]
            ]
        ],
    ];
    /**
     * Run the database seeds.
     */
    public function run(Type $type): void
    {
        foreach ($this->types as $key => $value) {
            $parent = $type->create(collect($value)->only($type->getFillable())->toArray());
            if (isset($value['children']))
                $this->createChildren($type, $parent->id, $value['children']);
        }
    }

    public function createChildren(Type $type, int $masterid, array $children)
    {
        foreach ($children as $key => $value) {
            $value['master_id'] = $masterid;
            $child = $type->create(collect($value)->only($type->getFillable())->toArray());
            if (isset($value['children']))
                $this->createChildren($type, $child->id, $value['children']);
        }
    }
}
