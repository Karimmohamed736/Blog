<?php

require_once "../inc/conn.php";

session_start();
if (!isset($_SESSION['user_id'])) {  //if he click logout go to login
    header("location:../Login.php");
}
 
unset($_SESSION['user_id']);  //logout
header("location:../Login.php");
