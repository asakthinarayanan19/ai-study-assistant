<?php
include "config.php";

if(isset($_POST['save']))
{
    $title = mysqli_real_escape_string(
        $conn,
        $_POST['title']
    );

    $content = mysqli_real_escape_string(
        $conn,
        $_POST['content']
    );

    $sql = "INSERT INTO notes(title, content)
            VALUES('$title', '$content')";

    if(mysqli_query($conn, $sql))
    {
        header("Location: ../notes.php");
        exit();
    }
    else
    {
        echo "Error: " . mysqli_error($conn);
    }
}
?>