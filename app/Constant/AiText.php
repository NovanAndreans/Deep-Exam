<?php

namespace App\Constant;


class AiText
{
    public static function MbtiGenerateQuestion(int $jumlah, string $text, string $desc)
    {
        return 'Buatkan ' . $jumlah . ' pertanyaan untuk test mbti dimensi ' . $text . '(' . $desc . ')' . '\n\n\n buat soal seperti ini : ' . JsonExample::MbtiGenerateQuestion . ' dan response menjadi format JSON. 
        tambahan : pastikan key nya sama dengan yang dicontoh!!! & 
        answers harus berjumlah 5!!!';
    }
}
