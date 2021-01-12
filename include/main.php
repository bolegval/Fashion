<?php
require($_SERVER['DOCUMENT_ROOT'] . '/include/connection.php');
require($_SERVER['DOCUMENT_ROOT'] . '/include/authorization.php');
require($_SERVER['DOCUMENT_ROOT'] . '/include/addProduct.php');
require($_SERVER['DOCUMENT_ROOT'] . '/include/addOrders.php');

/**
 * Функция запроса в БД, для вывода списков
 * @param string $table имя таблицы в БД
 * @return array массив в соотвествии данных в БД
 */
function getData($table, $active = 1) {
    if ($active == 1) {
        $result = mysqli_query(
        connect(),
        "SELECT * FROM $table WHERE active = 1"
        );
    } else {
        $result = mysqli_query(
            connect(),
            "SELECT * FROM $table"
        );
    }
    
    $array = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $array;

    mysqli_close(connect());
}

/**
 * Функция выборки пунктов меню в зависимости от раздела
 * @param string $section раздел меню
 * @return array массив пунктов меню, в зависимости от выбранного раздела
 */

function getMenu($section) {
    $result = mysqli_query(
        connect(),
        "SELECT m.name AS menu, m.path, s.name AS section FROM fashion.menu AS m
        LEFT JOIN menu_sections AS ms ON m.id = ms.id_menu
        LEFT JOIN sections AS s ON ms.id_section = s.id
        WHERE s.name = '$section'"
    );

    $array = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $array;
}

/**
 * Функция проверки url
 * @param string $url проверяемый адрес url
 * @param $component извлекаемая часть URI 
 * @return bool true или false
 */
function isCurrentUrl($url, $component = PHP_URL_PATH){
   return parse_url($_SERVER['REQUEST_URI'], $component) == $url;
}

/**
 * Функция определения активного пункта меню
 * @param array $array массив пунктов с ключом ['path']
 * @return string 'active'
 */
function activeMenu($array) {
   if (isCurrentUrl($array['path'])) {
      return 'active';
   }
}

/**
 * Функция определения активной категории
 * @param array $array массив категорий с ключом ['path']
 * @return string 'active'
 */
function activeCategory($array) {
   if (isCurrentUrl('category=' . $array['path'], PHP_URL_QUERY)) {
      return 'active';
   }
}

/**
 * Функция определения миннимальной и максимальной цены
 * @param string $price параметр выбора цены (минимальная или максимальная)
 * @param string $table таблица из БД для выборки цены
*/
function getPrice($price = 'MIN', $table = 'products') {
    $result = mysqli_query(
        connect(),
        "SELECT $price(price) FROM $table WHERE active = 1"
    );

    $price =  mysqli_fetch_row($result);

    return $price[0];
}

/**
 * Функция форматирования строки
 * @param int $count склоняемое число
 * @param array $array массив склоняемых слов
 * @return string слово в нужном склонении
*/
function formatStringCount($count, $array = ['модель', 'модели', 'моделей']) {
    if ($count % 10 == 1) {
        return $array[0];
    } elseif (($count % 10 < 2 && $count % 10 > 4) || ($count % 100 >= 5 && $count % 100 <= 20)) {
        return $array[2];
    } else {
        return $array[1];
    }
}

/**
 * Функция вывода меню
 * @param array $array исходный массив для вывода
 * @param string $templates имя исполняемого файла
 * @param string $class класс для стилей
 * @return void список меню в соотвествии с данными в массиве
 */
function showList($array, $templates, $class) {
    include($_SERVER['DOCUMENT_ROOT'] . '/templates/' . $templates . '.php');
}

/**
 * Функция сортировки по категориям
 * @param string $filter GET параметр по которому происходит сортировка
 * @return array массив в соотвествии соотвествии с запросом
 */
function getCategories($filter) {
    $result = mysqli_query(
        connect(),
        "SELECT c.name AS category, c.path, p.* FROM categories AS c
        LEFT JOIN categories_products AS cp ON c.id = cp.id_category
        LEFT JOIN products AS p ON p.id = cp.id_product
        WHERE c.path = '$filter' && p.active = 1"
    );

    $array = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $array;
}

/**
 * Функция фильтрации каталога по признаку (new, sale)
 * @param array $array фильтруемый массив
 * @param string $filter ключ фильтрации
 * @return array массив в соотвествии соотвествии с результатами фильтрации
 */
function filteredProduct($array, $filter) {
    $result = [];

    for ($i = 0; $i < count($array); $i++) { 

        if ($array[$i][$filter] == true) {
            $result[] = $array[$i];
        };
    }

    return $result;
}

