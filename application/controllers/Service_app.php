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
		$this->response = null ;
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
		$this->response = null ;
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
	public function get_account_balance(){
		$this->response = null ;
		$member_id = $this->input->post('member_id');
		//$member_id = "17"; //abcd
		if($data['member']=$this->Service_App_Model->check__isset_account($member_id)){
			foreach ($data['member']->result() as $row) {
				$account_balance = array(
					'account_id'=>$row->account_id, 
					'balance'=>$row->account_balance, 
				);	
			}  
			$this->response['error'] = false; 
			$this->response['message'] = 'พบข้อมูล'; 
			$this->response['account_balance'] = $account_balance;   
		}
		else{
			$this->response['error'] = true;
			$this->response['message'] = 'ไม่พบบัญชี';
		}  
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);
	}
	public function get_filter_statement(){
		$this->response = null ;
		$account_id = $this->input->post("account_id");
		$action = $this->input->post("action");
		/*$action = "deposit";
		$account_id = "2019002";*/
		if($data['statement']=$this->Service_App_Model->select_filter_st($account_id,$action)){
			foreach ($data['statement']->result() as $row) {
				$acccc = $row->action;
				$account_detail_id = $row->account_detail_id;
				if($acccc == "deposit" || $acccc == "open_account"){
					foreach ($this->Service_App_Model->select_st_deposit($account_detail_id)->result() as $row2) {
						$statement_array = array(
							'account_detail_id'=>$row2->account_detail_id,
							'trans_id'=>$row2->trans_id,
							'account_id'=>$row2->account_id,
							'staff_record_id'=>$row2->staff_record_id,
							'action'=>$row2->action,
							'record_date'=>$row2->record_date,
							'record_time'=>$row2->record_time,
							'account_detail_balance'=>$row2->account_detail_balance,
							'trans_money'=>$row2->trans_money,
							'account_id_tranfer'=>$row2->trans_money
						);
						$st[] = $statement_array;	
					}
				}
				else if($acccc == "tranfer_money" || $acccc == "recive_money"){
					foreach ($this->Service_App_Model->select_st_tranfer($account_detail_id)->result() as $row2) {
						$statement_array = array(
							'account_detail_id'=>$row2->account_detail_id,
							'trans_id'=>$row2->trans_id,
							'account_id'=>$row2->account_id,
							'staff_record_id'=>$row2->staff_record_id,
							'action'=>$row2->action,
							'record_date'=>$row2->record_date,
							'record_time'=>$row2->record_time,
							'account_detail_balance'=>$row2->account_detail_balance,
							'trans_money'=>$row2->trans_money,
							'account_id_tranfer'=>$row2->account_id_tranfer
						);
						$st[] = $statement_array;	
					}
				}
				else if($acccc == "add_interest"){
					foreach ($this->Service_App_Model->select_st_add_interest($account_detail_id)->result() as $row2) {
						$statement_array = array(
							'account_detail_id'=>$row2->account_detail_id,
							'trans_id'=>$row2->trans_id,
							'account_id'=>$row2->account_id,
							'staff_record_id'=>$row2->staff_record_id,
							'action'=>$row2->action,
							'record_date'=>$row2->record_date,
							'record_time'=>$row2->record_time,
							'account_detail_balance'=>$row2->account_detail_balance,
							'trans_money'=>$row2->trans_money,
							'account_id_tranfer'=>$row2->trans_money
						);
						$st[] = $statement_array;	
					}
				}
				else if($acccc == "withdraw"){
					foreach ($this->Service_App_Model->select_st_withdraw($account_detail_id)->result() as $row3) {
						$statement_array = array(
							'account_detail_id'=>$row3->account_detail_id,
							'trans_id'=>$row3->trans_id,
							'account_id'=>$row3->account_id,
							'staff_record_id'=>$row3->staff_record_id,
							'action'=>$row3->action,
							'record_date'=>$row3->record_date,
							'record_time'=>$row3->record_time,
							'account_detail_balance'=>$row3->account_detail_balance,
							'trans_money'=>$row3->trans_money,
							'account_id_tranfer'=>$row3->trans_money
						);
						$st[] = $statement_array;	
					}
				}

				
			}  
			$this->response['error'] = false; 
			$this->response['message'] = 'พบข้อมูล'; 
			$this->response['statement'] = $st;   
		}
		else{
			$this->response['error'] = true;
			$this->response['message'] = 'ไม่พบรายการ';
		}  
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);
	}
	public function get_statement(){
		$this->response = null ;
		$member_id = $this->input->post('member_id');
		//$member_id = "17"; //abcd
		
		if($data['member']=$this->Service_App_Model->check__isset_account($member_id)){
			foreach ($data['member']->result() as $row) {
				$account_id = $row->account_id;
			}    
			if($data['statement']=$this->Service_App_Model->get_statement($account_id))  {
				foreach ($data['statement']->result() as $row2) {
					$account_detail_id = $row2->account_detail_id;
					$acccc = $row2->action;
					if($acccc == 'deposit' || $acccc == 'open_account' || $acccc == 'add_interest'){
						foreach ($this->Service_App_Model->select_st_deposit($account_detail_id)->result() as $row3) {
							$statement_array = array(
								'account_detail_id'=>$row3->account_detail_id,
								'trans_id'=>$row3->trans_id,
								'account_id'=>$row3->account_id,
								'staff_record_id'=>$row3->staff_record_id,
								'action'=>$row3->action,
								'record_date'=>$row3->record_date,
								'record_time'=>$row3->record_time,
								'account_detail_balance'=>$row3->account_detail_balance,
								'trans_money'=>$row3->trans_money,
								'account_id_tranfer'=>$row3->trans_money
							);
							$st[] = $statement_array;	
						}
					}
					else if($acccc == 'withdraw'){
						foreach ($this->Service_App_Model->select_st_withdraw($account_detail_id)->result() as $row3) {
							$statement_array = array(
								'account_detail_id'=>$row3->account_detail_id,
								'trans_id'=>$row3->trans_id,
								'account_id'=>$row3->account_id,
								'staff_record_id'=>$row3->staff_record_id,
								'action'=>$row3->action,
								'record_date'=>$row3->record_date,
								'record_time'=>$row3->record_time,
								'account_detail_balance'=>$row3->account_detail_balance,
								'trans_money'=>$row3->trans_money,
								'account_id_tranfer'=>$row3->trans_money
							);
							$st[] = $statement_array;	
						}
					}
					else if($acccc == 'recive_money' || $acccc == 'tranfer_money'){
						foreach ($this->Service_App_Model->select_st_tranfer($account_detail_id)->result() as $row3) {
							$statement_array = array(
								'account_detail_id'=>$row3->account_detail_id,
								'trans_id'=>$row3->trans_id,
								'account_id'=>$row3->account_id,
								'staff_record_id'=>$row3->staff_record_id,
								'action'=>$row3->action,
								'record_date'=>$row3->record_date,
								'record_time'=>$row3->record_time,
								'account_detail_balance'=>$row3->account_detail_balance,
								'trans_money'=>$row3->trans_money,
								'account_id_tranfer'=>$row3->account_id_tranfer
							);
							$st[] = $statement_array;	
						}
					}		
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