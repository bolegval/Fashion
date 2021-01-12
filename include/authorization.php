<?php
session_start();
$isAuth = null;

if (isset($_POST['logIn'])) {

    if (isset($_COOKIE['login'])) {
        $login = $_COOKIE['login'];
    } else {
        $login = htmlspecialchars($_POST['login']);
    }

    $result = mysqli_fetch_assoc(mysqli_query(
        connect(), 
        "SELECT `id`, `login`, `password` FROM `users` WHERE `login` = '$login'"
    ));
 
    $isAuth = password_verify($_POST['password'], $result['password']);

    if ($isAuth) {
        $_SESSION['isAuth'] = 'yes';
        setcookie('login', $login, time() + 30 * 24 * 3600, '/');
    }
}

if (isset($_GET['login']) && $_GET['login'] == 'no') {

    unset($_SESSION['isAuth']);
    setcookie('login', '', time() - 3600);
    header("Location: /");
}