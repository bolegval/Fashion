<?php 
require($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
?>
<?php if(checkedUsersStatus($_COOKIE['login']) == 1) : ?>
  <main class="page-add">
  <h1 class="h h--1">Добавление товара</h1>
  <form class="custom-form" action="" method="post" enctype="multipart/form-data">
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
      <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
        <input type="text" class="custom-form__input" name="product-name" id="product-name">
        <p class="custom-form__input-label" style="<?= isset($name) && $name == "" ? "color: red" : "" ?>">
          <?php if (isset($name) && $name == "") : ?>
          <?php include($_SERVER['DOCUMENT_ROOT'] . '/templates/emptyInput.php')?>
          <?php else : ?>
          Название товара
          <?php endif ?> 
        </p>
      </label>
      <label for="product-price" class="custom-form__input-wrapper">
        <input type="text" class="custom-form__input" name="product-price" id="product-price">
        <p class="custom-form__input-label" style="<?= isset($price) && $price == "" ? "color: red" : "" ?>">
          <?php if (isset($price) && $price == "") : ?>
          <?php include($_SERVER['DOCUMENT_ROOT'] . '/templates/emptyInput.php')?>
          <?php else : ?>
          Цена товара
          <?php endif ?>
        </p>
      </label>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
      
      <ul class="add-list">
        <li class="add-list__item add-list__item--add">
          <input type="file" name="product-photo" id="product-photo" hidden="" accept="image/jpeg, image/png, image/png">
          <label for="product-photo" style="<?= isset($photo) && $photo == "" ? "color: red" : "" ?>">
          <?= isset($photo) && $photo == "" ? "Добавьте фотографию" : "Добавить фотографию" ?>
          </label>
        </li>
      </ul>
    </fieldset>
    <fieldset class="page-add__group custom-form__group">
      <legend class="page-add__small-title custom-form__title">Раздел</legend>
      <div class="page-add__select">
        <select name="category[]" class="custom-form__select" multiple="multiple">
          <option hidden="">Название раздела</option>
          <option value="female">Женщины</option>
          <option value="male">Мужчины</option>
          <option value="children">Дети</option>
          <option value="access">Аксессуары</option>
        </select>
      </div>
      <input type="checkbox" name="new" id="new" class="custom-form__checkbox">
      <label for="new" class="custom-form__checkbox-label">Новинка</label>
      <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox">
      <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
    </fieldset>
    <button class="button" type="submit" name="addProduct">Добавить товар</button>
  </form>
  <section class="shop-page__popup-end page-add__popup-end" hidden="">
    <div class="shop-page__wrapper shop-page__wrapper--popup-end">
      <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно добавлен</h2>
    </div>
  </section>
</main>
<?php else : ?>
<h3>Недостаточно прав доступа к данной странице</h3>
<?php endif ?>

<?php 
require($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');
?>
