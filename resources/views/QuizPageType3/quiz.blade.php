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
        position: relative;
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

    /* Tooltip Styles for Hint */
    .hint {
        max-width: 50%;
        position: absolute;
        top: 100%;
        /* Positioned below the Hint button */
        left: 50%;
        transform: translateX(-50%);
        background-color: #17a2b8;
        /* btn-info color */
        color: white;
        padding: 5px 10px;
        font-size: 14px;
        font-style: italic;
        border-radius: 5px;
        white-space: normal;
        /* Allow text to wrap */
        display: none;
        z-index: 10;
        margin-top: 5px;
        /* Space between Hint button and tooltip */
        overflow-wrap: break-word;
        /* Ensures long words break and wrap */
    }


    .hint-button:hover+.hint {
        display: block;
        /* Show hint when hovering over the Hint button */
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
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Media Query for Responsiveness */
    @media (max-width: 768px) {
        .quiz-container {
            flex-direction: column;
            padding: 10px;
        }

        .left-section,
        .right-section {
            flex: none;
            width: 100%;
        }

        .hint {
            left: 0;
            top: 100%;
            transform: translateY(10px);
            width: 100%;
            text-align: center;
        }

        .question-box {
            margin-bottom: 15px;
        }
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
        <h3 class="text-center">Quiz</h3>
        <div id="quiz-timer" class="timer">Waktu: {{ $setting->batas_waktu }}:00</div>
        <div id="current-subcpmk-info" class="text-center my-2"></div>
        <hr>
        <div id="question-container">
            {{-- @foreach (collect($questions)->take($setting->soal_per_sesi) as $index => $question)
            <div class="question hidden" id="question-{{ $index + 1 }}">
                <div class="question-box">
                    <h5>{{ $question->question }}</h5>
                    <!-- Button Hint -->
                    <button class="btn btn-info btn-sm hint-button" onmouseover="showHint()">Hint</button>
                    <!-- Tooltip for Hint -->
                    <p class="hint">{{ $question->hint }}</p>
                </div>
                @foreach ($question->answers as $answer)
                <button class="option-btn"
                    onclick="selectAnswer(this, {{ $index + 1 }}, '{{ $answer->isright }}', '{{ $question->question }}', '{{ $answer->answer }}')">
                    {{ $answer->answer }}
                </button>
                @endforeach
            </div>
            @endforeach --}}
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
            {{-- @foreach (collect($questions)->take($setting->soal_per_sesi) as $index => $question)
            <button id="nav-{{ $index + 1 }}" onclick="goToQuestion({{ $index + 1 }})">
                {{ $index + 1 }}
            </button>
            @endforeach --}}
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

    const firstCpmk = {{ $firstCpmks }};
    const firstLimitBloom = {{ $firstLimitBloom }};
    const predictUrl = "{{ $predictUrl }}";
    const id2 = {{ $id2 }};

    let quizLimitpersession = {{ $setting['soal_per_sesi'] }};
    let hintLimitpersession = 2;
    let currentQuestion = 1;
    let selectedAnswers = {};
    let correctAnswers = [];
    let wrongAnswers = [];
    let timer;
    let timeLeft = {{ $setting['batas_waktu'] }} * 60;
    let waktuBerjalan = timeLeft;
    
    let correctAnswersSesion = 0;
    let sessionStartTime;  // Variable to track session start time
    let userChangeAnswer = 0;
    let userSkipQuestion = 0;
    let userHintClicked = 0;

    document.body.addEventListener('copy', function (e) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'Copy tidak diperbolehkan!',
            timer: 1500,
            showConfirmButton: false
        });
    });

    document.body.addEventListener('paste', function (e) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'Paste tidak diperbolehkan!',
            timer: 1500,
            showConfirmButton: false
        });
    });

    document.body.addEventListener('cut', function (e) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'Cut tidak diperbolehkan!',
            timer: 1500,
            showConfirmButton: false
        });
    });

    document.body.addEventListener('contextmenu', function (e) {
        e.preventDefault();
        Swal.fire({
            icon: 'info',
            title: 'Diblokir!',
            text: 'Klik kanan dinonaktifkan!',
            timer: 1500,
            showConfirmButton: false
        });
    });
    document.onkeydown = function(e) {
        if (e.keyCode === 123) { // F12
            e.preventDefault();
        }
    }

