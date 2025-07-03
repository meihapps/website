<?php
require "vendor/autoload.php";

$router = new AltoRouter();

try {
    $router->map("GET", "/", "views/home.php");
    $router->map("GET", "/blog", "views/blog.php");
    $router->map("GET", "/blog/[*:title]", "views/post.php");
    $router->map("GET", "/feed.json", "views/feed.php");
    $router->map("GET", "/rss.xml", "views/rss.php");
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit("Internal server error");
}

$match = $router->match();
if ($match) {
    foreach ($match["params"] as $key => &$param) {
        // Sanitize title parameter to prevent path traversal
        if ($key === "title") {
            $param = basename($param); // Remove any directory traversal
            $param = preg_replace("/[^a-zA-Z0-9_-]/", "", $param); // Allow only safe characters
        }
        ${$key} = $param;
    }
    require_once $match["target"];
} else {
    http_response_code(404);
    require_once "views/404.php";
}
