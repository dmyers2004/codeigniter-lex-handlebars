<?php

class Lex {
	protected $plugins = [];

	public function parse($view,$data=[],$return=false) {
		$template = get_instance()->load->view($view,[],true);

		return $this->parse_string($template,$data,$return);
	}

	public function parse_string($template,$data=[],$return=false) {
		$parser = new Lex\Parser();

		$output = $parser->parse($template,$data,[$this,'callback']);

		if (!$return) {
			get_instance()->output->set_output($output);
		}

		return $output;
	}

	public function add_plugin($name,$plugin) {
		$this->plugins[$name] = $plugin;
		
		return $this;
	}

	public function callback($name,$attributes,$content) {
		if (!array_key_exists($name,$this->plugins)) {
			/* can't find a matching plugin */
			log_message('debug', __METHOD__.' cannot locate the plugin '.$name);

			return '';
		}

		return $this->plugins[$name]($attributes,$content);
	}

} /* end class */