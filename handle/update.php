<?php
require_once "../inc/conn.php";

if (isset($_POST['submit']) && isset($_GET['id'])) {
    //catch  
    $id = $_GET['id'];
    trim(htmlspecialchars(extract($_POST)));

    //select one
    $query = "select * from posts where id = '$id'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $post = mysqli_fetch_assoc($result);
        $old_image = $post['image'];  //catch the old image
    }

    //validation
    $errors = [];
    if (empty($title)) {
        $errors[] = 'title is required';
    } elseif (strlen($title) < 3 && strlen($title) > 255) {
        $errors[] = 'title must be in range 3 to 255';
    } elseif (is_numeric($title)) {
        $errors[] = 'title must be characters';
    }


    if (empty($body)) {
        $errors[] = 'body is required';
    } elseif (strlen($body) < 5 && strlen($title) > 255) {
        $errors[] = 'body must be in range 5 to 255';
    } elseif (is_numeric($body)) {
        $errors[] = 'body must be characters';
    }

    //upload image
    if (!empty($_FILES['image']['name'])) {  //if we add image in edit page
        $ex = ['png', 'jpg', 'jpeg'];
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $tmp = $image['tmp_name'];
        $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        $newName = uniqid() . ".$ext";

        $imageE = $image['error'];
        if (!in_array($ext, $ex)) {
            echo $errors[] = 'invalid extension';
        } elseif ($imageE != 0) {
            echo $errors[] = "error in image";
        }
    } else {  //if we don`t add image or keep the choose file empty, put the old image 
        $newName = $old_image;
        //now when we click submit after update without change the photo he still has the old image

    }


    //insert
    if (empty($errors)) {
        $q = "update posts set title = '$title', body = '$body', image = '$newName' where id = '$id'  ";
        $res = mysqli_query($conn, $q);

        if ($res) {
            if (!empty($_FILES['image']['name'])) {

                //if we add new image then remove the old one    
                unlink("../uploads/$old_image"); //remove
                move_uploaded_file($tmp, "../uploads/$newName"); //move new image
            }
            $_SESSION['sucess'] = "post updated sucessfully";
            header("location:../viewPost.php?id=$id");
        } else {
            $_SESSION['errors'] = ['error while update'];
            header("location:../editPost.php?id=$id");
        }
    } else {
        $_SESSION['title'] = $title;
        $_SESSION['body'] = $body;
        $_SESSION['errors'] = $errors;
        header("location:../editPost.php?id=$id");
    }
} else {
    header("location../errors/404.php");
}
