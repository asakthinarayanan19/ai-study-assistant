<!DOCTYPE html>
<html>
<head>
    <title>Flashcard Battle</title>
    <a href="dashboard.php" class="back">← Back to Dashboard</a>

    <style>
        .back{
            display:inline-block;
            background:orangered;
            color:white;
            text-decoration:none;
            padding:12px 20px;
            border-radius:12px;
            margin-bottom:20px;
        }
        body{
            font-family:Arial;
            background:#f4f6f9;
            padding:30px;
        }

        textarea{
            width:500px;
            height:100px;
            padding:15px;
            border-radius:10px;
        }

        button{
            padding:10px 20px;
            cursor:pointer;
            margin-top:10px;
        }

        .flashcard{
            background:white;
            padding:20px;
            margin-top:20px;
            border-radius:20px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
            display:none;
        }

        .result{
            margin-top:15px;
            font-weight:bold;
        }

        .scoreboard{
            background:white;
            padding:20px;
            border-radius:20px;
            margin:20px 0;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        input[type=text]{
            width:300px;
            padding:10px;
            border-radius:10px;
            border:1px solid #ccc;
        }
    </style>
</head>

<body>

<h1>⚔️ Flashcard Battle</h1>

<textarea
id="topic"
placeholder="Enter topic">
</textarea>

<br><br>

<button onclick="generateFlashcards()">
    Generate Flashcards
</button>

<div class="scoreboard">
    <h3>🏆 XP: <span id="xp">0</span></h3>

    <h3>🔥 Combo: <span id="combo">0</span></h3>
</div>

<div id="battle-container">
    <div id="flashcard-area"></div>
</div>

<script>

let xp = 0;
let combo = 0;
let bestCombo = 0;
let score = 0;
let total = 0;

function generateFlashcards()
{
    let topic =
        document.getElementById("topic").value;

    if(topic.trim() === "")
    {
        alert("Enter a topic.");
        return;
    }

    fetch(
        "backend/generate_flashcards.php",
        {
            method:"POST",

            headers:{
                "Content-Type":
                "application/x-www-form-urlencoded"
            },

            body:
            "topic="+encodeURIComponent(topic)
        }
    )

    .then(response => response.text())

    .then(data => {

        document.getElementById(
            "flashcard-area"
        ).innerHTML = data;

        let first =
            document.querySelector(".flashcard");

        if(first)
        {
            first.style.display = "block";
             total =
    document.querySelectorAll(".flashcard").length;
        }
    })

    .catch(error => {
        alert("Error generating flashcards");
        console.log(error);
    });
}

function checkAnswer(button)
{
    let card = button.parentElement;

    let userAnswer =
        card.querySelector(".userAnswer")
            .value
            .trim()
            .toLowerCase();

    let correctAnswer =
        card.getAttribute("data-answer")
            .trim()
            .toLowerCase();

    let resultDiv =
        card.querySelector(".result");

    if(userAnswer === "")
    {
        alert("Enter your answer.");
        return;
    }

    if(userAnswer.includes(correctAnswer) ||
    correctAnswer.includes(userAnswer))
    {
        xp += 10;
        combo++;
        score++;

        if(combo > bestCombo)
        {
            bestCombo = combo;
        }

        resultDiv.innerHTML =
            "✅ Correct! +10 XP";
    }
    else
    {
        resultDiv.innerHTML =
            "❌ Wrong<br>Correct Answer: "
            + correctAnswer;

        combo = 0;
    }

    document.getElementById("xp").innerText = xp;

    document.getElementById("combo").innerText = combo;

    button.disabled = true;

    setTimeout(function(){

        card.style.display = "none";

        let next =
            card.nextElementSibling;

        while(next &&
              !next.classList.contains("flashcard"))
        {
            next = next.nextElementSibling;
        }

        if(next)
        {
            next.style.display = "block";
        }
        else
        {
            document.getElementById(
                "battle-container"
            ).innerHTML =
            "<h2>🎉 Battle Complete!</h2>" +
            "<p>Total XP: " + xp + "</p>" +
            "<p>🔥 Best Combo: " + bestCombo + "</p>";
            fetch(
    "backend/save_flashcard_score.php",
    {
        method:"POST",
        headers:{
            "Content-Type":
            "application/x-www-form-urlencoded"
        },
        body:
        "score=" + score +
        "&total=" + total
    }
);
        }

    },1500);
}

</script>

</body>
</html>
