<?php

use LightnCandy\LightnCandy;

class Handlebars {
	protected $debug = false;
	protected $flags;
	protected $compiled_path = null;
	protected $plugins = null;

	public function __construct() {
		$this->debug = (DEBUG !== 'production');
		$this->flags = LightnCandy::FLAG_HANDLEBARS | LightnCandy::FLAG_BESTPERFORMANCE;
	}

	public function flags($flags) {
		/* set flags */
		$this->flags = $flags;

		/* chain-able */
		return $this;
	}

	public function debug($bool=true) {
		/* set debug mode */
		$this->debug = $bool;

		/* chain-able */
		return $this;
	}

	public function compiled_path($folder) {
		/* testing is writable in compile since we don't actually need to "write" when we change this */
		if (!realpath($folder)) {
			show_error(__METHOD__.' Cannot locate compiled handlebars folder "'.$folder.'"');
		}

		/* set this to the provided compiled location */
		$this->compiled_path = $folder;

		/* chain-able */
		return $this;
	}

	public function add_plugin($name,$plugin) {
		$this->plugins[$name] = $plugin;

		/* chain-able */
		return $this;
	}

	public function parse($view,$data=[],$return=false) {
		return $this->parse_string(get_instance()->load->view($view,[],true),$data,$return,$view);
	}

	public function parse_string($template,$data=[],$return=false,$template_name=null) {
		$compiled_file = $this->compiled_path.'/'.md5($template).'.php';

		/* compile if it's not there or is the mode true (non production) */
		if ($this->debug) {
			if (!$this->compile($template)) {
				$err = ($template_name) ? '"'.$template_name.'"' : 'string';
				show_error('Error compiling your handlebars template '.$err);
			}
		} elseif(!file_exists($compiled_file)) {
			show_error('Could not locate your compiled handlebars template');
		}

		$template_php = include $compiled_file;

		/* send data into the magic void... */
		$output = $template_php($data);

		if (!$return) {
			get_instance()->output->set_output($output);
		}

		return $output;
	}

	/* template file path */
	protected function compile($template) {
		if (!is_writable($this->compiled_path)) {
			show_error(__METHOD__.' Cannot write to folder "'.$this->compiled_path.'"');
		}

		/* compile it into a php magic! */
		$compiled_php = LightnCandy::compile($template,['flags'=>$this->flags,'helpers'=>$this->plugins]);

		return ($compiled_php) ? file_put_contents($this->compiled_path.'/'.md5($template).'.php','<?php '.$compiled_php.'?>') : false;
	}

} /* end class */