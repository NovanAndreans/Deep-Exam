<?php

namespace App\Constants;

class AiText
{
    public static function GenerateKisi($materi, $desc, $subcpmk)
    {
        return "Buatkan kisi-kisi yang berupa contoh pertanyaan dengan materi " . $materi . " 
        dengan deskripsi " . $desc . " dan subcpmk " . $subcpmk . ". 
        Buatkan kisi-kisi pertanyaan dari materi tersebut sesuai 
        taksonomi bloom kriteria afektif dan kognitif sesuai limit dan termasuk limit subcpmk.
        berikan jawaban dengan format json seperti berikut:
        " . JsonExample::KisiKisiLesson . ". pada formatnya tertera C1-C6 dan A1-A6, 
        tetapi jika limitnya tidak sebanyak pada format, maka sesuaikan pada limitnya
        \n langsung JSON jangan string !!!";
    }

    public static function CheckSubCpmkLimit($subcpmk)
    {
        return "
        Anda adalah seorang ahli dalam Taksonomi Bloom, 
        khususnya dalam konteks pendidikan. 
        kelompokkan berdasarkan ranah kognitif 
        (C1-Mengingat Mengutip Mengidentifikasi Menghafal, C2-Memahami Menjelaskan Mengartikan Membandingkan, C3-Menerapkan Menggunakan Melaksanakan, C4-Menguraikan Mengorganisasi Menganalisis, 
        C5-Mengevaluasi Menilai Menyimpulkan Membuktikan, dan C6-Menciptakan Membangun Merancang Mengkombinasikan). 
        \nCek berapakah level KKO Taksonomi Bloom dari 
        Sub CPMK ini " . $subcpmk . "
         \n berikan jawaban dalam format integer 1 digit";
    }
}
