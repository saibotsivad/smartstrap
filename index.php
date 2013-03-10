<?php
 /**
 * smarkdown
 * @package smarkdown
 */

// the basic setup, for most sites you should be able to
// change the settings in here
require('./app/control/info.php');

// but if you need more complex things change these
require('./app/control/menu.php');
require('./app/control/template_variables.php');
require('./app/control/metadata.php');

// the site uses Smarty for the templating
require('./libs/smarty/Smarty.class.php');

// and markdown for the content
require('./libs/markdown/markdown.php');

// overwrite the Smarty directory settings
class Smarty_Custom extends Smarty {
	function __construct()
	{
		parent::__construct();

		// smarty expects the template files (*.tpl) to be here
		$this->setTemplateDir('./app/templates/');

		// the cached and compiled output goes in
		// these, thus the gitignore
		$this->setCompileDir('./temp/templates_c/');
		$this->setCacheDir('./temp/cache/');

		// for local testing, set this to false to turn
		// off caching, but in production caching will
		// make you able to handle serious loads pretty well
		$this->caching = false;//Smarty::CACHING_LIFETIME_CURRENT;
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