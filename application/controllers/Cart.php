<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Class Cart
* Контроллер реализует работу AJAX корзины
*
*/

class Cart extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		//Подключение модели
		$this->load->model('Cart_model');
	}
	
	/**
	* Вывод товаров и корзины
	*/
	
	public function index()//($id)
	{
		//Массив, в котором будут храниться товары
		$products = array();
		
		//Получение товаров из БД
		//$data['products'] = $this->Cart_model->retrieve_products();

		//if(!$id)
		//{
			$products = $this->Cart_model->retrieve_products();
		//}
		//else
		//{
		//	$products = $this->Cart_model->retrieve_products_by_category($id);
		//}
		
		//print_r($data['products']);//выводим массив на посмотреть
		
		//Корзина пользователя, пока пустая
		//!!!в глобальный контроллер
		$user_cart = array();
		
		//Заполняем корзину из библиотеки cart
		//!!!в глобальный контроллер
		$user_cart = $this->cart->contents();
		//$user_cart = $this->$user_cart;
		
		//Массив данных для передачи в шаблон cart.php
		$data = array();
		
		//Если сумма заказа больше 50 долларов, скидка 5%
		$data['discount'] = 0;
		if($this->cart->total()>50)
		{
			$data['discount'] = 0.05;
		}
		
		//Подгружаем шаблоны корзины и сетки товаров.
		//Последним параметром передаем true, чтобы шаблон
		//выводился в переменную
		$data['cart'] = $this->load->view('cart/cart', array('cart_items' => $user_cart), TRUE);
		
		//переменная products со всеми товарами будет доступна в шаблоне с сеткой товаров
		$data['content'] = $this->load->view('products/products', array('products' => $products), TRUE);
		
	
		//ГРУЗИМ СПИСОК КАТЕГОРИЙ ИЗ БД!!!!
		//$data['category'] = $this->load->view('products/category', array('products' => $products), TRUE);	
		$data['category'] = $this->Cart_model->retrieve_categories();
		//$category = $this->Cart_model->retrieve_categories();
			
		//Выводим основные шаблоны
		$this->_render('products/products', $data);
		
	}
	
		
	/**
	* Каталог по категории товара
	*/
	
	public function catalog($id)
	{
		//Массив, в котором будут храниться товары
		$products = array();
		
		//Получаем товары выбранной категории
		$products = $this->Cart_model->retrieve_products_by_category($id);
		
		//print_r($data['products']);//выводим массив на посмотреть
		
		//Корзина пользователя, пока пустая
		$user_cart = array();
		
		//Заполняем корзину из библиотеки cart
		$user_cart = $this->cart->contents();
		
		//Массив данных для передачи в шаблон cart.php
		$data = array();
		
		$data['category_name'] = '';

		//Получаем данные категории
		$category = $this->Cart_model->get_category_name($id);
			
		//Если категория существует
		if ($category)
		{
			//Получаем имя категории
			$data['category_name'] = $category['name'];
		}
		
		//Подгружаем шаблоны корзины и сетки товаров.
		//Последним параметром передаем true, чтобы шаблон
		//выводился в переменную
		$data['cart'] = $this->load->view('cart/cart', array('cart_items' => $user_cart), TRUE);
		
		//переменная products со всеми товарами будет доступна в шаблоне с сеткой товаров
		$data['content'] = $this->load->view('products/products', array('products' => $products), TRUE);
		
		//ГРУЗИМ СПИСОК КАТЕГОРИЙ ИЗ БД!!!!
		//$data['category'] = $this->load->view('products/category', array('products' => $products), TRUE);	
		$data['category'] = $this->Cart_model->retrieve_categories();
		//$category = $this->Cart_model->retrieve_categories();
		
		

			
		//Выводим основные шаблоны
			$this->_render('products/products', $data);
		
	}
	
	//_______________________________________________________________________________
	
	/**
	* Добавление товара в корзину
	*/
	
	public function add_to_cart()
	{
		//Получаем id добавляемого товара
		$product_id = $this->input->post('product_id', TRUE);
		
		//Проверяем тип запроса. Если true, то запрос передан
		//с помощью AJAX, если false то обычный POST запрос
		$is_ajax = $this->input->is_ajax_request();
		
		//Массив с результатами работы скрипта
		$result = array(
			'status' => 'error',
			'message' => 'Переданы неверные данные',
		);
		
		//Если $product_id не пустой
		if ($product_id)
		{
			//Получаем данные товара
			$product_data = $this->Cart_model->get_product($product_id);
			
			//Если товар существует
			if ($product_data)
			{
				$this->cart->insert(array(
					'id' => $product_id,
					'qty' => 1,//$product_data['qty'],
					'price' => $product_data['price'],
					'name' => $product_data['name'],
				));
				
				//Получаем корзину пользователя
				$user_cart = $this->cart->contents();
				
				//Подгружаем шаблоны корзины и сетки товаров.
				//В конце передаем true, чтобы шаблон выводился в переменную
				$cart_html = $this->load->view('cart/cart', array('cart_items' => $user_cart), true);
				
				$result = array(
					'status' => 'success',
					'message' => 'Товар добавлен в корзину',
					'cart_html' => $cart_html,
				);
			}
			else
			{
				$result = array(
					'status' => 'error',
					'message' => 'Такого товара не существует',
				);
			}
		}
		
		if ($is_ajax)
		{
			//Если был AJAX запрос, возвращаем JSON ответ
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($result));
		}
		else
		{
			//Выводим сообщение
			$this->session->set_flashdata('message', $result);
			
			//Редирект на страницу с товарами
			redirect(base_url());
		}
	}
	
	/**
	* Удаление товара из корзины
	*/
	
	public function delete_item()
	{
		//Уникальный rowid товара в корзине
		$rowid = $this->input->post('rowid', TRUE);
		
		//Проверяем тип запроса. Если true, то запрос передан
		//с помощью AJAX, если false то обычный POST запрос
		$is_ajax = $this->input->is_ajax_request();
		
		//Массив с результатами работы скрипта
		$result = array(
			'status' => 'error',
			'message' => 'Такого товара нет в корзине',
		);
		
		if ($rowid)
		{
			$data = array(
				'rowid' => $rowid,
				'qty' => 0,
			);
			
			//Обновляем корзину пользователя
			$this->cart->update($data);
			
			$result = array(
				'status' => 'success',
				'message' => 'Товар успешно удалён из корзины',
			);
		}
		
		if($is_ajax)
		{
			//Если был AJAX запрос, возвращаем JSON ответ
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($result));
		}
		else
		{
			//Выводим сообщение
			$this->session->set_flashdata('message', $result);
			
			//Редирект на страницу с товарами
			redirect(base_url());
		}
	}
	
	/**
	* Очистка корзины
	*/
	
	public function cart_empty()
	{
		//Очищаем корзину
		$this->cart->destroy();
		
		$result = array(
			'status' => 'success',
			'message' => 'Корзина очищена',
		);
		
		 // Проверяем тип запроса. Если true, то запрос передан с помощью
		// AJAX, если false то обычный POST запрос
		$is_ajax = $this->input->is_ajax_request();
		
		if ($is_ajax)
		{
			// Если был AJAX запрос, возвращаем JSON ответ
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($result));
		}
		else
		{
			// Выводим сообщение
			$this->session->set_flashdata('message', $result);
 
			// Редирект на страницу с товарами
			redirect(base_url());
		}
	}

	
	//_________________________________________________________________________________________________	
	
	/**
	* Добавление категории товара
	*/
	
	public function add_category()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
	
		$data['title'] = 'Добавить категорию товара';
	
		$this->form_validation->set_rules('name', 'Название категории', 'required|is_unique[product_categories.name]');

		if ($this->form_validation->run() === FALSE)
		{
			//Массив с результатами работы скрипта
			/*&$result = array(
				'status' => 'error',
				'message' => 'Переданы неверные данные',
				//'cart_html' => $cart_html,
			);*/
			$result = array();
			$content = 'products/add_category';
		}
		else
		{
			
			//Массив с результатами работы скрипта
			$result = array(
				'status' => 'success',
				'message' => 'Категория товара успешно добавлена',
			);
			
			$this->Cart_model->add_category();

			//$this->load->view('products/category_success');
			$content = 'products/category_success';
		}
		
		//Выводим сообщение
		$this->session->set_flashdata('message', $result);
			
		//Определяем загружаемую страницу
		$this->_render($content, $data);

	}
	
	/**
	* Добавление товара
	*/
	
	public function add_product()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['category'] = $this->Cart_model->retrieve_categories();
	
		$data['title'] = 'Добавить товар';
	
		$this->form_validation->set_rules('name', 'Наименование товара', 'required|is_unique[products.name]');
		$this->form_validation->set_rules('category', 'Категория', 'required|callback_select_validate');
		$this->form_validation->set_rules('prime_cost', 'Себестоимость', 'required|numeric');
		$this->form_validation->set_rules('price', 'Цена', 'required|numeric');
		//$this->form_validation->set_rules('description', '', '');
		//$this->form_validation->set_rules('image', '', '');
	
		if ($this->form_validation->run() === FALSE)
		{	
			$result = array();
			$content = 'products/add_product';
			
		}
		else
		{
			$this->Cart_model->add_product();
			
			//Массив с результатами работы скрипта
			$result = array(
				'status' => 'success',
				'message' => 'Товар успешно добавлен',
			);
			
			$content = 'products/product_success';
			
		}
		
		//Выводим сообщение
		$this->session->set_flashdata('message', $result);
		$this->_render($content, $data);
	}

	/**
	* Функция для валидации поля Select (категории товаров)
	*/
	
	function select_validate($cat)
	{
		// 'none' первая опция по умолчанию "-------Выберите категорию-------" (у меня пока Ноуты)
		if($cat=="none")
		{
			$this->form_validation->set_message('select_validate', 'Пожалуйста выберите категорию');
			return FALSE;
		}
		else
		{
			// юзер что-то выбрал
			return TRUE;
		}
	}
	
	//_________________________________________________________________________________________________	
	
	/**
	* Добавление заказа покупателем
	*/
	
	public function add_order()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['category'] = $this->Cart_model->retrieve_categories();
	
		$data['title'] = 'Оформить заказ';
	
		$this->form_validation->set_rules('first_name','Имя', 'required');
		$this->form_validation->set_rules('last_name', 'Фамилия', 'required|callback_select_validate');
		$this->form_validation->set_rules('phone_number', 'Номер телефона', 'required|numeric');
		$this->form_validation->set_rules('address', 'Адрес доставки', 'required');
		//$this->form_validation->set_rules('description', 'Наименование товара', 'required');
		//$this->form_validation->set_rules('image', 'Наименование товара', 'required');
		
	
		if ($this->form_validation->run() === FALSE)
		{	
			$result = array();
			$content = 'cart/add_order';	
		}
		else
		{
			$this->Cart_model->add_order();
			$result = array(
				'status' => 'success',
				'message' => 'Заказ успешно оформлен',
			);
			
			$data['title'] = 'Заказ успешно оформлен!';
			$data['text'] = 'Вернуться на главную';
			$data['link'] = '/index.php/';
		
			$content = 'messages/success';
			
			//Очищаем корзину
			$this->cart->destroy();

		}
		
		//Выводим сообщение
		$this->session->set_flashdata('message', $result);
		$this->_render($content, $data);

	}
	
	/**
	* Вывод списка заказов
	*/

	public function orders_list($status)
	{

		//Массив данных для передачи в шаблон
		$data = array();
		
		if ($status=='all')
		{
			$data['title'] = 'Список заказов';
			//Загружаем список всех заказов из БД
			//$data['category'] = $this->load->view('products/category', array('products' => $products), TRUE);	
			$data['orders'] = $this->Cart_model->retrieve_orders();
			//$category = $this->Cart_model->retrieve_categories();
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
			$data['orders'] = $this->Cart_model->retrieve_orders_by_status($status);
			//$category = $this->Cart_model->retrieve_categories();
		}

		//Выводим основные шаблоны
		$this->_render('cart/orders_list', $data);
		
	}
	
	/**
	* Обработка заказа продавцом
	*/

	public function complete_order($id)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->Cart_model->complete_order($id);
		$result = array(
			'status' => 'success',
			'message' => 'Заказ успешно обработан',
		);
		
		$data['title'] = 'Заказ успешно обработан!';
		$data['text'] = 'Вернуться к списку заказов';
		$data['link'] = '/index.php/cart/orders_list/all';
		
		$content = 'messages/success';

		//Выводим сообщение
		$this->session->set_flashdata('message', $result);
		$this->_render($content, $data);

	}
	
	//_______________________________________________________________________________
	
	
	
	
	
	
	
	
	
	
//_________________________________________________________________________________________________	
	
	public function update_cart_old()
	{
		$this->Cart_model->validate_update_cart();
		redirect('cart/cart');
	}
	
	public function empty_cart_old()
	{
		$this->cart->destroy();
		redirect('cart');//обновляем страницу корзины
	}
}
?>