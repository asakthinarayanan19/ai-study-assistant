<?php
include "backend/config.php";

/* Total Notes */
$notes = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM notes"
    )
);

/* Total Completed Quizzes */
$quizzes = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM quizzes"
    )
);

/* Total AI Chats */
$chat_check = mysqli_query(
    $conn,
    "SHOW TABLES LIKE 'chat_history'"
);

if(mysqli_num_rows($chat_check) > 0)
{
    $chats = mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COUNT(*) AS total FROM chat_history"
        )
    );

    $chat_total = $chats['total'];
}
else
{
    $chat_total = 0;
}

/* Flashcard Battles */
$flashcard_check = mysqli_query(
    $conn,
    "SHOW TABLES LIKE 'flashcard_scores'"
);

if(mysqli_num_rows($flashcard_check) > 0)
{
    $flashcards = mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT COUNT(*) AS total
             FROM flashcard_scores"
        )
    );

    $flashcard_total = $flashcards['total'];
}
else
{
    $flashcard_total = 0;
}

/* Recent Notes */
$recent_notes = mysqli_query(
    $conn,
    "SELECT id, title
     FROM notes
     ORDER BY id DESC
     LIMIT 3"
);

/* Recent Quizzes */
$quiz_table = mysqli_query(
    $conn,
    "SHOW TABLES LIKE 'quizzes'"
);

if(mysqli_num_rows($quiz_table) > 0)
{
    $recent_quizzes = mysqli_query(
        $conn,
        "SELECT *
         FROM quizzes
         ORDER BY id DESC
         LIMIT 3"
    );
}
?>
<!DOCTYPE html>
<html>

<head>

<title>Dashboard</title>

<style>

*{
    margin:0;
    padding:0;
    font-family:Arial, Helvetica, sans-serif;
    box-sizing:border-box;
}

body{
    background:#f4f6f9;
}

.sidebar{
    width:250px;
    height:100vh;
    background-color:rgb(3,3,75);
    position:fixed;
    color:white;
    padding:20px;
}

.logo{
    width:70px;
    height:70px;
    background:orangered;
    border-radius:15px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:30px;
    font-weight:bold;
    margin-bottom:30px;
}

.menu a{
    display:block;
    text-decoration:none;
    color:#f4f6f9;
    padding:20px;
    margin-bottom:10px;
    background-color:rgb(255,255,255,0.1);
    border-radius:15px;
}

.menu a:hover{
    background-color:orangered;
}

.main{
    margin-left:250px;
    padding:20px;
}

.welcome{
    margin-left:15px;
    margin-top:15px;
    padding:15px;
    border-radius:20px;
    background-color:white;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

.cards{
    display:flex;
    gap:20px;
    margin-top:25px;
    margin-left:15px;
}

.card{
    flex:1;
    background:white;
    padding:25px;
    text-align:center;
    border-radius:20px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

.card h1{
    color:orangered;
    font-size:40px;
    margin-bottom:10px;
}

.section{
    margin:30px 15px;
}

.section h2{
    margin-bottom:15px;
}

.grid{
    display:flex;
    gap:20px;
}

.box{
    flex:1;
    background:white;
    padding:20px;
    border-radius:20px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

.box ul{
    padding-left:20px;
}

.box li{
    margin-bottom:10px;
}

.quick-actions{
    display:flex;
    flex-wrap:wrap;
    gap:15px;
}

.quick-btn{
    display:inline-block;
    background:orangered;
    color:white;
    text-decoration:none;
    padding:12px 18px;
    border-radius:12px;
}

.quick-btn:hover{
    opacity:0.9;
}

@media(max-width:900px)
{
    .cards,
    .grid{
        flex-direction:column;
    }

    .sidebar{
        position:relative;
        width:100%;
        height:auto;
    }

    .main{
        margin-left:0;
    }
}

</style>

</head>
<body>

    <div class="sidebar">

        <div class="logo">
            AI
        </div>

        <div class="menu">

            <a href="dashboard.php">
                Dashboard
            </a>

            <a href="ai-chat.html">
                AI Chats
            </a>

            <a href="notes.php">
                Notes
            </a>

            <a href="quiz.php">
                Quiz
            </a>

            <a href="flashcards.php">
                Flashcard Battle
            </a>

            <a href="logout.php">
                Logout
            </a>

        </div>

    </div>

    <div class="main">

        <div class="welcome">

            <h1>
                Welcome to AI Study Assistant
            </h1>

            <p>
                Manage your notes, quizzes and learning progress.
            </p>

        </div>

        <!-- Statistics Cards -->

        <div class="cards">

            <div class="card">

                <h1>
                    <?php echo $notes['total']; ?>
                </h1>

                <p>
                    Saved Notes
                </p>

            </div>

            <div class="card">

                <h1>
                    <?php echo $quizzes['total']; ?>
                </h1>

                <p>
                    Completed Quizzes
                </p>

            </div>

            <div class="card">

                <h1>
                    <?php echo $chat_total; ?>
                </h1>

                <p>
                    AI Chats Executed
                </p>

            </div>

            <div class="card">

                <h1>
                    <?php echo $flashcard_total; ?>
                </h1>

                <p>
                    Flashcard Battles
                </p>

            </div>

        </div>
                <!-- Recent Notes & Recent Quizzes -->

        <div class="section">

            <div class="grid">

                <!-- Recent Notes -->

                <div class="box">

                    <h2>
                        📚 Recent Notes
                    </h2>

                    <ul>

                        <?php
                        if(mysqli_num_rows($recent_notes) > 0)
                        {
                            while($note = mysqli_fetch_assoc($recent_notes))
                            {
                               echo "
<li>
    ".htmlspecialchars($note['title'])."

</li>
";
                            }
                        }
                        else
                        {
                            echo "
                            <li>
                                No notes available.
                            </li>
                            ";
                        }
                        ?>

                    </ul>

                </div>

                <!-- Recent Quizzes -->

                <div class="box">

                    <h2>
                        📝 Recent Quizzes
                    </h2>

                    <ul>

                        <?php
                        if(isset($recent_quizzes) &&
                           mysqli_num_rows($recent_quizzes) > 0)
                        {
                            while($quiz = mysqli_fetch_assoc($recent_quizzes))
                            {
                                echo "
                                <li>
                                    ".
                                    htmlspecialchars(
                                        $quiz['topic']
                                    )
                                    ." ("
                                    .$quiz['score']
                                    ."/"
                                    .$quiz['total']
                                    .")
                                </li>
                                ";
                            }
                        }
                        else
                        {
                            echo "
                            <li>
                                No quizzes attempted.
                            </li>
                            ";
                        }
                        ?>

                    </ul>

                </div>

            </div>

        </div>


        <!-- Quick Actions -->

        <div class="section">

            <h2>
                🚀 Quick Actions
            </h2>

            <div class="box">

                <div class="quick-actions">

                    <a href="ai-chat.html"
                       class="quick-btn">

                        Ask AI

                    </a>

                    <a href="notes.php"
                       class="quick-btn">

                        View Notes

                    </a>

                    <a href="quiz.php"
                       class="quick-btn">

                        Take Quiz

                    </a>

                    <a href="flashcards.php"
                       class="quick-btn">

                        Flashcard Battle

                    </a>

                </div>

            </div>

        </div>

    </div>

</body>

</html>