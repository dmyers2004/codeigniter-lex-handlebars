<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		$this->load->view('welcome_message');
	}

	protected function sample_data() {
		return [
			'title'     => 'Templates are Awesome!',
			'name'      => 'World',
			'real_name' => [
					'first' => 'Howard',
					'last'  => 'Doe',
			]
		];
	}

	public function lex() {
		$this->load->library('Lex');

		$data = $this->sample_data();

		$this->lex
			->add_plugin('lex.plugin',function($args,$content) {
				return 'foo="'.$args['foo'].'" name="'.$args['name'].'" nothing="'.$args['nothing'].'"';
			})
			->add_plugin('lex.switch',function($args,$content) {
				switch($args['mode']) {
					case 'lowercase':
						$content = strtolower($content);
					break;
					case 'uppercase':
						$content = strtoupper($content);
					break;
					case 'words':
						$content = ucwords($content);
					break;
					case 'first':
						$content = ucfirst($content);
					break;
				}

				return $content;
			});

		$this->lex->parse('lex_template',$data);
	}

	public function handlebars() {
		$this->load->library('Handlebars');

		$data = $this->sample_data();

		$this->handlebars
			->add_plugin('handle-plugin',function($options) {
				return 'foo="'.$options['hash']['foo'].'" name="'.$options['hash']['name'].'" nothing="'.$options['hash']['nothing'].'"';
			})
			->add_plugin('handle-switch',function($options) {
					$content = $options['fn']();
				
					switch($options['hash']['mode']) {
						case 'lowercase':
							$content = strtolower($content);
						break;
						case 'uppercase':
							$content = strtoupper($content);
						break;
						case 'words':
							$content = ucwords($content);
						break;
						case 'first':
							$content = ucfirst($content);
						break;
					}

				return $content;
			});

		$this->handlebars->compiled_path(APPPATH.'/views')->parse('handlebars_template',$data);
	}

} /* end controller */