<ul class="shop__paginator paginator">
    <?php for ($i = 1; $i <= $total; $i++) : ?>
        <li>
          <a class="paginator__item" 
          <?php if (($i !== 1 || !empty($_GET['page']))  && strpos($_SERVER["QUERY_STRING"], "$i") === false) : ?>
          href="<?= addGet('page', $i) ?>"
          <?php endif ?>>
          <?= $i ?></a>
        </li>
    <?php endfor ?>
  </ul>