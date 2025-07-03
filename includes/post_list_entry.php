<?php
/** @var array{title: string, link: string, date: string|null} $post */
?>
<article>
    <h3>
        <a href="<?= $post["link"] ?>">
            <?= $post["title"] ?>
        </a>
    </h3>
    <?php if ($post["date"]): ?>
        <time datetime="<?= $post["date"] ?>" class="subtle">
            <?= date("F j, Y", strtotime($post["date"])) ?>
        </time>
    <?php endif; ?>
</article>
