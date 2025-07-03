<?php
$posts = [];
foreach (scandir("posts") as $entry) {
    if ($entry == "." || $entry == ".." || !str_ends_with($entry, ".jsonld")) {
        continue;
    }

    // Load JSON-LD file to get proper title and date
    $json_content = file_get_contents("posts/" . $entry);
    $post_data = json_decode($json_content, true);

    if ($post_data && isset($post_data["headline"])) {
        $posts[] = [
            "title" => $post_data["headline"],
            "link" => "blog/" . str_replace(".jsonld", "", $entry),
            "date" => $post_data["datePublished"] ?? null,
        ];
    }
}

// Sort posts by date (newest first)
usort($posts, function ($a, $b) {
    if (!$a["date"] || !$b["date"]) {
        return 0;
    }
    return strtotime($b["date"]) - strtotime($a["date"]);
});
$title = "mei happs' blog";
?>

<?php include "includes/head.php"; ?>
<body>
    <div class="wrapper">
        <?php include "includes/header.php"; ?>
    	<main>
            <p>
                this is where i put my evil opinions on software and other foolish endeavours
            </p>
            <p class="subtle">
                <a href="/feed.json">json feed</a> · <a href="/rss.xml">rss feed</a>
            </p>
            <ol>
                <?php
                foreach ($posts as $post) {
                    echo "<li>";
                    include "includes/post_list_entry.php";
                    echo "</li>";
                }
                unset($post);
                ?>
            </ol>
        </main>
        <?php include "includes/footer.php"; ?>
    </div>
</body>
</html>
