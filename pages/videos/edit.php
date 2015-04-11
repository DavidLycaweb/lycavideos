<?php
$embedlycard_guid = get_input('guid');
$embedlycard = get_entity($embedlycard_guid);

if (!elgg_instanceof($embedlycard, 'object', 'embedlycard') || !$embedlycard->canEdit()) {
	register_error(elgg_echo('embedlycards:unknown_embedlycard'));
	forward(REFERRER);
}

$page_owner = elgg_get_page_owner_entity();

$title = elgg_echo('embedlycards:edit');
elgg_push_breadcrumb($title);

$vars = videos_prepare_form_vars($embedlycard);
$content = elgg_view_form('videos/save', array(), $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);