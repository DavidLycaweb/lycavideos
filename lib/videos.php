<?php
/**
 * videos helper functions
 */

function videos_prepare_form_vars($embedlycard = null) {
	$values = array(
		'title' => get_input('title', ''), 
		'address' => get_input('address', ''),
		'description' => get_input('description', ''),
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $embedlycard,
	);

	if ($embedlycard) {
		foreach (array_keys($values) as $field) {
			if (isset($embedlycard->$field)) {
				$values[$field] = $embedlycard->$field;
			}
		}
	}

	if (elgg_is_sticky_form('videos')) {
		$sticky_values = elgg_get_sticky_values('videos');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('videos');

	return $values;
}
