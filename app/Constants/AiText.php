<?php

namespace App\Constants;

class AiText
{
    public static function GenerateKisi($materi, $desc, $subcpmk)
    {
        return "Buatkan kisi-kisi yang berupa contoh pertanyaan dengan materi ".$materi." 
        dengan deskripsi ".$desc." dan subcpmk ".$subcpmk.". 
        Buatkan kisi-kisi pertanyaan dari materi tersebut sesuai 
        taksonomi bloom kriteria afektif dan kognitif 1 hingga 6.
        berikan jawaban dengan format json seperti berikut:
        ".JsonExample::KisiKisiLesson."\n langsung JSON jangan string !!!";
    }
}
