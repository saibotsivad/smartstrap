<?php

/**
 * This is where you put site-wide details.
 *
 * Change these to be whatever you want and add what
 * you need, they are basically global static variables.
 */
function info() {
	$vars = array(
		// the site title is what goes in the the "banner" title
		"site_title" => "SMARKDOWN",
		// used in the <header> block meta tag, and also used in the "banner" description
		"description" => "Demo site for the smarkdown framework thingy.",
		// this is what shows up in the browser title, it's appended/prepended by the page title
		"dom_title" => "SMARKDOWN",
		// this makes it like "My Site - Post Title"
		"dom_separator" => " - ",
		// this is the link to where you deploy this, aka "http://site.com", no trailing slash
		"link" => "http://localhost",
		// this is the folder where your markdown files go, a couple samples are included
		"content_folder" => "./content",
		// you can change the site wide date format here, although you might never use it
		"date_format" => "F j, Y"
	);
	return $vars;
}

/**
 * The basic settings are in the above config function. You should
 * change those if the changes are site-wide, but with this function
 * you can modify the variables for a single use case.
 *
 * , and you can change things like the site title by passing
 * in an array key/val pair (or pairs) with the new value (or values).
 */
function mod_info(array $mods = array()) {
	$info = info();
	// this overwrites and adds anything you want to the info variable.
	foreach ($mods as $key => $value) {
		$init[$key] = $value;
	}
	return $info;
}