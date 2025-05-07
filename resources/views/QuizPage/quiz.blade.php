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
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
    }

    .question-nav button.active {
        background: #2a9d8f;
    }

    .question-nav button.answered {
        background: #264653;
    }

    .completed-subcpmks {
        margin-top: 20px;
    }

    .completed-subcpmks ul {
        list-style-type: none;
        padding: 0;
    }

    .completed-subcpmks li {
        background: #a8dadc;
        padding: 5px 10px;
        margin: 5px 0;
        border-radius: 5px;
    }

    /* Loading Spinner Style */
    .loading-spinner {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<!-- Modal Siap Ujian -->
<div id="start-modal"
    style="position: fixed; z-index: 1000; background: rgba(0,0,0,0.5); top: 0; left: 0; right: 0; bottom: 0; display: flex; justify-content: center; align-items: center;">
    <div style="background: white; padding: 30px; border-radius: 10px; text-align: center; max-width: 400px;">
        <h4>Apakah kamu siap ujian?</h4>
        <p>Pastikan kamu sudah siap sebelum memulai karena waktu akan langsung berjalan.</p>
        <button onclick="startQuiz()" class="btn btn-success">Siap Ujian</button>
    </div>
</div>

<div class="quiz-container" style="display: none;">
    <div class="left-section">
        <h3 class="text-center">Quiz Matematika Dasar</h3>
        <div id="quiz-timer" class="timer">Waktu: {{ $setting->batas_waktu }}:00</div>
        <div id="current-subcpmk-info" class="text-center my-2"></div>
        <hr>
        <div id="question-container">
            @foreach (collect($questions)->take($setting->soal_per_sesi) as $index => $question)
            <div class="question hidden" id="question-{{ $index + 1 }}">
                <div class="question-box">
                    <h5>{{ $question->question }}</h5>
                </div>
                @foreach ($question->answers as $answer)
                <button class="option-btn"
                    onclick="selectAnswer(this, {{ $index + 1 }}, '{{ $answer->isright }}', '{{ $question->question }}', '{{ $answer->answer }}')">
                    {{ $answer->answer }}
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
    <div class="right-section">
        <h5>Navigasi Soal</h5>
        <div class="question-nav">
            @foreach (collect($questions)->take($setting->soal_per_sesi) as $index => $question)
            <button id="nav-{{ $index + 1 }}" onclick="goToQuestion({{ $index + 1 }})">
                {{ $index + 1 }}
            </button>
            @endforeach
        </div>

        <!-- Daftar SubCPMK yang Terpenuhi -->
        <div class="completed-subcpmks">
            <h5>SubCPMK yang Terpenuhi:</h5>
            <ul id="subcpmk-list">
                <!-- SubCPMK akan ditambahkan di sini -->
            </ul>
        </div>
    </div>
</div>

<!-- Loading Spinner -->
<div id="loading-spinner" class="loading-spinner"></div>

@endsection

@push('script')
<script>
    const allSubCpmks = @json($subCpmks);
    const quizLimit = {{ $setting['jumlah_soal'] }};
    let currentQuestion = 1;
    let selectedAnswers = {};
    let correctAnswers = [];
    let wrongAnswers = [];
    let timer;
    let timeLeft = {{ $setting['batas_waktu'] }} * 60;

    let progress = JSON.parse(localStorage.getItem("quizProgress")) || {
        sessionNumber: 1,
        currentSubCpmkId: allSubCpmks[0].id,
        currentBloomLevel: 1,
        answeredCount: 0,
        history: [],
        questionsLog: [],
        correctAnswers: [],
        wrongAnswers: []
    };

    function evaluateSession(score, totalQuestions) {
        const subCpmks = allSubCpmks;
        const currentCpmk = subCpmks.find(s => s.id === progress.currentSubCpmkId);
        const currentIndex = subCpmks.findIndex(s => s.id === progress.currentSubCpmkId);
        const passed = score === totalQuestions;

        // If all answers are correct, mark SubCPMK as passed
        progress.history.push({
            subCpmkId: progress.currentSubCpmkId,
            session: progress.sessionNumber,
            score: score,
            total: totalQuestions,
            passed: passed
        });

        // Increase Bloom Level or move to next SubCPMK if passed
        if (passed) {
            if (progress.currentBloomLevel < currentCpmk.limit_bloom) {
                progress.currentBloomLevel++;
            } else if (currentIndex + 1 < subCpmks.length) {
                progress.currentSubCpmkId = subCpmks[currentIndex + 1].id;
                progress.currentBloomLevel = 1;
            }
        }

        // Update session number and answered count
        progress.sessionNumber++;
        progress.answeredCount += totalQuestions;

        localStorage.setItem("quizProgress", JSON.stringify(progress));

        // Update SubCPMK information
        updateSubCpmkInfo();

        // Check if all questions are answered
        if (progress.answeredCount >= quizLimit) {
            // Store the results in local storage
            const quizResult = {
                totalDuration: progress.totalDuration,
                totalCorrect: correctAnswers.length,
                totalIncorrect: wrongAnswers.length,
                correctAnswers: correctAnswers,
                wrongAnswers: wrongAnswers,
                history: progress.history,
                questionsLog: progress.questionsLog,
                lastSubCpmk: progress.currentSubCpmkId,
                currentBloomLevel: progress.currentBloomLevel,
                totalSessions: progress.sessionNumber - 1
            };

            localStorage.setItem("quizResult", JSON.stringify(quizResult));
            alert(`Quiz selesai! Waktu total: ${Math.floor(progress.totalDuration / 60)} menit ${progress.totalDuration % 60} detik`);
            hapusSesi();
            window.location.href = "{{ route(\App\Constants\Routes::routeQuizResult) }}";
        } else {
            // Generate new questions for the next Bloom Level or SubCPMK
            generateNewQuestions(progress.currentSubCpmkId, progress.currentBloomLevel);
        }
    }

    function updateSubCpmkInfo() {
        const sub = allSubCpmks.find(s => s.id === progress.currentSubCpmkId);
        document.getElementById("current-subcpmk-info").innerHTML =
            `SubCPMK: <strong>${sub.subcpmk}</strong> (Bloom Level: ${progress.currentBloomLevel})`;

        const completedSubCpmks = allSubCpmks.filter(sub => {
            const historyItem = progress.history.find(item => item.subCpmkId === sub.id && item.passed);
            return historyItem && historyItem.passed;  // Filter completed SubCPMKs
        });

        const subCpmkListElement = document.getElementById("subcpmk-list");
        subCpmkListElement.innerHTML = ""; // Reset previous list

        completedSubCpmks.forEach(sub => {
            const bloomLevel = progress.currentBloomLevel || "undefined"; // Fallback for Bloom level
            const li = document.createElement("li");
            li.textContent = `SubCPMK ${sub.subcpmk} - Bloom Level: ${bloomLevel}`;
            subCpmkListElement.appendChild(li);
        });
    }

    function selectAnswer(button, questionIndex, isRight, questionText, answerText) {
        if (selectedAnswers.hasOwnProperty(questionIndex)) {
            const previouslySelectedBtn = document.querySelector(`#question-${questionIndex} .option-btn.selected`);
            if (previouslySelectedBtn) {
                previouslySelectedBtn.classList.remove("selected");
            }
        }

        button.classList.add("selected");

        const isCorrect = isRight === "true" || isRight === true;
        selectedAnswers[questionIndex] = { answer: answerText, isCorrect: isCorrect };

        if (isCorrect) {
            correctAnswers.push({ question: questionText, answer: answerText });
        } else {
            wrongAnswers.push({ question: questionText, answer: answerText });
        }

        document.getElementById(`nav-${questionIndex}`).classList.add("answered");

        if (questionIndex < document.querySelectorAll(".question").length) {
            setTimeout(() => nextQuestion(), 300);
        } else {
            document.getElementById("submit-btn").classList.remove("hidden");
        }
    }

    function nextQuestion() {
        const total = document.querySelectorAll(".question").length;
        if (currentQuestion < total) {
            // Hide the previous question
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
        const total = document.querySelectorAll(".question").length;
        document.getElementById("prev-btn").disabled = currentQuestion === 1;
        document.getElementById("next-btn").classList.toggle("hidden", currentQuestion === total);
        document.getElementById("submit-btn").classList.toggle("hidden", currentQuestion !== total);
        document.querySelectorAll(".question-nav button").forEach(btn => btn.classList.remove("active"));
        document.getElementById(`nav-${currentQuestion}`).classList.add("active");
    }

    function submitQuiz() {
        // Show loading spinner
        document.getElementById('loading-spinner').style.display = 'block';
        document.getElementById('question-container').classList.add("hidden");  // Hide quiz questions while loading
        clearInterval(timer);
        let total = document.querySelectorAll(".question").length;
        let correct = correctAnswers.length;

        const startTime = parseInt(localStorage.getItem("quizStartTime"));
        const endTime = Date.now();
        const totalDuration = Math.floor((endTime - startTime) / 1000);
        progress.totalDuration = totalDuration;

        evaluateSession(correct, total);
    }

    function generateNewQuestions(subCpmkId, bloomLevel) {
        $.ajax({
            url: `/quizes/generate-questions`,
            method: 'GET',
            data: {
                subcpmk: subCpmkId,
                limit_bloom: bloomLevel,
                answered: progress.answeredCount || 0
            },
            success: function(data) {
                progress.questionsLog.push(...data);
                localStorage.setItem("quizProgress", JSON.stringify(progress));

                renderQuestions(data);  // Re-render the questions
            },
            error: function(xhr, status, error) {
                alert("Gagal memuat soal baru");
                console.error("Error:", error);
            }
        });
    }

    function renderQuestions(data) {
        const container = document.getElementById("question-container");
        const navContainer = document.querySelector(".question-nav");

        container.innerHTML = "";
        navContainer.innerHTML = "";

        selectedAnswers = {};  // Reset selected answers
        currentQuestion = 1;   // Reset to the first question

        data.forEach((question, index) => {
            const qIndex = index + 1;

            const div = document.createElement("div");
            div.className = "question hidden";
            div.id = `question-${qIndex}`;

            const questionBox = document.createElement("div");
            questionBox.className = "question-box";

            const h5 = document.createElement("h5");
            h5.textContent = question.question;
            questionBox.appendChild(h5);
            div.appendChild(questionBox);

            question.answers.forEach(answer => {
                const btn = document.createElement("button");
                btn.className = "option-btn";
                btn.textContent = answer.answer;

                btn.onclick = function() {
                    selectAnswer(btn, qIndex, answer.isright, question.question, answer.answer);
                };
                div.appendChild(btn);
            });

            container.appendChild(div);

            const navBtn = document.createElement("button");
            navBtn.id = `nav-${qIndex}`;
            navBtn.textContent = qIndex;
            navBtn.onclick = function() {
                goToQuestion(qIndex);
            };
            navContainer.appendChild(navBtn);
        });

        document.getElementById("question-1").classList.remove("hidden");
        document.getElementById("nav-1").classList.add("active");
        updateButtons();
        updateSubCpmkInfo();
        startTimer();

        // Hide loading spinner and show questions
        document.getElementById('loading-spinner').style.display = 'none';
        document.getElementById('question-container').classList.remove("hidden");
    }

    function startTimer() {
        clearInterval(timer);
        timeLeft = {{ $setting['batas_waktu'] }} * 60;

        timer = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(timer);
                alert("Waktu habis!");
                window.location.href = "{{ route(\App\Constants\Routes::routeQuizResult) }}";
                hapusSesi();
                return;
            }
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById("quiz-timer").textContent =
                `Waktu: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        }, 1000);
    }

    function hapusSesi() {
        // Uncomment jika ingin reset saat selesai
        // localStorage.removeItem("quizProgress");
        // localStorage.removeItem("quizStartTime");
    }

    function startQuiz() {
        document.getElementById("start-modal").style.display = "none";
        document.querySelector(".quiz-container").style.display = "flex";

        localStorage.setItem("quizStartTime", Date.now());

        renderQuestions(@json(collect($questions)->take($setting->soal_per_sesi)));
        document.getElementById("question-1").classList.remove("hidden");
        document.getElementById("nav-1").classList.add("active");
        updateSubCpmkInfo();
        startTimer();
    }

    window.onload = () => {
        $('#startQuizModal').modal({ backdrop: 'static', keyboard: false });
        $('#startQuizModal').modal('show');
    };
</script>
@endpush
