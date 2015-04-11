<?php
$guid = get_input('guid');
$embedlycard = get_entity($guid);

if (elgg_instanceof($embedlycard, 'object', 'embedlycard') && $embedlycard->canEdit()) {
	$container = $embedlycard->getContainerEntity();
	if ($embedlycard->delete()) {
		system_message(elgg_echo("embedlycards:delete:success"));
		if (elgg_instanceof($container, 'group')) {
			forward("videos/group/$container->guid/all");
		} else {
			forward("videos/owner/$container->username");
		}
	}
}

register_error(elgg_echo("embedlycards:delete:failed"));
forward(REFERER);
