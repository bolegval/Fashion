<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
function connect() {
    $host = HOST;
    $user = USER;
    $password = PASWORD;
    $dbname = DBNAME;
    static $connection = null;

    if ($connection === null) {
        $connection = mysqli_connect($host, $user, $password, $dbname) or die('Ошибка соединения');
    }

    return $connection;
}
