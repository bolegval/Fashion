<main class="page-authorization">
  <h1 class="h h--1">Авторизация</h1>
  <?php if (!$isAuth && $isAuth !== null) : ?>
  <?php include($_SERVER['DOCUMENT_ROOT'] . '/templates/error.php') ?>
  <?php endif ?>
  <form class="custom-form" method="post">
    <input type="email" class="custom-form__input" name="login" required="">
    <input type="password" class="custom-form__input" name="password" required="">
    <button class="button" type="submit" name="logIn">Войти в личный кабинет</button>
  </form>
</main>
