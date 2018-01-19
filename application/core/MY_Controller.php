<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Class MY_Controller
* Контроллер реализует генерацию страниц и работу с данными пользователя
*
*/

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		//загружаем модели, которые будут на каждой странице
		$this->load->model('cart_model');
		$this->load->model('news_model');
	}
	
	/**
	* Отрисовываем страницу
	*/
	
	final public function _render($view = 'content', $data = array())
	{
		
		//$menu['top'] = $this->menu_model->get_top_menu();
		//$menu['cats'] = $this->category_model->get_list();
		
		//загружаем категории товаров
		$menu['category'] = $this->cart_model->retrieve_categories();
		
		$menu['nouts'] = $this->cart_model->retrieve_categories_by_parent(1);
		$menu['complect'] = $this->cart_model->retrieve_categories_by_parent(2);
		$menu['tech'] = $this->cart_model->retrieve_categories_by_parent(3);
		$menu['audio'] = $this->cart_model->retrieve_categories_by_parent(4);
		$menu['office'] = $this->cart_model->retrieve_categories_by_parent(5);
		$menu['net'] = $this->cart_model->retrieve_categories_by_parent(6);
		$menu['phones'] = $this->cart_model->retrieve_categories_by_parent(7);
		
		$menu['news'] = $this->news_model->get_news();
		$menu['messages'] = '';
		
		//Получаем сообщения из сессии и выводим их пользователю
		if ($message = $this->session->flashdata('message'))
		{
			$menu['messages'] = '<div class="message-' . $message['status'] . '">' . $message['message'] . '</div>';
		}
		
		//$menu['tags'] = $this->tag_model->get_list();
		//$menu['last comments'] = $this->comment_model->get_last(10);
		//$menu['links'] = $this->link_model->get_list();
		//$menu['month_pages'] = $this->page_model->get_month_list();
		//$menu['top_pages'] = $this->page_model->get_top(10);
		//$menu['top_comments'] = $this->comment_model->get_top(10);
		
		
		//Корзина пользователя, пока пустая
		$user_cart = array();
		$menu['user_cart'] = array();
		
		//Заполняем корзину из библиотеки cart
		$user_cart = $this->cart->contents();
		$menu['user_cart'] = $this->cart->contents();
		
		//Подгружаем шаблоны корзины и сетки товаров.
		//Последним параметром передаем true, чтобы шаблон
		//выводился в переменную
		//$data['cart'] = $this->load->view('cart/cart', array('cart_items' => $user_cart), TRUE);

		$cart['user_cart'] = array();
		
		$menu['first_name'] = $this->session->userdata('first_name');
		$role_id = $this->session->userdata('role_id');
		$menu['role_id'] = $role_id;
		
		$this->load->view('templates/header', $menu);
		//$this->load->view('templates/left', $menu);
		
		//если незарегистрированный или покупатель, показываем корзину
		if($role_id < 2) $this->load->view('cart/cart', $menu, $data, $cart, $user_cart);
		//$this->load->view('templates/pre-content');
		$this->load->view($view, $data, $menu);
		$this->load->view('templates/right', $menu);
		$this->load->view('templates/footer', $menu);
	}
	
	/**
	* Читаем данные пользователя, чтобы показать на странице
	*/

	public function read_user_information($username)
	{
		$condition = "user_name =" . "'" . $username . "'";
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1)
		{
			return $query->result();
		} else
		{
			return false;
		}
	}
	
	
}