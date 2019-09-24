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
    public function check_login_app($user,$pass){
		$this->db->from('user');
		$this->db->join('member', 'user.member_id = member.member_id','inner');
		$this->db->where('username',$user);
		$this->db->where('password',$pass);
		$this->db->where('member_status','1');		
		return $query=$this->db->get('');
		
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
}
