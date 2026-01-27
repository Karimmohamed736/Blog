<?php

require_once "../inc/conn.php";

if (isset($_POST['submit']) && isset($_GET['id'])) {
    $id  = $_GET['id'];

    $q = "select * from posts where id = '$id'";
    $res = mysqli_query($conn, $q);
    if (mysqli_num_rows($res) == 1) {
        //remove old image
        $post = mysqli_fetch_assoc($res);
        $old_image = $post['image'];

        $query = "delete from posts where id = '$id'";
        $res = mysqli_query($conn, $query);
        if ($res) {
            //remove image
            if (!empty($old_image)) {  //if there is image
                unlink("../uploads/$old_image");
            }
            $_SESSION['sucess'] = "deleted sucessfully";
            header("location:../index.php");
        } else {
            $_SESSION['errors'] = ["error while deleting"];
            header("location:../index.php");
        }
    } else {
        $_SESSION['errors'] = "error";
        header("location:../index.php");
    }
} else {
    header("../errors/404.php");
}
