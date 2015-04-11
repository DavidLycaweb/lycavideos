<?php
/**
 * File river view.
 */

$object = $vars['item']->getObjectEntity();
$objeto = $object->guid;
$excerpto = strip_tags($object->description);
$excerpt = thewire_filter($excerpto);
$reggex = '/https?\:\/\/[^\" ]+/i';
preg_match_all($reggex, $excerpto, $partes);
    
foreach($partes as $parte){ 

if ((count($parte)) == '1') {
foreach($parte as $part) {

   $excerptus = "<div class='elwire-$objeto'>
<a class='embedly-card' href='$part'></a>
</div>";
   $excerptini = elgg_view('output/url_preview', array('value' => $part));

}

}

}

$scraper = elgg_get_plugin_setting('scraper_system', 'embedlycards');

if ($scraper != 'scraper'){
 $excerpt .= $excerptus;
 }
 else {
 $excerpt .= $excerptini;
 }
$subject = $vars['item']->getSubjectEntity();
$subject_link = elgg_view('output/url', array(
	'href' => $subject->getURL(),
	'text' => $subject->name,
	'class' => 'elgg-river-subject',
	'is_trusted' => true,
));

$object_link = elgg_view('output/url', array(
	'href' => "thewire/owner/$subject->username",
	'text' => elgg_echo('thewire:wire'),
	'class' => 'elgg-river-object',
	'is_trusted' => true,
));

$summary = elgg_echo("river:create:object:thewire", array($subject_link, $object_link));



echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => $excerpt,
	'summary' => $summary,
));

