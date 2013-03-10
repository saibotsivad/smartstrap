<?php

/**
 * This is how I propose to create menus. For simple sites it
 * might be easier to actually write the menus hard coded into
 * the template, but this approach gives you a simple way to
 * set a menu item as "active".
 */
function menu(array $url) {
	// the following is an example of use

	// For example, suppose we have two menu items, an "about" page
	// and a "how to" page, we could do a simple URL lookup to see
	// which menu item is active. Of course, more complex logic is
	// possible, but for simple sites it is probably not necessary.
	$vars = array(
		array(
			"class" => (isset($url[0]) && $url[0] == 'about' ? "active" : ""),
			"link" => "about",
			"name" => "About"
		),
		array(
			"class" => (isset($url[0]) && $url[0] == 'howto' ? "active" : ""),
			"link" => "howto",
			"name" => "How To"
		)
	);
	return $vars;
}