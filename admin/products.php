<?php 
require($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
?>

<?php if(checkedUsersStatus($_COOKIE['login']) == 1) : ?>
  <?= showList(getDataPagination(getProductList(), getCountPage(getProductList())), 'productList', 'page-products__list') ?>
  
<?php else : ?>
<h3>Недостаточно прав доступа к данной странице</h3>
<?php endif ?>

<?php 
require($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');
?>