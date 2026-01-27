<?php
    require_once "../inc/conn.php";

if (isset($_POST['submit'])) {
    
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password= trim(htmlspecialchars($_POST['password']));
    $phone = trim(htmlspecialchars($_POST['phone']));

    $errors = [];
    if (empty($name)) {
        $errors[] = 'name is required';
    } elseif (strlen($name) < 3 || strlen($name) > 255) {
        $errors[] = 'name must be in range 3 to 255';
    } elseif (is_numeric($name)) {
        $errors[] = 'name must be characters';
    }


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



    if (empty($phone)) {
        $errors[] = 'phone is required';
    } elseif (strlen($phone) < 5 || strlen($phone) > 255) {
        $errors[] = 'phone must be in range 5 to 255';
    } elseif (!is_numeric($phone)) {
        $errors[] = 'phone must be numeric';
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    if (empty($errors)) {
        $q = "insert into users (`name`, `email`, `password`, `phone`) values ('$name', '$email', '$password' , '$phone')";
        $res = mysqli_query($conn, $q);
        if ($res) {
            $_SESSION['success'] = 'Saved successfully';
            header("location:../Login.php");
        } else {
            $_SESSION['errors'] = ['errors while register'];
            header("location:../register.php");
        }
    } else {
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;

        $_SESSION['errors'] = $errors;
        header("location:../register.php");
    }
} else {
    header("location:../errors/404.php");
}
