<?php

require_once "../inc/conn.php";

if (isset($_POST['submit'])) {
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));

    $errors = [];
    if (empty($email)) {
        $errors[] = 'email is required';
    } elseif (strlen($email) < 5 || strlen($email) > 255) {
        $errors[] = 'email must be in range 5 to 255';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'email not correct';
    }

    if (empty($password)) {
        $errors[] = 'password is required';
    } elseif (strlen($password) < 8) {
        $errors[] = 'password must be in greater than 8';
    }

    if (empty($errors)) {
        $q = "Select * from users where email = '$email'";
        $res = mysqli_query($conn, $q);
        if (mysqli_num_rows($res) == 1) {
            $user = mysqli_fetch_assoc($res);
            $oldpass = $user['password']; //catch pass to check 
            $verifypass = password_verify($password, $oldpass); //functon to check on hash password
            if ($verifypass) {
                $_SESSION['user_id'] = $user['id']; //when add post in addPost.php
                $_SESSION['success'] = 'login successfully';
                header("location:../index.php");
            } else {
                $_SESSION['errors'] = ['email or password not correct'];
                header("location:../Login.php");
            }
        } else {
            $_SESSION['errors'] = ['email or password not correct'];
            header("location:../Login.php");
        }
    } else {
        $_SESSION['errors'] = $password;
        $_SESSION['errors'] = $email;
        $_SESSION['errors'] = $errors;
        header("location:../login.php");
    }
} else {
    header("location:../errors/404.php");
}
