<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Serious Game - Nirdious</title>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo"><img src="assets/logo nirdious.png" alt="logo nirdious" width="250px"></div>
            <ul class="nav-links">
                <li><a href="snake.html">Snake</a></li>
                <li><a href="#services">Femmes dans le numérique</a></li>
                <li><a href="#apropos">Nous Contacter</a></li>
                <li><a href="#contact">FAQ et Support</a></li>
                <li><a href="qcm.html">Nirdious Game</a></li>
            </ul>
            <button class="menu-toggle" id="menuToggle" aria-label="Ouvrir le menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>
    
    <div class="quiz-container">
        <div class="quiz-header">
            <h1>Quiz : Culture Numérique</h1>
            <p>Testez vos connaissances sur le monde du numérique</p>
        </div>

        <div id="quizSection">
            <div class="progress-bar">
                <div class="progress-fill" id="progressBar"></div>
            </div>

            <div class="question-counter" id="questionCounter">
                Question 1 sur 4
            </div>

            <div id="questionsContainer"></div>

            <div class="feedback" id="feedback"></div>

            <div class="btn-container">
                <button class="btn btn-secondary" id="prevBtn" onclick="previousQuestion()" disabled>
                    ← Précédent
                </button>
                <button class="btn btn-primary" id="nextBtn" onclick="nextQuestion()" disabled>
                    Suivant →
                </button>
                <button class="btn btn-primary" id="submitBtn" onclick="submitQuiz()" style="display:none;">
                    Voir les résultats
                </button>
            </div>
        </div>

        <div class="results" id="results">
            <h2>🎉 Quiz Terminé !</h2>
            <div class="score-display" id="scoreDisplay">0/4</div>
            <div class="score-message" id="scoreMessage"></div>

            <div class="stats">
                <div class="stat-card">
                    <div class="stat-value" id="correctCount">0</div>
                    <div class="stat-label">Bonnes réponses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="incorrectCount">0</div>
                    <div class="stat-label">Mauvaises réponses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="percentageScore">0%</div>
                    <div class="stat-label">Score</div>
                </div>
            </div>

            <div class="btn-container">
                <button class="btn btn-primary" onclick="restartQuiz()">
                    🔄 Recommencer
                </button>
            </div>
        </div>
    </div>

    <script>
    // --- DONNÉES DU QUIZ ---
    const questions = [
        {
            question: "Quel système d’exploitation est open-source et gratuit ?",
            answers: ["A) Windows", "B) Linux NIRD", "C) PrimTux", "D) MacOS","E) Réponse B et C"],
            correct: 4, 
            explanation: "Linux NIRD est un système d’exploitation open-source et gratuit."
        },
        {
            question: "Que veut dire NIRD ?",
            answers: ["Numérique Inclusif Responsable Durable", "Nous Ignorons les Réseaux Durables", "Une abréviation de Nature Bird"],
            correct: 0,
            explanation: "NIRD signifie « Numérique Inclusif Responsable Durable »."
        },
        {
            question: "Combien font 595 + 453 ?",
            answers: ["948", "1048", "957"],
            correct: 1,
            explanation: "595 + 453 = 1048"
        },
        {
            question: "Que peut t’on trouver/faire dans un éditeur de texte ?",
            answers: ["Mettre le texte en italique","Mettre le texte en gras","Mettre le texte en mosaïque","Mettre le texte en république","Réponse A et B","Réponse C et D"],
            correct: 4,
            explanation: ""
        }
    ];

    // --- VARIABLES GLOBALES ---
    let currentQuestion = 0;
    let userAnswers = [];
    let score = 0;

    // --- INITIALISATION ---
    document.addEventListener('DOMContentLoaded', initQuiz);

    function initQuiz() {
        renderQuestion();
        updateProgress();
        updateButtons();
    }

    // --- AFFICHAGE DE LA QUESTION ---
    function renderQuestion() {
        const container = document.getElementById('questionsContainer');
        const q = questions[currentQuestion];
        
        if (!q) return;

        container.innerHTML = `
            <div class="question-card active">
                <div class="question">${currentQuestion + 1}. ${q.question}</div>
                <div class="answers">
                    ${q.answers.map((answer, i) => `
                        <button class="answer-btn" onclick="selectAnswer(${i})">
                            ${answer}
                        </button>
                    `).join('')}
                </div>
            </div>
        `;

        document.getElementById('feedback').classList.remove('show');
        updateQuestionCounter();
    }

    // --- SÉLECTION D'UNE RÉPONSE ---
    function selectAnswer(answerIndex) {
        // Si on a déjà répondu, on ne fait rien
        if (userAnswers[currentQuestion] !== undefined) return;

        userAnswers[currentQuestion] = answerIndex;
        
        const q = questions[currentQuestion];
        const buttons = document.querySelectorAll('.answer-btn');
        
        const correctData = q.correct;
        const isCorrect = Array.isArray(correctData) 
            ? correctData.includes(answerIndex) 
            : correctData === answerIndex;

        buttons.forEach((btn, i) => {
            btn.disabled = true;
            if (i === answerIndex) {
                if (isCorrect) {
                    btn.classList.add('correct');
                    score++;
                    showFeedback(true, q.explanation);
                } else {
                    btn.classList.add('incorrect');
                    showFeedback(false, q.explanation);
                    
                    const mainCorrect = Array.isArray(correctData) ? correctData[0] : correctData;
                    buttons[mainCorrect].classList.add('correct');
                }
            }
        });

        updateButtons();
    }

    // --- AFFICHAGE DU FEEDBACK ---
    function showFeedback(correct, explanation) {
        const feedback = document.getElementById('feedback');
        feedback.className = `feedback show ${correct ? 'correct' : 'incorrect'}`;
        feedback.innerHTML = `
            <strong>${correct ? '✅ Bonne réponse !' : '❌ Mauvaise réponse'}</strong><br>
            ${explanation || ''}
        `;
    }

    // --- QUESTION SUIVANTE ---
    function nextQuestion() {
        if (currentQuestion < questions.length - 1) {
            currentQuestion++;
            renderQuestion();
            updateProgress();
            updateButtons();
        }
    }

    // --- QUESTION PRÉCÉDENTE ---
    function previousQuestion() {
        if (currentQuestion > 0) {
            currentQuestion--;
            renderQuestion();
            updateProgress();
            updateButtons();
        }
    }

    // --- MISE À JOUR DES BOUTONS ---
    function updateButtons() {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');

        // Bouton Précédent
        if (prevBtn) prevBtn.disabled = currentQuestion === 0;
        
        // Vérifie si l'utilisateur a répondu
        const hasAnswered = userAnswers[currentQuestion] !== undefined;

        // Dernière question
        if (currentQuestion === questions.length - 1) {
            if (nextBtn) nextBtn.style.display = 'none';
            if (submitBtn) {
                submitBtn.style.display = 'inline-block';
                submitBtn.disabled = !hasAnswered;
            }
        } else {
            if (nextBtn) {
                nextBtn.style.display = 'inline-block';
                nextBtn.disabled = !hasAnswered;
            }
            if (submitBtn) submitBtn.style.display = 'none';
        }
    }

    // --- BARRE DE PROGRESSION ---
    function updateProgress() {
        const progress = ((currentQuestion + 1) / questions.length) * 100;
        const bar = document.getElementById('progressBar');
        if (bar) bar.style.width = progress + '%';
    }

    // --- COMPTEUR DE QUESTIONS ---
    function updateQuestionCounter() {
        const counter = document.getElementById('questionCounter');
        if (counter) counter.textContent = `Question ${currentQuestion + 1} sur ${questions.length}`;
    }

    // --- SOUMISSION DU QUIZ ---
    function submitQuiz() {
        document.getElementById('quizSection').style.display = 'none';
        document.getElementById('results').classList.add('show');
        
        const percentage = Math.round((score / questions.length) * 100);
        document.getElementById('scoreDisplay').textContent = `${score}/${questions.length}`;
        document.getElementById('correctCount').textContent = score;
        document.getElementById('incorrectCount').textContent = questions.length - score;
        document.getElementById('percentageScore').textContent = percentage + '%';
        
        let message = '';
        if (percentage === 100) message = "🏆 Parfait ! Vous êtes un expert !";
        else if (percentage >= 75) message = "🎉 Excellent travail !";
        else if (percentage >= 50) message = "👍 Bon travail, continuez !";
        else message = "💪 Courage, réessayez !";
        
        document.getElementById('scoreMessage').textContent = message;
    }

    // --- RECOMMENCER LE QUIZ ---
    function restartQuiz() {
        currentQuestion = 0;
        userAnswers = [];
        score = 0;
        document.getElementById('quizSection').style.display = 'block';
        document.getElementById('results').classList.remove('show');
        initQuiz();
    }
    </script>
</body>
</html>
