<?php 
$entity = elgg_extract('entity', $vars);
?>

<p>
<label>
<?php 
$titulo = elgg_echo ('embedlycards:settings:scraper');
echo $titulo;
?>
</label>
<?php 
$selecciona = elgg_view('input/dropdown', array(
	'name' => 'params[scraper_system]',
	'options_values' => array(
		'embedly' => elgg_echo('option:embedly'),
		'scraper' => elgg_echo('option:scraper')
	),
	'value' => $entity->scraper_system,
));
echo $selecciona;
?>
</p>

<p>
<label>
<?php 
$titulo = elgg_echo ('embedlycards:settings:savewire');
echo $titulo;
?>
</label>
<?php 
$selecciona = elgg_view('input/dropdown', array(
	'name' => 'params[save_wire]',
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no')
	),
	'value' => $entity->save_wire,
));
echo $selecciona;
?>
</p>


