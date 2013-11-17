<?php

/**
 * This is where you put site-wide details.
 *
 * Change these to be whatever you want and add what you need, these are
 * basically global static variables wrapped in a nice little function.
 */
function info($key = null) {
	$vars = array(
		// the site title is what goes in the the "banner" title
		"site_title" => "SMARTSTRAP",
		// used in the <header> block meta tag, and also used in the "banner" description
		"description" => "Demo site for the smartstrap framework thingy.",
		// this is what shows up in the browser title, it's appended/prepended by the page title
		"dom_title" => "SMARTSTRAP",
		// this makes it like "My Site - Post Title"
		"dom_separator" => " - ",
		// this is the link to where you deploy this, aka "http://site.com", no trailing slash
		"link" => "http://smartstrap.dev",
		// this is the folder where your markdown files go, a couple samples are included
		"content_folder" => "./public/content",
		// you can change the site wide date format here, although you might never use it
		"date_format" => "F j, Y"
	);

	return $key == null ? $vars : $vars[$key];
}