/**
 * Функция сортировки массива по дате и активности
 * @param array $array входной массив для сортировки
 * @return array отсортированный массив
 */
function sortDate($array) {

    $dateArray  = array_column($array, 'date');
    $activeItem = array_column($array, 'active');

    array_multisort($activeItem, SORT_DESC, $dateArray, SORT_ASC, $array);

    return $array;
}

/**
 * Функция проверки статуса пользователя
 * @param string $login логин пользователя
 * @return string статус пользователя
 */
function checkedUsersStatus($login) {
    $login = $_COOKIE['login'];
    
    $result = mysqli_query(
        connect(),
        "SELECT u.login, g.status FROM fashion.users AS u
        LEFT JOIN groups_users as gu ON u.id = gu.id_user
        LEFT JOIN fashion.groups AS g ON gu.id_group = g.id
        WHERE u.login = '$login'"
    );
    
    $array = mysqli_fetch_all($result, MYSQLI_ASSOC);

    for ($i = 0; $i < count($array); $i++) { 
        if ($array[$i]['login'] == $login) {
            return $array[$i]['status'];
        }
    }
}

/**
 * Функция запроса в БД товаров по категориям
 * @return array масиив товаров с категориями для вывода
 */
function getProductList() {
    $result = mysqli_query(
        connect(),
        "SELECT p.id, p.name, p.price, p.new, p.active, c.name AS category FROM products AS p
        LEFT JOIN categories_products AS cp ON p.id = cp.id_product
        LEFT JOIN categories AS c ON cp.id_category = c.id
        WHERE p.active = 1"
    );
    
    $array = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $array;
}

/**
 *  Функция пагинации
 * @param array $array входжной массив данных из БД для показа
 * @param int $total количество страниц
 * @param int $num количество элементов на странице
 * @return array массив для вывода списка элементов
 */
function getDataPagination($array, $total, $num = 6) {
    $page = null;

    if(empty($_GET['page']) or $page < 0) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    if($page > $total) {
        $page = $total;
    }    

    $start = $page * $num - $num;

    return array_slice($array, $start, $num);
}

/**
 * Функция определния количества страниц
 * @param array $array массив данных из БД
 * @param int @num количество элементов на странице
 * @param int количество страниц
 */
function getCountPage($array, $num = 6) {
    return intval((count($array) - 1) / $num + 1);
}

/**
 * Функция показа элементов пагинации
 * @param int $total общее количество страниц
 * @param string $href ссылка на страницу
 * @return void список страниц
 */
function showPagination($total) {
    include($_SERVER['DOCUMENT_ROOT'] . '/templates/pagination.php');  
}

/**
 * Функция сортировки массива по ключу
 * @param array $array сортируемый массив
 * @param string $key ключ, по которому сортируется массив
 * @param string $sort направление сортировки
 * @return array отсортированный массив
 */
function arraySort(array $array, $key = "name", $sort = SORT_ASC): array
{
   foreach ($array as $index => $item) {
      $menuItem[$index] = $item[$key];
   }
   
   array_multisort($menuItem, $sort, $array);
   return $array;  
}

$products = getData('products');

$products = !isset($_GET['category']) || $_GET['category'] == "" ? getData('products') : getCategories($_GET['category']);

if (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == "/new/") {
    $products = filteredProduct($products, "new");
}

if (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == "/sale/") {
    $products = filteredProduct($products, "sale");
}

/**
 * Функция добавления GET параметров
 * @param string $param передаваемый GET параметр
 * @param string $value значение предаваемого GET параметра
*/
function addGet ($param, $value) {
    $add = $param . '=' . $value;
    $url = "$_SERVER[REQUEST_URI]";

    if (isset($_SERVER["QUERY_STRING"]) && strpos($_SERVER["QUERY_STRING"], $param) !== false) {

        $r = strstr("$_SERVER[REQUEST_URI]", $param, true);
        $url = $r . $add;
    } else {
        $url .= (strpos($url, '?') === false ? '?' : '&') . $add;
    }

    return $url;
}

/**
 * Функция выборки информации о доставке
 * @param string $value выбираемое значение
 * @return string $array[$value] необходимое значение
*/
function getDeliveryInfo($value = "delivery") {
    $result = mysqli_query(
        connect(),
        "SELECT * FROM orders_settings"
    );

    $array = mysqli_fetch_assoc($result);

    return $array[$value];

    mysqli_close(connect());
}
