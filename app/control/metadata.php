<?php

function parse_metadata($string) {
	$var = array();

	// parse metadata
	$content = preg_split("/[\r\n]+-+[\r\n]+/", $string, 2);
	if (count($content) === 2) {
		$lines = preg_split("/[\r\n]/", $content[0]);
		$metadata = array();
		foreach ($lines as $line) {
			if (strlen($line) > 0) {
				$data = explode(":", $line, 2);
				if (count($data) === 2) {
					$metadata[$data[0]] = $data[1];
				}
			}
		}
		$var['metadata'] = $metadata;
	}

	// parse the markdown content
	if (count($content) > 0) {
		$var['html'] = Markdown($content[count($content) - 1]);
	}

	// include the plaintext for possible downstream use
	$var['plaintext'] = $string;

	return $var;
}

