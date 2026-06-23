<?php
include "backend/config.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz History</title>

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background:#f4f6f9;
            padding:30px;
            margin:0;
        }

        .back{
            display:inline-block;
            text-decoration:none;
            background:orangered;
            color:white;
            padding:12px 20px;
            border-radius:12px;
            margin-bottom:20px;
        }

        h1{
            margin-bottom:25px;
        }

        .attempt{
            background:white;
            padding:25px;
            border-radius:20px;
            margin-bottom:25px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        .attempt h2{
            color:orangered;
            margin-bottom:15px;
        }

        details{
            margin-top:20px;
        }

        summary{
            cursor:pointer;
            font-size:20px;
            font-weight:bold;
        }

        .detail{
            background:#f8f9fa;
            padding:15px;
            border-radius:15px;
            margin-top:15px;
        }

        .detail h3{
            margin-top:0;
        }

        .delete-btn{
            display:inline-block;
            margin-top:15px;
            background:red;
            color:white;
            text-decoration:none;
            padding:10px 15px;
            border-radius:10px;
        }

        .delete-btn:hover{
            background:darkred;
        }

        .empty{
            background:white;
            padding:25px;
            border-radius:20px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body>

<a href="dashboard.php" class="back">
    ← Back to Dashboard
</a>

<h1>Quiz History</h1>
<a href="backend/clear_quizzes.php"
   onclick="return confirm('Are you sure you want to delete ALL quiz history?')"
   style="
       display:inline-block;
       background:darkred;
       color:white;
       text-decoration:none;
       padding:12px 20px;
       border-radius:12px;
       margin-bottom:20px;
       margin-left:10px;
   ">
   🗑 Clear All Quizzes
</a>

<?php

$quizzes = mysqli_query(
    $conn,
    "SELECT * FROM quizzes ORDER BY id DESC"
);

if(mysqli_num_rows($quizzes) == 0)
{
    echo "
    <div class='empty'>
        <h2>No Quiz Attempts Found</h2>
        <p>Attend a quiz from the AI Chat tab to see your history here.</p>
    </div>
    ";
}
else
{
    while($quiz = mysqli_fetch_assoc($quizzes))
    {
        $topic = $quiz['topic'];

        if(empty($topic))
        {
            $topic = "Quiz";
        }

        echo "
        <div class='attempt'>

            <h2>📚 ".$topic."</h2>

            <p>
                <b>Score:</b>
                ".$quiz['score']."/".$quiz['total']."
            </p>

            <p>
                <b>Date:</b>
                ".$quiz['created_at']."
            </p>

            <a class='delete-btn'
               href='backend/delete_quiz.php?id=".$quiz['id']."'
               onclick=\"return confirm('Delete this quiz attempt?')\">
               🗑 Delete Attempt
            </a>

            <details>
                <summary>View Details</summary>
        ";

        $details = mysqli_query(
            $conn,
            "SELECT * FROM quiz_details
             WHERE quiz_id='".$quiz['id']."'"
        );

        $qno = 1;

        while($row = mysqli_fetch_assoc($details))
        {
            $status =
                ($row['user_answer'] == $row['correct_answer'])
                ? "Correct"
                : "Wrong";

            echo "
            <div class='detail'>

                <h3>Question ".$qno." ".$status."</h3>

                <p>
                    <b>Question:</b><br>
                    ".$row['question']."
                </p>

                <p>
                    <b>Your Answer:</b>
                    ".$row['user_answer']."
                </p>

                <p>
                    <b>Correct Answer:</b>
                    ".$row['correct_answer']."
                </p>

                <p>
                    <b>Explanation:</b><br>
                    ".$row['explanation']."
                </p>

            </div>
            ";

            $qno++;
        }

        echo "
            </details>

        </div>
        ";
    }
}

?>

</body>
</html>