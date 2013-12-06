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
			// this is the file-system location
			"content_folder" => "../content/smartstrap.tobiaslabs.com/",
			// this is the file-system location
			"template_folder" => "../templates/default/"
		)
	);
	
	// these are global configurations that can be overwritten by setting them in the per-site configs
	public $global_configs = array(
		"install_path" => "../libs",
		// caching (turn off during development by setting to false)
		"caching" => false // Smarty::CACHING_LIFETIME_CURRENT
	);

	// combines the site_list and global_configs, overwriting the global with the site if there are dupes
	public function site($site) {
		$output = $this->global_configs;
		$output['site'] = $site;
		foreach ($this->site_list[$site] as $key => $value) {
			$output[$key] = $value;
		}
		return $output;
	}
}
