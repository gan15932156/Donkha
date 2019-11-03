<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Service_app extends CI_Controller {
    public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('Service_App_Model');
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
		$account_id = $this->input->post('account_id');
		//$member_id = "17"; //abcd
		if($data['account']=$this->Service_App_Model->select_account($account_id)){
			foreach ($data['account']->result() as $row) {
				$account_balance = array(
					'account_id'=>$row->account_id, 
					'balance'=>$row->account_balance, 
					'account_name'=>$row->account_name
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
	public function check_account(){
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
		$account_id = $this->input->post('account_id');
		//$member_id = "17"; //abcd  
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
		
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);
	}
	public function get_member_detail(){
		$this->response = null ;
		$member_id = $this->input->post("member_id");
		//$member_id = "17";
		if($data['member']=$this->Service_App_Model->select_member_detail($member_id)){
			foreach ($data['member']->result() as $row) {
				$member_array = array(
					'member_id'=>$row->member_id,
					'level_id'=>$row->level_id,
					'edu_id'=>$row->edu_id,
					'std_code'=>$row->std_code,
					'member_id_card'=>$row->member_id_card,
					'member_name'=>$row->member_name,
					'member_birth_date'=>$row->member_birth_date,
					'member_yofadmis'=>$row->member_yofadmis,
					'address'=>$row->address,
					'phone_number'=>$row->phone_number,
					'member_pic'=>$row->member_pic,
					'member_signa_pic'=>$row->member_signa_pic,
					'member_regis_date'=>$row->member_regis_date,
					'member_title'=>$row->member_title,
					'zipcode'=>$row->zipcode,
					'DISTRICT_NAME'=>$row->DISTRICT_NAME,
					'AMPHUR_NAME'=>$row->AMPHUR_NAME,
					'PROVINCE_NAME'=>$row->PROVINCE_NAME,
					'job_name'=>$row->job_name,
				);
			}
			$this->response['error'] = false; 
			$this->response['message'] = 'พบสมาชิก'; 
			$this->response['member'] = $member_array;    
		}
		else{
			$this->response['error'] = true;
			$this->response['message'] = 'ไม่พบสมาชิก';
		}



		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);
	}
	public function select_account(){
		$this->response = null ;
		$account_id = $this->input->post('account_id');
		//$account_id = '2019001';
		$rel_check;
		if($data['check']=$this->Service_App_Model->check_statement_not_confirm($account_id)){
			foreach($data['check']->result() as $row1){
				$rel_check = $row1->account_detail_confirm;
			}
			if($rel_check === "0"){
				$this->response['result_check'] = '0' ;
			}
			else{
				$this->response['result_check'] = '1' ;
				foreach ($this->Service_App_Model->select_account($account_id)->result() as $row) {
					$account_array = array(
						'account_id'=>$row->account_id,
						'member_id'=>$row->member_id,
						'staff_open_id'=>$row->staff_open_id,
						'staff_close_id'=>$row->staff_close_id,
						'account_open_date'=>$row->account_open_date,
						'account_close_date'=>$row->account_close_date,
						'account_name'=>$row->account_name,
						'account_status'=>$row->account_status,
						'account_balance'=>$row->account_balance,
						'passbook_line'=>$row->passbook_line,
						'interest_update'=>$row->interest_update,
						'member_signa_pic'=>$row->member_signa_pic
					);
				}
				$this->response['account'] = $account_array;    
			}
			$this->response['error'] = false; 
			$this->response['message'] = 'พบบัญชี'; 
			
		}
		else{
			$this->response['error'] = true;
			$this->response['message'] = 'ไม่พบบัญชี';
		}

		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);
	}
	public function receive_deposit_insert(){
		$this->response = null ;
		date_default_timezone_set('Asia/Bangkok');	
		$dep_code = $this->User_model->auto_generate_deposit_code();
		$data_dep=array(
			'deposit_id'=>$dep_code,
			'account_id'=>$this->input->post("account_id"),
			'money_deposit'=>$this->input->post("deposit_money")
		);	
		$data_account_detail=array(
			'trans_id'=>$dep_code,
			'account_id'=>$this->input->post("account_id"),
			'staff_record_id'=>'',
			'action'=>'deposit',
			'record_date'=>date('Y-m-d'),
			'record_time'=>date('H:i:s'),
			'account_detail_balance'=>$this->input->post("new_balance"),
			'trans_money'=>$this->input->post("deposit_money"),
			'account_detail_confirm'=>'0',
		);
		if($this->Service_App_Model->deposit_service_insert($data_dep) && $this->Service_App_Model->account_detail_service_insert($data_account_detail)){
			$this->response['error'] = false;
			$this->response['message'] = 'ทำรายการสำเร็จ กรุณารอการยืนยันจากพนักงาน';
		}
		else{
			$this->response['error'] = true;
			$this->response['message'] = 'ไม่สามารถทำรายการได้';
		}
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);	
	}
	public function receive_withdraw_insert(){
		$this->response = null ;
		date_default_timezone_set('Asia/Bangkok');	
		$wd_code = $this->User_model->auto_generate_withdraw_code();
		$data_wd=array(
			'withdraw_id'=>$wd_code,
			'account_id'=>$this->input->post("account_id"),
			'money_withdraw'=>$this->input->post("withdraw_money")
		);	
		$data_account_detail=array(
			'trans_id'=>$wd_code,
			'account_id'=>$this->input->post("account_id"),
			'staff_record_id'=>'',
			'action'=>'withdraw',
			'record_date'=>date('Y-m-d'),
			'record_time'=>date('H:i:s'),
			'account_detail_balance'=>$this->input->post("new_balance"),
			'trans_money'=>$this->input->post("withdraw_money"),
			'account_detail_confirm'=>'0',
		);
		if($this->Service_App_Model->withdraw_service_insert($data_wd) && $this->Service_App_Model->account_detail_service_insert($data_account_detail)){
			$this->response['error'] = false;
			$this->response['message'] = 'ทำรายการสำเร็จ กรุณารอการยืนยันจากพนักงาน';
		}
		else{
			$this->response['error'] = true;
			$this->response['message'] = 'ไม่สามารถทำรายการได้';
		}
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);	
	}
	public function bypasstranfer(){
		$this->response = null ;
		$this->response['error'] = true;
		
		
		foreach ($this->Service_App_Model->check_account_tranfer($this->input->post("account_id_tranfer"))->result() as $row) {
			$account_balance=$row->account_balance;
		}
		$new_balance = $account_balance+$this->input->post('tranfer_money',true);	
		$this->response['message'] = 'account_id '.$this->input->post("account_id")." account_id_tranfer ".$this->input->post("account_id_tranfer")." money_tranfer ".$this->input->post("tranfer_money")." total ".$this->input->post("new_balance")." receriver banlance ".$new_balance;
		
		
		
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);
	}
	public function receive_tranfer_insert(){
		$this->response = null ;
		date_default_timezone_set('Asia/Bangkok');	
		$tdf_code = $this->User_model->auto_generate_tranfer_money_code();
		$data_tran=array(
			'tranfer_money_id'=>$tdf_code,
			'account_id'=>$this->input->post("account_id"),
			'account_id_tranfer'=>$this->input->post("account_id_tranfer"),
			'money_tranfer'=>$this->input->post("tranfer_money")
		);	
		$data_account_detail=array(
			'trans_id'=>$tdf_code,
			'account_id'=>$this->input->post("account_id"),
			'staff_record_id'=>'1',
			'action'=>'tranfer_money',
			'record_date'=>date('Y-m-d'),
			'record_time'=>date('H:i:s'),
			'account_detail_balance'=>$this->input->post("new_balance"),
			'trans_money'=>$this->input->post("tranfer_money"),
			'account_detail_confirm'=>'1',
		);
		if($data["check_account"]=$this->Service_App_Model->check_account_tranfer($this->input->post("account_id_tranfer"))){
			if($this->Service_App_Model->tranfer_service_insert($data_tran) && $this->Service_App_Model->account_detail_service_insert($data_account_detail)){		
				$this->Service_App_Model->update_account_tranfer_service($this->input->post("account_id"),$this->input->post("new_balance"));
				
				$rec_code = $this->User_model->auto_generate_recive_money_code();
				foreach ($data["check_account"]->result() as $row) {
					$account_balance=$row->account_balance;
				}
				$new_balance = $account_balance+$this->input->post('tranfer_money',true);	

				$data_account_detail_reciver=array(
					'trans_id'=>$rec_code, //recive tranfer money
					'account_id'=>$this->input->post("account_id_tranfer"),
					'staff_record_id'=>'1',
					'action'=>'recive_money',
					'record_date'=>date('Y-m-d'),
					'record_time'=>date('H:i:s'),
					'account_detail_balance'=>$new_balance,
					'trans_money'=>$this->input->post("tranfer_money"),
					'account_detail_confirm'=>'1',
				);
				$data_rec=array(
					'tranfer_money_id'=>$rec_code,
					'account_id'=>$this->input->post("account_id_tranfer"),
					'account_id_tranfer'=>$this->input->post("account_id"),
					'money_tranfer'=>$this->input->post("tranfer_money")
				);
				if($this->Service_App_Model->tranfer_service_insert($data_rec) && $this->Service_App_Model->account_detail_service_insert($data_account_detail_reciver)){
					$this->Service_App_Model->update_confirm_account_tranfer_service($this->input->post("account_id_tranfer"),$new_balance);
					$this->response['error'] = false;
					$this->response['message'] = 'ทำรายการสำเร็จ';
				}
				else{
					$this->response['error'] = true;
					$this->response['message'] = 'ไม่สามารถทำรายการได้';
				}		
			}
			else{
				$this->response['error'] = true;
				$this->response['message'] = 'ไม่สามารถทำรายการได้';
			}
		}
		else{
			$this->response['error'] = true;
			$this->response['message'] = 'ไม่พบบัญชีที่โอน';
		}	
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);	
	}
	public function check_statement_confirm(){
		$this->response = null ;
		$account_id = $this->input->post("account_id");
		//$account_id = "2019001";
		if($data['account']=$this->Service_App_Model->select_check_statement_confirm($account_id)){
			$rel;
			foreach ($data['account']->result() as $row) {
				$account_array = array(
					'account_detail_id'=>$row->account_detail_id,
					'trans_id'=>$row->trans_id,
					'account_id'=>$row->account_id,
					'staff_record_id'=>$row->staff_record_id,
					'action'=>$row->action,
					'record_date'=>$row->record_date,
					'record_time'=>$row->record_time,
					'account_detail_balance'=>$row->account_detail_balance,
					'trans_money'=>$row->trans_money
				);
				$rel = $row->account_detail_confirm;
			}
			$this->response['account'] = $account_array;
			$this->response['relsult_check'] = $rel;
			$this->response['error'] = true;
			$this->response['message'] = 'พบ';
		}
		else{
			$this->response['error'] = false;
			$this->response['message'] = 'ไม่พบ';
		}

		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);	
	}
	public function select_statement_today(){
		date_default_timezone_set('Asia/Bangkok');
		$this->response = null; 
		$account_id = $this->input->post("account_id");
		//$account_id = "2019002";

		if($data['statement']=$this->Service_App_Model->select_st_today($account_id,date('Y-m-d')))  {
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
		
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);
	}
	public function select_deposit_today(){
		date_default_timezone_set('Asia/Bangkok');
		$this->response = null; 
		$account_id = $this->input->post("account_id");
		//$account_id = "2019001";

		if($data['statement']=$this->Service_App_Model->select_deposit_today($account_id,date('Y-m-d')))  {
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
			}
			$this->response['error'] = false; 
			$this->response['message'] = 'พบข้อมูล'; 
			$this->response['statement'] = $st;    
			
		}
		else{
			$this->response['error'] = true; 
			$this->response['message'] = 'ไม่พบข้อมูล';
		}
		
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);
	}
	public function select_withdraw_today(){
		date_default_timezone_set('Asia/Bangkok');
		$this->response = null; 
		$account_id = $this->input->post("account_id");
		//$account_id = "2019001";

		if($data['statement']=$this->Service_App_Model->select_withdraw_today($account_id,date('Y-m-d')))  {
			foreach ($data['statement']->result() as $row2) {
				$account_detail_id = $row2->account_detail_id;
				$acccc = $row2->action;
				if($acccc == 'withdraw'){
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
			$this->response['message'] = 'ไม่พบข้อมูล';
		}
		
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);
	}
	public function select_tranfer_today(){
		date_default_timezone_set('Asia/Bangkok');
		$this->response = null; 
		$account_id = $this->input->post("account_id");
		//$account_id = "2019001";

		if($data['statement']=$this->Service_App_Model->select_tranfer_today($account_id,date('Y-m-d')))  {
			foreach ($data['statement']->result() as $row2) {
				$account_detail_id = $row2->account_detail_id;
				$acccc = $row2->action;
				if($acccc == 'recive_money' || $acccc == 'tranfer_money'){
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
		
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);
	}
	public function select_autocomplete_account_id(){
		date_default_timezone_set('Asia/Bangkok');
		$this->response = null; 

		if($data['account_id']=$this->Service_App_Model->select_auto_account($this->input->post("account_id"))){
			foreach($data['account_id']->result() as $row){
				$account = array(
					'account_id'=>$row->account_id,
				);
				$accountt[] = $account;	
			}
			$this->response['error'] = false; 
			$this->response['message'] = 'พบข้อมูล'; 
			$this->response['account_id'] = $accountt;    
		}
		else{
			$this->response['error'] = true; 
			$this->response['message'] = 'ไม่พบข้อมูล';
		}
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);
	}
	public function check_received_tranfer_money(){
		date_default_timezone_set('Asia/Bangkok');
		$this->response = null; 
		$account_id = $this->input->post("account_id");
		$account_id = "2019005";
		if($data['check']=$this->Service_App_Model->check_receive_tranfer_money($account_id)){
			foreach($data['check']->result() as $row){
				$this->response['check'] = $row;
			}
			$this->response['error'] = false; 
			$this->response['message'] = 'พบข้อมูล'; 
			    
		}
		else{
			$this->response['error'] = true; 
			$this->response['message'] = 'ไม่พบข้อมูล';
		}
		echo json_encode($this->response,JSON_UNESCAPED_UNICODE);
	}
}