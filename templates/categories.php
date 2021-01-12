<ul class="<?= $class ?>">
    <?php foreach ($array as $item) : ?>
        <li>
            <a class="filter__list-item <?= activeCategory($item) ?>" href="?category=<?= $item['path'] ?>"><?= $item['name'] ?></a>
        </li>
    <?php endforeach ?>
</ul>
