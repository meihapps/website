<?php
header("Content-Type: application/json; charset=utf-8");

use League\CommonMark\CommonMarkConverter;

// Load all posts from JSON-LD files
$posts = [];
foreach (scandir("posts") as $entry) {
    if ($entry == "." || $entry == ".." || !str_ends_with($entry, ".jsonld")) {
        continue;
    }

    $json_content = file_get_contents("posts/" . $entry);
    $post_data = json_decode($json_content, true);

    if ($post_data && isset($post_data["headline"])) {
        $posts[] = $post_data;
    }
}

// Sort posts by date published (newest first)
usort($posts, function ($a, $b) {
    $dateA = $a["datePublished"] ?? "";
    $dateB = $b["datePublished"] ?? "";
    return strcmp($dateB, $dateA);
});

// Build JSON Feed
$feed = [
    "version" => "https://jsonfeed.org/version/1.1",
    "title" => "mei happs' blog",
    "home_page_url" => "https://meihapps.gay/blog",
    "feed_url" => "https://meihapps.gay/feed.json",
    "description" =>
        "this is where i put my evil opinions on software and other foolish endeavours",
    "language" => "en",
    "authors" => [
        [
            "name" => "mei happs",
            "url" => "https://meihapps.gay",
        ],
    ],
    "items" => [],
];

// Convert each post to JSON Feed item format
foreach ($posts as $post) {
    $slug = basename($post["url"]);

    // Load markdown content if available
    $content_html = "";
    if (isset($post["articleBody"]) && file_exists($post["articleBody"])) {
        $markdown_content = file_get_contents($post["articleBody"]);

        // Convert markdown to HTML using CommonMark
        $converter = new CommonMarkConverter([
            "html_input" => "strip",
            "allow_unsafe_links" => false,
        ]);
        $content_html = $converter->convert($markdown_content)->getContent();
    }

    $item = [
        "id" => $post["url"],
        "url" => $post["url"],
        "title" => $post["headline"],
        "content_html" => $content_html,
        "date_published" => $post["datePublished"] . "T00:00:00Z",
        "authors" => [
            [
                "name" => $post["author"]["name"] ?? "mei happs",
            ],
        ],
    ];

    // Add JSON-LD data as extension
    $item["_json_ld"] = $post;

    $feed["items"][] = $item;
}

echo json_encode(
    $feed,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
);
?>
