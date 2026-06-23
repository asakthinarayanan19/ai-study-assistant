<?php
session_start();

if(isset($_SESSION['user_id']))
{
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>AI Study Assistant</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
    scroll-behavior:smooth;
}

body{
    background:#f5f7fb;
    color:#222;
}

/* NAVBAR */

.navbar{
    position:sticky;
    top:0;
    z-index:1000;
    background:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 8%;
    box-shadow:0 2px 15px rgba(0,0,0,0.08);
}

.logo{
    font-size:32px;
    font-weight:800;
    color:#4f46e5;
}

.nav-links{
    display:flex;
    align-items:center;
    gap:20px;
}

.nav-links a{
    text-decoration:none;
    color:#333;
    font-weight:600;
}

.login-btn{
    background:#2563eb;
    color:white !important;
    padding:10px 20px;
    border-radius:8px;
}

.register-btn{
    background:#4f46e5;
    color:white !important;
    padding:10px 20px;
    border-radius:8px;
}

/* HERO */

.hero{
    min-height:85vh;
    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;
    padding:60px 8%;
}

.hero-content{
    max-width:900px;
}

.hero h1{
    font-size:65px;
    margin-bottom:20px;
    color:#111827;
}

.hero span{
    color:#4f46e5;
}

.hero p{
    font-size:22px;
    color:#666;
    line-height:1.8;
    margin-bottom:35px;
}

.hero-buttons{
    display:flex;
    justify-content:center;
    gap:15px;
    flex-wrap:wrap;
}

.hero-buttons a{
    text-decoration:none;
    padding:15px 28px;
    border-radius:10px;
    font-weight:bold;
}

.get-started{
    background:#4f46e5;
    color:white;
}

.login{
    background:#2563eb;
    color:white;
}

/* SECTION TITLE */

.section-title{
    text-align:center;
    font-size:40px;
    margin-bottom:50px;
    color:#111827;
}

/* FEATURES */

.features{
    padding:80px 8%;
}

.feature-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

.feature-card{
    background:white;
    padding:35px;
    border-radius:20px;
    text-align:center;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
    transition:.3s;
}

.feature-card:hover{
    transform:translateY(-10px);
}

.feature-card i{
    font-size:50px;
    color:#4f46e5;
    margin-bottom:15px;
}

.feature-card h3{
    margin-bottom:15px;
}

/* HOW IT WORKS */

.steps{
    padding:80px 8%;
}

.step-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:20px;
}

