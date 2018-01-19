<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Class Feedback
* Контроллер реализует обратную связь клиентов с продавцами
*
*/

class Feedback extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('feedback_model');
		$this->load->helper('url_helper');
	}
	
	/**
	* Вывод сообщений и формы обратной связи
	*/
	
	public function index()
	{
		//добываем посты
		$data['posts'] = $this->feedback_model->get_posts();
		
		//показываем их
		$data['title'] = 'Обратная связь';
		
		$this->_render('feedback/index', $data);
		
	}
	
	/*
	
	public function view($slug = NULL)
	{
		$data['news_item'] = $this->news_model->get_news($slug);
		
		if (empty($data['news_item']))
		{
			show_404();
		}
		
		$data['title'] = $data['news_item']['title'];
		
		$this->_render('news/view', $data);
		
	}
	*/
	
	/**
	* Создание сообщения
	*/
	
	public function create()
	{
		//если пользователь зарегистрирован
		if($this->session->userdata('role_id') > 0)
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

			$data['title'] = 'Сообщение отправлено!';
			$data['text'] = 'Вернуться';
			$data['link'] = '/index.php/feedback/index';

		}
		else
		{
			$result = array(
					'status' => 'error',
					'message' => 'Вы не вошли',
				);
			$this->session->set_flashdata('message', $result);
			
			$data['title'] = 'Вы не вошли!';
			$data['text'] = 'Войти';
			$data['link'] = '/index.php/user/login';
		}
		
		$content = 'messages/success';
			
		$this->_render('feedback/index', $data);
	}
		
}
?>