<ul class="<?= $class ?>">
    <?php foreach ($array as $category) : ?>
          <li>
            <a class="filter__list-item <?= !isset($_GET['category']) && $category['name'] == 'Все' ? 'active' : activeCategory($category) ?>" 
              href="<?= $category['path'] === "" ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : "?category=" . $category['path'] ?>">
            <?= $category['name'] ?>
            </a>
          </li>
    <?php endforeach ?>
</ul>

        