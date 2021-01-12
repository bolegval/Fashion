<?php 
require($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
?>
<?php if(checkedUsersStatus($_COOKIE['login']) == 1) : ?>
  <main class="page-add">
  <h1 class="h h--1">Редактирование товара</h1>
  <form class="custom-form" action="/include/addProduct.php" method="post" enctype="multipart/form-data">
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
      <input type="hidden" name="id" value="<?= $product['id'] ?>">
      <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
        <input type="text" class="custom-form__input" name="product-name" id="product-name" value="<?= $product['name'] ?>">
      </label>
      <label for="product-price" class="custom-form__input-wrapper">
        <input type="text" class="custom-form__input" name="product-price" id="product-price" value="<?= $product['price'] ?>">
      </label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
      <ul class="add-list">
        <li class="add-list__item add-list__item--add" <?= !empty($product['image']) ? "hidden" : "" ?>>
          <input type="file" name="product-photo" id="product-photo" hidden="" accept="image/jpeg, image/png, image/png" value="<?= $product['image'] ?>">
          <label for="product-photo">Изменить фотографию</label>
        </li>
        <?php if (!empty($product['image'])) : ?>
        <li class="add-list__item add-list__item--active">
        <input type="text" name="product-photo" hidden="" accept="image/jpeg, image/png, image/png" value="<?= $product['image'] ?>">
            <img src="/img/products/<?= $product['image'] ?>">
        </li>
        <?php endif ?>
      </ul>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Раздел</legend>
      <div class="page-add__select">
        <select name="category[]" class="custom-form__select" multiple="multiple">
          <option hidden="">Название раздела</option>
          <option value="female" <?= in_array("Женщины", $product['category']) ? "selected" : "" ?>>Женщины</option>
          <option value="male" <?= in_array("Мужчины", $product['category']) ? "selected" : "" ?>>Мужчины</option>
          <option value="children" <?= in_array("Дети", $product['category']) ? "selected" : "" ?>>Дети</option>
          <option value="access" <?= in_array("Аксессуары", $product['category']) ? "selected" : "" ?>>Аксессуары</option>
        </select>
      </div>
      <input type="checkbox" name="new" id="new" class="custom-form__checkbox" <?= $product['new'] == 1 ? "checked" : "" ?>>
      <label for="new" class="custom-form__checkbox-label">Новинка</label>
      <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?= $product['sale'] == 1 ? "checked" : "" ?>>
      <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
    </fieldset>
    <button class="button" type="submit" name="editProduct">Изменить товар</button>
  </form>
  <section class="shop-page__popup-end page-add__popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно изменен</h2>
    </div>
  </section>
</main>
<?php else : ?>
<h3>Недостаточно прав доступа к данной странице</h3>
<?php endif ?>

<?php 
require($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');
?>
