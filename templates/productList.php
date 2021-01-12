<main class="page-products">
  <h1 class="h h--1">Товары</h1>
  <a class="page-products__button button" href="/admin/add.php">Добавить товар</a>
  <div class="page-products__header">
    <span class="page-products__header-field">Название товара</span>
    <span class="page-products__header-field">ID</span>
    <span class="page-products__header-field">Цена</span>
    <span class="page-products__header-field">Категория</span>
    <span class="page-products__header-field">Новинка</span>
  </div>
  <ul class="<?= $class ?>">
  <?php foreach ($array as $item) : ?>
    <?php if ($item['active']) : ?>
    <li class="product-item page-products__item">
      <b class="product-item__name"><?= $item['name'] ?></b>
      <span class="product-item__field product-item__field--id"><?= $item['id'] ?></span>
      <span class="product-item__field"><?= number_format($item['price'], 0, ',', ' ') ?> руб.</span>
      <span class="product-item__field"><?= $item['category'] ?></span>
      <span class="product-item__field"><?= $item['new'] ? 'Да' : '' ?></span>
      <a href="/admin/edit.php?id=<?= $item['id'] ?>" class="product-item__edit" aria-label="Редактировать"></a>
      <button class="product-item__delete" name="delete"></button>
    </li>
    <?php endif ?>
    <?php endforeach ?>
  </ul>
  <?= showPagination(getCountPage(getProductList()), '/admin/products.php') ?>
</main>