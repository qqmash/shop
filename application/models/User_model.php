<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Class User_model
* Модель организует работу с пользователями сайта
*
*/

class User_model extends CI_Model
{
	
	public $status;
	//public $roles;
	
	function __construct()
	{
		parent::__construct();
		$this->status = $this->config->item('status');
		//$this->roles = $this->config->item('roles');
	}
	
	/**
	* Добавляем пользователя в БД
	*/
	
	public function insertUser($data)
	{
		$string = array(
			'first_name'=>$data['firstname'],
			'last_name'=>$data['lastname'],
			'email'=>$data['email'],
			'role_id'=>'1',
			//'status'=>$this->status[0],
			'password' => $data['password'],
			'last_login' => date('Y-m-d h:i:s A'),
			'status' => $this->status[1]
		);
		$query = $this->db->insert_string('users',$string);
		$this->db->query($query);
		//$id = $this->db->insert_id();
		
		//$user_info = $this->getUserInfo($id);
		return $query;
	}
	
	/**
	* Проверяем, зарегистрирован ли уже такой емейл
	*/
	
	public function isDuplicate($email)
	{
		$this->db->get_where('users', array('email'=>$email), 1);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	/**
	* Проверяем данные логина
	*/
	
	public function checkLogin($post)
	{
		//$this->load->library('password');
		$this->db->select('*');
		$this->db->where('email', $post['email']);
		$query = $this->db->get('users');
		$userInfo = $query->row();
		
		if(!($post['password'] == $userInfo->password))
		{
			error_log('Неудачная попытка логина('.$post['email'].')');
			return FALSE;
		}
		
		$this->updateLoginTime($userInfo->id);
		
		unset($userInfo->password);
		return $userInfo;
	}
	
	/**
	* Обновляем время логина
	*/
	
	public function updateLoginTime($id)
	{
		$this->db->where('id', $id);
		$this->db->update('users', array('last_login' => date('Y-m-d h:i:s A')));
		return;
	}
	
	
	
	/**
	* Получает список всех пользователей
	*/
	
	public function retrieve_users()
	{
		//Получает все записи из таблицы users
							
		//$this->db->select('users.*, roles.*');
		$this->db->select('users.*, roles.role_name');
		//$this->db->from('order_details, products');
		$this->db->from('users');
		$this->db->join('roles', 'users.role_id = roles.id');
		$this->db->order_by('role_id');
		$query = $this->db->get();
		
		//Возвращает в виде ассоциативного массива
		return $query->result_array();
	}
	
	/**
	* Получает пользователей определенного статуса
	* @param $status
	* @return $query
	*/
	
	public function retrieve_users_by_status($status)
	{
		//$this->db->select('order_details.*, products.*');
		$this->db->select('order_details.*, products.name, customers.first_name, customers.last_name, customers.phone_number, customers.address, orders.order_date, orders.order_status');
		//$this->db->from('order_details, products');
		$this->db->from('order_details');
		$this->db->join('products', 'order_details.product_id = products.id');
		$this->db->join('orders', 'order_details.order_id = orders.id');
		$this->db->join('customers', 'orders.customer_id = customers.id');
		$this->db->order_by('order_id');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	/**
	* Получает список всех ролей
	*/
	
	public function retrieve_roles()
	{
		//Получает все записи из таблицы roles
							
		$query = $this->db->get('roles');
		
		//Возвращает в виде ассоциативного массива
		return $query->result_array();
	}
	
	/**
	* Добавляет роль
	*/
	
	public function add_role()
	{
		$this->load->helper('url');
		$this->load->helper('text');
		
		$data = array(
			'role' => $this->input->post('role'),
			'role_name' => $this->input->post('role_name')
		);
		
		return $this->db->insert('roles', $data);
	}
	
}