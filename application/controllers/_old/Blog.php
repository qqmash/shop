<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('blog_model');
		$this->load->helper('url');
	}
	
	//retrieve all entry in db
	function index()
	{
		$this->load->helper('form');
		$this->load->library(array('form_validation', 'session'));
		
		//set validation rules
		$this->form_validation->set_rules('name', 'Заголовок', 'required|xss_clean|max_length[200]');
		$this->form_validation->set_rules('body', 'Тело', 'required|xss_clean');
		
		$this->load->view('templates/header');
		$this->load->view('templates/left');
			
		if ($this->form_validation->run() == FALSE)
		{
			//$this->load->view('blog/index');
			$this->load->view('blog/add_new_entry');
		}
		else
		{
			$name = $this->input->post('name');
			$body = $this->input->post('body');
			$this->blog_model->add_new_entry($name,$body);
			$this->session->set_flashdata('message', 'Добавлена 1 новая запись!');
			redirect('blog/add_new_entry');
		}
		
		$this->load->view('templates/right');
		$this->load->view('templates/footer');
	}
}