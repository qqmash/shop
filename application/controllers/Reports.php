<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Class Reports
* Контроллер реализует генерацию и вывод отчетов директору
*
*/

class Reports extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		//Подключение модели
		$this->load->model('Reports_model');
		$this->load->helper('url_helper');
	}
	
	/**
	* Вывод главной страницы отчета
	*/
	
	public function index()
	{
		//если не директор, не открываем страницу
		if (!($this->session->userdata('role_id') == '3')) 
		{
			show_404();
		}
		
		//добываем посты
		$data['posts'] = $this->Reports_model->get_posts();
		
		//показываем их
		$data['title'] = 'Обратная связь';
		
		$this->_render('feedback/index', $data);
		
	}
	
		
	/**
	* Вывод списка заказов
	*/

	public function orders_list($status)
	{
		//если не директор, не открываем страницу
		if (!($this->session->userdata('role_id') == '3')) 
		{
			show_404();
		}

		//Массив данных для передачи в шаблон
		$data = array();
		
		if ($status=='all')
		{
			$data['title'] = 'Список заказов';
			//Загружаем список всех заказов из БД
			//$data['category'] = $this->load->view('products/category', array('products' => $products), TRUE);	
			$data['orders'] = $this->Reports_model->retrieve_orders();
		}
		else
		{
			if ($status=='not_sent')
			{
				$data['title'] = 'Активные заказы';
			}
			else
			{
				$data['title'] = 'Заказы со статусом' . $status;
			}
			
			//Загружаем список заказов из БД по статусу
			//$data['category'] = $this->load->view('products/category', array('products' => $products), TRUE);	
			$data['orders'] = $this->Reports_model->retrieve_orders_by_status($status);
		}

		//Выводим основные шаблоны
		$this->_render('reports/sellings_list', $data);
		
	}
	
			
	/**
	* Вывод списка продаж
	*/

	public function sellings_list()
	{
		//если не директор, не открываем страницу
		if (!($this->session->userdata('role_id') == '3')) 
		{
			show_404();
		}
		

		//Массив данных для передачи в шаблон
		$data = array();
		
		$status='complete';
		
		$data['title'] = 'Список продаж';
		
		//Загружаем список всех заказов из БД
		//$data['category'] = $this->load->view('products/category', array('products' => $products), TRUE);	
		$data['orders'] = $this->Reports_model->retrieve_orders_by_status($status);
		//$category = $this->Cart_model->retrieve_categories();

		//Выводим основные шаблоны
		$this->_render('reports/sellings_list', $data);
		
	}
	
				
	/**
	* Вывод списка проданных товаров
	*/

	public function sold_products_revenue()
	{
		//если не директор, не открываем страницу
		if (!($this->session->userdata('role_id') == '3')) 
		{
			show_404();
		}
		

		//Массив данных для передачи в шаблон
		$data = array();
		
		$status='complete';
		
		$data['title'] = 'Список проданных товаров (по выручке)';
		
		//Загружаем список всех заказов из БД
		//$data['category'] = $this->load->view('products/category', array('products' => $products), TRUE);	
		$data['orders'] = $this->Reports_model->retrieve_sold_products_revenue();
		//$category = $this->Cart_model->retrieve_categories();

		//Выводим основные шаблоны
		$this->_render('reports/sold_products_revenue', $data);
		
	}
	
					
	/**
	* Вывод списка проданных товаров
	*/

	public function sold_products_profit()
	{
		//если не директор, не открываем страницу
		if (!($this->session->userdata('role_id') == '3')) 
		{
			show_404();
		}
		

		//Массив данных для передачи в шаблон
		$data = array();
		
		$status='complete';
		
		$data['title'] = 'Список проданных товаров (по прибыли)';
		
		//Загружаем список всех заказов из БД
		//$data['category'] = $this->load->view('products/category', array('products' => $products), TRUE);	
		$data['orders'] = $this->Reports_model->retrieve_sold_products_profit();
		//$category = $this->Cart_model->retrieve_categories();

		//Выводим основные шаблоны
		$this->_render('reports/sold_products_profit', $data);
		
	}
	
	
	/**
	* Вывод отчета о выручке
	*/

	public function revenue()
	{
		//если не директор, не открываем страницу
		if (!($this->session->userdata('role_id') == '3')) 
		{
			show_404();
		}
		

		//Массив данных для передачи в шаблон
		$data = array();
		
		$status='complete';
		
		$data['title'] = 'Выручка';
		
		//Загружаем список всех заказов из БД
		//$data['category'] = $this->load->view('products/category', array('products' => $products), TRUE);	
		$data['orders'] = $this->Reports_model->retrieve_orders_by_status($status);
		//$category = $this->Cart_model->retrieve_categories();

		//Выводим основные шаблоны
		$this->_render('reports/sellings_list', $data);
		
	}
	
	
	/**
	* Вывод отчета о прибыли
	*/

	public function profit()
	{
		//если не директор, не открываем страницу
		if (!($this->session->userdata('role_id') == '3')) 
		{
			show_404();
		}
		

		//Массив данных для передачи в шаблон
		$data = array();
		
		$status='complete';
		
		$data['title'] = 'Прибыль';
		
		//Загружаем список всех заказов из БД
		//$data['category'] = $this->load->view('products/category', array('products' => $products), TRUE);	
		$data['orders'] = $this->Reports_model->retrieve_orders_by_status($status);
		//$category = $this->Cart_model->retrieve_categories();

		//Выводим основные шаблоны
		$this->_render('reports/sellings_list', $data);
		
	}
	
	
	/**
	* Вывод отчета о затратах
	*/

	public function costs()
	{
		//если не директор, не открываем страницу
		if (!($this->session->userdata('role_id') == '3')) 
		{
			show_404();
		}
		

		//Массив данных для передачи в шаблон
		$data = array();
		
		$status='complete';
		
		$data['title'] = 'Затраты';
		
		//Загружаем список всех заказов из БД
		//$data['category'] = $this->load->view('products/category', array('products' => $products), TRUE);	
		$data['orders'] = $this->Reports_model->retrieve_orders_by_status($status);
		//$category = $this->Cart_model->retrieve_categories();

		//Выводим основные шаблоны
		$this->_render('reports/sellings_list', $data);
		
	}
	

	
	
	
	/**
	* Вывод товаров и корзины
	*/
	
	public function create()
	{
		if($this->session->userdata('role_id')>0)//если пользователь зарегистрирован
		{
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			$data['title'] = 'Обратная связь';
			
			$this->form_validation->set_rules('title', 'Заголовок', 'required');
			$this->form_validation->set_rules('text', 'Текст', 'required');
			
			
			if ($this->form_validation->run())
			{
				$this->feedback_model->set_post();
				$this->_render('feedback/index', $data);
				$this->redirect(base_url().'index.php/feedback/index');
			}
			
			//$this->_render('feedback/index', $data);
		}
		else
		{
			$result = array(
					'status' => 'error',
					'message' => 'Вы не зарегистрированы',
				);
			$this->session->set_flashdata('message', $result);
			//$this->_render('feedback/index', $data);
		}
	}
		
}
?>