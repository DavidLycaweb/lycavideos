<?php
gatekeeper();
$title = "Upload new media";
elgg_push_breadcrumb($title);
$vars = videos_prepare_form_vars();
$content = elgg_view_form('videos/save', array(), $vars);
$sidebar = "";
$body = elgg_view_layout('one_sidebar', array(
   'content' => $content,
   'title' => $title
));
echo elgg_view_page($title, $body);





