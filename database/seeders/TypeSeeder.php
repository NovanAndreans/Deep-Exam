<?php

namespace Database\Seeders;

use App\Constant\DBTypes;
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
            'code' => DBTypes::MBTI,
            'name' => 'MBTI',
            'children' => [
                [
                    'name' => 'INFJ',
                    'desc' => 'important',
                    'code' => DBTypes::INFJ
                ],
                [
                    'name' => 'ENFJ',
                    'desc' => 'important',
                    'code' => DBTypes::ENFJ
                ],
                [
                    'name' => 'INFP',
                    'desc' => 'important',
                    'code' => DBTypes::INFP
                ],
                [
                    'name' => 'ENFP',
                    'desc' => 'important',
                    'code' => DBTypes::ENFP
                ],
                [
                    'name' => 'INTJ',
                    'desc' => 'important',
                    'code' => DBTypes::INTJ
                ],
                [
                    'name' => 'ENTJ',
                    'desc' => 'important',
                    'code' => DBTypes::ENTJ
                ],
                [
                    'name' => 'INTP',
                    'desc' => 'important',
                    'code' => DBTypes::INTP
                ],
                [
                    'name' => 'ENTP',
                    'desc' => 'important',
                    'code' => DBTypes::ENTP
                ],
                [
                    'name' => 'ISFJ',
                    'desc' => 'important',
                    'code' => DBTypes::ISFJ
                ],
                [
                    'name' => 'ESFJ',
                    'desc' => 'important',
                    'code' => DBTypes::ESFJ
                ],
                [
                    'name' => 'ISTJ',
                    'desc' => 'important',
                    'code' => DBTypes::ISTJ
                ],
                [
                    'name' => 'ESTJ',
                    'desc' => 'important',
                    'code' => DBTypes::ESTJ
                ],
                [
                    'name' => 'ISFP',
                    'desc' => 'important',
                    'code' => DBTypes::ISFP
                ],
                [
                    'name' => 'ESFP',
                    'desc' => 'important',
                    'code' => DBTypes::ESFP
                ],
                [
                    'name' => 'ISTP',
                    'desc' => 'important',
                    'code' => DBTypes::ISTP
                ],
                [
                    'name' => 'ESTP',
                    'desc' => 'important',
                    'code' => DBTypes::ESTP
                ],
            ]
        ],
        [
            'code' => DBTypes::MBTIQuestionCategory,
            'name' => 'MBTI Question Category',
            'children' => [
                [
                    'name' => 'E-I',
                    'desc' => 'E: 2, I: -2',
                    'code' => DBTypes::MBTIQuestionCategoryIE
                ],
                [
                    'name' => 'S-N',
                    'desc' => 'S: 2, N: -2',
                    'code' => DBTypes::MBTIQuestionCategorySN
                ],
                [
                    'name' => 'F-T',
                    'desc' => 'F: 2, T: -2',
                    'code' => DBTypes::MBTIQuestionCategoryFT
                ],
                [
                    'name' => 'J-P',
                    'desc' => 'J: 2, P: -2',
                    'code' => DBTypes::MBTIQuestionCategoryJP
                ]
            ]
        ],
        [
            'code' => DBTypes::LessonCategory,
            'name' => 'Lesson Category',
            'children' => [
                [
                    'name' => 'Bahasa',
                    'desc' => 'important',
                    'code' => DBTypes::LessonCategoryBahasa,
                    'children' => [
                        [
                            'name' => 'Bahasa Indonesia',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryBahasaIndo
                        ],
                        [
                            'name' => 'Bahasa Inggris',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryBahasaInggris
                        ],
                        [
                            'name' => 'Bahasa Arab',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryBahasaArab
                        ],
                    ]
                ],
                [
                    'name' => 'IPA',
                    'desc' => 'important',
                    'code' => DBTypes::LessonCategoryIPA,
                    'children' => [
                        [
                            'name' => 'Fisika',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryIPAFisika
                        ],
                        [
                            'name' => 'Kimia',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryIPAKimia
                        ],
                        [
                            'name' => 'Biologi',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryIPABiologi
                        ],
                    ]
                ],
                [
                    'name' => 'IPS',
                    'desc' => 'important',
                    'code' => DBTypes::LessonCategoryIPS,
                    'children' => [
                        [
                            'name' => 'Sejarah',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryIPSSejarah
                        ],
                        [
                            'name' => 'Geografi',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryIPSGeografi
                        ],
                        [
                            'name' => 'Ekonomi',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryIPSEkonomi
                        ],
                    ]
                ],
                [
                    'name' => 'Matematika',
                    'desc' => 'important',
                    'code' => DBTypes::LessonCategoryMTK,
                    'children' => [
                        [
                            'name' => 'Aljabar',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryMTKAljabar
                        ],
                        [
                            'name' => 'Kalkulus',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryMTKKalkulus
                        ],
                        [
                            'name' => 'Statistika',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryMTKStatistika
                        ],
                    ]
                ],
                [
                    'name' => 'TIK',
                    'desc' => 'important',
                    'code' => DBTypes::LessonCategoryTIK,
                    'children' => [
                        [
                            'name' => 'Web Development',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryTIKWeb
                        ],
                        [
                            'name' => 'Mobile Development',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryTIKMobile
                        ],
                        [
                            'name' => 'Machine Learning',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryTIKML
                        ],
                    ]
                ],
                [
                    'name' => 'Agama',
                    'desc' => 'important',
                    'code' => DBTypes::LessonCategoryAgama,
                    'children' => [
                        [
                            'name' => 'Islam',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryAgamaIslam
                        ],
                        [
                            'name' => 'Kristen',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryAgamaKristen
                        ],
                        [
                            'name' => 'Katolik',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryAgamaKatolik
                        ],
                    ]
                ],
                [
                    'name' => 'Seni',
                    'desc' => 'important',
                    'code' => DBTypes::LessonCategorySeni,
                    'children' => [
                        [
                            'name' => 'Seni Rupa',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategorySeniRupa
                        ],
                        [
                            'name' => 'Seni Musik',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategorySeniMusik
                        ],
                        [
                            'name' => 'Seni Lukis',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategorySeniLukis
                        ],
                    ]
                ],
                [
                    'name' => 'Olahraga',
                    'desc' => 'important',
                    'code' => DBTypes::LessonCategoryOlahraga,
                    'children' => [
                        [
                            'name' => 'Marathon',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryOlahragaMarathon
                        ],
                        [
                            'name' => 'Basket',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryOlahragaBasket
                        ],
                        [
                            'name' => 'Futsal',
                            'desc' => 'important',
                            'code' => DBTypes::LessonCategoryOlahragaFutsal
                        ],
                    ]
                ],
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
            'code' => DBTypes::LogCategory,
            'name' => 'Kategory Berita',
            'children' => [
                [
                    'name' => 'Study',
                    'desc' => 'important',
                    'code' => DBTypes::LogCategoryStudy
                ],
                [
                    'name' => 'Test',
                    'desc' => 'important',
                    'code' => DBTypes::LogCategoryTest
                ],
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
