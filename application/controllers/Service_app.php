<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Service_app extends CI_Controller {
    public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('Service_App_Model');
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

		$data['login']=$this->Service_App_Model->check_login_app($username, $password);
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
		$username = $this->input->post('Username');

		if($data['result']=$this->Service_App_Model->fotgot_password_app($forgot,$state,$username))  {
			foreach ($data['result']->result() as $row) {
				$forgot_array = array(
					'username'=>$row->username, 
					'password'=>base64_decode($row->password), 
				);
			}
			$this->response['error'] = false; 
			$this->response['message'] = 'สำเร็จ'; 
			$this->response['forgot'] = $forgot_array;     
			
		}
		else{
			$this->response['error'] = true; 
			$this->response['message'] = 'ไม่สำเร็จ';
		}
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);
	}
	public function get_statement(){
		$member_id = $this->input->post('member_id');
		//$member_id = "2"; //abcd
		
		if($data['member']=$this->Service_App_Model->check__isset_account($member_id)){
			foreach ($data['member']->result() as $row) {
				$account_id = $row->account_id;
			}    
			if($data['statement']=$this->Service_App_Model->get_statement($account_id))  {
				
				foreach ($data['statement']->result() as $row2) {
					$statement_array = array(
						'account_id'=>$row2->account_id, 
						'account_detail_id'=>$row2->account_detail_id, 
						'action'=>$row2->action, 
						'record_date'=>$row2->record_date, 
						'record_time'=>$row2->record_time, 
						'trans_money'=>$row2->trans_money, 

					);
					$st[] = $statement_array;	
				}
				$this->response['error'] = false; 
				$this->response['message'] = 'พบข้อมูล'; 
				$this->response['statement'] = $st;    
				
			}
			else{
				$this->response['error'] = true; 
				$this->response['message'] = 'ไม่พบข้อมูล';
			}
		}
		else{
			$this->response['error'] = true;
			$this->response['message'] = 'ไม่พบบัญชี';
		}
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);
	}

}