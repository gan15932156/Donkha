<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Service_app extends CI_Controller {
    public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('User_model');
		$response = array();
	}
	public function isTheseParametersAvailable($params){
		
		foreach($params as $param){
			if(!isset($_POST[$param])){
				return false; 
			}
		}
		return true; 
	}
	public function login_check_app(){
		$username = $this->input->post('Username');
		$password = base64_encode($this->input->post('Password'));
		/*$username = "abcd";
		$password = base64_encode("1234");*/

		$data['login']=$this->User_model->check_login_app($username, $password);
		if($data['login']->num_rows() > 0){
			foreach ($data['login']->result() as $row) {
				$user = array(
					'id'=>$row->member_id, 
					'username'=>$row->username, 
					'password'=>base64_decode($row->password), 
					'name'=>$row->member_name
				);
			}
			$this->response['error'] = false; 
			$this->response['message'] = 'เข้าสู่ระบบสำเร็จ'; 
			$this->response['user'] = $user;     
        }
        else{
            $this->response['error'] = true; 
			$this->response['message'] = 'ชื่อผู้ใช้หรือรหัสผ่านผิด';
		}
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);
	}
	public function forgot_password(){
		$forgot = $this->input->post('Forgot');
		$state = $this->input->post('State');
		$forgot = "15932158";
		$state = "นักเรียน";
		if($data['result']=$this->User_model->fotgot_password_app($forgot,$state))  {
			foreach ($data['result']->result() as $row) {
				echo "[{'error':'failed','password':'".base64_decode($row->password)."'}]";
			}
			
		}
		else{
			echo "[{'error':'failed','password':''}]";
		}
	}

}