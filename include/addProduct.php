<?php

$success = null;

/**
 * Функция проверки расширения файла
 * @param string $file проверяемый файл
 * @param array $includesFileTypes разрешенные типы файлов
 * @return bool true или false
 */
function checkedFileType($file, $includesFileTypes) {
    if ($file) {
        return in_array(mime_content_type($file), $includesFileTypes);
    }
}

if (!empty($_POST['addProduct'])) {
    $id = $_POST['id'] ?? '';
    $name = $_POST['product-name'];
    $price = $_POST['product-price'];
    $photo = isset($_POST['product-photo']) ? $_POST['product-photo'] : $_FILES['product-photo']['name'];
    $categories = isset($_POST['category']) ? $_POST['category'] : '';  
    $new = isset($_POST['new']) == 'on' ? '1' : '0';
    $sale = isset($_POST['sale']) == 'on' ? '1' : '0';  
    $uploadsFile = $_FILES['product-photo']['tmp_name'];
    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/img/products/';

    $success = $name != '' && $price != '' && $photo != '';

    if ($success) {
        if (isset($_POST['addProduct'])) {
            
            move_uploaded_file($uploadsFile, $uploadPath . $photo);

            mysqli_query(
                connect(),
                "INSERT INTO `products` (`name`, `price`, `image`, `new`, `sale`) 
                 VALUES ('$name', '$price', '$photo', '$new', '$sale')"
            );
        
            $productId = mysqli_insert_id(connect());

            if ($categories) {
                foreach ($categories as $category) {
                    $getIdCategories = mysqli_query(
                        connect(),
                        "SELECT * FROM `categories` WHERE `path` = '$category' "
                    );
                
                    $categoryId = mysqli_fetch_assoc($getIdCategories)['id'];

                    mysqli_query(
                        connect(),
                        "INSERT INTO `categories_products` (`id_category`, `id_product`) 
                         VALUES ('$categoryId', '$productId')"
                    );
                }
            }
        } 

        if (isset($_POST['editProduct'])) {

            mysqli_query(
                connect(),
                "UPDATE `products` SET `name` = '$name', `price` = '$price', `image` = '$photo', `new` = '$new', `sale` = '$sale' WHERE id = '$id'"
            );

            mysqli_query(
                connect(),
                "DELETE FROM `categories_products` WHERE `id_product` = '$id'"
            );

            if ($categories) {
                foreach ($categories as $category) {
                    $getIdCategories = mysqli_query(
                        connect(),
                        "SELECT * FROM `categories` WHERE `path` = '$category' "
                    );
                
                    $categoryId = mysqli_fetch_assoc($getIdCategories)['id'];

                    mysqli_query(
                        connect(),
                        "INSERT INTO `categories_products` (`id_category`, `id_product`) 
                         VALUES ('$categoryId', '$id')"
                    );
                }
            }

        }

        header("Location: /admin/products.php");
    } 
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = mysqli_query(
        connect(),
        "SELECT p.id, p.name, p.price,  p.image, p.new, p.sale, c.name AS category FROM products AS p
        LEFT JOIN categories_products AS cp ON p.id = cp.id_product
        LEFT JOIN categories AS c ON cp.id_category = c.id
        WHERE p.id = $id"
    );
    
    $product = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $categories = [];
    foreach ($product as $item) {
        foreach ($item as $key => $value) {
            if ($key === 'category') {
                $categories[] = $item[$key];
            }
        }
    }
    
    $product = $product[0];
    $product['category'] = $categories;
}


