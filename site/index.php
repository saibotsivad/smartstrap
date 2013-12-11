<?php

 /**
 * smartstrap
 * @package smartstrap
 */

// The settings and configurations of SmartStrap are found in the file called "configs.php", this is
// only how it's turned into a configuration function within SmartStrap.

// Setting a config file one folder up from the smarty install will let you do a `git rebase` updating
// to the next version without worrying about the rebase modifying configuration details.
if (file_exists('../../smartstrap-configs.php')) {
	require('../../smartstrap-configs.php');
} else {
	require('../smartstrap-configs.php');
}

/**
 * Configuration controller. Handles the retrieval of site settings.
 *
 * @package smartstrap
*/
class ControlledSmartStrapConfig extends SmartStrapConfig {
	/**
	 * Returns an array containing all site details for a given domain and key.
	 *
	 * @param string $site The domain, e.g. 'smartstrap.com'
	*/
	public function info($setting = null, $site = null) {
		// Default to the HTTP host
		if ($site == null) {
			$site = $_SERVER['HTTP_HOST'];
		}

		// Check if the site exists
		if (!isset($this->site_list[$site])) {
			throw new Exception("The site '" . $site . "' is not configured!", 1);
		}

		// Use global settings, but overwrite them with the per-site settings, if they are set.
		$output = $this->global_configs;
		$output['site'] = $site;
		$output['baseurl'] = '//' . $site;
		foreach ($this->site_list[$site] as $key => $value) {
			$output[$key] = $value;
		}

		// Check if the (optional) key is set
		if ($key !== null && !isset($this->site_list[$site][$key])) {
			throw new Exception("The site '" . $site . "' is not configured with the setting '" . $key . "'!", 1);
		}

		if ($setting !== null) {
			$output = $output[$setting];
		}

		return $output;
	}
}
$smartstrap_config = new ControlledSmartStrapConfig();

/**
 * This is basically a helper function. Inside another function you can call it, instead of having to
 * declare the $smartstrap_config variable global.
*/
function smartstrap_info($key = null) {
	global $smartstrap_config;
	return $smartstrap_config->info($key);
}

/**
 * Some PHP installations don't set the default timezone, but we'll want it to
 * parse dates correctly, and Smarty requires it.
*/
if (function_exists('date_default_timezone_set')) {
	$timezone = smartstrap_info('timezone');
	date_default_timezone_set($timezone == null ? 'UTC' : $timezone);
}

/**
 * Overwrite the Smarty caching directory settings with a per-site location.
 *
 * @package smartstrap
*/
require(smartstrap_info('install_path') . '/smarty/Smarty.class.php');
class Smarty_Custom extends Smarty {
	function __construct()
	{
		parent::__construct();

		// smarty expects the template files (*.tpl) to be here
		$this->setTemplateDir(smartstrap_info('template_folder'));

		// the compiled templates are per domain
		$cache_path = smartstrap_info('install_path') . '/smarty/temp/' . smartstrap_info('site');
		$this->setCompileDir($cache_path . '/templates_c/');
		$this->setCacheDir($cache_path . '/cache/');

		$cache_length = smartstrap_info('caching');
		if ($cache_length === 0) {
			$this->caching = false;
		} else if ($cache_length < 0) {
			$this->caching = Smarty::CACHING_LIFETIME_CURRENT;
		} else if ($cache_length > 0) {
			$this->caching = $cache_length;
		}
	}
}
$smartstrap_smarty = new Smarty_Custom;

/**
 * Load the core functionality of SmartStrap.
*/
require(smartstrap_info('install_path') . '/smartstrap/smartstrap.php');
$smartstrap_core = new SmartStrapCore($_GET);

// If it's cached we can avoid costly file scans, but otherwise we'll need to generate template variables.
if (!$smartstrap_smarty->isCached($smartstrap_core->template(), $smartstrap_core->cache_id())) {

	require(smartstrap_info('install_path') . '/markdown/markdown.php');

	$vars = null;
	if (isset($_GET['feed'])) {
		$vars = $smartstrap_core->process_feed_variables($_GET);
	} else {
		$vars = $smartstrap_core->process_template_variables();
	}
	foreach ($vars as $key => $val) {
		$smartstrap_smarty->assign($key, $val);
	}

}

// finally
$smartstrap_smarty->display($smartstrap_core->template(), $smartstrap_core->cache_id());
