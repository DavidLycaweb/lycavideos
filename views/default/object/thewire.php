<?php
/**
 * View a wire post
 * 
 * @uses $vars['entity']
 */

elgg_load_js('elgg.thewire');

$full = elgg_extract('full_view', $vars, FALSE);
$post = elgg_extract('entity', $vars, FALSE);

if (!$post) {
	return true;
}

$excerpto = strip_tags($post->description);

$reggex = '/https?\:\/\/[^\" ]+/i';
preg_match_all($reggex, $excerpto, $partes);

foreach($partes as $parte){ 

if ((count($parte)) == '1') {
foreach($parte as $part) {

   $excerpti = "<div class='elwire-$objeto'>
<a class='embedly-card' href='$part'></a>
</div>";
   $excerptini = elgg_view('output/url_preview', array('value' => $part));

}

}

}


// make compatible with posts created with original Curverider plugin
$thread_id = $post->wire_thread;
if (!$thread_id) {
	$post->wire_thread = $post->guid;
}

$owner = $post->getOwnerEntity();

$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array(
	'href' => "thewire/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($post->time_created);

$metadata = elgg_view_menu('entity', array(
	'entity' => $post,
	'handler' => 'thewire',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

$contenido = thewire_filter($post->description);
$scraper = elgg_get_plugin_setting('scraper_system', 'embedlycards');

if ($scraper != 'scraper'){
$contenido .= $excerpti;
}
else {
$contenido .= $excerptini;
}


$params = array(
	'entity' => $post,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
	'content' => $contenido,
	'tags' => false,
);
$params = $params + $vars;
$list_body = elgg_view('object/elements/summary', $params);

echo elgg_view_image_block($owner_icon, $list_body);

if ($post->reply) {
	echo "<div class=\"thewire-parent hidden\" id=\"thewire-previous-{$post->guid}\">";
	echo "</div>";
}
