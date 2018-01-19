<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Class Cart_model
* Модель организует работу со страницей обратной связи
*
*/

class Feedback_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_posts()
	{
		$this->db->select('feedback.*, users.first_name, users.last_name');
		//$this->db->from('order_details, products');
		$this->db->from('feedback');
		$this->db->join('users', 'feedback.user_id = users.id');
		$this->db->order_by('datetime');
		$query = $this->db->get();

		//$query = $this->db->get('feedback');
		return $query->result_array();

	}
	
	public function set_post()
	{
		$this->load->helper('url');
		$this->load->helper('text');
		
		$data = array(
			'user_id' => $this->session->userdata('id'),
			'title' => $this->input->post('title'),
			'datetime' => date('Y-m-d h:i:s A'),
			'text' => $this->input->post('text')
		);
		
		return $this->db->insert('feedback', $data);
	}
	
}