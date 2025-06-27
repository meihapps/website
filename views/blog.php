<?php
$posts = [];
foreach (scandir("posts") as $entry) {
    if ($entry == "." || $entry == "..") {
        continue;
    }
    $posts[] = [
        "title" => str_replace(["_", ".php"], [" ", ""], $entry),
        "link" => "blog/" . str_replace(".php", "", $entry),
    ];
}
$title = "mei happs' blog";
?>

<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.php"; ?>
<body>
    <div class="wrapper">
        <?php include "includes/header.php"; ?>
    	<main>
            <p>
                this is where i put my evil opinions on software and other foolish endeavours
            </p>
        </main>
        <section>
            <?php
            foreach ($posts as $post) {
                include "includes/post_list_entry.php";
            }
            unset($post);
            ?>
        </section>
        <?php include "includes/footer.php"; ?>
    </div>
</body>
</html>
