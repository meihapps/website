<?php
header("Content-Type: application/rss+xml; charset=utf-8");

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

// Function to convert date to RFC 2822 format
function formatRSSDate($dateString)
{
    $date = DateTime::createFromFormat("Y-m-d", $dateString);
    if ($date) {
        return $date->format("D, d M Y H:i:s T");
    }
    return $dateString;
}

// Function to escape XML content
function xmlEscape($text)
{
    return htmlspecialchars($text, ENT_XML1 | ENT_QUOTES, "UTF-8");
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<rss version="2.0"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:jsonld="https://schema.org/">
  <channel>
    <title>mei happs' blog</title>
    <link>https://meihapps.gay/blog</link>
    <description>this is where i put my evil opinions on software and other foolish endeavours</description>
    <language>en</language>
    <managingEditor>mei@meihapps.gay (mei happs)</managingEditor>
    <webMaster>mei@meihapps.gay (mei happs)</webMaster>
    <lastBuildDate><?= formatRSSDate(date("Y-m-d")) ?></lastBuildDate>

    <?php foreach ($posts as $post): ?>
    <item>
      <title><?= xmlEscape($post["headline"]) ?></title>
      <link><?= xmlEscape($post["url"]) ?></link>
      <guid><?= xmlEscape($post["url"]) ?></guid>
      <pubDate><?= formatRSSDate($post["datePublished"]) ?></pubDate>
      <author>mei@meihapps.gay (<?= xmlEscape(
          $post["author"]["name"] ?? "mei happs"
      ) ?>)</author>

      <?php if (
          isset($post["articleBody"]) &&
          file_exists($post["articleBody"])
      ): ?>
        <?php
        $markdown_content = file_get_contents($post["articleBody"]);

        // Convert markdown to HTML using CommonMark
        $converter = new CommonMarkConverter([
            "html_input" => "strip",
            "allow_unsafe_links" => false,
        ]);
        $content_html = $converter->convert($markdown_content)->getContent();
        ?>
        <description><?= xmlEscape(strip_tags($content_html)) ?></description>
        <content:encoded><![CDATA[<?= $content_html ?>]]></content:encoded>
      <?php endif; ?>

      <!-- Include full JSON-LD data as extension -->
      <jsonld:data><![CDATA[<?= json_encode(
          $post,
          JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
      ) ?>]]></jsonld:data>
    </item>
    <?php endforeach; ?>

  </channel>
</rss>
