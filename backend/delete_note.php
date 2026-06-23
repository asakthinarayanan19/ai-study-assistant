<?php
include "config.php";

if(isset($_GET['id']))
{
    $id = intval($_GET['id']);

    mysqli_query(
        $conn,
        "DELETE FROM notes
         WHERE id='$id'"
    );

    header("Location: ../notes.php");
    exit();
}
?>