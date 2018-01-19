<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Class Cart_model
* Модель организует работу с новостями фирмы
*
*/

class News_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_news($slug = FALSE)
	{
		if ($slug === FALSE)
		{
			$query = $this->db->get('news');
			return $query->result_array();
		}
		
		$query = $this->db->get_where('news', array('slug' => $slug));
		return $query->row_array();
	}
	
	public function set_news()
	{
		$this->load->helper('url');
		$this->load->helper('text');
		
		//ТРАНСЛИТЕРИРУЕМ, ЧТОБЫ ЗАПИХАТЬ В УРЛ
		
		$slug = convert_accented_characters(url_title($this->input->post('title', 'dash', TRUE)));
		
		//$slug = url_title($this->input->post('title', 'dash', TRUE));
		//$slug = 'id';
		
		$data = array(
			'title' => $this->input->post('title'),
			'slug' => $slug,
			'text' => $this->input->post('text')
		);
		
		return $this->db->insert('news', $data);
	}
	
}