<?php
gatekeeper();
$title = "Upload new media";
$content = elgg_view_title($title);
$content .= elgg_view_form("videos/save");
$sidebar = "";
$body = elgg_view_layout('one_sidebar', array(
   'content' => $content,
   'sidebar' => $sidebar
));
echo elgg_view_page($title, $body);