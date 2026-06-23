<?php
include "config.php";

if(isset($_POST['question']) && isset($_POST['answer']))
{
    $title = mysqli_real_escape_string(
        $conn,
        $_POST['question']
    );

    $content = mysqli_real_escape_string(
        $conn,
        $_POST['answer']
    );

    $sql = "INSERT INTO notes(title, content)
            VALUES('$title', '$content')";

    if(mysqli_query($conn, $sql))
    {
        echo "Note saved successfully!";
    }
    else
    {
        echo "Database Error: " . mysqli_error($conn);
    }
}
else
{
    echo "Missing data.";
}
?>