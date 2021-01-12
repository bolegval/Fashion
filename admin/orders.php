<?php 
require($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
?>

<main class="page-order">
  <h1 class="h h--1">Список заказов</h1>
  <?= showList(sortDate(getData('orders', '')), 'orders', 'page-order__list') ?>
</main>

<?php 
require($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');
?>
