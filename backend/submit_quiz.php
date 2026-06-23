<?php

include "config.php";

$score = 0;
$total = 10;

$result = "";

/* Create quiz attempt */
$topic = mysqli_real_escape_string(
    $conn,
    $_POST['topic'] ?? "Quiz"
);

mysqli_query(
    $conn,
    "INSERT INTO quizzes(topic,score,total)
     VALUES('$topic',0,$total)"
);

$quiz_id = mysqli_insert_id($conn);

/* Check all 10 questions */
for($i = 1; $i <= 10; $i++)
{
    /* Question */
    $question = mysqli_real_escape_string(
        $conn,
        $_POST["question$i"] ?? ""
    );

    /* User answer */
    $user_answer = $_POST["q$i"] ?? "Not Answered";

    /* Correct answer */
    $correct_answer = $_POST["correct$i"] ?? "";

    /* Explanation */
    $explanation = mysqli_real_escape_string(
        $conn,
        $_POST["explanation$i"] ?? ""
    );

    /* Score */
    if($user_answer == $correct_answer)
    {
        $score++;
        $status = "✅ Correct";
    }
    else
    {
        $status = "❌ Wrong";
    }

    /* Display result */
    $result .= "
    <div style='
        background:white;
        padding:15px;
        margin-top:15px;
        border-radius:15px;
        box-shadow:0 0 10px rgba(0,0,0,0.1);
    '>

        <h3>Question $i $status</h3>

        <p>
            <b>Question:</b><br>
            $question
        </p>

        <p>
            <b>Your Answer:</b>
            $user_answer
        </p>

        <p>
            <b>Correct Answer:</b>
            $correct_answer
        </p>

        <p>
            <b>Explanation:</b><br>
            $explanation
        </p>

    </div>
    ";

    /* Save quiz details */
    mysqli_query(
        $conn,
        "INSERT INTO quiz_details
        (
            quiz_id,
            question,
            user_answer,
            correct_answer,
            explanation
        )
        VALUES
        (
            '$quiz_id',
            '$question',
            '$user_answer',
            '$correct_answer',
            '$explanation'
        )"
    );
}

/* Update final score */
mysqli_query(
    $conn,
    "UPDATE quizzes
     SET score='$score'
     WHERE id='$quiz_id'"
);

/* Output */
echo "
<div style='
    background:#e8fff0;
    padding:20px;
    border-radius:20px;
    margin-top:20px;
    text-align:center;
'>
    <h2>🎉 Quiz Submitted Successfully!</h2>

    <h3>Your Score: $score/$total</h3>

    <p>
        View detailed results in the Quiz tab.
    </p>
</div>

".$result;
?>