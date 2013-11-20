<?php

function get_template_variables(array $get) {

	// based on the URL, get the item or item list
	$url = empty($get) ? array() : explode("/", rtrim($get["params"], "/"));
	$url_size = count($url);

	// basic page information
	$info = info();
	$vars = array(
		"info" => $info,
		"menus" => fix_menu_item_list(menu_item_list(), $url)
	);

	// if a URL subfolder is specified, try to get the content
	// from that markdown file
	if (count($url) >= 1) {

		// try and find the file specified by the URL
		$filename = find_file($info['content_folder'], $url);
		if ($filename !== null) {
			$contents = parse_file($filename);
			$vars['content'] = $contents['html'];
			foreach ($contents['metadata'] as $key => $value) {
				// note: this will overwrite any pre-existing values
				$vars[$key] = $value;
			}
			if (isset($vars['title'])) {
				$info['dom_title'] = $info['dom_title'] . $info['dom_separator'] . $vars['title'];
			}
			$vars['template'] = "post.tpl";
		} else {
			// if no markdown file was found, there's not much to do but 404
			header("HTTP/1.0 404 Not Found");
			$vars['template'] = "404.tpl";
		}

	// if no subfolder is specified in the URL, we'll
	// load the main page
	} else {

		// if it exists, include index.md from the root folder
		$filename = find_file($info['content_folder'], array("index"));
		if ($filename !== null) {
			$contents = parse_file($filename);
			$vars['content'] = $contents['html'];
			foreach ($contents['metadata'] as $key => $value) {
				// note: this will overwrite any pre-existing values
				$vars[$key] = $value;
			}
		}

		$vars['template'] = "index.tpl";
	}

	// special case: formatting the date
	if (isset($vars['date'])) {
		$vars['date'] = "<br /><small>". date($info['date_format'], strtotime($vars['date'])) ."</small>";
	} else {
		$vars['date'] = "";
	}

	return $vars;
}

/**
 * Concatenates an array to a string, making those array elements filename safe by
 * replacing all non acceptable characters with a dash character. If a file exists at
 * that location it returns the full path, otherwise it returns null.
 *
 * Acceptable characters: [A-za-z0-9._-]
 */
function find_file($base, array $location) {
	// concatenate
	foreach ($location as $value) {
		$base = $base . "/" . preg_replace("/[^A-Za-z0-9._-]/", "-", $value);
	}
	// add .md
	$base = $base . ".md";
	if (file_exists($base)) {
		return $base;
	}
	return null;
}

/**
 * For a file, get the contents and return an array
 * with the metadata and markdown text.
 */
function parse_file($filename) {
	// get file contents
	$text = file_get_contents($filename);

	// parse the file for markdown and metadata
	$content = parse_metadata($text);

	return $content;
}

/**
 * Returns an array of all markdown files in a folder, searches recursively.
 */
function file_list($folder) {
	$file_list = array();

	$files = scandir($folder);
	foreach ($files as $file) {
		// markdown files in this directory
		if (!is_dir($file) && substr($file, -strlen(".md")) === ".md") {
			$file_list[] = $folder . "/" . $file;
		}
		// look into the deeper directories
		if (is_dir($folder . "/" . $file) && $file != "." && $file != "..") {
			$more_files = file_list($folder . "/" . $file);
			foreach ($more_files as $more_file) {
				$file_list[] = $more_file;
			}
		}
	}

	return $file_list;
}

/**
 * For a list of files, get the metadata for each and return as an array.
 */
function file_content_list($base, array $files) {
	$data = array();

	foreach ($files as $file) {
		$content = parse_file($file);
		$content['metadata']['url'] = substr($file, strlen($base) + 1, -3);
		$data[] = $content['metadata'];
	}

	return $data;
}

/**
 * Things that happen:
 *
 *   - check and add `active` to active menu item
 *   - add `odd` to every other row
 *   - change links to absolute
*/
function fix_menu_item_list($menu_item_list, array $url) {
	$result_set = array();
	$even_or_odd = 0;
	foreach ($menu_item_list as $menu_item) {
		if ($even_or_odd % 2 > 0) {
			$menu_item['class'] = "odd";
		}
		$even_or_odd++;

		if ($menu_item['link'] == $url[0]) {
			$menu_item['class'] = $menu_item['class'] . " active";

			if (sizeof($url) > 0 && $menu_item['children']) {
				$menu_item['children'] = fix_menu_item_list($menu_item['children'], array_slice($url, 1));
			}
		}

		$menu_item['link'] = info('base_url') . "/" . $menu_item['link'];

		$result_set[] = $menu_item;
	}
	return $result_set;
}