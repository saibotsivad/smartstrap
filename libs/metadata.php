<?php

if (!file_exists('./cache/compiled_markdown_metadata.php')) {
	compile_markdown_files_metadata('./content', './cache/compiled_markdown_metadata.php');
}
require('./cache/compiled_markdown_metadata.php');

function get_file_path($input = null) {
	$path = './content/index.md';
	if ($input != null) {
		preg_match('/(\w+)\/(\d{4})\/(\d{2})\/(\d{2})\/(.*)$/', $input, $group);
		if (!empty($group)) {
			$path = './content/' . $group[1] . '/' . $group[2] . '-' . $group[3] . '-' . $group[4] . '_' . preg_replace('/[^A-Za-z0-9._-]/', '-', $group[5]) . '.md';
		} else {
			$clean_path = array();
			$dirty_path = explode('/', rtrim($input, '/'));
			foreach ($dirty_path as $value) {
				$clean_path[] = preg_replace('/[^A-Za-z0-9._-]/', '-', $value);
			}
			$path = './content/' . implode('/', $clean_path) . '.md';
		}
	}

	if (!file_exists($path)) {
		header('HTTP/1.0 404 Not Found');
		$path = './content/404.md';
	}

	return $path;
}

function parse_file($file) {
	$content = preg_split("/[\r\n]+-+[\r\n]+/", file_get_contents($file), 2);

	$vars = array();
	$vars['content'] = Markdown($content[count($content) - 1]);
	foreach (preg_split("/[\r\n]/", $content[0]) as $line) {
		if (strlen($line) > 0) {
			$data = explode(":", $line, 2);
			if (count($data) === 2) {
				$vars[trim($data[0])] = trim($data[1]);
			}
		}
	}
	return $vars;
}

function file_list($folder) {
	$file_list = array();

	$files = scandir($folder);
	foreach ($files as $file) {
		// markdown files in this directory
		if (!is_dir($file) && substr($file, -strlen('.md')) === '.md') {
			$file_list[] = $folder . '/' . $file;
		}
		// look into the deeper directories
		if (is_dir($folder . '/' . $file) && $file != '.' && $file != '..') {
			$more_files = file_list($folder . '/' . $file);
			foreach ($more_files as $more_file) {
				$file_list[] = $more_file;
			}
		}
	}

	return $file_list;
}

function generate_link($file) {
	// inside either `./content` or `./content/FOLDER`
	//  YYYY-MM-DD_PAGETITLE.md  |  PAGETITLE.md
	preg_match('/\.\/content\/(?:(\w+)\/)?(?:(\d{4})-(\d{2})-(\d{2})_(.*?)\.md|(.*?)\.md)$/', $file, $group);
	$path_list = array();
	for ($i=1; $i < count($group); $i++) {
		if ($group[$i] !== '') {
			$path_list[] = $group[$i];
		}
	}
	return '/' . implode("/", $path_list);
}

function date_compare($a, $b) {
    $t1 = strtotime($a['date']);
    $t2 = strtotime($b['date']);
    return $t1 - $t2;
}

function compile_markdown_files_metadata($folder, $output_file) {
	$data = array();
	foreach (file_list($folder) as $file) {
		$data[$file] = parse_file($file);
		$data[$file]['link'] = generate_link($file);
		unset($data[$file]['content']);
	}
	usort($data, 'date_compare');


$data_before = <<<EOT
<?php
/*
===== This file is auto-generated. It contains the compiled metadata from the markdown. =====
*/

function compiled_metadata(\$file = null) {
\$data = 
EOT;

$data_after = <<<EOT
;
	if (\$file == null || !isset(\$data[\$file])) {
		return \$data;
	} else {
		return \$data[\$file];
	}
}
EOT;

	$complete_data = $data_before . var_export($data, true) . $data_after;

	$file_handle = fopen($output_file, "w");
	if ($file_handle == false) {
		die('Could not open compiled file to write.');
	}
	if (!fwrite($file_handle, $complete_data)) {
		die('Could not write to file');
	}
}
