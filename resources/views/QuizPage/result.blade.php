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
        padding: 20px;
        font-size: 28px;
        font-weight: bold;
        border-radius: 12px;
        margin-bottom: 30px;
        color: #333;
    }

    .answer-list {
        text-align: left;
        margin-top: 20px;
    }

    .answer-item {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        border-left: 6px solid;
        background-color: #f9f9f9;
    }

    .correct {
        border-color: #2a9d8f;
        background: #e0f7f4;
        color: #1e5c54;
    }

    .wrong {
        border-color: #e63946;
        background: #fdecea;
        color: #831c1c;
    }

    .footer {
        margin-top: 30px;
    }

    .question-text {
        font-weight: bold;
        margin-bottom: 5px;
    }

    @media (max-width: 600px) {
        .score-box {
            font-size: 22px;
        }

        .answer-item {
            font-size: 14px;
        }
    }
</style>
@endpush

@section('content')
<div class="result-container">
    <h2>Hasil Quiz</h2>
    <div class="score-box">
        Skor Anda: <span id="score">0</span> / <span id="total">0</span> (<span id="percent">0</span>%)
    </div>

    <h4>Detail Quiz</h4>
    <ul class="list-group text-start">
        <li class="list-group-item">Durasi: <strong id="duration">-</strong></li>
        <li class="list-group-item">Jumlah Sesi: <strong id="sessions">-</strong></li>
        <li class="list-group-item">Sub-CPMK Terakhir: <strong id="subcpmk">-</strong></li>
    </ul>

    <h4>Jawaban Anda</h4>
    <div id="answer-list-container" class="answer-list">
        <!-- Jawaban akan ditambahkan di sini -->
    </div>

    <div class="footer mt-4">
        <a href="/" class="btn btn-primary">Kembali ke Beranda</a>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };

        const quizData = JSON.parse(localStorage.getItem("quizProgress"));

        if (!quizData) {
            alert("Data quiz tidak ditemukan!");
            window.location.href = "/";
            return;
        }

        const correctAnswers = quizData.correctAnswers || [];
        const wrongAnswers = quizData.wrongAnswers || [];
        const questionLogs = quizData.questionsLog || [];

        const correct = correctAnswers.length;
        const incorrect = wrongAnswers.length;
        const total = correct + incorrect;
        const percent = total > 0 ? Math.round((correct / total) * 100) : 0;

        document.getElementById("score").innerText = correct;
        document.getElementById("total").innerText = total;
        document.getElementById("percent").innerText = percent;

        // Konversi durasi detik -> menit & detik
        const totalSeconds = quizData.totalDuration || 0;
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;
        document.getElementById("duration").innerText = `${minutes} menit ${seconds} detik`;

        document.getElementById("sessions").innerText = quizData.totalSessions || "-";
        document.getElementById("subcpmk").innerText = quizData.currentBloomLevel || "-";

        // Helper untuk ambil jawaban user
        const getSelectedAnswer = (answers) => {
            const selected = answers.find(a => a.isright);
            return selected ? selected.answer : "Tidak dijawab";
        };

        const answerListContainer = document.getElementById("answer-list-container");

        questionLogs.forEach(log => {
            const userAnswer = getSelectedAnswer(log.answers);
            const correctAnswerObj = correctAnswers.find(item => item.question === log.question);
            const wrongAnswerObj = wrongAnswers.find(item => item.question === log.question);

            let status = "unknown";
            if (correctAnswerObj && correctAnswerObj.answer === userAnswer) {
                status = "correct";
            } else if (wrongAnswerObj && wrongAnswerObj.answer === userAnswer) {
                status = "wrong";
            }

            const el = document.createElement("div");
            el.classList.add("answer-item", status);
            el.innerHTML = `
                <div class="question-text"><strong>${log.question}</strong></div>
                <div>Jawaban Anda: <strong>${userAnswer}</strong></div>
                <div>Status: <span style="color:${status === "correct" ? "green" : "red"}">${status === "correct" ? "Benar" : "Salah"}</span></div>
            `;

            // Tambahkan jawaban yang benar jika salah
            if (status === "wrong" && correctAnswerObj) {
                el.innerHTML += `<div>Jawaban yang benar: <strong>${correctAnswerObj.answer}</strong></div>`;
            }

            answerListContainer.appendChild(el);
        });

        const progressToSend = {
            totalDuration: quizData.totalDuration || 0,
            timeSpendSessions: quizData.timeSpendSessions || [],
            userSkipQuestionSessions: quizData.userSkipQuestionSessions || [],
            userChangeAnswerSessions: quizData.userChangeAnswerSessions || [],
            userHintSessions: quizData.userHintSessions || [],
            correctCount: correct,
            wrongCount: incorrect,
            correctPercent: percent
        };

        fetch('/quiz/progress/submit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(progressToSend)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Gagal mengirim data ke server.");
            }
            return response.json();
        })
        .then(data => {
            console.log("Progres berhasil dikirim:", data);

            // Hapus data setelah sukses kirim
            localStorage.removeItem("quizResult");
            localStorage.removeItem("quizStartTime");
            localStorage.removeItem("quizProgress");
        })
        .catch(error => {
            console.error("Gagal mengirim progres:", error);
            alert("Gagal mengirim data ke server. Coba lagi nanti.");
        });

        // Hapus semua data di localStorage setelah menampilkan hasil
        localStorage.removeItem("quizResult");
        localStorage.removeItem("quizStartTime");
        localStorage.removeItem("quizProgress");
    });
</script>
@endpush