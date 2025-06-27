<?php global $title; ?>

<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.php"; ?>
<body>
    <div class="wrapper">
        <?php include "includes/header.php"; ?>
        <main>
            <h2><?= str_replace("_", " ", $title) ?></h2>
        </main>
        <section>
            <?php include "posts/" . $title . ".php"; ?>
        </section>
        <?php include "includes/footer.php"; ?>
    </div>
<script src="/static/prism.js"></script>
</body>
</html>
