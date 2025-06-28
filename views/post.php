<?php
/** @var string $title */

$post_file = "posts/" . $title . ".php";
if (!file_exists($post_file)) {
    http_response_code(404);
    exit("Post not found");
}
?>

<!DOCTYPE html>
<html lang="en">
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
        </main>
        <section>
            <?php include $post_file; ?>
        </section>
        <?php include "includes/footer.php"; ?>
    </div>
<script src="/static/prism.js"></script>
</body>
</html>
