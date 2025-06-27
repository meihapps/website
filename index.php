<?php
require "vendor/autoload.php";

$router = new AltoRouter();

try {
    $router->map("GET", "/", "views/home.php");
    $router->map("GET", "/blog", "views/blog.php");
    $router->map("GET", "/blog/[*:title]", "views/post.php");
    $router->map(
        "GET",
        "/google89c6f7f3769cad39.html",
        "google89c6f7f3769cad39.html"
    );
} catch (Exception $e) {
    echo $e;
}

$match = $router->match();
if ($match) {
    foreach ($match["params"] as &$param) {
        ${key($match["params"])} = $param;
    }
    require_once $match["target"];
} else {
    http_response_code(404);
    exit("Page not found");
}
