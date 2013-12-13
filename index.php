<?php

// THESE ARE THE THINGS TO CHANGE, THEY ARE JUST USED IN THE TEMPLATE
$info = array(
	'title' => 'SmartStrap',
	'description' => 'Simple and enjoyable blogging.',
	'menu_list' => array('Archived Content' => '/archive') // array( TITLE => LINK )
);

date_default_timezone_set('UTC');

require('./libs/smarty/Smarty.class.php');
require('./libs/markdown.php');
require('./libs/metadata.php');

$smarty = new Smarty;
$smarty->setTemplateDir('./template/');
$smarty->setCompileDir('./cache/templates_c/');
$smarty->setCacheDir('./cache/cache/');

$vars = parse_file(get_file_path($_GET['path']));
$vars['info'] = $info;
$vars['info']['url'] = 'http://' . $_SERVER["SERVER_NAME"];
$vars['files'] = compiled_metadata();
foreach ($vars as $key => $value) {
	$smarty->assign($key, $value);
}

if (isset($_GET['feed']) && $_GET['feed'] == 'rss') {
	header("Content-type: application/rss+xml");
	$vars['xml_header'] = '<?xml version="1.0" encoding="utf-8"?>';
	$smarty->display('rss.tpl');
} else {
	$smarty->display('index.tpl');
}
