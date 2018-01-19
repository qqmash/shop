<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Class User
* Контроллер реализует регистрацию и аутентификацию пользователей
*
*/

class User extends MY_Controller
{
	public $status;
	//public $roles;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('User_model', 'user_model', TRUE);
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->status = $this->config->item('status');
		//$this->roles = $this->config->item('roles');
	}
	
	/**
	* Осуществляет регистрацию пользователя
	*/
	
	public function register()
	{
		
		$this->form_validation->set_rules('firstname', 'Имя', 'required');
		$this->form_validation->set_rules('lastname', 'Фамилия', 'required');
		$this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Пароль', 'required|min_length[6]');
		$this->form_validation->set_rules('passconf', 'Подтверждение пароля', 'required|matches[password]');
		
		
		if($this->form_validation->run() == FALSE)
		{
			$this->_render('users/register');
			//$this->_render('complete', $data);
		}
		else
		{
			if($this->user_model->isDuplicate($this->input->post('email')))
			{
				$result = array(
					'status' => 'error',
					'message' => 'Такой e-mail уже зарегистрирован',
				);
				$this->session->set_flashdata('message', $result);
				redirect(base_url().'index.php/user/register');
			}
			
			else
			{
				$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));

				$userInfo = $this->user_model->insertUser($clean);
				
				if(!$userInfo)
				{
					$result = array(
						'status' => 'error',
						'message' => 'Проблема при обновлении вашей записи',
					);
					$this->session->set_flashdata('message', $result);
					redirect(base_url().'index.php/user/login');
				}
				
				//foreach($userInfo as $key=>$val)
				//{
					//$this->session->set_userdata($key, $val);
				//}
				
				$result = array(
					'status' => 'success',
					'message' => 'Вы успешно зарегистрировались на сайте',
				);
				$this->session->set_flashdata('message', $result);				
				redirect(base_url().'index.php/user/login');
				
				$data = array(
					'firstName'=>$user_info->first_name,
					'email'=>$user_info->email,
					'user_id'=>$user_info->id,
					//'token'=>base64_encode($token)
				);

			};
		};
	}
	
	/**
	* Осуществляет аутентификацию пользователя
	*/
	
	public function login()
	{
		$this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Пароль', 'required');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->_render('users/login');
		}
		else
		{
			$post = $this->input->post();
			$clean = $this->security->xss_clean($post);
			
			$userInfo = $this->user_model->checkLogin($clean);
			
			if(!$userInfo)
			{
				$result = array(
					'status' => 'error',
					'message' => 'Вход не удался',
				);
				$this->session->set_flashdata('message', $result);		
				redirect(base_url().'index.php/user/login');
			}
			foreach($userInfo as $key=>$val)
			{
				$this->session->set_userdata($key, $val);
			}
			redirect(base_url().'index.php/');
		}
	}
	
	/**
	* Осуществляет выход пользователя из-под учетной записи
	*/
	
	public function logout()
	{
		//удаляем данные сессии
		$userdata = array(
			'id',
			'email',
			'first_name',
			'last_name',
			'role_id',
			'password',
		);
		
		$this->session->unset_userdata($userdata);
		
		$result = array(
					'status' => 'success',
					'message' => 'Вы успешно вышли',
				);
				
		$this->session->set_flashdata('message', $result);		
		redirect(base_url());
	}
	
	/**
	* Выводит список пользователей
	*/
	
	public function users_list()
	{
		
		//Массив данных для передачи в шаблон users_list
		$data = array();

		//Загружаем список всех пользователей из БД
		//$data['users'] = $this->load->view('users/users_list', array('users' => $data), TRUE);	
		$data['users'] = $this->user_model->retrieve_users();
		//$users = $this->Cart_model->retrieve_categories();

		//Выводим основные шаблоны
		$this->_render('users/users_list', $data);
	}
	
	/**
	* Выводит список ролей пользователей
	*/
	
	public function roles_list()
	{
		
		//Массив данных для передачи в шаблон roles_list
		$data = array();

		//Загружаем список всех ролей пользователей из БД
		//$data['users'] = $this->load->view('users/users_list', array('users' => $data), TRUE);
		$data['roles'] = $this->user_model->retrieve_roles();
		//$users = $this->Cart_model->retrieve_categories();

		//Выводим основные шаблоны
		$this->_render('users/roles_list', $data);
	}
	
	/**
	* Добавляет новую роль
	*/
	
	public function add_role()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
	
		$data['title'] = 'Добавить роль';
	
		$this->form_validation->set_rules('role', 'Роль', 'required|alpha_dash|valid_base64|is_unique[roles.role]');
		$this->form_validation->set_rules('role_name', 'Выводимое имя', 'required|is_unique[roles.role_name]');

		if ($this->form_validation->run() === FALSE)
		{
			//Массив с результатами работы скрипта
			$result = array();
			$content = 'user/roles_list';
		}
		else
		{
			
			//Массив с результатами работы скрипта
			$result = array(
				'status' => 'success',
				'message' => 'Роль успешно добавлена',
			);
			
			$this->user_model->add_role();

			$content = 'user/roles_list';
		}
		
		//Выводим сообщение
		$this->session->set_flashdata('message', $result);
			
		//Определяем загружаемую страницу
		//$this->_render($content, $data);
		redirect(base_url().'index.php/user/roles_list');

	}
}
?>