<?php
$posts = [];
foreach (scandir("posts") as $entry) {
    if ($entry == "." || $entry == ".." || !str_ends_with($entry, ".jsonld")) {
        continue;
    }

    // Load JSON-LD file to get proper title
    $json_content = file_get_contents("posts/" . $entry);
    $post_data = json_decode($json_content, true);

    if ($post_data && isset($post_data["headline"])) {
        $posts[] = [
            "title" => $post_data["headline"],
            "link" => "blog/" . str_replace(".jsonld", "", $entry),
        ];
    }
}
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
            <?php
            foreach ($posts as $post) {
                include "includes/post_list_entry.php";
            }
            unset($post);
            ?>
        </main>
        <?php include "includes/footer.php"; ?>
    </div>
</body>
</html>
