<?php
/**
 * Action for adding a wire post
 * 
 */

$body = get_input('body', '', false);
$reggex = '/https?\:\/\/[^\" ]+/i';
$etiquetas = '/(#[^\s]+)/';
preg_match_all($reggex, $body, $partes);
preg_match_all($etiquetas, $body, $tocos);
$access_id = ACCESS_PUBLIC;
$method = 'site';
$parent_guid = (int) get_input('parent_guid');

if (empty($body)) {
	register_error(elgg_echo("thewire:blank"));
	forward(REFERER);
}
$guid = thewire_save_post($body, elgg_get_logged_in_user_guid(), $access_id, $parent_guid, $method);
 
if ($guid) {	
foreach($partes as $parte){ 

if ((count($parte)) == '1') {

foreach($parte as $part) {

$diredire = $part;
}

if (videos_filter_videos($part) == '1') {

foreach ($tocos as $toco) {
$toc = $toco;
}

$title = $diredire;
$body = get_input('body', '', false);
$estaurl = $diredire;
$tags = $toc;
$card = new ElggObject();
$card->subtype = "embedlycard";
$card->title = $title;
$card->description = $body;
$card->address = $estaurl;
$card->access_id = ACCESS_PUBLIC;
$card->owner_guid = elgg_get_logged_in_user_guid();
$card->tags = $tags;
$card_guid = $card->save();
}

}

}

	$options = array(
		'pagination' => false,
		'limit' => 1
	);
	$output = elgg_list_river($options);
	echo $output;
}

system_message(elgg_echo("thewire:posted"));
forward(REFERER);
