<?php
include "config.php";

if(isset($_POST['score']) && isset($_POST['total']))
{
    $score = (int)$_POST['score'];
    $total = (int)$_POST['total'];

    mysqli_query(
        $conn,
        "INSERT INTO flashcard_scores(score, total)
         VALUES('$score','$total')"
    );

    echo "success";
}
?>