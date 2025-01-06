<?php

namespace App\Constants;

class JsonExample
{
  const MbtiGenerateQuestion = <<<JSON
{
  "questions":  [
    {
      "question": "Are you INFJ",
      "answers": [
        {
          "answer": "Sangat Setuju",
          "value": 2
        },
        {
          "answer": "Setuju",
          "value": 1
        },
        {
          "answer": "Netral",
          "value": 0
        },
        {
          "answer": "Tidak Setuju",
          "value": -1
        },
        {
          "answer": "Sangat Tidak Setuju",
          "value": -2
        }
      ]
    },
    {
      "question": "Kapan anda merasa senang",
      "answers": [
        {
          "answer": "saat pesta",
          "value": 2
        },
        {
          "answer": "saat dengan teman",
          "value": 1
        },
        {
          "answer": "selalu senang",
          "value": 0
        },
        {
          "answer": "saat memikirkan sesuatu",
          "value": -1
        },
        {
          "answer": "saat sendirian",
          "value": -2
        }
      ]
    }
  ]
}
JSON;
}