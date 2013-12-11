<?php

/**
 * Core controller class for SmartStrap.
 *
 * @package smartstrap
*/
class SmartStrapCore {
	private $get_params = array();
	private $path = null;
	private $cache_id = null;
	private $template = null;
	private $markdown_file = null;

	/**
	 * Given a bunch of parameters, define the template and cache id for Smarty. The .htaccess
	 * rules rewrite 'site.com/path?key=var' to 'site.com/?smartstrap=path&key=var'
	 *
	 * @param array $get  this is basically just the $_GET variable
	*/
	public function __construct(array $get = null) {
		if ($get !== null && !empty($get)) {
			$this->get_params = $get;

			if (isset($get['smartstrap'])) {
				if (is_array($get['smartstrap'])) {
					$this->path = implode('/', $get['smartstrap']);
				} else {
					$this->path = $get['smartstrap'];
				}
			}

			$get_list = array();
			foreach ($get as $key => $value) {
				if (is_array($get[$key])) {
					$get_list[] = $key . '=' . implode(',', $get[$key]);
				} else {
					$get_list[] = $key . '=' . $get[$key];
				}
			}
			$this->cache_id = implode('&', $get_list);
		}

		// check for a markdown file at the specified path
		if ($this->path == null || $this->path == '') {
			$this->markdown_file = "index";
		} else {
			$this->markdown_file = $this->path;
		}
		$this->markdown_file = $this->find_file(smartstrap_info('content_folder'), $this->markdown_file, '.md');

		// as a last resort, look for the 404 file
		if ($this->markdown_file == null && $this->find_file(smartstrap_info('content_folder'), '404', '.md') != null) {
			$this->markdown_file = '404.md';
		}
	}

	/**
	 * Public read only accessor.
	*/
	public function parameters() {
		return $this->get_params;
	}

	/**
	 * Public read only accessor.
	*/
	public function path() {
		return $this->path;
	}

	/**
	 * Public read only accessor.
	*/
	public function cache_id() {
		return $this->cache_id;
	}

	/**
	 * Public read only accessor.
	*/
	public function markdown_file() {
		return $this->markdown_file;
	}

	/**
	 * Return the path to the chosen template.
	*/
	public function template() {
		if ($this->template == null) {

			// check for the existence of a specified template file
			if (isset($this->get_params['feed'])) {
				// for feeds we'll use the feed templates
				$feed_type =  ($get['feed'] == '' || !in_array($get['feed'], array('rss', 'atom', 'json', 'jsonp'))) ? 'rss' : $get['feed'];
				$this->template = 'feeds/' . $this->get_params['feed'] . '.tpl';

			} else {
				if ($this->path == null || $this->path == '') {
					$this->template = 'index.tpl';
				} else {
					// attempt to get template by GET parameters, so 'site.com/path' will look for 'path.tpl'
					$this->template = $this->find_file(smartstrap_info('template_folder'), $this->path, '.tpl');

					if ($this->template == null) {
						$this->template = 'post.tpl';
					}
				}
			}

			if ($this->template == null || $this->markdown_file == null) {
				header('HTTP/1.0 404 Not Found');
				$this->template = '404.tpl';
			}

		}
		return $this->template;
	}

	/**
	 * Returns an array of variables from the markdown file specified in the path.
	*/
	function process_template_variables() {

		// basic page information
		$vars = array(
			'info' => smartstrap_info(),
			'menu_list' => $this->fix_menu_item_list(smartstrap_info('menu_list'), $this->path)
		);

		// get file and process
		if ($this->markdown_file != null) {
			$filename = $this->find_file(smartstrap_info('content_folder'), $this->markdown_file);
			if ($filename !== null) {
				$contents = $this->parse_file(smartstrap_info('content_folder') . '/' . $filename);
				$vars['content'] = $contents['html'];
				foreach ($contents['metadata'] as $key => $value) {
					// note: this will overwrite any pre-existing values
					$vars[$key] = $value;
				}
				if (isset($vars['title'])) {
					$vars['info']['dom_title'] = smartstrap_info('dom_title') . smartstrap_info('dom_separator') . smartstrap_info('title');
				}
			}
		}

		// special case: formatting the date
		if (isset($vars['metadata']['date']) && isset($vars['date'])) {
			$vars['metadata']['date'] = '<br /><small>'. date($info['date_format'], strtotime($vars['date'])) .'</small>';
		} else {
			$vars['date'] = '';
		}

		return $vars;
	}

