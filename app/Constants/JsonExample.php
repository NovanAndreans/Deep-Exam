<?php

namespace App\Constants;

class JsonExample
{
  const KisiKisiLesson = <<<JSON
[
    {
      "taksonomi_bloom": "Afektif",
      "isi": [
        {
          "type": "A1",
          "question": "...."
        },
        {
          "type": "A2",
          "question": "...."
        },
        {
          "type": "A3",
          "question": "...."
        },
        {
          "type": "A4",
          "question": "...."
        },
        {
          "type": "A5",
          "question": "...."
        },
        {
          "type": "A6",
          "question": "...."
        }
      ]
    },
    {
      "taksonomi_bloom": "Kognitif",
      "kisi-kisi": [
        {
          "type": "C1",
          "question": "...."
        },
        {
          "type": "C2",
          "question": "...."
        },
        {
          "type": "C3",
          "question": "...."
        },
        {
          "type": "C4",
          "question": "...."
        },
        {
          "type": "C5",
          "question": "...."
        },
        {
          "type": "C6",
          "question": "...."
        }
      ]
    }
  ]
JSON;

  const questionFormat = <<<JSON
[
  {
    "question": "Soal Disini",
    "answers": [
      { "answer": "Jawaban A", "isright": false },
      { "answer": "Jawaban B", "isright": true },
      { "answer": "Jawaban C", "isright": false },
      { "answer": "Jawaban D", "isright": false }
    ],
    "hint": "Hint Disini"
  }
]
JSON;
}
