<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Class Cart_model
* Модель организует работу с товаром магазина
*
*/

class Cart_model extends CI_Model
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
	* @param $parent
	* @return $query
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
	* @param $category_id
	* @return $query
	*/

	public function get_category_name($category_id)
	{
		//Получает запись из таблицы product_categories
		//$query = $this->db->get_where('product_categories', array('id' => $category_id), 1);
		
		//Возвращает в виде ассоциативного массива
		//return $query->result_array();
		
		$query = $this->db->where('id', $category_id)
			->get('product_categories');
			
			//Результат в виде ассоциативного массива
			//->row_array();
			
		return $query->row_array();
		
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
	* Добавляет новый заказ
	*/
	
	public function add_order()
	{
		$this->load->helper('text');
		
		//добавляем данные заказчика
		$data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'phone_number' => $this->input->post('phone_number'),
			'address' => $this->input->post('address'),
		);
		
		$result = $this->db->insert('customers', $data);
		$customer_id = $this->db->insert_id();
		$date = date('Y-m-d');
		
		//добавляем заказанные товары
		$data = array(
			'customer_id' => $customer_id,
			'ship_address' => $this->input->post('address'),
			'order_date' => $date,
			'order_status' => 'not_sent',
		);
			
		$result = $this->db->insert('orders', $data);
		$order_id = $this->db->insert_id();
		
		//добавляем данные о заказанных товарах из корзины (все товары из списка, по АЙДИШНИКАМ!)
		
		$cart_items = $this->cart->contents();
		
		$discount = 0;
		
		//если товара набрано больше, чем на 50 долларов, скидка 5%
		if($this->cart->total()>50)
		{
			$discount = 0.05;
		}
		
		foreach( $cart_items as $row_id => $item)
		{
			$data = array(
				'order_id' => $order_id,
				'product_id' => $item['id'],
				'unit_price' => $item['price'],
				'quantity' => $item['qty'],
				'discount' => $discount,
				//субтотал с учетом скидки
				'subtotal' => $item['subtotal'] * (1 - $discount),
			);
			
			$result = $this->db->insert('order_details', $data);
			
		}
			//ЧИСТИМ КОРЗИНУ, МЫ Ж УЖЕ ЗАКАЗАЛИ ВСЕ
		
	
		return $result; //$this->db->insert('customers', $data);
	}
	
	/**
	* Проверяет, есть ли такой емейл в базе
	*/
	
	public function isDuplicate($email)
	{
		$this->db->get_where('users', array('email'=>$email), 1);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
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
	* Меняет статус заказа на "выполнен"
	* @param $id
	* @return $bool
	*/
		
	public function complete_order($id)
	{
			
		$this->db->set('order_status', 'complete');
		$this->db->where('id', $id);
		$this->db->update('orders');
			
		//$this->db->get_where('orders', array('id'=>$id), 1);
		//$this->db->insert('orders', $data);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
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