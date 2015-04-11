<?php
/**
* Elgg videos save action
*
* @package videos
*/

$title = htmlspecialchars(get_input('title', '', false), ENT_QUOTES, 'UTF-8');
$description = get_input('description');
$address = get_input('address');
$access_id = get_input('access_id');
$tags = get_input('tags');
$guid = get_input('guid');
$share = get_input('share');
$container_guid = get_input('container_guid', elgg_get_logged_in_user_guid());

elgg_make_sticky_form('videos');

// don't use elgg_normalize_url() because we don't want
// relative links resolved to this site.
if ($address && !preg_match("#^((ht|f)tps?:)?//#i", $address)) {
	$address = "http://$address";
}

if (!$title || !$address) {
	register_error(elgg_echo('videos:save:failed'));
	forward(REFERER);
}



if ($guid == 0) {
	$card = new ElggObject;
	$card->subtype = "embedlycard";
	$card->container_guid = (int)get_input('container_guid', $_SESSION['user']->getGUID());
	$new = true;
} else {
	$card = get_entity($guid);
	if (!$card->canEdit()) {
		system_message(elgg_echo('videos:save:failed'));
		forward(REFERRER);
	}
}

$tagarray = string_to_tag_array($tags);

$card->title = $title;
$card->address = $address;
$card->description = $description;
$card->access_id = $access_id;
$card->tags = $tagarray;

if ($card->save()) {

	elgg_clear_sticky_form('videos');

	// @todo
	if (is_array($shares) && sizeof($shares) > 0) {
		foreach($shares as $share) {
			$share = (int) $share;
			add_entity_relationship($card->getGUID(), 'share', $share);
		}
	}
	system_message(elgg_echo('videos:save:success'));

	//add to river only if new
	if ($new) {
		add_to_river('river/object/videos/create','create', elgg_get_logged_in_user_guid(), $card->getGUID());
	}

	forward($card->getURL());
} else {
	register_error(elgg_echo('videos:save:failed'));
	forward("videos");
}
