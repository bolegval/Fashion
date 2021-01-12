<?php
require($_SERVER['DOCUMENT_ROOT'] . '/include/main.php');

if (isset($_GET['new'])) {
   $products = array_filter($products, function($k) { return $k['new'] == 1; });
} 

if (isset($_GET['sale'])) {
   $products = array_filter($products, function($k) { return $k['sale'] == 1; });
} 

if (isset($_GET['minPrice'])) {
    $products = array_filter($products, function($k) { return $k['price'] > $_GET["minPrice"] && $k['price'] < $_GET["maxPrice"]; });
} 

if ($_GET['sortBy'] !== "" || $_GET['sortOrder'] !== "") {
    $sortBy = $_GET['sortBy'] == "price" ? "price" : "name";
    $sortOrder = $_GET['sortOrder'] ==  "desc" ? SORT_DESC : SORT_ASC;
    
    $products = arraySort($products, $sortBy, $sortOrder);
}

showList($products, 'product', 'shop__item product');


