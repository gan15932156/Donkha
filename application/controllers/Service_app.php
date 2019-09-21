<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Service_app extends CI_Controller {
    public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->database();
		$this->load->model('User_model');
		$this->load->library('pagination');
		$this->load->library('Pdf');
    }
    public function login_check_app(){
		$username = $this->input->post('Username');
		$password = md5($this->input->post('Password'));
		if($data['login']=$this->User_model->check_login_app($username, $password))  {
			$result = $data['login']->result();
			echo json_encode($result,JSON_UNESCAPED_UNICODE);
		}
		else{
			echo "[{'error':'failed','member_id':''}]";
				
		}
		
	}
}