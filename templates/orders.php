<ul class="<?= $class ?>">
  <?php foreach ($array as $item) : ?>
    <li class="order-item page-order__item">
      <div class="order-item__wrapper">
        <div class="order-item__group order-item__group--id">
          <span class="order-item__title">Номер заказа</span>
          <span class="order-item__info order-item__info--id"><?= $item['id'] ?></span>
        </div>
        <div class="order-item__group">
          <span class="order-item__title">Сумма заказа</span>
          <?= $item['sum'] ?> руб.
        </div>
        <button class="order-item__toggle"></button>
      </div>
      <div class="order-item__wrapper">
        <div class="order-item__group order-item__group--margin">
          <span class="order-item__title">Заказчик</span>
          <span class="order-item__info"><?= $item['customer'] ?></span>
        </div>
        <div class="order-item__group">
          <span class="order-item__title">Номер телефона</span>
          <span class="order-item__info"><?= $item['phone'] ?></span>
        </div>
        <div class="order-item__group">
          <span class="order-item__title">Способ доставки</span>
          <span class="order-item__info">
          <?= $item['delivery'] == 'dev-no' ? 'Самовывоз' : 'Курьерская доставка' ?>
          </span>
        </div>
        <div class="order-item__group">
          <span class="order-item__title">Способ оплаты</span>
          <span class="order-item__info">
          <?= $item['pay'] == 'cash' ? 'Наличными' : 'Банковской картой' ?>
          </span>
        </div>
        <div class="order-item__group order-item__group--status">
          <span class="order-item__title">Статус заказа</span>
          <span class="order-item__info <?= $item['active'] == 1 ? 'order-item__info--no' : 'order-item__info--yes' ?>">
          <?= $item['active'] == 1 ? 'Не выполнено' : 'Выполнено' ?>
          </span>
          <button class="order-item__btn">Изменить</button>
        </div>
      </div>
      <?php if($item['delivery'] == 'dev-yes') : ?>
      <div class="order-item__wrapper">
        <div class="order-item__group">
          <span class="order-item__title">Адрес доставки</span>
          <span class="order-item__info"><?= $item['address'] ?></span>
        </div>
      </div>
      <?php endif ?>
      <div class="order-item__wrapper">
        <div class="order-item__group">
          <span class="order-item__title">Комментарий к заказу</span>
          <span class="order-item__info"><?= $item['comment'] ?></span>
        </div>
      </div>
    </li>
    <?php endforeach ?>
  </ul>