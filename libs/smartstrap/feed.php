<?php

function get_feed_variables(array $get) {
	$feed_type =  ($get['feed'] == '' || !in_array($get['feed'], array('rss', 'atom', 'json', 'jsonp'))) ? 'rss' : $get['feed'];

	$vars = array(
		"info" => info(),
		"template" => $feed_type
	);

	foreach (file_list(info('content_folder')) as $file) {
		$vars['content_list'][] = parse_file($file);
	}

	$vars['content_list'] = sort_feed_list($vars['content_list']);

	if (isset($vars['content_list'][0]) && isset($vars['content_list'][0]['metadata']) && isset($vars['content_list'][0]['metadata']['date'])) {
		$vars['latest_date'] = $vars['content_list'][0]['metadata']['date'];
	} else {
		$vars['latest_date'] = date();
	}

	if (isset($vars['content_list'][count($vars['content_list']) - 1])) {
		$last_item = $vars['content_list'][count($vars['content_list']) - 1];
		if (isset($last_item['metadata']) && isset($last_item['metadata']['date'])) {
			$vars['earliest_date'] = $last_item['metadata']['date'];
		} else {
			$vars['earliest_date'] = date();
		}
	} else {
		$vars['earliest_date'] = date();
	}

	// special case for json, we can hand this to Smarty so it gets properly cached as well
	if ($feed_type == 'jsonp') {
		if (isset($_GET['callback']) && $_GET['callback'] != '') {
			header("Content-type: application/javascript");
			$vars['callback'] = $_GET['callback'];
			$vars['content'] = json_encode($vars['content_list']);
			unset($vars['content_list']);
			// we'll handle the callback in the Smarty template, it helps caching
			$vars['template'] = 'json';
		} else {
			die('Please provide a callback on GET[\'callback\']');
		}
	} else if ($feed_type == 'json') {
		header("Content-type: application/json");
		$vars['content'] = json_encode($vars['content_list']);
		unset($vars['content_list']);
	} else {
		// header("Content-type: text/xml");
		header("Content-type: application/" . $feed_type . "+xml");
		$vars['xml_header'] = '<?xml version="1.0" encoding="utf-8"?>';
	}

	$vars['template'] = 'feeds/' . $vars['template'] . '.tpl';
	return $vars;
}

function sort_feed_list(array $feed_list) {
	$item_list = array();
	foreach ($feed_list as $item) {
		if (isset($item['metadata']) && isset($item['metadata']['date'])) {
			// NOTE: This means dates must be unique!
			$item_list[$item['metadata']['date']] = $item;
		}
	}
	arsort($item_list);

	$sorted_list = array();
	foreach ($item_list as $key => $var) {
		$var['link'] = generate_link_from_filename($var['filename']);
		$sorted_list[] = $var;
	}

	return $sorted_list;
}

function generate_link_from_filename($filename) {
	$url = info('base_url') . substr($filename, strlen(info('content_folder')));
	if (preg_match('/\.\w+$/', $url, $matches)) {
		$url = substr($url, 0, strlen($url) - strlen($matches[0]));
	}
	return $url;
}