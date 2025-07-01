<?php
/** @var string $title */

$post_file = "posts/" . $title . ".php";
if (!file_exists($post_file)) {
    http_response_code(404);
    require_once "views/404.php";
    exit();
}

// Extract date and content from post file using output buffering
ob_start();
include $post_file;
$post_content = ob_get_clean();

$date_pattern = '/<p class="subtle">([^<]+)<\/p>/';
$date = "";
if (preg_match($date_pattern, $post_content, $matches)) {
    $date = $matches[1];
    $post_content = preg_replace($date_pattern, "", $post_content, 1);
}
?>

<?php include "includes/head.php"; ?>
<body>
    <div class="wrapper">
        <?php include "includes/header.php"; ?>
        <main>
            <h2><?= htmlspecialchars(
                str_replace("_", " ", $title),
                ENT_QUOTES,
                "UTF-8"
            ) ?></h2>
            <?php if ($date): ?>
                <p class="subtle"><?= htmlspecialchars($date) ?></p>
            <?php endif; ?>
            <article>
                <?= $post_content ?>
            </article>
        </main>
        <?php include "includes/footer.php"; ?>
    </div>
<script src="/static/prism.js"></script>
</body>
</html>
