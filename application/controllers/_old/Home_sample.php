<?php

class Home extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		//Подключение модели
		$this->load->model('Cart_model');
	}
	
	public function index()
	{
		//add this code
		$this->load->model('Cart_model');
		$data['query'] = $this->Cart_model->retrieve_products();
		$this->load->vars($data);
		//end of new code
		
		$this->load->view('templates/header');
		//$this->load->view('menu');
		$this->load->view('templates/left');
		$this->load->view('products/products', $data);
		$this->load->view('templates/right');
		$this->load->view('templates/footer');
	}
	
	public function get_All()
	{
		$this->load->model('Cart_model');
		$data['query'] = $this->Cart_model->retrieve_products();
		$this->load->view('cart/cart', $data);
	}
	
}

?>