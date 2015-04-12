<?php
function videos_init() {
$ruta = dirname(__FILE__);
elgg_register_library('elgg:videos', "$ruta/lib/videos.php");
elgg_register_action("videos/save", elgg_get_plugins_path() . "lycavideos/actions/videos/save.php");	
$scraper = elgg_get_plugin_setting('scraper_system', 'lycavideos');
$savewire = elgg_get_plugin_setting('save_wire', 'lycavideos');
if ($scraper != 'scraper'){
elgg_extend_view("page/default", "videos/js");
}
if ($savewire != 'no'){
elgg_register_action("thewire/add", "$ruta/actions/add.php");
elgg_register_action("river_addon/add", "$ruta/actions/riveraddon/add.php");
}
elgg_register_action('videos/delete', "$ruta/actions/videos/delete.php");
elgg_register_entity_url_handler('object', 'embedlycard', 'embedlycard_url');
elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'videos_owner_block_menu');
elgg_register_entity_type('object', 'embedlycard');
add_group_tool_option('videos', elgg_echo('lycavideos:enablevideos'), true);
elgg_extend_view('groups/tool_latest', 'videos/group_module');
elgg_register_plugin_hook_handler('get_views', 'ecml', 'videos_ecml_views_hook');
elgg_register_widget_type('videos', elgg_echo('lycavideos'), elgg_echo('lycavideos:widget:description'));
elgg_register_menu_item('site', array(
		'name' => 'videos',
		'text' => elgg_echo('lycavideos'),
		'href' => 'videos/all'
	));

}
elgg_register_event_handler('init','system','videos_init'); 

function videos_ecml_views_hook($hook, $type, $return, $params) {
	$return['object/embedlycard'] = elgg_echo('item:object:lycavideos');
	return $return;
}



elgg_register_page_handler('videos', 'videos_page_handler');


function videos_page_handler($page) {

	elgg_load_library('elgg:videos');

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	elgg_push_breadcrumb(elgg_echo('videos'), 'videos/all');

	// old group usernames
	if (substr_count($page[0], 'group:')) {
		preg_match('/group\:([0-9]+)/i', $page[0], $matches);
		$guid = $matches[1];
		if ($entity = get_entity($guid)) {
			videos_url_forwarder($page);
		}
	}

	// user usernames
	$user = get_user_by_username($page[0]);
	if ($user) {
		videos_url_forwarder($page);
	}

	$pages = dirname(__FILE__) . '/pages/videos';

	switch ($page[0]) {
		case "all":
			include "$pages/all.php";
			break;

		case "owner":
			include "$pages/owner.php";
			break;

		case "friends":
			include "$pages/friends.php";
			break;

		case "view":
			set_input('guid', $page[1]);
			include "$pages/view.php";
			break;

		case "add":
			gatekeeper();
			include "$pages/add.php";
			break;

		case "edit":
			gatekeeper();
			set_input('guid', $page[1]);
			include "$pages/edit.php";
			break;

		case 'group':
			group_gatekeeper();
			include "$pages/owner.php";
			break;

		default:
			return false;
	}

	elgg_pop_context();
	return true;
}


/**
 * Forward to the new style of URLs
 *
 * @param string $page
 */
function videos_url_forwarder($page) {
	global $CONFIG;

	if (!isset($page[1])) {
		$page[1] = 'items';
	}

	switch ($page[1]) {
		case "read":
			$url = "{$CONFIG->wwwroot}videos/view/{$page[2]}/{$page[3]}";
			break;
		case "inbox":
			$url = "{$CONFIG->wwwroot}videos/inbox/{$page[0]}";
			break;
		case "friends":
			$url = "{$CONFIG->wwwroot}videos/friends/{$page[0]}";
			break;
		case "add":
			$url = "{$CONFIG->wwwroot}videos/add/{$page[0]}";
			break;
		case "items":
			$url = "{$CONFIG->wwwroot}videos/owner/{$page[0]}";
			break;

	}

	register_error(elgg_echo("changeembedlycard"));
	forward($url);
}

/**
 * Populates the ->getUrl() method for shared objects
 */
function embedlycard_url($entity) {
	global $CONFIG;
	$title = $entity->title;
	$title = elgg_get_friendly_title($title);
	return $CONFIG->url . "videos/view/" . $entity->getGUID() . "/" . $title;
}

/**
 * Add a menu item to an ownerblock
 */
function videos_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "videos/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('videos', elgg_echo('videos'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->videos_enable != 'no') {
			$url = "videos/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('videos', elgg_echo('videos:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}




/**
*Filter videos
*/

function videos_filter_videos($part) {
$youtube = 'youtube.com';
$youtu = 'youtu.be';
$vimeo = 'vimeo.com';
$vevo = 'vevo';
$metacafe = 'metacafe';
$vk = 'vk.com';
$dailymotion = 'dailymotion';
$tutv = 'tu.tv';
$blip = 'blip.tv';
$veoh = 'veoh.com';
$yahoo ='screen.yahoo.com';
$wat = 'wat.tv';
$vidme = 'vid.me';
$magistro = 'magisto.com';
$tynipic = 'tinypic.com/';
$hulu = 'hulu.com';
$sapo = 'videos.sapo.pt';

if ((false !== strpos($part,$youtube)) or (false !== strpos($part,$youtu))
or (false !== strpos($part,$vimeo)) or (false !== strpos($part,$vevo)) 
or (false !== strpos($part,$metacafe)) or (false !== strpos($part,$vk))
or (false !== strpos($part,$dailymotion)) or (false !== strpos($part,$tutv))
or (false !== strpos($part,$blip)) or (false !== strpos($part,$veoh))
or (false !== strpos($part,$yahoo)) or (false !== strpos($part,$wat))
or (false !== strpos($part,$vidme)) or (false !== strpos($part,$magistro))
or (false !== strpos($part,$tynipic)) or (false !== strpos($part,$hulu))
or (false !== strpos($part,$sapo))) {
$validating = '1';
}
else {
$validating = '0';
}


return $validating;
}
