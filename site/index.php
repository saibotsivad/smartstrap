<?php
 /**
 * smarkdown
 * @package smarkdown
 */

/**
 * Settings and configs for the SmartStrap CMS are available via here.
 *
 * Anything in here is essentially a global variable, this is where you
 * configure most of SmartStrap.
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
		"base_url" => "http://smartstrap.dev",
		// this is the URL to the public template folder
		"template_url" => "http://smartstrap.dev/template",
		// install path for the SmartStrap CMS
		"install_path" => "../libs",
		// caching (turn off during development by setting to false)
		"caching" => false, // Smarty::CACHING_LIFETIME_CURRENT,
		// this is the folder where your markdown files go, a couple samples are included
		"content_folder" => "./content",
		// this is the folder where your template files go, like TPL/CSS/JS/etc files
		"template_folder" => "./template",
		// you can change the site wide date format here, although you might never use it
		"date_format" => "F j, Y"
	);
	return $key == null ? $vars : $vars[$key];
}

/**
 * Menu Bar configuration
 *
 * This will automatically add the class `active` to the correct item, and `odd` to every other.
*/
function menu_item_list() {
	$vars = array(
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
	);
	return $vars;
}

// if you need more complex things change these files
require(info('install_path') . '/smartstrap/template_variables.php');
require(info('install_path') . '/smartstrap/metadata.php');

// ===== NO NEED TO EDIT BELOW HERE =====

// the site uses Smarty for the templating
require(info('install_path') . '/smarty/Smarty.class.php');

// and markdown for the content
require(info('install_path') . '/markdown/markdown.php');

// set the timezone for the Markdown date conversion, this defaults to UTC unless overridden in the info.php
if (function_exists('date_default_timezone_set')) {
	$timezone = info('timezone');
	date_default_timezone_set($timezone == null ? 'UTC' : $timezone);
}

// overwrite the Smarty directory settings
class Smarty_Custom extends Smarty {
	function __construct()
	{
		parent::__construct();

		// smarty expects the template files (*.tpl) to be here
		$this->setTemplateDir(info('template_folder'));

		// the compiled templates
		$this->setCompileDir(info('install_path') . '/smartstrap/temp/templates_c/');
		$this->setCacheDir(info('install_path') . '/smartstrap/temp/cache/');

		// for local testing, set this to false to turn
		// off caching, but in production caching will
		// make you able to handle serious loads pretty well
		$this->caching = info('caching');
	}
}
$smarty = new Smarty_Custom;

// set template variables by this function, it is where
// the majority of the work happens
$vars = get_template_variables($_GET);
foreach ($vars as $key => $val) {
	$smarty->assign($key, $val);
}

// display the template, the template file name is
// set by the above function
$smarty->display($vars['template']);