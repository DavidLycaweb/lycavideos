<?php
/**
 * List most recent videos on group profile page
 */

$group = elgg_get_page_owner_entity();
$gruguid = $group->guid;
if ($group->videos_enable == "no") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "videos/group/$gruguid/all",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtype' => 'embedlycard',
	'container_guid' => elgg_get_page_owner_guid(),
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
);
$content = elgg_list_entities($options);
elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('videos:none') . '</p>';
}

$new_link = elgg_view('output/url', array(
	'href' => "videos/add/$gruguid",
	'text' => elgg_echo('videos:add'),
	'is_trusted' => true,
));

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('videos:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
