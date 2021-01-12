<ul class="<?= $class ?>">
    <?php foreach ($array as $menuItem) : ?>
    <li>
        <a href="<?= $menuItem['path'] ?>"
        class="main-menu__item <?= activeMenu($menuItem) ?>"> <?= $menuItem['menu'] ?></a>
    </li>
    <?php endforeach ?>
</ul>