@extends('Templates.admin')

@section('title', 'Quiz Matematika Dasar')

@push('css')
<style>
    body {
        background-color: #f4f6f9;
    }

    .quiz-container {
        display: flex;
        max-width: 900px;
        margin: auto;
        padding: 20px;
        background: #fffaf3;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .left-section {
        flex: 2;
        padding-right: 10px;
    }

    .right-section {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .question-box {
        background: #ffecd9;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        text-align: center;
    }

    .option-btn {
        display: block;
        width: 100%;
        text-align: left;
        padding: 10px;
        margin: 5px 0;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        font-size: 16px;
        transition: 0.3s;
    }

    .option-btn:nth-child(odd) {
        background: #a8dadc;
    }

    .option-btn:nth-child(even) {
        background: #fcbf49;
    }

    .option-btn.selected {
        background: #457b9d !important;
        color: white;
    }

    .quiz-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .hidden {
        display: none;
    }

    .timer {
        background: #e63946;
        color: white;
        padding: 5px;
        text-align: center;
        font-weight: bold;
        border-radius: 5px;
    }

    .question-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        justify-content: center;
    }

    .question-nav button {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 5px;
        background: #f4a261;
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .question-nav button.active {
        background: #2a9d8f;
    }

    .question-nav button.answered {
        background: #264653;
    }
</style>
@endpush

@section('content')
<div class="quiz-container">
    <!-- Bagian Soal -->
    <div class="left-section">
        <h3 class="text-center">Quiz Matematika Dasar</h3>
        <div id="quiz-timer" class="timer">Waktu: 30:00</div>

        <hr>

        <div id="question-container">
            @foreach ($questions as $index => $question)
            <div class="question hidden" id="question-{{ $index + 1 }}">
                <div class="question-box">
                    <h5>{{ $question['question'] }}</h5>
                </div>
                @foreach ($question['answers'] as $answer)
                <button class="option-btn" onclick="selectAnswer(this, {{ $index + 1 }}, '{{ $answer['isright'] }}')">
                    {{ $answer['answer'] }}
                </button>
                @endforeach
            </div>
            @endforeach
        </div>

        <div class="quiz-footer">
            <button class="btn btn-secondary" id="prev-btn" onclick="prevQuestion()" disabled>Sebelumnya</button>
            <button class="btn btn-primary" id="next-btn" onclick="nextQuestion()">Selanjutnya</button>
            <button class="btn btn-success hidden" id="submit-btn" onclick="submitQuiz()">Submit</button>
        </div>
    </div>

    <!-- Bagian Navigasi Soal -->
    <div class="right-section">
        <h5>Navigasi Soal</h5>
        <div class="question-nav">
            @foreach ($questions as $index => $question)
            <button id="nav-{{ $index + 1 }}" onclick="goToQuestion({{ $index + 1 }})">
                {{ $index + 1 }}
            </button>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    let currentQuestion = 1;
    const totalQuestions = {{ count($questions) }};
    let selectedAnswers = {};
    let timer;
    let timeLeft = 30 * 60; 

    function selectAnswer(button, questionIndex, isRight) {
        document.querySelectorAll(`#question-${questionIndex} .option-btn`).forEach(btn => {
            btn.classList.remove("selected");
        });

        button.classList.add("selected");
        selectedAnswers[questionIndex] = isRight === "true";

        document.getElementById(`nav-${questionIndex}`).classList.add("answered");

        // Jika belum di soal terakhir, otomatis ke soal berikutnya
        if (questionIndex < totalQuestions) {
            setTimeout(() => {
                nextQuestion();
            }, 300); // Delay 300ms agar transisi terasa halus
        } else {
            // Jika sudah di soal terakhir, tampilkan tombol submit
            document.getElementById("submit-btn").classList.remove("hidden");
        }
    }


    function nextQuestion() {
        if (currentQuestion < totalQuestions) {
            document.getElementById(`question-${currentQuestion}`).classList.add("hidden");
            currentQuestion++;
            document.getElementById(`question-${currentQuestion}`).classList.remove("hidden");
        }
        updateButtons();
    }

    function prevQuestion() {
        if (currentQuestion > 1) {
            document.getElementById(`question-${currentQuestion}`).classList.add("hidden");
            currentQuestion--;
            document.getElementById(`question-${currentQuestion}`).classList.remove("hidden");
        }
        updateButtons();
    }

    function goToQuestion(index) {
        document.getElementById(`question-${currentQuestion}`).classList.add("hidden");
        currentQuestion = index;
        document.getElementById(`question-${currentQuestion}`).classList.remove("hidden");
        updateButtons();
    }

    function updateButtons() {
        document.getElementById("prev-btn").disabled = currentQuestion === 1;
        document.getElementById("next-btn").classList.toggle("hidden", currentQuestion === totalQuestions);
        document.getElementById("submit-btn").classList.toggle("hidden", currentQuestion !== totalQuestions);

        document.querySelectorAll(".question-nav button").forEach(btn => {
            btn.classList.remove("active");
        });
        document.getElementById(`nav-${currentQuestion}`).classList.add("active");
    }


    function submitQuiz() {
        clearInterval(timer);
        
        let totalQuestions = {{ count($questions) }};
        let correctAnswers = 0;
        let answerData = [];

        for (let i = 1; i <= totalQuestions; i++) {
            let selectedBtn = document.querySelector(`#question-${i} .option-btn.selected`);
            let correctBtn = document.querySelector(`#question-${i} .option-btn[data-correct="true"]`);

            let selectedAnswer = selectedBtn ? selectedBtn.innerText : "Tidak Dijawab";
            let correctAnswer = correctBtn ? correctBtn.innerText : "Tidak Diketahui";
            let isCorrect = selectedBtn && selectedBtn.dataset.correct === "true";

            if (isCorrect) correctAnswers++;

            answerData.push({
                question: document.querySelector(`#question-${i} .question-box h5`).innerText,
                selectedAnswer: selectedAnswer,
                correctAnswer: correctAnswer,
                isCorrect: isCorrect
            });
        }

        let quizResult = {
            score: correctAnswers,
            total: totalQuestions,
            answers: answerData
        };

        // Simpan hasil ke localStorage
        localStorage.setItem("quizResult", JSON.stringify(quizResult));

        // Redirect ke halaman hasil
        window.location.href = "{{ route(\App\Constants\Routes::routeQuizResult) }}";
    }


    function startTimer() {
        timer = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(timer);
                alert("Waktu habis! Quiz akan dikirim otomatis.");
                submitQuiz();
                return;
            }
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById("quiz-timer").textContent = `Waktu: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        }, 1000);
    }

    window.onload = () => {
        document.getElementById("question-1").classList.remove("hidden");
        document.getElementById("nav-1").classList.add("active");
        startTimer();
    };
</script>
@endpush