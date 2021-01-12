<?php
require($_SERVER['DOCUMENT_ROOT'] . '/include/connection.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $result = mysqli_query(
        connect(),
        "SELECT * FROM `orders` WHERE `id` = '$id'"
    );

    $order = $array = mysqli_fetch_assoc($result);

    $status = $order['active'] == 0 ? '1' : '0';

    mysqli_query(
        connect(),
        "UPDATE `orders` SET `active` = '$status', `date` = CURRENT_TIMESTAMP WHERE `id` = '$id'"
    );

    mysqli_close(connect());
}

if (isset($_POST['idProduct'])) {
    $id = $_POST['idProduct'];

    mysqli_query(
        connect(),
        "UPDATE `products` SET `active` = '0' WHERE `id` = '$id'"
    );
}