	/**
	 * Things that happen:
	 *
	 *   - check and add `active` to active menu item
	 *   - add `odd` to every other row
	 *   - change links to absolute
	*/
	function fix_menu_item_list($menu_item_list, $url) {
		if (!is_array($url)) {
			$url = explode('/', rtrim($url, '/'));
		}

		$result_set = array();
		$even_or_odd = 0;
		foreach ($menu_item_list as $menu_item) {
			$class_list = array();
			if (isset($menu_item['class'])) {
				if (is_array($menu_item['class'])) {
					$class_list = $menu_item['class'];
				}
			}

			if ($even_or_odd % 2 > 0) {
				$class_list[] = 'odd';
			}
			$even_or_odd++;

			if ($menu_item['link'] == '/' . $url[0]) {
				$class_list[] = 'active';

				if (sizeof($url) > 0 && isset($menu_item['children'])) {
					$menu_item['children'] = $this->fix_menu_item_list($menu_item['children'], array_slice($url, 1));
				}
			}

			if (count($class_list) > 0) {
				$menu_item['class'] = implode(" ", $class_list);
			}

			$result_set[] = $menu_item;
		}

		return $result_set;
	}

	/**
	 * Concatenates an array to a string, making those array elements filename safe by
	 * replacing all non acceptable characters with a dash character. If a file exists at
	 * that location it returns the full path, otherwise it returns null.
	 *
	 * @param string  $base       folder to being search in
	 * @param array   $location   folder depth array
	 * @param string  $extension  file extension to look for (e.g. '.tpl' or '.md')
	 */
	public function find_file($base, $location, $extension = '') {
		$cleaned_path = array();

		if (!is_array($location)) {
			$location = explode('/', rtrim($location, '/'));
		}

		foreach ($location as $value) {
			$cleaned_path[] = preg_replace('/[^A-Za-z0-9._-]/', '-', $value);
		}

		$file = implode('/', $cleaned_path) . $extension;
		if (!file_exists($base . '/' . $file)) {
			$file = null;
		}
		return $file;
	}

	/**
	 * For a file, get the contents and return an array
	 * with the metadata and markdown text.
	 */
	function parse_file($filename) {
		// get file contents
		$text = file_get_contents($filename);

		// parse the file for markdown and metadata
		$content = $this->parse_metadata($text);

		$content['filename'] = $filename;
		return $content;
	}

	/**
	 * Parse the metadata and text from a markdown file.
	*/
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

	/**
	 * Generate the variablse for the feed. This involves scanning a directory for files, and
	 * generating all the data from each one.
	*/
	public function process_feed_variables(array $get) {
		$feed_type =  ($get['feed'] == '' || !in_array($get['feed'], array('rss', 'atom', 'json', 'jsonp'))) ? 'rss' : $get['feed'];

		$vars = array(
			"info" => smartstrap_info(),
			"template" => $feed_type
		);

		foreach ($this->file_list(smartstrap_info('content_folder')) as $file) {
			$vars['content_list'][] = $this->parse_file($file);
		}

		$vars['content_list'] = $this->sort_feed_list($vars['content_list']);

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

	/**
	 * Sort the feed list by date.
	*/
	public function sort_feed_list(array $feed_list) {
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
			$url = 'http:' . smartstrap_info('baseurl') . substr($var['filename'], strlen(smartstrap_info('content_folder')));
			if (preg_match('/\.\w+$/', $url, $matches)) {
				$url = substr($url, 0, strlen($url) - strlen($matches[0]));
			}
			$var['link'] = $url;
			$sorted_list[] = $var;
		}

		return $sorted_list;
	}

	/**
	 * Returns an array of all markdown files in a folder, searches recursively.
	 */
	public function file_list($folder) {
		$file_list = array();

		$files = scandir($folder);
		foreach ($files as $file) {
			// markdown files in this directory
			if (!is_dir($file) && substr($file, -strlen('.md')) === '.md') {
				$file_list[] = $folder . '/' . $file;
			}
			// look into the deeper directories
			if (is_dir($folder . '/' . $file) && $file != '.' && $file != '..') {
				$more_files = $this->file_list($folder . '/' . $file);
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
	public function file_content_list($base, array $files) {
		$data = array();

		foreach ($files as $file) {
			$content = parse_file($file);
			$content['metadata']['url'] = substr($file, strlen($base) + 1, -3);
			$data[] = $content['metadata'];
		}

		return $data;
	}
}
