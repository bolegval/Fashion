<?php 
require($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');

if (isset($_SESSION['isAuth'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/templates/main.php');
} else {
    include($_SERVER['DOCUMENT_ROOT'] . '/admin/authorization.php');
}
 
require($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');