.step-card{
    background:white;
    border-radius:20px;
    text-align:center;
    padding:30px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.step-number{
    width:60px;
    height:60px;
    margin:auto;
    border-radius:50%;
    background:#4f46e5;
    color:white;
    font-size:24px;
    font-weight:bold;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:15px;
}

/* STATS */

.stats{
    padding:80px 8%;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:25px;
}

.stat-card{
    background:white;
    border-radius:20px;
    text-align:center;
    padding:35px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.stat-card h2{
    color:#4f46e5;
    font-size:45px;
}

/* CTA */

.cta{
    padding:90px 8%;
    text-align:center;
}

.cta-box{
    background:linear-gradient(135deg,#4f46e5,#2563eb);
    color:white;
    border-radius:25px;
    padding:60px;
}

.cta-box h2{
    font-size:40px;
    margin-bottom:15px;
}

.cta-box p{
    margin-bottom:25px;
    font-size:18px;
}

.cta-box a{
    text-decoration:none;
    background:white;
    color:#4f46e5;
    padding:15px 30px;
    border-radius:10px;
    font-weight:bold;
}

/* FOOTER */

.footer{
    background:#111827;
    color:white;
    text-align:center;
    padding:40px;
}

.footer h3{
    margin-bottom:10px;
}

/* MOBILE */

@media(max-width:768px){

.navbar{
    flex-direction:column;
    gap:15px;
}

.hero h1{
    font-size:42px;
}

.hero p{
    font-size:18px;
}

.section-title{
    font-size:30px;
}

}

</style>

</head>

<body>

<!-- NAVBAR -->

<div class="navbar">

    <div class="logo">
        AI STUDY ASSISTANT
    </div>

    <div class="nav-links">

        <a href="#home">Home</a>
        <a href="#features">Features</a>
        <a href="#how">How It Works</a>

        <a href="login.html" class="login-btn">
            Login
        </a>

        <a href="reg.html" class="register-btn">
            Register
        </a>

    </div>

</div>

<!-- HERO -->

<section class="hero" id="home">

    <div class="hero-content">

        <h1>
            Your Personal <span>AI Study Assistant</span>
        </h1>

        <p>
            Chat with AI, save smart notes, generate quizzes,
    battle flashcards, explore knowledge maps,
    and master exam revision — all in one platform
    designed for students.
        </p>

        <div class="hero-buttons">

            <a href="reg.html"
               class="get-started">
                Get Started Free
            </a>

            <a href="login.html"
               class="login">
                Login
            </a>

        </div>

    </div>

</section>
<!-- FEATURES -->

<section class="features" id="features">

<h2 class="section-title">
    Features
</h2>

<div class="feature-grid">

    <div class="feature-card">
        <i class="fas fa-robot"></i>
        <h3>AI Chat Assistant</h3>
        <p>
            Ask academic questions and receive
            instant AI-powered explanations.
        </p>
    </div>

    <div class="feature-card">
        <i class="fas fa-book"></i>
        <h3>Smart Notes</h3>
        <p>
            Save important AI responses as notes
            and revisit them anytime.
        </p>
    </div>

    <div class="feature-card">
        <i class="fas fa-file-circle-question"></i>
        <h3>Auto Quiz Generator</h3>
        <p>
            Generate 10 MCQs automatically from
            any topic and test your understanding.
        </p>
    </div>

    <div class="feature-card">
        <i class="fas fa-history"></i>
        <h3>Quiz History</h3>
        <p>
            Review previous attempts, scores,
            explanations, and improve continuously.
        </p>
    </div>

    <div class="feature-card">
        <i class="fas fa-bolt"></i>
        <h3>Flashcard Battles</h3>
        <p>
            Learn through XP, combo streaks,
            and fun revision battles.
        </p>
    </div>

    <div class="feature-card">
        <i class="fas fa-sitemap"></i>
        <h3>AI Knowledge Maps</h3>
        <p>
            Visualize topics as interactive
            roadmaps for quick revision.
        </p>
    </div>

    <div class="feature-card">
        <i class="fas fa-chart-line"></i>
        <h3>Learning Dashboard</h3>
        <p>
            Track notes, quizzes, and AI
            activities in one place.
        </p>
    </div>

    <div class="feature-card">
        <i class="fas fa-stopwatch"></i>
        <h3>30-Min Revision Mode</h3>
        <p>
            Revise top concepts and FAQs
            before entering the exam hall.
        </p>
    </div>

</div>

</section>

<!-- HOW IT WORKS -->

<section class="steps" id="how">

<h2 class="section-title">
    How It Works
</h2>

<div class="step-grid">

    <div class="step-card">
        <div class="step-number">1</div>
        <h3>Register</h3>
        <p>Create your account.</p>
    </div>

    <div class="step-card">
        <div class="step-number">2</div>
        <h3>Ask AI</h3>
        <p>Get instant explanations.</p>
    </div>

    <div class="step-card">
        <div class="step-number">3</div>
        <h3>Save Notes</h3>
        <p>Store important responses.</p>
    </div>

    <div class="step-card">
        <div class="step-number">4</div>
        <h3>Take Quizzes</h3>
        <p>Practice with MCQs.</p>
    </div>

    <div class="step-card">
        <div class="step-number">5</div>
        <h3>Battle Flashcards</h3>
        <p>Earn XP and combos.</p>
    </div>

    <div class="step-card">
        <div class="step-number">6</div>
        <h3>Knowledge Maps</h3>
        <p>Visualize concepts quickly.</p>
    </div>

    <div class="step-card">
        <div class="step-number">7</div>
        <h3>Track Progress</h3>
        <p>Improve every day.</p>
    </div>

</div>

</section>

<!-- WHY STUDENTS LOVE US -->

<section class="stats">

<h2 class="section-title">
    Why Students Love Us
</h2>

<div class="stats-grid">

    <div class="stat-card">
        <h2>24/7</h2>
        <p>AI Learning Support</p>
    </div>

    <div class="stat-card">
        <h2>⚔️</h2>
        <p>Gamified Flashcard Battles</p>
    </div>

    <div class="stat-card">
        <h2>🗺️</h2>
        <p>Interactive Knowledge Maps</p>
    </div>

    <div class="stat-card">
        <h2>🎯</h2>
        <p>Exam Revision Mode</p>
    </div>

</div>

</section>
<!-- CTA -->

<section class="cta">

    <div class="cta-box">

        <h2>
            Start Your Smart Learning Journey Today
        </h2>

        <p>
            Join AI Study Assistant and transform the
            way you study using AI-powered notes,
            automatic quizzes, and personalized
            learning tools designed for students.
        </p>

        <a href="reg.html">
            Get Started Free
        </a>

    </div>

</section>

<!-- FOOTER -->

<div class="footer">

    <h3>
        AI Study Assistant
    </h3>

    <p>
        Learn Smarter • Practice Better • Achieve More
    </p>

    <br>

    <p>
        © 2026 AI Study Assistant. All Rights Reserved.
    </p>

</div>

</body>
</html>