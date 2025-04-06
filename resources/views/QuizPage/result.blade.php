@extends('Templates.admin')

@section('title', 'Hasil Quiz')

@push('css')
<style>
    body {
        background-color: #f4f6f9;
    }

    .result-container {
        max-width: 800px;
        margin: auto;
        padding: 20px;
        background: #fffaf3;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .score-box {
        background: #ffb703;
        padding: 15px;
        font-size: 24px;
        font-weight: bold;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .answer-list {
        text-align: left;
        margin-top: 20px;
    }

    .answer-item {
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 5px;
    }

    .correct {
        background: #2a9d8f;
        color: white;
    }

    .wrong {
        background: #e63946;
        color: white;
    }

    .footer {
        margin-top: 20px;
    }
</style>
@endpush

@section('content')
<div class="result-container">
    <h2>Hasil Quiz</h2>
    <div class="score-box">
        Skor Anda: <span id="score">0</span> / <span id="total"></span>
    </div>

    <h4>Jawaban Anda</h4>
    <div class="answer-list" id="answer-list"></div>

    <div class="footer">
        <a href="/" class="btn btn-primary">Kembali ke Beranda</a>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Mencegah pengguna menekan tombol back
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };

        // Ambil data dari localStorage
        let quizData = JSON.parse(localStorage.getItem("quizResult"));

        if (!quizData) {
            alert("Tidak ada data quiz! Kembali ke halaman utama.");
            window.location.href = "/";
            return;
        }

        document.getElementById("score").innerText = quizData.score;
        document.getElementById("total").innerText = quizData.total;

        let answerList = document.getElementById("answer-list");
        quizData.answers.forEach((answer, index) => {
            let div = document.createElement("div");
            div.classList.add("answer-item");
            div.classList.add(answer.isCorrect ? "correct" : "wrong");
            div.innerHTML = `<b>${index + 1}. ${answer.question}</b><br>
                             Jawaban Anda: ${answer.selectedAnswer} <br>
                             Jawaban Benar: ${answer.correctAnswer}`;
            answerList.appendChild(div);
        });

        // Hapus data setelah ditampilkan
        localStorage.removeItem("quizResult");
    });
</script>
@endpush
