<header>
    <?php
    include "includes/pfp.php";
    echo $_SERVER["PHP_SELF"];
    ?>
    <h1>mei happs</h1>
    <p class="subtle">
        (she/it)
    </p>
    <nav>
        <a href="/" <?php if (
            $_SERVER["PHP_SELF"] == "/index.php/"
        ) { ?> class="active" <?php } ?>>home</a>
        <a href="/blog" <?php if (
            $_SERVER["PHP_SELF"] == "/index.php/blog"
        ) { ?> class="active" <?php } ?>>blog</a>
        <p></p>
    </nav>
</header>
