<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Class Pages
* Контроллер реализует показ статических страниц
*
*/

class Pages extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function view($page = 'home')
	{
		if( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
		{
			//Упс, такой страницы нет!
			show_404();
		}
		
		$data['title'] = ucfirst($page); //Увеличиваем первую букву
		
		$this->_render('pages/'.$page, $data);
		
		//$this->load->view('templates/header');
		//$this->load->view('templates/left');
		//$this->load->view('pages/'.$page, $data);
		//$this->load->view('templates/right');
		//$this->load->view('templates/footer');
	}
}
?>