<?php
/** @var string $title */

$post_file = "posts/" . $title . ".jsonld";
if (!file_exists($post_file)) {
    http_response_code(404);
    require_once "views/404.php";
    exit();
}

// Load and parse JSON-LD post
$json_content = file_get_contents($post_file);
$post_data = json_decode($json_content, true);

if (!$post_data) {
    http_response_code(500);
    exit("Invalid post format");
}

$date = $post_data["datePublished"] ?? "";
$post_content = $post_data["articleBody"] ?? "";

// Replace code file references with actual file content
$post_content = preg_replace_callback(
    '/```(\w+)\n([^\n]+)\n```/',
    function ($matches) use ($title) {
        $language = $matches[1];
        $filename = $matches[2];

        $filepath = "static/" . $title . "/" . $filename;

        if (file_exists($filepath)) {
            $code = file_get_contents($filepath);
            return "```{$language}\n{$code}\n```";
        }
        return $matches[0]; // Return original if file not found
    },
    $post_content
);

// Parse markdown to HTML
use League\CommonMark\CommonMarkConverter;

$converter = new CommonMarkConverter([
    "html_input" => "strip",
    "allow_unsafe_links" => false,
]);
$post_content = $converter->convert($post_content)->getContent();
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
            <script type="application/ld+json">
                <?= $json_content ?>
            </script>
        </main>
        <?php include "includes/footer.php"; ?>
    </div>
<script src="/static/prism.js"></script>
</body>
</html>
