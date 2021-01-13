<?php foreach ($array as $productItem) : ?>

<article class="<?= $class ?>" tabindex="<?= $productItem['id'] ?>">
    <div class="product__image">
      <img src="/img/products/<?= $productItem['image'] ?>" alt="<?= $productItem['name'] ?>">
    </div>
    <p class="product__name"><?= $productItem['name'] ?></p>
    <span class="product__price"><?= number_format($productItem['price'], 0, ',', ' ') ?> руб</span>
</article>

<?php endforeach ?>
