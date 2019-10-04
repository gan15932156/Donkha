<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Service_App_Model extends CI_Model {
	public function __construct(){
		parent::__construct();
    }
    public function check__isset_account($member_id){
		$this->db->from('member');
		$this->db->join('account', 'account.member_id = member.member_id','inner');
		$this->db->where('member.member_id',$member_id);
		$this->db->where('account_status','1');
		$this->db->where('member_status','1');		
		$query=$this->db->get('');
		if($query->num_rows() > 0){
            return $query;
        }
        else{
            return false;
        }
    }
    public function get_statement($account_id){
      $this->db->from('account_detail');
		$this->db->where('account_id',$account_id);
		$this->db->where('account_detail_confirm','1');	
		$query=$this->db->get('');
		if($query->num_rows() > 0){
            return $query;
        }
        else{
            return false;
        }
	}
	public function select_st_deposit($account_detail_id){
		$this->db->from('account_detail');
		$this->db->join('deposit', 'deposit.deposit_id = account_detail.trans_id','inner');
		$this->db->where('account_detail_id',$account_detail_id);
		$this->db->where("(action = 'deposit' OR action = 'open_account')"); 
		$query=$this->db->get('');
		if($query->num_rows() > 0){
            return $query;
        }
        else{
            return false;
        }
	}
	public function select_st_withdraw($account_detail_id){
		$this->db->from('account_detail');
		$this->db->join('withdraw', 'withdraw.withdraw_id = account_detail.trans_id','inner');
		$this->db->where('account_detail_id',$account_detail_id);
		$this->db->where("action = 'withdraw'"); 
		$query=$this->db->get('');
		if($query->num_rows() > 0){
            return $query;
        }
        else{
            return false;
        }
	}
	public function select_st_add_interest($account_detail_id){
		$this->db->from('account_detail');
		$this->db->join('interest_history', 'interest_history.ih_id = account_detail.trans_id','inner');
		$this->db->where('account_detail_id',$account_detail_id);
		$this->db->where("action = 'add_interest'"); 
		$query=$this->db->get('');
		if($query->num_rows() > 0){
            return $query;
        }
        else{
            return false;
        }
	}
	public function select_st_tranfer($account_detail_id){
		$this->db->from('account_detail');
		$this->db->join('tranfer_money', 'tranfer_money.tranfer_money_id = account_detail.trans_id','inner');
		$this->db->where('account_detail_id',$account_detail_id);
		$this->db->where("(action = 'recive_money' OR action = 'tranfer_money')"); 
		$query=$this->db->get('');
		if($query->num_rows() > 0){
            return $query;
        }
        else{
            return false;
        }
	}
	public function select_filter_st($account_id,$action){
		$this->db->from('account_detail');
		$this->db->where('account_id',$account_id);
		if($action != "all"){
			if($action == "deposit"){
				$this->db->where("(action = 'recive_money' OR action = 'add_interest' OR action = 'deposit' OR action = 'open_account')"); 
			}
			else if($action == "withdraw"){
				$this->db->where("action = 'withdraw'"); 
			}
			else{
				$this->db->where('action','tranfer_money');	
			}
		}
		$this->db->where('account_detail_confirm','1');	
		$query=$this->db->get('');
		if($query->num_rows() > 0){
            return $query;
        }
        else{
            return false;
        }
	}
    public function check_login_app($user,$pass){
		$this->db->from('user');
		$this->db->join('member', 'user.member_id = member.member_id','inner');
		$this->db->where('username',$user);
		$this->db->where('password',$pass);
		$this->db->where('member_status','1');		
		return $query=$this->db->get('');
		
	}
	public function select_member_detail($member_id){
		$this->db->from('member');
		$this->db->join('zipcodes', 'zipcodes.DISTRICT_CODE = member.DISTRICT_CODE','inner');
		$this->db->join('districts', 'member.DISTRICT_CODE = districts.DISTRICT_CODE','inner');
		$this->db->join('amphures', 'amphures.AMPHUR_ID = districts.AMPHUR_ID','inner');
		$this->db->join('provinces', 'provinces.PROVINCE_ID = amphures.PROVINCE_ID','inner');
		$this->db->join('job', 'job.job_id = member.job_id','inner');
		$this->db->where('member_id',$member_id);
		$this->db->where('member_status','1');		
		return $query=$this->db->get('');
		if($query->num_rows() > 0){
            return $query;
        }
        else{
            return false;
        }
		
	}
	public function select_account($account){
		$this->db->from('account');
		$this->db->join('member', 'member.member_id = account.member_id','inner');
		$this->db->where('account_id',$account);
		$this->db->where('account_status','1');		
		return $query=$this->db->get('');
		if($query->num_rows() > 0){
            return $query;
        }
        else{
            return false;
        }
		
	}
	public function fotgot_password_app($forgot,$state,$username){
		$this->db->from('user');
		$this->db->join('member', 'user.member_id = member.member_id','inner');
		if($state == "นักเรียน"){
			$this->db->where('std_code',$forgot);
		}
		else{
			$this->db->where('member_id_card',$forgot);
		}	
		$this->db->where('username',$username);	
		$this->db->where('member_status','1');		
		$query=$this->db->get();
		if($query->num_rows() > 0){
            return $query;
        }
        else{
            return false;
        }
	}
	public function deposit_service_insert($data_dep){
		$this->db->insert('deposit',$data_dep);	
		if( $this->db->affected_rows() > 0 ) 
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	public function account_detail_service_insert($data_account_detail){	
		$this->db->insert('account_detail',$data_account_detail);
        if( $this->db->affected_rows() > 0 ) 
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
}
