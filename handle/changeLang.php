<?php

session_start();

if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];

    if ($lang == "en") {
        $_SESSION['lang'] = "en";
    } else {
        $_SESSION['lang'] = "ar";
    }
} else {
    $_SESSION['lang'] = "en";
}

header("location:".$_SERVER['HTTP_REFERER']);  //refer to page itself
