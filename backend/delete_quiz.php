<?php
include "config.php";

if(isset($_GET['id']))
{
    $id = intval($_GET['id']);

    mysqli_query($conn,
        "DELETE FROM quiz_details
         WHERE quiz_id='$id'");

    mysqli_query($conn,
        "DELETE FROM quizzes
         WHERE id='$id'");

    header("Location: ../quiz.php");
    exit();
}
?>