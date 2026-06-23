<?php

session_start();

include "config.php";

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0)
    {
        $user = mysqli_fetch_assoc($result);

        if($password == $user['password'])
        {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];

            header("Location: ../dashboard.php");
            exit();
        }
        else
        {
            echo "<script>
                    alert('Invalid Password');
                    window.location='../login.html';
                  </script>";
        }
    }
    else
    {
        echo "<script>
                alert('User Not Found');
                window.location='../login.html';
              </script>";
    }
}

?>