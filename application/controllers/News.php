<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Class News
* Контроллер реализует создание и показ новостей фирмы
*
*/

class News extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('news_model');
		$this->load->helper('url_helper');
	}
	
	/**
	* Вывод списка новостей
	*/
	
	public function index()
	{
		//добываем новости
		$data['news'] = $this->news_model->get_news();
		
		//показываем их
		$data['title'] = 'Архив новостей';
		
		$this->_render('news/index', $data);
		
		//$this->load->view('templates/header');
		//$this->load->view('templates/left');
		//$this->load->view('news/index', $data);
		//$this->load->view('templates/right');
		//$this->load->view('templates/footer');
	}
	
	/**
	* Вывод новости
	*/
	
	public function view($slug = NULL)
	{
		$data['news_item'] = $this->news_model->get_news($slug);
		
		if (empty($data['news_item']))
		{
			show_404();
		}
		
		$data['title'] = $data['news_item']['title'];
		
		$this->_render('news/view', $data);
		
		//$this->load->view('templates/header');
		//$this->load->view('templates/left');
		//$this->load->view('news/view', $data);
		//$this->load->view('templates/right');
		//$this->load->view('templates/footer');
	}
	
	/**
	* Создание новости
	*/
	
	public function create()
	{
		//если не работник магазина, не открываем страницу
		if (!($this->session->userdata('role_id') < '2')) 
		{
			show_404();
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['title'] = 'Создать новость';
		
		$this->form_validation->set_rules('title', 'Заголовок', 'required');
		
		$this->form_validation->set_rules('text', 'Текст', 'required');
		
		//$this->load->view('templates/header');
		//$this->load->view('templates/left');
		
		if ($this->form_validation->run() === FALSE)
		{	
			$this->_render('news/create', $data);
			//$this->load->view('news/create',$data);	
		}
		else
		{
			$this->news_model->set_news();
			$this->_render('news/success');
			//$this->load->view('news/success');
		}
		
		//$this->load->view('templates/right');
		//$this->load->view('templates/footer');
	}
		
}
?>