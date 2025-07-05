<?php
/** @var array{title: string, link: string, date: string|null} $post */
?>
<article>
    <h2>
        <a href="<?= $post["link"] ?>">
            <?= $post["title"] ?>
        </a>
    </h2>
    <?php if ($post["date"]): ?>
        <time datetime="<?= $post["date"] ?>" class="subtle">
            <?= date("F j, Y", strtotime($post["date"])) ?>
        </time>
    <?php endif; ?>
</article>