document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        Swal.fire({
            icon: 'danger',
            title: 'Perhatian!',
            text: 'Anda tidak fokus mengerjakan ujian',
            showConfirmButton: true
        });
    }
});


    
    let progress = JSON.parse(localStorage.getItem("quizProgress")) || {
        sessionNumber: 1,
        currentSubCpmkId: allSubCpmks[0].id,
        currentBloomLevel: 1,
        answeredCount: 0,
        history: [],
        questionsLog: [],
        correctAnswers: [],
        wrongAnswers: [],
        timeSpendSessions: [], 
        userChangeAnswerSessions: [],
        userSkipQuestionSessions: [],
        userHintSessions: [],
        rps_id: id2
    };

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

        console.log('Pertanyaan : '+questionText);
        console.log('Jawaban : '+answerText);

        if (isCorrect) {
            correctAnswersSesion++;
            progress.correctAnswers.push({ question: questionText, answer: answerText });
        } else {
            progress.wrongAnswers.push({ question: questionText, answer: answerText });
        }

        // Track answer changes
        // if (!progress.userChangeAnswerSessions[progress.sessionNumber - 1]) {
        //     progress.userChangeAnswerSessions[progress.sessionNumber - 1] = 0;
        // }
        
        userChangeAnswer++;

        document.getElementById(`nav-${questionIndex}`).classList.add("answered");

        if (questionIndex < document.querySelectorAll(".question").length) {
            setTimeout(() => nextQuestion(), 300);
        } else {
            document.getElementById("submit-btn").classList.remove("hidden");
        }
    }

    function showHint() { 
        userHintClicked++;
    }

    function nextQuestion() {
        const total = document.querySelectorAll(".question").length;
        if (currentQuestion < total) {
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
        
        // Track question skips
        if (!selectedAnswers[currentQuestion]) {
            // if (!progress.userSkipQuestionSessions[progress.sessionNumber - 1]) {
            //     progress.userSkipQuestionSessions[progress.sessionNumber - 1] = 0;
            // }
            userSkipQuestion++;
        }
        
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
        // Tampilkan loading spinner
        document.getElementById('loading-spinner').style.display = 'block';
        document.getElementById('question-container').classList.add("hidden");
        clearInterval(timer);

        let total = document.querySelectorAll(".question").length;
        let correct = correctAnswersSesion;

        const startTime = parseInt(localStorage.getItem("quizStartTime"));
        const endTime = Date.now();
        const totalDuration = Math.floor((endTime - startTime) / 1000);
        progress.totalDuration = totalDuration;

        // Record time spent on the session
        const sessionTimeSpent = Math.floor((endTime - sessionStartTime) / 1000); // Time spent on current session
        progress.timeSpendSessions.push({
            session: progress.sessionNumber - 1,
            time: sessionTimeSpent
        });

        // Evaluasi SubCPMK
        evaluateSession(correct, quizLimitpersession, sessionTimeSpent);

    }


    async function evaluateSession(score, totalQuestions, sessionTimeSpent) {
        const subCpmks = allSubCpmks;
        const currentCpmk = subCpmks.find(s => s.id === progress.currentSubCpmkId);
        progress.currentBloomLevel = currentCpmk['limit_bloom'];

        const currentIndex = subCpmks.findIndex(s => s.id === progress.currentSubCpmkId);
        
        let passed;
        const accuracy = score / totalQuestions;


        if (userChangeAnswer === 0) {
            userChangeAnswer = 0;
        } else if (userChangeAnswer === quizLimitpersession) {
            userChangeAnswer = 0;
        } else {
            userChangeAnswer -= quizLimitpersession;
        }

        let notasiB = score;
        let notasiM = (totalQuestions - score);
        let notasiC = userChangeAnswer / (totalQuestions * 2);
        let notasiT = sessionTimeSpent / 240;
        let notasiO = userSkipQuestion / 4;
        let notasiI = userHintClicked / (totalQuestions * 3);
        let notasiE = (notasiB * 0.5) + (notasiM * 0.3) + (notasiC * 0.2);
        let notasiTr = (notasiB + notasiM) / 2;
        let notasiQ = (notasiB + notasiM + notasiC) / 3;
        let notasiSt = (notasiO + notasiI + notasiQ + notasiTr) / 4;

        // PENTING: tunggu hasil async clasification
        let classific = await clasification(notasiB, notasiM, notasiC, notasiT, notasiO, notasiI, notasiE, notasiTr, notasiQ, notasiSt);
        let levelAdjust = classific.ep.class_index + classific.me.class_index;
        
        // let questionAdjust = classific.ep.class_index - classific.te.class_index;
        if (classific.ep.class_index == 2 && quizLimitpersession > 1) {
            quizLimitpersession -= 1;
        }else if (classific.ep.class_index == 1) {
            quizLimitpersession = quizLimitpersession;
        }else if (classific.ep.class_index == 0 && quizLimitpersession < 4) {
            quizLimitpersession += 1;
        }

        if (classific.te.class_index == 0 && quizLimitpersession > 1) {
            quizLimitpersession -= 1;
        }else if (classific.te.class_index == 1) {
            quizLimitpersession = quizLimitpersession;
        }else if (classific.te.class_index == 2 && quizLimitpersession < 4) {
            quizLimitpersession += 1;
        }

        let timeAdjust = classific.cf.class_index + classific.ps.class_index;
        console.log("timeAdjust = " + timeAdjust);
        if (timeAdjust < 2 && timeLeft > 120) {
            console.log("timeAdjust Dikurangi");
            timeLeft -= 30;
        } else if (timeAdjust == 2) {
            timeLeft = timeLeft;
        } else if (timeAdjust >= 3 && timeLeft < 240) {
            timeLeft += 30;
        }

        let hintAdjust = classific.cf.class_index + classific.ac.class_index;
        console.log("hintAdjust = " + hintAdjust);
        if (hintAdjust < 2 && hintLimitpersession > 1) {
            hintLimitpersession -= 1;
        } else if (hintAdjust == 2) {
            hintLimitpersession = hintLimitpersession;
        } else if (hintAdjust >= 3 && hintLimitpersession < 3) {
            hintLimitpersession += 1;
        }

        if (classific.me.class_index == 2 && hintLimitpersession > 1) {
            hintLimitpersession -= 1;
        }else if (classific.me.class_index == 1) {
            hintLimitpersession = hintLimitpersession;
        }else if (classific.me.class_index == 0 && hintLimitpersession < 3) {
            hintLimitpersession += 1;
        }

        // LOGIC MENAIKKAN DAN MENURUNKAN LEVEL
        if (levelAdjust < 2 && progress.currentBloomLevel !== 1) {
            passed = false;
            progress.currentBloomLevel = Math.max(progress.currentBloomLevel - 1, 1);
        } else if (levelAdjust === 2) {
            passed = false;
        } else if (levelAdjust >= 3) {
            if (progress.currentBloomLevel < currentCpmk.limit_bloom) {
                progress.currentBloomLevel++;
            } else if (currentIndex + 1 < subCpmks.length) {
                passed = true;
                progress.currentBloomLevel = 1;
            }
        }

        progress.userChangeAnswerSessions.push({
            session: progress.sessionNumber,
            changeAnswer: userChangeAnswer
        });

        progress.userHintSessions.push({
            session: progress.sessionNumber,
            hintShowed: userHintClicked
        });

        progress.userSkipQuestionSessions.push({
            session: progress.sessionNumber,
            skipQuestion: userSkipQuestion
        });

        progress.sessionNumber++;
        progress.answeredCount += totalQuestions;

        localStorage.setItem("quizProgress", JSON.stringify(progress));

        // Update informasi SubCPMK yang aktif
        updateSubCpmkInfo();

        // Log hasil evaluasi session
        console.log(`Evaluasi sesi: SubCPMK ID ${progress.currentSubCpmkId}`);
        console.log(`Skor: ${score}, Total: ${totalQuestions}, Akurasi: ${accuracy.toFixed(2)}`);

        // Cek apakah semua SubCPMK sudah selesai
        const allSubCpmksCompleted = allSubCpmks.every(sub => {
            const completed = progress.history
                .filter(item => item.subCpmkId === sub.id)
                .some(item => item.passed);

            console.log(`SubCPMK ID ${sub.id}: ${completed ? 'Selesai' : 'Belum Selesai'}`);
            return completed;
        });

        console.log(`Semua SubCPMK selesai: ${allSubCpmksCompleted}`);
        
        // Simpan hasil evaluasi sesi
        progress.history.push({
            subCpmkId: progress.currentSubCpmkId,
            session: progress.sessionNumber,
            score: score,
            total: totalQuestions,
            passed: passed
        });

        if (passed) {
            progress.currentSubCpmkId = subCpmks[currentIndex + 1].id;
        }

        if (allSubCpmksCompleted) {
            console.log('Semua SubCPMK selesai, mengakhiri ujian...');
            finishQuizAutomatically();
        } else {
            console.log('Masih ada SubCPMK yang belum selesai, melanjutkan...');
            if (progress.questionsLog.length < quizLimit) {
                generateNewQuestions(progress.currentSubCpmkId, progress.currentBloomLevel);
            } else {
                finishQuizAutomatically();
            }
        }
    }

    // Fungsi clasification tetap async seperti ini:
    async function clasification(notasiB, notasiM, notasiC, notasiT, notasiO, notasiI, notasiE, notasiTr, notasiQ, notasiSt) {
        try {
            const response = await fetch(predictUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    "features_ep_no_cluster2": [notasiB, notasiQ, notasiM, notasiC, notasiE],
                    "features_cf_no_cluster2": [notasiB, notasiQ, notasiM, notasiC],
                    "features_te_no_cluster2": [notasiB, notasiQ, notasiTr, notasiM, notasiC],
                    "features_me_no_cluster2": [notasiB, notasiT, notasiE, notasiSt],
                    "features_ps_no_cluster2": [notasiT, notasiTr, notasiE, notasiSt],
                    "features_ac_no_cluster2": [notasiI, notasiQ, notasiSt]
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Response:', data);
            return data;

        } catch (error) {
            console.error('Error:', error);
            return 0;
        }
    }

    function updateSubCpmkInfo() {
        const sub = allSubCpmks.find(s => s.id === progress.currentSubCpmkId);
        document.getElementById("current-subcpmk-info").innerHTML =
            `SubCPMK: <strong>${sub.subcpmk}</strong>`;

        const completedSubCpmks = allSubCpmks.filter(sub => {
            const historyItem = progress.history.find(item => item.subCpmkId === sub.id && item.passed);
            return historyItem && historyItem.passed;
        });

        const subCpmkListElement = document.getElementById("subcpmk-list");
        subCpmkListElement.innerHTML = "";  // Reset previous list

        completedSubCpmks.forEach(sub => {
            const bloomLevel = progress.currentBloomLevel || "undefined";  // Fallback for Bloom level
            const li = document.createElement("li");
            li.textContent = `SubCPMK ${sub.subcpmk}`;
            subCpmkListElement.appendChild(li);
        });
    }

    function generateNewQuestions(subCpmkId, bloomLevel) {
        correctAnswersSesion = 0;
        userChangeAnswer = 0;
        userSkipQuestion = 0;
        userHintClicked = 0;
        $.ajax({
            url: `/quizes/generate-questions`,
            method: 'GET',
            data: {
                subcpmk: subCpmkId,
                limit_bloom: bloomLevel,
                answered: progress.answeredCount || 0,
                jml_soal: quizLimitpersession,
                jml_hint: hintLimitpersession,
            },
            success: function(data) {
                progress.questionsLog.push(...data);
                localStorage.setItem("quizProgress", JSON.stringify(progress));
                renderQuestions(data);
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

        selectedAnswers = {};
        currentQuestion = 1;

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

            // Container tombol hint
            const hintButtonsContainer = document.createElement("div");
            hintButtonsContainer.className = "hint-buttons-container";

            // Tooltip hint
            const hintText = document.createElement("p");
            hintText.className = "hint";
            hintText.style.display = "none";

            // Loop seluruh array hints
            question.hints.forEach((hintObj, i) => {
                // hintObj adalah objek seperti {hint1: "..."} atau {hint2: "..."}
                // ambil value dari objek (ada satu saja)
                const hint = Object.values(hintObj)[0];

                const hintButton = document.createElement("button");
                hintButton.className = "btn btn-info btn-sm hint-button";
                hintButton.textContent = `Hint ${i + 1}`;

                hintButton.addEventListener('mouseover', () => {
                    hintText.style.display = "block";
                    hintText.textContent = hint;
                });

                hintButton.addEventListener('mouseout', () => {
                    hintText.style.display = "none";
                });

                hintButtonsContainer.appendChild(hintButton);
            });

            questionBox.appendChild(hintButtonsContainer);
            questionBox.appendChild(hintText);

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

        document.getElementById('loading-spinner').style.display = 'none';
        document.getElementById('question-container').classList.remove("hidden");
    }


    function startTimer() {
        clearInterval(timer);
        sessionStartTime = Date.now(); // Mark the start time of the session
        waktuBerjalan = timeLeft;
        timer = setInterval(() => {
            if (waktuBerjalan == 0) {
                clearInterval(timer);
                Swal.fire({
                            icon: 'danger',
                            title: 'Perhatian!',
                            text: 'Waktu habis!',
                            timer: 1500,
                            showConfirmButton: false
                    });
                submitQuiz();
            }
            waktuBerjalan--;
            const minutes = Math.floor(waktuBerjalan / 60);
            const seconds = waktuBerjalan % 60;
            document.getElementById("quiz-timer").textContent =
                `Waktu: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        }, 1000);
    }

    function startQuiz() {
        document.getElementById("start-modal").style.display = "none";
        document.querySelector(".quiz-container").style.display = "flex";

        localStorage.setItem("quizStartTime", Date.now());

        generateNewQuestions(firstCpmk, firstLimitBloom);
        document.getElementById("question-1").classList.remove("hidden");
        document.getElementById("nav-1").classList.add("active");
        updateSubCpmkInfo();
        startTimer();
    }

    function finishQuizAutomatically() {
        // Show loading spinner
        document.getElementById('loading-spinner').style.display = 'block';
        document.getElementById('question-container').classList.add("hidden");
        clearInterval(timer);

        let total = document.querySelectorAll(".question").length;
        let correct = correctAnswersSesion;

        const startTime = parseInt(localStorage.getItem("quizStartTime"));
        const endTime = Date.now();
        const totalDuration = Math.floor((endTime - startTime) / 1000);
        progress.totalDuration = totalDuration;

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
        window.location.href = "{{ route(\App\Constants\Routes::routeQuizResult3) }}";
    }


    window.onload = () => {
        $('#startQuizModal').modal({ backdrop: 'static', keyboard: false });
        $('#startQuizModal').modal('show');
    };
</script>
@endpush