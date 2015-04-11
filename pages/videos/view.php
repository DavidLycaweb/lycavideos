<?php

$embedlycard = get_entity(get_input('guid'));
if (!$embedlycard) {
	register_error(elgg_echo('noaccess'));
	$_SESSION['last_forward_from'] = current_page_url();
	forward('');
}

$page_owner = elgg_get_page_owner_entity();

$crumbs_title = $page_owner->name;

if (elgg_instanceof($page_owner, 'group')) {
	elgg_push_breadcrumb($crumbs_title, "videos/group/$page_owner->guid/all");
} else {
	elgg_push_breadcrumb($crumbs_title, "videos/owner/$page_owner->username");
}

$title = $embedlycard->title;

elgg_push_breadcrumb($title);

$content = elgg_view_entity($embedlycard, array('full_view' => true));
$content .= elgg_view_comments($embedlycard);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);

