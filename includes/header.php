<header>
    <?php include "includes/pfp.php"; ?>
    <h1>mei happs</h1>
    <p class="subtle">
        (she/it)
    </p>
    <nav>
        <a href="/" <?php if (
            $_SERVER["REQUEST_URI"] == "/"
        ) { ?> class="active" <?php } ?>>home</a>
        <a href="/blog" <?php if (
            $_SERVER["REQUEST_URI"] == "/blog"
        ) { ?> class="active" <?php } ?>>blog</a>
        <p></p>
    </nav>
</header>
