<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "config.php";

if(isset($_POST['register']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check = mysqli_query($conn,
        "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0)
    {
        echo "<script>alert('Email Already Exists');</script>";
    }
    else
    {
        $sql = "INSERT INTO users(name,email,password)
                VALUES('$name','$email','$password')";

        if(mysqli_query($conn,$sql))
        {
            echo "<script>
                    alert('Registration Successful');
                    window.location='../login.html';
                  </script>";
        }
        else
        {
            echo mysqli_error($conn);
        }
    }
}

?>