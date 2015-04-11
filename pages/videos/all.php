<?php 
elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('videos'));

elgg_register_title_button();

$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'embedlycard',
	'full_view' => false,
	'view_toggle_type' => false,
));

if (!$content) {
	$content = elgg_echo('videos:none');
}

$title = elgg_echo('videos:everyone');

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('videos/sidebar'),
));

echo elgg_view_page($title, $body);