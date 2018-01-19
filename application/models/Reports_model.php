<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Class Reports_model
* Модель организует работу с отчетами
*
*/

class Reports_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	* Получает все товары магазина из БД
	*/

	public function retrieve_products()
	{
		//Получает все записи из таблицы products
		$query = $this->db->get('products');
		
		 //Возвращает массив с записями в виде ассоциативного массива
		return $query->result_array();
	}
	
	/**
	* Получает товар магазина
	* @param $product_id
	* @return mixed
	*/
	
	public function get_product($product_id)
	{
		return $this->db->where('id', $product_id)
			->get('products')
			//Результат в виде ассоциативного массива
			->row_array();
	}
	
	//________________________________________________________________________
	
	/**
	* Получает все категории товаров
	*/

	public function retrieve_categories()
	{
		//Получает все записи из таблицы product_categories
		$query = $this->db->get('product_categories');
		
		//Возвращает в виде ассоциативного массива
		return $query->result_array();
	}
	
	/**
	* Получает все категории товаров по родительской категории
	*/

	public function retrieve_categories_by_parent($parent)
	{
		//Получает все записи из таблицы product_categories
		$query = $this->db->get_where('product_categories', array('parent_id' => $parent));
		
		//Возвращает в виде ассоциативного массива
		return $query->result_array();
	}
	
	/**
	* Получает категорию по id
	*/

	public function get_category_name($category_id)
	{
		//Получает запись из таблицы product_categories
		$query = $this->db->get('product_categories');
		$query = $this->db->get_where('product_categories', array('id' => $category_id), 1);
		
		//Возвращает в виде ассоциативного массива
		return $query->result_array();
		
	}
	
	/**
	* Получает все товары определенной категории
	* @param $category_id
	* @return $query
	*/
	
	public function retrieve_products_by_category($category_id)
	{
		$query = $this->db->get_where('products', array('category' => $category_id));
		return $query->result_array();
	}
	
	/**
	* Добавляет новую категорию
	*/
	
	public function add_category()
	{
		$this->load->helper('url');
		$this->load->helper('text');
	
		//Транслитерируем имя категории, чтобы запихать в URL
		$slug = convert_accented_characters(url_title($this->input->post('name', 'dash', TRUE)));
	
		$data = array(
			//'title' => $this->input->post('id'),
			'slug' => $slug,
			'name' => $this->input->post('name')
		);
	
		return $this->db->insert('product_categories', $data);
	}
	
	/**
	* Добавляет новый товар
	*/
	
	public function add_product()
	{
		$this->load->helper('text');

		$image = $this->input->post('image');
		
		if(!($image)) $image='default.jpg';
	
		$data = array(
			'name' => $this->input->post('name'),
			'category' => $this->input->post('category'),
			'prime_cost' => $this->input->post('prime_cost'),
			'price' => $this->input->post('price'),
			'description' => $this->input->post('description'),
			'image' => $image,
		);
	
		return $this->db->insert('products', $data);
	}
	
	//________________________________________________________________________
	
	/**
	* Получает список всех заказов
	*/
	public function retrieve_orders()
	{
		//Получает все записи из таблицы order_details
							
		//$this->db->select('order_details.*, products.*');
		$this->db->select('order_details.*, products.name, customers.first_name, customers.last_name, customers.phone_number, customers.address, orders.order_date, orders.order_status');
		//$this->db->from('order_details, products');
		$this->db->from('order_details');
		$this->db->join('products', 'order_details.product_id = products.id');
		$this->db->join('orders', 'order_details.order_id = orders.id');
		$this->db->join('customers', 'orders.customer_id = customers.id');
		$this->db->order_by('order_id');
		$query = $this->db->get();
		
		//Возвращает в виде ассоциативного массива
		return $query->result_array();
	}
	
	/**
	* Получает все заказы определенного статуса
	* @param $status
	* @return $query
	*/
	public function retrieve_orders_by_status($status)
	{
		//$this->db->select('order_details.*, products.*');
		$this->db->select('order_details.*, products.name, customers.first_name, customers.last_name, customers.phone_number, customers.address, orders.order_date, orders.order_status');
		//$this->db->from('order_details, products');
		$this->db->from('order_details');
			
		$this->db->where('order_status', $status);
			
		$this->db->join('products', 'order_details.product_id = products.id');
		$this->db->join('orders', 'order_details.order_id = orders.id');
		$this->db->join('customers', 'orders.customer_id = customers.id');
		$this->db->order_by('order_id');
		$query = $this->db->get();
			
		return $query->result_array();
	}
	
	/**
	* Получает список самых продаваемых товаров с сортировкой по объему продаж
	* @param $status
	* @return $query
	*/
	public function retrieve_sold_products_revenue()
	{
		$status='complete';

		//$this->db->select('order_details.*, products.*');
		$this->db->select('order_details.*, products.name, orders.order_date, orders.order_status, SUM(quantity) AS quantity, SUM(subtotal) AS subtotal', FALSE);
		//$this->db->from('order_details, products');
		$this->db->from('order_details');
			
		$this->db->where('order_status', $status);
			
		$this->db->join('products', 'order_details.product_id = products.id');
		$this->db->join('orders', 'order_details.order_id = orders.id');

		$this->db->group_by('products.name');
		$this->db->order_by('subtotal', 'desc');
		
		$query = $this->db->get();
			
		return $query->result_array();
	}
		
	/**
	* Получает список самых продаваемых товаров с сортировкой по прибыли
	* @param $status
	* @return $query
	*/
	public function retrieve_sold_products_profit()
	{
		$status='complete';

		//$this->db->select('order_details.*, products.*');
		$this->db->select('order_details.*, products.name, (products.price - products.prime_cost) AS unit_profit, orders.order_date, orders.order_status, SUM(quantity) AS quantity, ((products.price - products.prime_cost) * quantity) AS profit', FALSE);
		//$this->db->from('order_details, products');
		$this->db->from('order_details');
			
		$this->db->where('order_status', $status);
			
		$this->db->join('products', 'order_details.product_id = products.id');
		$this->db->join('orders', 'order_details.order_id = orders.id');

		$this->db->group_by('products.name');
		$this->db->order_by('profit', 'desc');
		
		$query = $this->db->get();
			
		return $query->result_array();
	}
		
	//_______________________________________________________________________________
		
	public function selection_products_old($category_id)
	{
		$query = $this->db->select('*')
							->from('products')
							->join('product_category', 'product_category.id = products.category')
							->get();
		return $query;
	}
		
}