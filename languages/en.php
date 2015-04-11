<?php
/**
 * Cards English language file
 */

$english = array(

	/**
	 * Menu items and titles
	 */
	'embedlycards' => "Videos",
	'embedlycards:add' => "Add a video",
	'videos:add' => "Add a video",
	'embedlycards:edit' => "Edit video",
	'embedlycards:owner' => "%s's videos",
	'embedlycards:friends' => "Friends' videos",
	'embedlycards:everyone' => "All site videos",
	'videos:everyone' => "All site videos",
	'embedlycards:this:group' => "Video in %s",
	'embedlycards:cardlet:group' => "Get group videos",
	'embedlycards:inbox' => "videos inbox",
	'embedlycards:moreembedlycards' => "More videos",
	'embedlycards:more' => "More",
	'embedlycards:new' => "A new video",
	'embedlycards:address' => "Address of the video",
	'embedlycards:none' => 'No videos',

	

	'embedlycards:delete:confirm' => "Are you sure you want to delete this resource?",

	'embedlycards:numbertodisplay' => 'Number of videos to display',

	'embedlycards:shared' => "shared",
	'embedlycards:visit' => "Visit resource",
	'embedlycards:recent' => "Recent videos",

	'river:create:object:embedlycards' => '%s shared %s',
	'river:comment:object:embedlycards' => '%s commented on a video %s',
	'embedlycards:river:annotate' => 'a comment on this video',
	'embedlycards:river:item' => 'an item',

	'item:object:embedlycards' => 'videos',

	'embedlycards:group' => 'Group videos',
	'embedlycards:enableembedlycards' => 'Enable group videos',
	'embedlycards:nogroup' => 'This group does not have any video yet',
	'embedlycards:more' => 'More videos',

	'embedlycards:no_title' => 'No title',

	/**
	 * Widget 
	 */
	'embedlycards:widget:description' => "Display your latest videos.",

	/**
	 * Status messages
	 */

	'embedlycards:save:success' => "Your item was successfully shared.",
	'embedlycards:delete:success' => "Your video was deleted.",

	/**
	 * Error messages
	 */

	'embedlycards:save:failed' => "Your video could not be saved. Make sure you've entered a title and address and then try again.",
	'embedlycards:save:invalid' => "The address of the video is invalid and could not be saved.",
	'embedlycards:delete:failed' => "Your video could not be deleted. Please try again.",
);

add_translation('en', $english);