<?php

include "config.php";

/* Delete all quiz details first */
mysqli_query(
    $conn,
    "DELETE FROM quiz_details"
);

/* Delete all quizzes */
mysqli_query(
    $conn,
    "DELETE FROM quizzes"
);

/* Reset auto increment  */
mysqli_query(
    $conn,
    "ALTER TABLE quiz_details AUTO_INCREMENT = 1"
);

mysqli_query(
    $conn,
    "ALTER TABLE quizzes AUTO_INCREMENT = 1"
);

/* Redirect back */
header("Location: ../quiz.php");
exit();

?>