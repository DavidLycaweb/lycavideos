<?php
/**
 * Card view
 */

$full = elgg_extract('full_view', $vars, FALSE);
$embedlycard = elgg_extract('entity', $vars, FALSE);
if (!$embedlycard) {
	return;
}
$estaurl = $embedlycard->address;
$tarjeta = "<a href='$estaurl' class='embedly-card'></a>";
$owner = $embedlycard->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$container = $embedlycard->getContainerEntity();
$categories = elgg_view('output/categories', $vars);
$scraper = elgg_get_plugin_setting('scraper_system', 'lycavideos');
if ($scraper == 'scraper'){
$scraperlink = elgg_view('output/url_preview', array('value' => $estaurl));
}
else {
$scraperlink = '';
}
$link = elgg_view('output/url', array('href' => $embedlycard->address));
$description = parse_urls($embedlycard->description);
$owner_link = elgg_view('output/url', array(
	'href' => "videos/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($embedlycard->time_created);
$comments_count = $embedlycard->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $embedlycard->getURL() . '#comments',
		'text' => $text,
		'is_trusted' => true,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'videos',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link $categories";

if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full && !elgg_in_context('gallery')) {
	$params = array(
		'entity' => $embedlycard,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);
	$body = <<<HTML
<div class="embedlycard elgg-content mts">	
	$description 
	$tarjeta
    $scraperlink	
</div>
HTML;

	echo elgg_view('object/elements/full', array(
		'entity' => $embedlycard,
		'icon' => $owner_icon,
		'summary' => $summary,
		'body' => $body,
	));

} elseif (elgg_in_context('gallery')) {
	echo <<<HTML
<div class="videos-gallery-item">
	<h3>$embedlycard->title</h3>
	$tarjeta
	$scraperlink
	<p class='subtitle'>$owner_link $date</p>
</div>
HTML;
} else {
//mini
	$url = $embedlycard->address;
	$display_text = $url;
	$excerpt = $description;
	if (strlen($url) > 25) {
		$bits = parse_url($url);
		if (isset($bits['host'])) {
			$display_text = $bits['host'];
		} else {
			$display_text = elgg_get_excerpt($url, 100);
		}
	}
    $excerpt .= $tarjeta;	
	$excerpt .= $scraperlink;
	$link = elgg_view('output/url', array(
		'href' => $embedlycard->address,
		'text' => $display_text,
	));

	$content = $excerpt;
	$params = array(
		'entity' => $embedlycard,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $content,
	);
	$params = $params + $vars;
	$body = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($owner_icon, $body);
}
