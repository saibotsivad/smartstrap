<?php

/**
 * Settings and configs for the SmartStrap CMS.
 *
 * Anything in here is essentially a global variable, so this is where you
 * configure most of SmartStrap.
 *
 * @package smartstrap
*/
class SmartStrapConfig {
	/**
	 * The settings are an array of key=>value objects, with a single array per site. E.g.,
	 *
	 * site.com => array( key1 => value1, key2 => value2)
	 *
	 * The expected values for each site, for the default Smartstrap install, are:
	 *
	 * - site_title     string   it's what is used in the displayed banner at the top of the page
	 * - dom_title      string   used in the title bar of the browser itself
	 * - dom_separator  string   the thing between the title and the post, so " - " looks like "MySite - MyPost"
	 * - date_format    string   the desired date output of posts with dates in them, refer to http://php.net/manual/en/function.date.php
	 * - menu_list      array    see below
	 *
	 * The menu settings are pretty rudimentary, it's just an array of markdown files links, and
	 * pretty names. You can also define child elements of menus. The expected values per menu are:
	 *
	 * - link       string   the link, which is from the domain root, aka "/path" for "site.com" will output "site.com/path"
	 * - name       string   the text displayed
	 * - class      array    (optional) a flat list of classes to add to the element
	 * - children   array    (optional) child menu elements
	 *
	 * For child menu elements, simply add an array inside that menu item's array, called "children", e.g.
	 *
	 * "menu_list" => array(
	 *      array( "link" => "/parent1", "name" => "Parent1 Name", "class" => array("first", "second") ),
	 *      array( "link" => "/parent2", "name" => "Parent2 Name", "children" => array(
	 *          array( "link" => "/parent2/child", "name" => "Child Name" ))))
	 *
	*/
	protected $site_list = array(
		'smartstrap.dev' => array(
			"site_title" => "SMARTSTRAP",
			"description" => "Demo site for the smartstrap framework thingy.",
			"dom_title" => "SMARTSTRAP",
			"dom_separator" => " - ",
			"date_format" => "F j, Y",
			"menu_list" => array(
				array( "link" => "/about", "name" => "About" ),
				array( "link" => "/howto", "name" => "How To", "children" => array(
					array("link" => "/howto/menu",	"name" => "Menu Bar")))
			)
		)
	);
	
	// ===== YOU PROBABLY DON'T NEED TO EDIT BELOW HERE =====

	/**
	 * These global configurations are overwritten by setting them in the per-site settings.
	*/
	protected $global_configs = array(
		"content_folder" => "./content",
		"template_folder" => "./template",
		"install_path" => "../libs",
		// use 0 for no caching, -1 for infinite caching, and any positive value for number of seconds
		"caching" => 100
	);
}





