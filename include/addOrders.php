<?php
//require($_SERVER['DOCUMENT_ROOT'] . '/include/connection.php');

if (isset($_POST['sendOrder'])) {
    $send = false;
    $surname = $_POST['surname'];
    $name = $_POST['name'];
    $thirdName = $_POST['thirdName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $delivery = $_POST['delivery'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $home = $_POST['home'];
    $aprt = $_POST['aprt'];
    $pay = $_POST['pay'];
    $comment = $_POST['comment'];
    
    $customer = $surname  . ' ' . $name . ' ' . $thirdName;
    $address = $city . ', ' . $street . ', ' . $home . ', ' . $aprt;
    $orderSum = 0;

    if ($surname != '' && $name != '' && $phone != '' && $email != '') {
        

        if ($delivery == 'dev-no') {
            mysqli_query(
                connect(),
                "INSERT INTO `orders` (`customer`, `phone`, `email`, `delivery`, `pay`, `comment`, `sum`)
                 VALUES ('$customer', '$phone', '$email', '$delivery', '$pay', '$comment', '$orderSum')"
            );
        } elseif ($city != '' && $street != '' && $home != '' && $aprt != '') {
            $result = mysqli_query(
                connect(),
                "SELECT * FROM `orders_settings`"
            );
            $settings = mysqli_fetch_assoc($result);

            if ($orderSum < $settings['min_sum']) {
                $orderSum += $settings['delivery'];
            }

            mysqli_query(
                connect(),
                "INSERT INTO `orders` (`customer`, `phone`, `email`, `delivery`, `pay`, `address`, `comment`, `sum`)
                 VALUES ('$customer', '$phone', '$email', '$delivery', '$pay', '$address', '$comment', '$orderSum')"
            );
        } 
    }
}

