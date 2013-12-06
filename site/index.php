<?php
 /**
 * smartstrap
 * @package smartstrap
 */

// The settings and configurations of SmartStrap are found in the file called "configs.php", this is
// only how it's turned into a configuration function within SmartStrap.

// up one folder is the default configs file, but if you use the suggested layout you can have your cake and eat it too!
if (file_exists('../../smartstrap-configs.php')) {
	require('../../smartstrap-configs.php');
} else {
	require('../smartstrap-configs.php');
}

$smartstrap_configuration = new SmartStrapConfig();
$smartstrap_configuration_site = $smartstrap_configuration->site($_SERVER['HTTP_HOST']);
function info($key = null) {
	global $smartstrap_configuration_site;
	return $key == null ? $smartstrap_configuration_site : $smartstrap_configuration_site[$key];
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

if (function_exists('date_default_timezone_set')) {
	$timezone = info('timezone');
	date_default_timezone_set($timezone == null ? 'UTC' : $timezone);
}

// if you need more complex things change these files
require(info('install_path') . '/smartstrap/template_variables.php');
require(info('install_path') . '/smartstrap/feed.php');
require(info('install_path') . '/smartstrap/metadata.php');
// the site uses Smarty for the templating
require(info('install_path') . '/smarty/Smarty.class.php');
// markdown for the content
require(info('install_path') . '/markdown/markdown.php');

// overwrite the Smarty directory settings
class Smarty_Custom extends Smarty {
	function __construct()
	{
		parent::__construct();

		// smarty expects the template files (*.tpl) to be here
		$this->setTemplateDir(info('template_folder'));

		// the compiled templates are per domain
		$this->setCompileDir(info('install_path') . '/smarty/temp/' . info('site') . '/templates_c/');
		$this->setCacheDir(info('install_path') . '/smarty/temp/' . info('site') . '/cache/');

		$cache_length = info('caching');
		if ($cache_length === 0) {
			$this->caching = false;
		} else if ($cache_length < 0) {
			$this->caching = Smarty::CACHING_LIFETIME_CURRENT;
		} else if ($cache_length > 0) {
			$this->caching = $cache_length;
		}
	}
}
$smarty = new Smarty_Custom;

// we intercept for feed requests to use a built in template
$vars = null;
if (isset($_GET['feed'])) {
	$vars = get_feed_variables($_GET);
} else {
	// set template variables by this function, it is where
	// the majority of the work happens
	$vars = get_template_variables($_GET);
}
foreach ($vars as $key => $val) {
	$smarty->assign($key, $val);
}

// display the template, the template file name is
// set by the above function
$smarty->display($vars['template']);