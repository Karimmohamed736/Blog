<?php

  require_once "../inc/conn.php";

  if (isset($_POST['submit'])) {
  //catch  
  trim(htmlspecialchars( extract($_POST)));

  //validation
  $errors = [];
  if (empty($title)) {
    $errors[] ='title is required';
  }elseif (strlen($title) <3 && strlen($title)>255) {
    $errors[] ='title must be in range 3 to 255';
  }elseif (is_numeric($title)) {
    $errors[] = 'title must be characters';
  }


  if (empty($body)) {
    $errors[] = 'body is required';
  }elseif (strlen($body) <5 && strlen($body)>255) {
    $errors[] ='body must be in range 5 to 255';
  }elseif (is_numeric($body)) {
    $errors[] = 'body must be characters';
  }

  //upload image
  $ex = ['png', 'jpg', 'jpeg'];
  $image = $_FILES['image'];
  $image_name = $image['name'];
  $tmp= $image['tmp_name'];
  $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

  $newName = uniqid(). ".$ext";

  $imageE = $image['error'];
  if (!in_array($ext, $ex)) {
    echo $errors[]='invalid extension';
  }elseif ($imageE !=0) {
    echo $errors[]="error in image";
  }  

  //insert
  if (empty($errors)) {
    $q = "insert into posts (`title`, `body`, `image`, `user_id`) values ('$title', '$body', '$newName' ,1) ";
    $res = mysqli_query($conn , $q);
    if ($res) {
    move_uploaded_file($tmp, "../uploads/$newName");
    $_SESSION['sucess']= "post saved sucessfully";
    header("location:../index.php");

    }else {
      $_SESSION['errors']= ['error while insert'];
      header("location:../addPost.php"); 
      }
  }else {
    $_SESSION ['title'] = $title;
    $_SESSION ['body'] = $body;
    $_SESSION ['errors'] = $errors;
    header("location:../addPost.php");

  }
    
    }else {
      header("location../errors/404.php");
    }