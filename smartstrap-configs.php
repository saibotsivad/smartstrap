<?php
 /**
 * smartstrap
 * @package smartstrap
 */

/**
 * Settings and configs for the SmartStrap CMS are available via here.
 *
 * Anything in here is essentially a global variable, this is where you
 * configure most of SmartStrap.
*/
class SmartStrapConfig {
	public $site_list = array(
		// each site is an array of variables, with the base URL as the key
		'smartstrap.dev' => array(
			// the site title is what goes in the the "banner" title
			"site_title" => "SMARTSTRAP",
			// used in the <header> block meta tag, the RSS/Atom feeds, and the "banner" description
			"description" => "Demo site for the smartstrap framework thingy.",
			// this is what shows up in the browser title, it's appended/prepended by the page title
			"dom_title" => "SMARTSTRAP",
			// this makes it like "My Site - Post Title"
			"dom_separator" => " - ",
			// you can change the site wide date format here, although you might never use this
			"date_format" => "F j, Y",
			// this is the menu bar configuration, there's a name and a link per, and then children are possible
			"menu_list" => array(
				array(
					"link" => "about",
					"name" => "About"
				),
				array(
					"link" => "howto",
					"name" => "How To",
					"children" => array(
						array(
							"link" => "menu",
							"name" => "Menu Bar"
						)
					)
				)
			)

		)
	);
	
	// ===== YOU SHOULDN'T NEED TO EDIT BELOW HERE =====

	// these are global configurations that can be overwritten by setting them in the per-site configs
	public $global_configs = array(
		"content_folder" => "./content",
		"template_folder" => "./template",
		"install_path" => "../libs",
		// use 0 for no caching, -1 for infinite caching, and any positive value for number of seconds
		"caching" => 100
	);

	// combines the site_list and global_configs, overwriting the global with the site if there are dupes
	public function site($site) {
		$output = $this->global_configs;
		$output['site'] = $site;
		$output['baseurl'] = '//' . $site;
		foreach ($this->site_list[$site] as $key => $value) {
			$output[$key] = $value;
		}
		return $output;
	}
}
