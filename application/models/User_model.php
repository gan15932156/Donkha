﻿<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}

	public function posts()
    {
       $query = $this
                ->db
                ->limit(10)
                ->get('posts');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return null;
        }

    }
	////////////////////////////////////////////////////////////
	/////////////////////  CHECK    ///////////////////////////

	public function check_login($user,$pass){
		$this->db->join('staff', 'user.staff_id = staff.staff_id','inner');
		$this->db->where('username',$user);
		$this->db->where('password',$pass);
		$this->db->where('staff_status','1');		
		$query=$this->db->get('user');
		if($query->num_rows() > 0){
            return $query;
        }
        else{
            return false;
        }
	}
	public function check_std_code($std_code){
		$this->db->where('stu_code',$std_code);
		$query=$this->db->get('staff');
		if($query->num_rows() > 0){
            return '<script type="text/javascript">
            		alert("รหัสนักเรียนซ้ำ");
            		$(document).ready(function(){
            			$("#std_code").val("");
            			$("#name").val("");
            		});
            	</script>
            '; // 0 =ไม่ได้
        }
        else{
            return  '<script type="text/javascript">alert("ใช้รหัสนักเรียนนี้ได้");</script>';  // 1 ได้
        }
	}
	public function check_std_code_member($std_code){
		$this->db->where('std_code',$std_code);
		$query=$this->db->get('member');
		if($query->num_rows() > 0){
            return '<script type="text/javascript">
            		alert("รหัสนักเรียนซ้ำ");
            		$(document).ready(function(){
            			$("#std_code").val("");
            			$("#name").val("");
            		});
            	</script>
            '; // 0 =ไม่ได้
        }
        else{
            return  '<script type="text/javascript">alert("ใช้รหัสนักเรียนนี้ได้");</script>';  // 1 ได้
        }
	}
	public function check_username($username){
		$this->db->where('username',$username);
		$query=$this->db->get('user');
		if($query->num_rows() > 0){
            return '<script type="text/javascript">
            			alert("Username ซ้ำ");
            			$(document).ready(function(){
            				$("#username").val("");
            			});
            		</script>
            '; // 0 =ไม่ได้
        }
        else{
            return '<script type="text/javascript">alert("ใช้ Username นี้ได้");</script>';  // 1 ได้
        }
	}
	public function check_staff_name($name){
		$this->db->where('staff_name',$name);
		$query=$this->db->get('staff');
		if($query->num_rows() > 0){
            return '<script type="text/javascript">
            			alert("ชื่อพนักงานซ้ำ");
            			$(document).ready(function(){
            				$("#name").val("");
            			});
            		</script>
            '; // 0 =ไม่ได้
        }
        else{
            return '<script type="text/javascript">alert("ใช้ชื่อนี้ได้");</script>';  // 1 ได้
        }
	}
	public function check_member_name($name){
		$this->db->where('member_name',$name);
		$query=$this->db->get('member');
		if($query->num_rows() > 0){
            return '<script type="text/javascript">
            			alert("ชื่อสมาชิกซ้ำ");
            			$(document).ready(function(){
            				$("#name").val("");
            			});
            		</script>
            '; // 0 =ไม่ได้
        }
        else{
            return '<script type="text/javascript">alert("ใช้ชื่อนี้ได้");</script>';  // 1 ได้
        }
	}

	////////////////////////////////////////////////////////////
	/////////////////////  INSERT    //////////////////////////

	public function insert_staff($data_staff){
		$this->db->insert('staff',$data_staff);
	}
	public function insert_user($data_user){
		$this->db->insert('user',$data_user);
	}
	public function insert_member($data_member){
		$this->db->insert('member',$data_member);
	}
	public function insert_account($data_account){
		$this->db->insert('account',$data_account);
	}
	public function insert_account_details($data_account_detail){
		$this->db->insert('account_detail',$data_account_detail);
	}
	public function insert_deposit($data_dep){
		$this->db->insert('deposit',$data_dep);
	}
	public function insert_withdraw($data_wd){
		$this->db->insert('withdraw',$data_wd);
	}
	public function insert_tranfer_money($data_tdf){
		$this->db->insert('tranfer_money',$data_tdf);
	}
	public function insert_interest_history($data_interest){
		$this->db->insert('interest_history',$data_interest);
	}
	public function insert_stock_cash_history($data){
		$this->db->insert('stock_cash_history',$data);
	}

	////////////////////////////////////////////////////////////
	/////////////////////  SELECT    //////////////////////////

	public function getProvince(){
		$this->db->from('provinces');
		$query=$this->db->get();
		return $query;
	}
	public function getAmphur($postData){
		$response=array();
		$this->db->select("AMPHUR_ID,AMPHUR_NAME");
		$this->db->where('PROVINCE_ID',$postData['prov_id']);
		$query=$this->db->get("amphures");
		$response=$query->result_array();
		return $response;
	}
	public function getDist($postData){
		$response=array();
		$this->db->select("DISTRICT_CODE,DISTRICT_NAME");
		$this->db->where('AMPHUR_ID',$postData['amp_id']);
		$query=$this->db->get("districts");
		$response=$query->result_array();
		return $response;
	}
	public function getZip($postData){
		$response=array();
		$this->db->select("zipcode");
		$this->db->where('district_code',$postData);
		$query=$this->db->get("zipcodes");
		$output ='';
		foreach($query->result() as $row){
		   $output .= $row->zipcode;
		}
		return $output;
	}
	public function getEdu_level(){
		$this->db->from('edu_level');
		$query=$this->db->get();
		return $query;
	}
	public function getPermission(){
		$this->db->from('level');
		$query=$this->db->get();
		return $query;
	}
	public function select_staff_latest(){
		$this->db->select('*');
		$this->db->limit('1','0');
		$this->db->order_by('staff_id','DESC');
		$query=$this->db->get('staff');
		return $query;
	}
	public function select_member_latest(){
		$this->db->select('*');
		$this->db->limit('1','0');
		$this->db->order_by('member_id','DESC');
		$query=$this->db->get('member');
		return $query;
	}
	public function record_count_staff(){
		return $this->db->count_all("staff");
	}
	public function record_count_member(){
		return $this->db->count_all("member");
	}
	public function select_staff_between($start,$limit){
		$this->db->select('*');
		$this->db->limit($start,$limit);
		$this->db->from('staff');
		$this->db->join('edu_level', 'staff.edu_id = edu_level.edu_id','inner');
		$this->db->join('level', 'staff.level_id = level.level_id','inner');
		$this->db->order_by('staff_id','ASC');
		$query=$this->db->get();
		return $query;
	}
	public function select_member_between($start,$limit){
		$this->db->select('*');
		$this->db->limit($start,$limit);
		$this->db->from('member');
		$this->db->order_by('member_id','ASC');
		$query=$this->db->get();
		return $query;
	}
	public function get_everything_staff($staff_id){
		$this->db->select('*');
		$this->db->from('staff');
		$this->db->join('zipcodes', 'zipcodes.DISTRICT_CODE = staff.DISTRICT_CODE','inner');
		$this->db->join('districts', 'staff.DISTRICT_CODE = districts.DISTRICT_CODE','inner');
		$this->db->join('amphures', 'amphures.AMPHUR_ID = districts.AMPHUR_ID','inner');
		$this->db->join('provinces', 'provinces.PROVINCE_ID = amphures.PROVINCE_ID','inner');
		$this->db->join('edu_level', 'staff.edu_id = edu_level.edu_id','inner');
		$this->db->join('level', 'staff.level_id = level.level_id','inner');
		$this->db->join('user', 'staff.staff_id = user.staff_id','inner');
		$this->db->where("staff.staff_id",$staff_id);
		$query=$this->db->get();
		return $query;
	}
	public function get_student_member($member_id){
		$this->db->select('*');
		$this->db->from('member');
		$this->db->join('zipcodes', 'zipcodes.DISTRICT_CODE = member.DISTRICT_CODE','inner');
		$this->db->join('districts', 'member.DISTRICT_CODE = districts.DISTRICT_CODE','inner');
		$this->db->join('amphures', 'amphures.AMPHUR_ID = districts.AMPHUR_ID','inner');
		$this->db->join('provinces', 'provinces.PROVINCE_ID = amphures.PROVINCE_ID','inner');
		$this->db->join('edu_level', 'member.edu_id = edu_level.edu_id','inner');
		$this->db->join('user', 'user.member_id = member.member_id','inner');
		$this->db->join('level', 'member.level_id = level.level_id','inner');
		$this->db->where("member.member_id",$member_id);
		$query=$this->db->get();
		return $query;
	}
	public function get_personal_member($member_id){
		$this->db->select('*');
		$this->db->from('member');
		$this->db->join('zipcodes', 'zipcodes.DISTRICT_CODE = member.DISTRICT_CODE','inner');
		$this->db->join('districts', 'member.DISTRICT_CODE = districts.DISTRICT_CODE','inner');
		$this->db->join('amphures', 'amphures.AMPHUR_ID = districts.AMPHUR_ID','inner');
		$this->db->join('provinces', 'provinces.PROVINCE_ID = amphures.PROVINCE_ID','inner');
		$this->db->join('level', 'member.level_id = level.level_id','inner');
		$this->db->join('user', 'user.member_id = member.member_id','inner');
		$this->db->join('job', 'member.job_id = job.job_id','inner');
		$this->db->where("member.member_id",$member_id);
		$query=$this->db->get();
		return $query;
	}
	public function get_member($member_id){
		$this->db->select('*');
		$this->db->from('member');
		$this->db->join('zipcodes', 'zipcodes.DISTRICT_CODE = member.DISTRICT_CODE','inner');
		$this->db->join('districts', 'member.DISTRICT_CODE = districts.DISTRICT_CODE','inner');
		$this->db->join('amphures', 'amphures.AMPHUR_ID = districts.AMPHUR_ID','inner');
		$this->db->join('provinces', 'provinces.PROVINCE_ID = amphures.PROVINCE_ID','inner');
		$this->db->where("member.member_id",$member_id);
		$query=$this->db->get();
		return $query;
	}
	public function get_member_noparameter(){
		$this->db->select('*');
		$this->db->from('member');
		$this->db->join('edu_level', 'member.edu_id = edu_level.edu_id','inner');
		$this->db->join('zipcodes', 'zipcodes.DISTRICT_CODE = member.DISTRICT_CODE','inner');
		$this->db->join('districts', 'member.DISTRICT_CODE = districts.DISTRICT_CODE','inner');
		$this->db->join('amphures', 'amphures.AMPHUR_ID = districts.AMPHUR_ID','inner');
		$this->db->join('provinces', 'provinces.PROVINCE_ID = amphures.PROVINCE_ID','inner');
		$this->db->order_by('member_name','ASC');
		$query=$this->db->get();
		return $query;
	}
	public function get_all_member_with_no_edu_6(){
		$this->db->select('*');
		$this->db->from('member');
		$this->db->where('std_code !=', '0');
		$this->db->where('member_status', '1');
		$this->db->where('member.edu_id !=', '0');
		$this->db->order_by('member_id','ASC');
		$query=$this->db->get();
		return $query;
	}
	public function get_all_staff_with_no_edu_6(){
		$this->db->select('*');
		$this->db->from('staff');
		$this->db->where('stu_code !=', '0');
		$this->db->where('staff_status', '1');
		$this->db->where('staff.edu_id !=', '0');
		$this->db->order_by('staff_id','ASC');
		$query=$this->db->get();
		return $query;
	}
	public function get_memberr($member_name){
		$response=array();
		$this->db->select('*');
		$this->db->from('member');
		$this->db->like('member_name',$member_name);
		$query = $this->db->get();
	    if($query->num_rows() > 0) {
	    	$response=$query->result_array();
			return $response ;
	    }
	    else {
	    	return false;
	    }
	}
	public function getAllAmp($pro_id){
		$this->db->from('amphures');
		$this->db->where('PROVINCE_ID',$pro_id);
		$query=$this->db->get();
		return $query;
	}
	public function getAllDist($amp_id){
		$this->db->from('districts');
		$this->db->where('AMPHUR_ID',$amp_id);
		$query=$this->db->get();
		return $query;
	}
	public function getAllZip($dist_id){
		$this->db->from('zipcodes');
		$this->db->where('district_code',$dist_id);
		$query=$this->db->get();
		return $query;
	}
	public function select_search_staff_data($data){
		$this->db->select('*');
		$this->db->from('staff','level');
		if($data != ''){
			$this->db->like('edu_id',$data);
			$this->db->or_like('level_id',$data);
			$this->db->or_like('stu_code',$data);
			$this->db->or_like('staff_name',$data);
			$this->db->or_like('staff_status',$data);
		}
		$this->db->order_by('staff_id','ASC');
		$query = $this->db->get();
		return $query ;
	}
	public function select_search_member_data($data){
		$this->db->select('*');
		$this->db->from('member');
		if($data != ''){
			$this->db->or_like('std_code',$data);
			$this->db->or_like('member_name',$data);
			$this->db->or_like('member_status',$data);
		}
		$this->db->order_by('member_id','ASC');
		$query = $this->db->get();
		return $query ;
	}
	public function getJob(){
		$this->db->from('job');
		$query=$this->db->get();
		return $query;
	}
	public function getMember_student(){
		$this->db->from('member');
		$this->db->where('job_id','2');
		$query=$this->db->get();
		return $query;
	}
	public function getMember_person(){
		$this->db->from('member');
		$this->db->where('std_code','0');
		$query=$this->db->get();
		return $query;
	}
	public function auto_generate_account_code()
	{
	    $year = date("Y");
	    $this->db->select('RIGHT(account.account_id,3) as num', FALSE);
	    $this->db->order_by('account_id', 'DESC');
	    $this->db->limit(1);
	    $query = $this->db->get('account');
	    if($query->num_rows() <> 0) {
	        $data = $query->row();
	        $num = intval($data->num) + 1;
	    }
	    else {
	        $num = 1;
	    }
	    $accode = $year . str_pad($num, 3, 0, STR_PAD_LEFT);
	    return $accode;
	}
	public function select_account_latest(){
		$this->db->select('*');
		$this->db->limit('1','0');
		$this->db->order_by('account_id','DESC');
		$query=$this->db->get('account');
		return $query;
	}
	public function auto_generate_deposit_code()
	{
	    $year = date("Y");
	    $this->db->select('RIGHT(deposit.deposit_id,3) as num', FALSE);
	    $this->db->order_by('deposit_id', 'DESC');
	    $this->db->limit(1);
	    $query = $this->db->get('deposit');
	    if($query->num_rows() <> 0) {
	        $data = $query->row();
	        $num = intval($data->num) + 1;
	    }
	    else {
	        $num = 1;
	    }
	    $depcode = $year . str_pad($num, 3, 0, STR_PAD_LEFT);
	    $real_code = "DEP". $depcode;
	    return $real_code;
	}
	public function auto_generate_withdraw_code()
	{
	    $year = date("Y");
	    $this->db->select('RIGHT(withdraw.withdraw_id,3) as num', FALSE);
	    $this->db->order_by('withdraw_id', 'DESC');
	    $this->db->limit(1);
	    $query = $this->db->get('withdraw');
	    if($query->num_rows() <> 0) {
	        $data = $query->row();
	        $num = intval($data->num) + 1;
	    }
	    else {
	        $num = 1;
	    }
	    $wdcode = $year . str_pad($num, 3, 0, STR_PAD_LEFT);
	    $real_code = "WD". $wdcode;
	    return $real_code;
	}
	public function auto_generate_tranfer_money_code()
	{
	    $year = date("Y");
	    $this->db->select('RIGHT(tranfer_money.tranfer_money_id,3) as num', FALSE);
	    $this->db->order_by('tranfer_money_id', 'DESC');
	    $this->db->limit(1);
	    $query = $this->db->get('tranfer_money');
	    if($query->num_rows() <> 0) {
	        $data = $query->row();
	        $num = intval($data->num) + 1;
	    }
	    else {
	        $num = 1;
	    }
	    $wdcode = $year . str_pad($num, 3, 0, STR_PAD_LEFT);
	    $real_code = "TDF". $wdcode;
	    return $real_code;
	}
	public function auto_generate_interest_code()
	{
	    $year = date("Y");
	    $this->db->select('RIGHT(interest_history.ih_id,3) as num', FALSE);
	    $this->db->order_by('ih_id', 'DESC');
	    $this->db->limit(1);
	    $query = $this->db->get('interest_history');
	    if($query->num_rows() <> 0) {
	        $data = $query->row();
	        $num = intval($data->num) + 1;
	    }
	    else {
	        $num = 1;
	    }
	    $wdcode = $year . str_pad($num, 3, 0, STR_PAD_LEFT);
	    $real_code = "INT". $wdcode;
	    return $real_code;
	}
	public function auto_generate_recive_money_code()
	{
	    $year = date("Y");
		 $this->db->select('RIGHT(tranfer_money.tranfer_money_id,3) as num', FALSE);
		 $this->db->where('tranfer_money_id != ');
		 $this->db->where('SUBSTR(tranfer_money_id,1,3) != "TDF"');
	    $this->db->order_by('tranfer_money_id', 'DESC');
	    $this->db->limit(1);
	    $query = $this->db->get('tranfer_money');
	    if($query->num_rows() <> 0) {
	        $data = $query->row();
	        $num = intval($data->num) + 1;
	    }
	    else {
	        $num = 1;
	    }
	    $wdcode = $year . str_pad($num, 3, 0, STR_PAD_LEFT);
	    $real_code = "REC". $wdcode;
	    return $real_code;
	}
	public function select_account_detail_latest(){
		$this->db->select('*');
		$this->db->limit('1','0');
		$this->db->order_by('account_detail_id','DESC');
		$query=$this->db->get('account_detail');
		return $query;
	}
	public function record_count_account(){
		return $this->db->count_all("account");
	}
	public function select_account_between($start,$limit){
		$this->db->select('*');
		$this->db->limit($start,$limit);
		$this->db->from('account');
		$this->db->order_by('account_id','ASC');
		$query=$this->db->get();
		return $query;
	}
	public function select_search_account_data($data){
		$this->db->select('*');
		$this->db->from('account');
		if($data != ''){
			$this->db->or_like('account_name',$data);
			$this->db->or_like('account_id',$data);
		}
		$this->db->order_by('account_id','ASC');
		$query = $this->db->get();
		return $query ;
	}
	public function select_search_member_staff_data($data){
		$this->db->select('*');
		$this->db->from('member');
		if($data != ''){
			$this->db->or_like('std_code',$data);
			$this->db->or_like('member_name',$data);
			$this->db->or_like('member_status',$data);
		}
		$this->db->order_by('member_id','ASC');
		$query = $this->db->get();
		return $query ;
	}
	public function count_not_confirm_record_dep(){
		$this->db->from('account_detail');
		$this->db->where('account_detail_confirm',"0");	
		$this->db->where("(action = 'recive_money' OR action = 'add_interest' OR action = 'deposit' OR action = 'open_account')");
		return $this->db->count_all_results();
	}
	public function count_not_confirm_record_wd(){
		$this->db->from('account_detail');
		$this->db->where('account_detail_confirm',"0");
		$this->db->where('action', 'withdraw');
		return $this->db->count_all_results();
	}
	public function count_not_confirm_record_tdf(){
		$this->db->from('account_detail');
		$this->db->where('account_detail_confirm',"0");
		$this->db->where('action', 'tranfer_money');
		return $this->db->count_all_results();
	}
	public function select_account_with_parameter($account_id){
		$this->db->from('account');
		$this->db->join('member', 'member.member_id = account.member_id','inner');
		$this->db->where('account_id',$account_id);
		$query=$this->db->get();
		return $query;
	}
	public function select_account_detail_id_tranfer_money($accdetail,$action){
		$this->db->from('account_detail');
		$this->db->join('tranfer_money', 'tranfer_money.tranfer_money_id = account_detail.trans_id','inner');
		$this->db->where('account_detail_id',$accdetail);
		$this->db->where('action',$action);
		$query=$this->db->get('');
		if($query->num_rows() > 0){
            return $query;
        }
        else{
            return false;
        }
	}
	public function select_unconfirm_deposit(){
		$this->db->from('account_detail');
		$this->db->join('deposit', 'trans_id = deposit_id','inner');
		$this->db->join('account', 'account_detail.account_id = account.account_id','inner');
		$this->db->where('account_detail_confirm',"0");
		$this->db->where("(action = 'deposit' OR action = 'open_account')");
		$query = $this->db->get();
		return $query;
	}
	public function select_unconfirm_withdraw(){
		$this->db->from('account_detail');
		$this->db->join('withdraw', 'trans_id = withdraw_id','inner');
		$this->db->join('account', 'account_detail.account_id = account.account_id','inner');
		$this->db->where('account_detail_confirm',"0");
		$this->db->where('action', 'withdraw');
		$query = $this->db->get();
		return $query;
	}
	public function select_unconfirm_tranfer_money(){
		$this->db->from('account_detail');
		$this->db->where('account_detail_confirm',"0");
		$this->db->where('action', 'tranfer_money');
		$this->db->join('tranfer_money', 'trans_id = tranfer_money_id','inner');
		$this->db->join('account', 'account_detail.account_id = account.account_id','inner');
		$query = $this->db->get();
		return $query;
	}
	public function select_account_detail_parameter($account_detail_id){
		$this->db->from('account_detail');
		$this->db->join('account', 'account_detail.account_id = account.account_id','inner');
		$this->db->where('account_detail_id',$account_detail_id);
		$query=$this->db->get();
		return $query;
	}
	public function get_search_account($account_name){
		$response=array();
		$this->db->select('*');
		$this->db->from('account');
		$this->db->join('member', 'member.member_id = account.member_id','inner');
		$this->db->like('account_id',$account_name);
		$this->db->or_like('account_name',$account_name);
		$query = $this->db->get();
	    if($query->num_rows() > 0) {
	    	$response=$query->result_array();
			return $response ;
	    }
	    else {
	    	return false;
	    }
	}
	public function get_search_account_id($account){
		$response=array();
		$this->db->select('*');
		$this->db->from('account');
		$this->db->join('member', 'member.member_id = account.member_id','inner');
		$this->db->where('account_id',$account);
		$this->db->or_where('account_name', $account);
		$query = $this->db->get();
	    if($query->num_rows() > 0) {
			return $query ;
	    }
	    else {
	    	return false;
	    }
	}
	public function check_statement_not_confirm($account_id){
		$this->db->from('account_detail');
		$this->db->join('account', 'account.account_id = account_detail.account_id','inner');
		$this->db->where('account_status','1');	
		$this->db->where('account_detail.account_id',$account_id);	
		$this->db->limit('1','0');
		$this->db->order_by('record_date','DESC');
		$this->db->order_by('record_time','DESC');
		$query=$this->db->get();
		if($query->num_rows() > 0){
            return $query;
        }
        else{
            return false;
        }
	}
	public function get_search_account_id_passbook($account_id){
		$response=array();
		$this->db->select('*');
		$this->db->from('account');
		$this->db->where('account_id',$account_id);
		$query = $this->db->get();
	    if($query->num_rows() > 0) {
	    	$response=$query->result_array();
			return $response ;
	    }
	    else {
	    	return false;
	    }
	}
	public function select_account_detail_with_account_id_not_print($account_id){
		$this->db->from('account_detail');
		$this->db->where('account.account_id',$account_id);
		$this->db->where('passbook_row_status','0');
		$this->db->join('account', 'account_detail.account_id = account.account_id','inner');
		$this->db->join('staff', 'staff_id = staff_record_id','inner');
		$this->db->order_by('record_date ASC, record_time ASC');
		$query=$this->db->get();
		return $query;
	}
	public function select_account_detail_with_account_id_not_print_limit($account_id){
		$this->db->from('account_detail');
		$this->db->where('account.account_id',$account_id);
		$this->db->where('passbook_row_status','0');
		$this->db->join('account', 'account_detail.account_id = account.account_id','inner');
		$this->db->join('staff', 'staff_id = staff_record_id','inner');
		$this->db->limit('1','0');
		$this->db->order_by('record_date ASC, record_time ASC');
		$query=$this->db->get();
		return $query;
	}

	public function select_account_detail_parameter_account_id($account_id,$previous){
		$this->db->from('account_detail');
		$this->db->where('account_id',$account_id);
		$this->db->where("(record_date BETWEEN '".date('Y-m-d', strtotime("-".$previous." month"))."' AND '".date('Y-m-d')."')");
		$this->db->join('staff', 'staff_id = staff_record_id','inner');
		$this->db->order_by('record_date DESC, record_time DESC');
		$query=$this->db->get();
		return $query;
	}
	public function select_account_detail_parameter_account_id_filter($account_id,$filter,$previous){
		$this->db->from('account_detail');
		$this->db->where('account_id',$account_id);
		if($filter == "deposit"){
			$this->db->where("(action = 'recive_money' OR action = 'add_interest' OR action = 'deposit' OR action = 'open_account')"); 
		}
		else if($filter == "withdraw"){
			$this->db->where("(action = 'withdraw' OR action = 'close_account')"); 
		}
		else if($filter == "tranfer_money"){
			$this->db->where('action','tranfer_money');	
		}
		$this->db->where("(record_date BETWEEN '".date('Y-m-d', strtotime("-".$previous." month"))."' AND '".date('Y-m-d')."')");
		$this->db->join('staff', 'staff_id = staff_record_id','inner');
		$this->db->order_by('record_date DESC, record_time DESC');
		$query=$this->db->get();
		return $query;
	}
	public function select_filter_transaction($account_id,$transaction){
		$this->db->from('account_detail');
		if($transaction == "all"){		
			$this->db->where('account_id',$account_id);
		}
		else{
			$this->db->where('account_id',$account_id);
			if($transaction == "deposit"){
				$this->db->where("(action = 'recive_money' OR action = 'add_interest' OR action = 'deposit' OR action = 'open_account')"); 
			}
			else if($transaction == "withdraw"){
				$this->db->where("(action = 'withdraw' OR action = 'close_account')"); 
			}
			else{
				$this->db->where("action = 'tranfer_money'"); 
			}
		}
		$this->db->join('staff', 'staff_id = staff_record_id','inner');
		$this->db->order_by('record_date ASC, record_time ASC');
		$query=$this->db->get();
		return $query;
	}
	public function select_all_account(){
		$this->db->from('account_detail');
		$this->db->where('end_day',"0");
		$this->db->order_by('account_id ASC,record_date ASC, record_time ASC');
		$query=$this->db->get();
		return $query;
	}
	public function select_all_account_never_cal(){
		$this->db->from('account');
		$this->db->where('account_status',"1");
		$this->db->order_by('account_id ASC');
		$query=$this->db->get();
		return $query;
	}
	public function select_account_detail_end_day($account_id){
		$this->db->from('account_detail');
		$this->db->where('account_detail.account_id',$account_id);
		$this->db->where('end_day',"1");
		$this->db->join('account', 'account_detail.account_id = account.account_id','inner');
		$this->db->join('staff', 'staff_id = staff_record_id','inner');
		$this->db->order_by('record_date ASC, record_time ASC');
		$query=$this->db->get();
		return $query;
	}
	public function select_account_detail_end_day_close_account($account_id,$start_date,$stop_date){
		date_default_timezone_set('Asia/Bangkok');
		$this->db->from('account_detail');
		$this->db->where('account_id',$account_id);
		$this->db->where('end_day',"1");
	    $this->db->where('record_date <=',$stop_date);
	    $this->db->where('record_date >=',$start_date);
		$this->db->join('staff', 'staff_id = staff_record_id','inner');
		$this->db->order_by('record_date ASC, record_time ASC');
		$query=$this->db->get();
		if($query->num_rows() > 0) {
			return $query ;
	    }
	    else {
	    	return null;
	    }
	}
	public function select_account_detail_end_day_phase_1($account_id){
		date_default_timezone_set('Asia/Bangkok');
		$this->db->from('account_detail');
		$this->db->where('account_id',$account_id);
		$this->db->where('end_day',"1");
	    $this->db->where('record_date <',date('Y-04-01'));
	    $this->db->where('record_date >=',date('Y-10-01',strtotime('-1 year')));
		$this->db->join('staff', 'staff_id = staff_record_id','inner');
		$this->db->order_by('record_date ASC, record_time ASC');
		$query=$this->db->get();
		if($query->num_rows() > 0) {
			return $query ;
	    }
	    else {
	    	return null;
	    }
	}
	public function select_account_detail_end_day_phase_2($account_id){
		date_default_timezone_set('Asia/Bangkok');
		$this->db->from('account_detail');
		$this->db->where('account_id',$account_id);
		$this->db->where('end_day',"1");
	  $this->db->where('record_date >=',date('Y-04-01'));
	  $this->db->where('record_date <',date('Y-10-01'));
		$this->db->join('staff', 'staff_id = staff_record_id','inner');
		$this->db->order_by('record_date ASC, record_time ASC');
		$query=$this->db->get();
		if($query->num_rows() > 0) {
			return $query ;
	    }
	    else {
	    	return null;
	    }
	}
	public function select_account_detail_end_day_next_row($account_id,$date){
		$this->db->from('account_detail');
		$this->db->where('account_id',$account_id);
		$this->db->where('record_date >', $date);
		$this->db->where('end_day',"1");
		$this->db->limit('1','0');
		$query=$this->db->get();
		return $query;
	}
	public function select_account_detail_end_day_lastest_row($account_id,$date){
		$this->db->from('account_detail');
		$this->db->select_max('record_date');
		$this->db->where('account_id',$account_id);
		$this->db->where('end_day',"1");
		$query=$this->db->get();
		return $query;
	}
	public function select_max_time_account_detail($account_id,$date){
		$this->db->from('account_detail');
		$this->db->select_max('record_time');
		$this->db->where('account_id',$account_id);
		$this->db->where('record_date ',$date);
		$query=$this->db->get();
		return $query;
	}
	public function check_next_date_clsoe_account($account_id,$start_date,$stop_date){
		$this->db->from('account_detail');
		$this->db->select_max('record_date');
		$this->db->where('account_id',$account_id);
		$this->db->where('record_date <=',$stop_date);
		$this->db->where('record_date >=',$start_date);
		$this->db->where('end_day',"1");
		$query = $this->db->get();
	    if($query->num_rows() > 0) {
			return $query;
	    }
	    else {
	    	return false;
	    }
	}
	public function check_next_date_phase1($account_id){
		$this->db->from('account_detail');
		$this->db->select_max('record_date');
		$this->db->where('account_id',$account_id);
		$this->db->where('record_date <',date('Y-04-01'));
		$this->db->where('end_day',"1");
		$query = $this->db->get();
	    if($query->num_rows() > 0) {
			return $query;
	    }
	    else {
	    	return false;
	    }
	}
	public function check_next_date_phase2($account_id){
		$this->db->from('account_detail');
		$this->db->select_max('record_date');
		$this->db->where('account_id',$account_id);
		$this->db->where('record_date >=',date('Y-04-01'));
		$this->db->where('end_day',"1");
		$query = $this->db->get();
	    if($query->num_rows() > 0) {
			return $query;
	    }
	    else {
	    	return false;
	    }
	}
	public function fetch_member_auto_complete($member_name){
		$response=array();
		$this->db->select('*');
		$this->db->from('member');
		$this->db->where('member_status','1');
		$this->db->like('member_name',$member_name);
		$this->db->order_by('member_name', 'ASC');
		$query = $this->db->get();
	    if($query->num_rows() > 0) {
			return $query->result();
	    }
	    else {
	    	return false;
	    }
	}
	public function fetch_account_auto_complete($account){
		$response=array();
		$this->db->select('*');
		$this->db->from('account');
		$this->db->where('account_status','1');
		$this->db->like('account_id',$account);
		$this->db->order_by('account_id', 'ASC');
		$query = $this->db->get();
	   if($query->num_rows() > 0) {
			return $query->result();
	   }
	   else {
	   	return false;
	   }
	}
	public function fetch_account_tranfer_auto_complete($account){
		$response=array();
		$this->db->select('*');
		$this->db->from('account');
		$this->db->where('account_status','1');
		$this->db->like('account_id',$account);
		$this->db->order_by('account_id', 'ASC');
		$query = $this->db->get();
	   if($query->num_rows() > 0) {
			return $query->result();
	   }
	   else {
	   	return false;
	   }
	}
	public function select_repost_test(){
		$this->db->select("*");
		$this->db->from("account");
		$query = $this->db->get();
		return $query->result();
	}
	public function select_open_account_between_date($start_date,$stop_date){
		$this->db->from('account');
		$this->db->where('account_open_date BETWEEN "'. $start_date. '" and "'. $stop_date.'"');
		$this->db->join('member', 'member.member_id = account.member_id','inner');
		$this->db->order_by('account_open_date DESC');
		$query=$this->db->get();
		return $query;
	}
	public function select_close_account_between_date($start_date,$stop_date){
		$this->db->from('account');
		$this->db->join('member', 'member.member_id = account.member_id','inner');
		$this->db->join('staff', 'staff.staff_id = account.staff_close_id','inner');
		$this->db->where('account_close_date BETWEEN "'. $start_date. '" and "'. $stop_date.'"');
		$this->db->where('staff.staff_id = account.staff_close_id');
		$query=$this->db->get();
		return $query;
	}
	public function select_account_detail_open($account_id,$record_date){
		$this->db->from('account_detail');
		$this->db->where('account_id',$account_id);
		$this->db->where('record_date',$record_date);
		$this->db->order_by('record_date ASC, record_time ASC');
		$this->db->limit(1,0);
		$query=$this->db->get();
		return $query;
	}
	public function select_account_detail_close($account_id,$record_date){
		$this->db->from('account_detail');
		$this->db->where('account_id',$account_id);
		$this->db->where('record_date',$record_date);
		$this->db->order_by('record_date ASC, record_time ASC');
		$this->db->limit(1,0);
		$query=$this->db->get();
		return $query;
	}
	public function count_account_opendate_between($start,$end){
		$this->db->from('account');
		$this->db->where('account_open_date BETWEEN "'. $start. '" and "'. $end.'"');
		return $this->db->count_all_results();
	}
	public function count_account_closedate_between($start,$end){
		$this->db->from('account');
		$this->db->where('account_close_date BETWEEN "'. $start. '" and "'. $end.'"');
		return $this->db->count_all_results();
	}
	public function fetch_account_datatable($param){
		$keyword = $param['keyword'];
		$this->db->select('*');
 
		$condition = "1=1";
		if(!empty($keyword)){
			$condition .= " and (account_id like '%{$keyword}%' or account_name like '%{$keyword}%')";
		}
 
		$this->db->where($condition);
		$this->db->limit($param['page_size'], $param['start']);
		$this->db->order_by($param['column'], $param['dir']);
 
		$query = $this->db->get('account');
		$data = [];
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}
		$count_condition = $this->db->from('account')->where($condition)->count_all_results();
		$count = $this->db->from('account')->count_all_results();
		$result = array('count'=>$count,'count_condition'=>$count_condition,'data'=>$data,'error_message'=>'');
		return $result;
	}
	public function fetch_account_detail_datatable($param,$account_id){
		$keyword = $param['keyword'];
		$this->db->select('*');
		$this->db->join('staff', 'staff_id = staff_record_id','inner');
		$condition = "1=1";
		if(!empty($keyword)){
			$condition .= " and (account_detail_id like '%{$keyword}%' or action like '%{$keyword}%')";
		}
		$this->db->where('account_id',$account_id);
		$this->db->where($condition);
		
		$this->db->limit($param['page_size'], $param['start']);
		//$this->db->order_by($param['column'], $param['dir']);
		$this->db->order_by('record_date DESC, record_time DESC');
		$query = $this->db->get('account_detail');
		$data = [];
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}
		$count_condition = $this->db->from('account_detail')->where($condition)->where('account_id',$account_id)->count_all_results();
		$count = $this->db->from('account_detail')->where('account_id',$account_id)->count_all_results();
		$result = array('count'=>$count,'count_condition'=>$count_condition,'data'=>$data,'error_message'=>'');
		return $result;
	}
	public function fetch_filter_account_detail_datatable($param,$account_id,$action){
		$keyword = $param['keyword'];
		$this->db->select('*');
		$this->db->join('staff', 'staff_id = staff_record_id','inner');
		$condition = "1=1";
		if(!empty($keyword)){
			$condition .= " and (account_detail_id like '%{$keyword}%' or action like '%{$keyword}%')";
		}
		$this->db->where('account_id',$account_id);		
		if($action != "all"){
			if($action == "deposit"){
				$condition .= " and (action = 'recive_money' OR action = 'add_interest' OR action = 'deposit' OR action = 'open_account')"; 
			}
			else if($action == "withdraw"){
				$condition .= " and (action = 'withdraw' OR action = 'close_account')"; 
			}
			else{
				$condition .= " and action = 'tranfer_money'"; 
			}
		}
		$this->db->where($condition);
		$this->db->limit($param['page_size'], $param['start']);
		$this->db->order_by('record_date DESC, record_time DESC');
		$query = $this->db->get('account_detail');
		$data = [];
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}
		$count_condition = $this->db->from('account_detail')->where($condition)->where('account_id',$account_id)->count_all_results();
		$count = $this->db->from('account_detail')->where('account_id',$account_id)->count_all_results();
		$result = array('count'=>$count,'count_condition'=>$count_condition,'data'=>$data,'error_message'=>'');
		return $result;
	}
	public function fetch_previous_filter_account_detail_datatable($param,$account_id,$action,$previous){
		date_default_timezone_set('Asia/Bangkok');
		$keyword = $param['keyword'];
		$this->db->select('*');
		$this->db->join('staff', 'staff_id = staff_record_id','inner');
		$condition = "1=1";
		if(!empty($keyword)){
			$condition .= " and (account_detail_id like '%{$keyword}%' or action like '%{$keyword}%')";
		}
		$this->db->where('account_id',$account_id);		
		if($action != "all"){
			if($action == "deposit"){
				$condition .= " and (action = 'recive_money' OR action = 'add_interest' OR action = 'deposit' OR action = 'open_account')"; 
			}
			else if($action == "withdraw"){
				$condition .= " and (action = 'withdraw' OR action = 'close_account')"; 
			}
			else{
				$condition .= " and action = 'tranfer_money'"; 
			}
		}
		$condition .= " and (record_date BETWEEN '".date('Y-m-d', strtotime("-".$previous." month"))."' AND '".date('Y-m-d')."')";
		$this->db->where($condition);
		$this->db->limit($param['page_size'], $param['start']);
		$this->db->order_by('record_date DESC, record_time DESC');
		$query = $this->db->get('account_detail');
		$data = [];
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}
		$count_condition = $this->db->from('account_detail')->where($condition)->where('account_id',$account_id)->count_all_results();
		$count = $this->db->from('account_detail')->where('account_id',$account_id)->count_all_results();
		$result = array('count'=>$count,'count_condition'=>$count_condition,'data'=>$data,'error_message'=>'');
		return $result;
	}
	public function fetch_member_datatable($param){
		date_default_timezone_set('Asia/Bangkok');
		$keyword = $param['keyword'];
		$this->db->select('*');
 
		$condition = "1=1";
		if(!empty($keyword)){
			$condition .= " and (
				member_name like '%{$keyword}%' or 
				std_code like '%{$keyword}%' or
				member_id_card like '%{$keyword}%'
				)";
		}
		$this->db->where($condition);
		$this->db->limit($param['page_size'], $param['start']);
		$this->db->order_by($param['column'], $param['dir']);
 
		$query = $this->db->get('member');
		$data = [];
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}
 
		$count_condition = $this->db->from('member')->where($condition)->count_all_results();
		$count = $this->db->from('member')->count_all_results();
		$result = array('count'=>$count,'count_condition'=>$count_condition,'data'=>$data,'error_message'=>'');
		return $result;
	}
	public function fetch_staff_datatable($param){
		date_default_timezone_set('Asia/Bangkok');
		$keyword = $param['keyword'];
		$this->db->join('level', 'staff.level_id = level.level_id','inner');
		$this->db->select('*');
		
		$condition = "1=1";
		if(!empty($keyword)){
			$condition .= " and (
				staff_name like '%{$keyword}%' or 
				staff.level_id like '%{$keyword}%' or
				staff_status like '%{$keyword}%'
				)";
		}
		
		$this->db->where($condition);
		$this->db->limit($param['page_size'], $param['start']);
		$this->db->order_by($param['column'], $param['dir']);
		
		$query = $this->db->get('staff');
		$data = [];
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}
		$count_condition = $this->db->from('staff')->where($condition)->count_all_results();
		$count = $this->db->from('staff')->count_all_results();
		$result = array('count'=>$count,'count_condition'=>$count_condition,'data'=>$data,'error_message'=>'');
		return $result;
	}
	public function select_account_detail_lastest($account_id){
		date_default_timezone_set('Asia/Bangkok');
		$this->db->from('account_detail');
		$this->db->where('account_id',$account_id);
		$this->db->order_by('record_date DESC, record_time DESC');
		$this->db->limit(1,0);
		$query=$this->db->get();
		if($query->num_rows() > 0){
            return $query;
        }
        else{
            return false;
        }
	}
	public function select_deposit_year(){
		$this->db->select('substr(record_date, 1, 4) as year from account_detail WHERE (action="deposit" OR action="open_account" OR action="recive_money" OR action="add_interest" ) AND record_date !="0000-00-00" group BY year', FALSE);
		return $this->db->get();
	}
	public function select_withdraw_year(){
		$this->db->select('substr(record_date,1,4) as year from account_detail WHERE (action="withdraw" OR action="close_account") AND record_date !="0000-00-00" group BY year', FALSE);
		return $this->db->get();
	}
	public function select_tranfer_year(){
		$this->db->select('substr(record_date,1,4) as year from account_detail WHERE action="tranfer_money" AND record_date !="0000-00-00" group BY year', FALSE);
		return $this->db->get();
	}
	public function select_sum_deposit_year($year){
		$this->db->select('SUM(trans_money) as sum_year from account_detail WHERE (action="deposit" OR action="open_account" OR action="recive_money" OR action="add_interest" ) AND substr(record_date, 1, 4) ='.$year.' AND record_date !="0000-00-00"');
		return $this->db->get();
	}
	public function select_sum_withdraw_year($year){
		$this->db->select('SUM(trans_money) as sum_year from account_detail WHERE (action="withdraw" OR action="close_account") AND substr(record_date, 1, 4) ='.$year.' AND record_date !="0000-00-00"');
		return $this->db->get();
	}
	public function select_sum_tranfer_year($year){
		$this->db->select('SUM(trans_money) as sum_year from account_detail WHERE action="tranfer_money" AND substr(record_date, 1, 4) ='.$year.' AND record_date !="0000-00-00"');
		return $this->db->get();
	}
	public function select_deposit_month($year){
		$this->db->select('DISTINCT(SUBSTR(record_date,6,2)) as month FROM account_detail WHERE (action="deposit" OR action="open_account" OR action="recive_money" OR action="add_interest" ) AND record_date != "0000-00-00" AND SUBSTR(record_date,1,4) = "'.$year.'" ORDER BY record_date');
		return $this->db->get();
	}
	public function select_withdraw_month($year){
		$this->db->select('DISTINCT(SUBSTR(record_date,6,2)) as month FROM account_detail WHERE (action="withdraw" OR action="close_account") AND record_date != "0000-00-00" AND SUBSTR(record_date,1,4) = "'.$year.'" ORDER BY record_date');
		return $this->db->get();
	}
	public function select_tranfer_month($year){
		$this->db->select('DISTINCT(SUBSTR(record_date,6,2)) as month FROM account_detail WHERE action="tranfer_money" AND record_date != "0000-00-00" AND SUBSTR(record_date,1,4) = "'.$year.'" ORDER BY record_date');
		return $this->db->get();
	}
	public function select_sum_deposit_month($year,$month){
		$this->db->select('SUM(trans_money) as summonth FROM `account_detail` WHERE (action="deposit" OR action="open_account" OR action="recive_money" OR action="add_interest" ) AND record_date != "0000-00-00" AND SUBSTR(record_date,1,4) = "'.$year.'" AND SUBSTR(record_date,6,2) = "'.$month.'"');
		return $this->db->get();
	}	
	public function select_sum_withdraw_month($year,$month){
		$this->db->select('SUM(trans_money) as summonth FROM `account_detail` WHERE (action="withdraw" OR action="close_account") AND record_date != "0000-00-00" AND SUBSTR(record_date,1,4) = "'.$year.'" AND SUBSTR(record_date,6,2) = "'.$month.'"');
		return $this->db->get();
	}	
	public function select_sum_tranfer_month($year,$month){
		$this->db->select('SUM(trans_money) as summonth FROM `account_detail` WHERE action="tranfer_money" AND record_date != "0000-00-00" AND SUBSTR(record_date,1,4) = "'.$year.'" AND SUBSTR(record_date,6,2) = "'.$month.'"');
		return $this->db->get();
	}
	public function select_deposit_day($year,$month){
		$this->db->select('DISTINCT(record_date) as tran_date FROM account_detail WHERE (action="deposit" OR action="open_account" OR action="recive_money" OR action="add_interest" ) AND record_date != "0000-00-00" AND SUBSTR(record_date,1,4) = "'.$year.'" AND SUBSTR(record_date,6,2) = "'.$month.'" ORDER BY record_date');
		return $this->db->get();
	}
	public function select_withdraw_day($year,$month){
		$this->db->select('DISTINCT(record_date) as tran_date FROM account_detail WHERE (action="withdraw" OR action="close_account") AND record_date != "0000-00-00" AND SUBSTR(record_date,1,4) = "'.$year.'" AND SUBSTR(record_date,6,2) = "'.$month.'" ORDER BY record_date');
		return $this->db->get();
	}
	public function select_tranfer_day($year,$month){
		$this->db->select('DISTINCT(record_date) as tran_date FROM account_detail WHERE action="tranfer_money" AND record_date != "0000-00-00" AND SUBSTR(record_date,1,4) = "'.$year.'" AND SUBSTR(record_date,6,2) = "'.$month.'" ORDER BY record_date');
		return $this->db->get();
	}
	public function select_sum_deposit_day($date){
		$this->db->select('SUM(trans_money) as sum FROM account_detail WHERE (action="deposit" OR action="open_account" OR action="recive_money" OR action="add_interest" ) AND record_date != "0000-00-00" AND record_date ="'.$date.'"');
		return $this->db->get();
	}
	public function select_sum_withdraw_day($date){
		$this->db->select('SUM(trans_money) as sum FROM account_detail WHERE (action="withdraw" OR action="close_account") AND record_date != "0000-00-00" AND record_date ="'.$date.'"');
		return $this->db->get();
	}
	public function select_sum_tranfer_day($date){
		$this->db->select('SUM(trans_money) as sum FROM account_detail WHERE action="tranfer_money" AND record_date != "0000-00-00" AND record_date ="'.$date.'"');
		return $this->db->get();
	}
	public function select_today_statement(){
		date_default_timezone_set('Asia/Bangkok');
		$this->db->from('account_detail');
		$this->db->join('account', 'account.account_id = account_detail.account_id','inner');
		$this->db->where("record_date",date('Y-m-d'));
		$this->db->where("(action = 'deposit' OR action = 'open_account' OR action = 'withdraw' OR action = 'close_account')");
		$this->db->order_by('record_date DESC, record_time DESC');
		$query=$this->db->get();
		if($query->num_rows() > 0){
            return $query;
        }
        else{
            return false;
        }
	}
	public function select_open_account_open_money($account_id){
		$this->db->select('*');
		$this->db->join('account', 'account.account_id = account_detail.account_id','inner');
		$this->db->join('member', 'member.member_id = account.member_id','inner');
		$this->db->from('account_detail');
		$this->db->where('account_detail.account_id',$account_id);
		//		$this->db->where('action','open_account');
		$this->db->order_by('record_date ASC, record_time ASC');
		$this->db->limit(1,0);
		$query=$this->db->get();
		if($query->num_rows() > 0){
         return $query;
      }
      else{
         return false;
      }
	}
	public function select_open_account_report($param,$start_date,$stop_date){
		date_default_timezone_set('Asia/Bangkok');
		$keyword = $param['keyword'];
      	$this->db->select('*');
		
		$condition = "1=1";
		if(!empty($keyword)){
			$condition .= " and (account_id like '%{$keyword}%' or account_name like '%{$keyword}%')";
		}
		$this->db->where('account_open_date BETWEEN "'. $start_date. '" and "'. $stop_date.'"');
		$this->db->limit($param['page_size'], $param['start']);
		$this->db->order_by('account_open_date DESC');
		$this->db->order_by('account_id DESC');
		$query = $this->db->get('account');
		$data = [];
		$limit_money = 0.0;
		$total_money = 0.0;
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				foreach($this->select_open_account_open_money($row->account_id)->result() as $row2){
					$data[] = $row2;
					$limit_money += floatval($row2->trans_money);
				}	
			}
			foreach($this->select_open_account_between_date($start_date,$stop_date)->result() as $row3){
				foreach($this->select_open_account_open_money($row3->account_id)->result() as $row4){
					$total_money += floatval($row4->trans_money);
				}	
			}
		}

		$count_condition = $this->db->from('account')->where($condition)->where('account_open_date BETWEEN "'. $start_date. '" and "'. $stop_date.'"')->count_all_results();
		$count = $this->db->from('account')->where('account_open_date BETWEEN "'. $start_date. '" and "'. $stop_date.'"')->count_all_results();
		$result = array('count'=>$count,'count_condition'=>$count_condition,'data'=>$data,'error_message'=>'','limit_money'=>$limit_money,'total_money'=>$total_money);
		return $result;
	}
	public function select_close_account_report($param,$start_date,$stop_date){
		date_default_timezone_set('Asia/Bangkok');
		$keyword = $param['keyword'];
      $this->db->select('*');
		
		$condition = "1=1";
		if(!empty($keyword)){
			$condition .= " and (account_id like '%{$keyword}%' or account_name like '%{$keyword}%')";
		}
		$this->db->join('member', 'member.member_id = account.member_id','inner');
		$this->db->join('staff', 'staff.staff_id = account.staff_close_id','inner');
		$this->db->where('account_close_date BETWEEN "'. $start_date. '" and "'. $stop_date.'"');
		$this->db->limit($param['page_size'], $param['start']);
		$this->db->order_by('account_close_date DESC');
		$this->db->order_by('account_id DESC');
		$query = $this->db->get('account');
		$data = [];
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row;		
			}
		}
		$count_condition = $this->db->from('account')->where($condition)->where('account_close_date BETWEEN "'. $start_date. '" and "'. $stop_date.'"')->count_all_results();
		$count = $this->db->from('account')->where('account_close_date BETWEEN "'. $start_date. '" and "'. $stop_date.'"')->count_all_results();
		$result = array('count'=>$count,'count_condition'=>$count_condition,'data'=>$data,'error_message'=>'');
		return $result;
	}
	public function select_account_detail_today_non_parameter($param){
		date_default_timezone_set('Asia/Bangkok');
		$keyword = $param['keyword'];
      	$this->db->select('*');
		$this->db->join('account', 'account.account_id = account_detail.account_id','inner');
		$condition = "1=1";
		if(!empty($keyword)){
			$condition .= " and (account_id like '%{$keyword}%' or account_name like '%{$keyword}%')";
		}
		$this->db->where("record_date",date('Y-m-d'));
		$this->db->where("record_date",date('Y-m-d'));
		$this->db->where($condition);
		$this->db->where("(action = 'deposit' OR action = 'open_account' OR action = 'withdraw' OR action = 'close_account')");
		$this->db->limit($param['page_size'], $param['start']);
		$this->db->order_by('record_date DESC, record_time DESC');
		$query = $this->db->get('account_detail');
		$data = [];
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}
		$count_condition = $this->db->from('account_detail')->where($condition)->where("record_date",date('Y-m-d'))->where("(action = 'deposit' OR action = 'open_account' OR action = 'withdraw' OR action = 'close_account')")->count_all_results();
		$count = $this->db->from('account_detail')->where("record_date",date('Y-m-d'))->where("(action = 'deposit' OR action = 'open_account' OR action = 'withdraw' OR action = 'close_account')")->count_all_results();
		$result = array('count'=>$count,'count_condition'=>$count_condition,'data'=>$data,'error_message'=>'');
		return $result;
	}
	public function get_sum_statement_today_limit($page_size,$start){
		date_default_timezone_set('Asia/Bangkok');
		$this->db->select('*');
		$this->db->where("record_date",date('Y-m-d'));
		$this->db->where("(action = 'deposit' OR action = 'open_account' OR action = 'withdraw' OR action = 'close_account')");
		$this->db->limit($page_size, $start);
		$this->db->order_by('record_date DESC, record_time DESC');
		return $this->db->get("account_detail");
	}
	public function get_sum_statement_today(){
		date_default_timezone_set('Asia/Bangkok');
		$this->db->select('*');
		$this->db->where("record_date",date('Y-m-d'));
		$this->db->where("(action = 'deposit' OR action = 'open_account' OR action = 'withdraw' OR action = 'close_account')");
		$this->db->order_by('record_date DESC, record_time DESC');
		return $this->db->get("account_detail");
	}
	public function select_stock_cash($admin_id){
		if($admin_id == "4"){
			$this->db->select("stock_cash");
			$query=$this->db->get("stock_cash");
			if($query->num_rows() > 0){
				return $query;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	public function select_stock_cash_no_admin(){
		$this->db->select("stock_cash");
		$query=$this->db->get("stock_cash");
		if($query->num_rows() > 0){
			return $query;
		}
		else{
			return false;
		}
	}


	////////////////////////////////////////////////////////////
	/////////////////////  UPDATE    //////////////////////////

	public function update_staff($data,$staff_id){
		$this->db->where("staff_id",$staff_id);
		$this->db->update("staff",$data);
	}
	public function staff_change_status($staff_id,$status){
		if($status == '1'){
			$data = array('staff_status' => '0');
			$this->db->where("staff_id",$staff_id);
			$this->db->update("staff",$data);
		}
		else{
			$data = array('staff_status' => '1');
			$this->db->where("staff_id",$staff_id);
			$this->db->update("staff",$data);
		}
	}
	public function update_member($data,$member_id){
		$this->db->where("member_id",$member_id);
		$this->db->update("member",$data);
	}
	public function member_change_status($member_id,$status){
		if($status == '1'){
			$data = array('member_status' => '0');
			$this->db->where("member_id",$member_id);
			$this->db->update("member",$data);
		}
		else{
			$data = array('member_status' => '1');
			$this->db->where("member_id",$member_id);
			$this->db->update("member",$data);
		}
	}
	public function update_confirm_deposit($account_detail_id,$trans_id,$staff_id){
		$data_account_detail = array(
			'account_detail_confirm' => '1',
			'staff_record_id' => $staff_id
		);
		$this->db->where("account_detail_id",$account_detail_id);
		$this->db->where("action","deposit");
		$this->db->or_where("action","open_account");
		$this->db->where("trans_id",$trans_id);
		$this->db->update("account_detail",$data_account_detail);
	}
	public function update_confirm_withdraw($account_detail_id,$trans_id,$staff_id){
		$data_account_detail = array(
			'account_detail_confirm' => '1',
			'staff_record_id' => $staff_id
	);
		$this->db->where("account_detail_id",$account_detail_id);
		$this->db->where("action","withdraw");
		$this->db->where("trans_id",$trans_id);
		$this->db->update("account_detail",$data_account_detail);
	}
	public function update_confirm_tranfer_money($account_detail_id,$trans_id,$staff_id){
		$data_account_detail = array(
			'account_detail_confirm' => '1',
			'staff_record_id' => $staff_id
		);
		$this->db->where("account_detail_id",$account_detail_id);
		$this->db->where("action","tranfer_money");
		$this->db->where("trans_id",$trans_id);
		$this->db->update("account_detail",$data_account_detail);
	}
	public function update_staff_confirm_reice_tranfer($account_detail_id,$staff_id){
		$data_account_detail = array(
			'account_detail_confirm' => '1',
			'staff_record_id' => $staff_id
		);
		$this->db->where("account_detail_id",$account_detail_id);
		$this->db->update("account_detail",$data_account_detail);
	}
	public function update_confirm_account_deposit($account_id,$account_balance){
		$data_account = array('account_balance' => $account_balance);
		$this->db->where("account_id",$account_id);
		$this->db->update("account",$data_account);
	}
	public function update_confirm_account_withdraw($account_id,$account_balance){
		$data_account = array('account_balance' => $account_balance);
		$this->db->where("account_id",$account_id);
		$this->db->update("account",$data_account);
	}
	public function update_confirm_account_tranfer($account_id,$account_balance){
		$data_account = array('account_balance' => $account_balance);
		$this->db->where("account_id",$account_id);
		$this->db->update("account",$data_account);
	}
	public function update_table_confirm_deposit_money_tb_account_detail($account_detail_id,$data_account_detail){
		$this->db->where("account_detail_id",$account_detail_id);
		$this->db->update("account_detail",$data_account_detail);
	}
	public function update_table_confirm_deposit_money_tb_deposit($deposit_id,$data_deposit){
		$this->db->where("deposit_id",$deposit_id);
		$this->db->update("deposit",$data_deposit);
	}
	public function update_table_confirm_withdraw_money_tb_account_detail($account_detail_id,$data_account_detail){
		$this->db->where("account_detail_id",$account_detail_id);
		$this->db->update("account_detail",$data_account_detail);
	}
	public function update_table_confirm_withdraw_money_tb_withdraw($withdraw_id,$data_withdraw){
		$this->db->where("withdraw_id",$withdraw_id);
		$this->db->update("withdraw",$data_withdraw);
	}
	public function update_table_confirm_tranfer_money_tb_tranfer($tdf_id,$data_tdf){
		$this->db->where("tranfer_money_id",$tdf_id);
		$this->db->update("tranfer_money",$data_tdf);
	}
	public function update_end_day_account_detail($account_detail_id,$data){
		$this->db->where("account_detail_id",$account_detail_id);
		$this->db->update("account_detail",$data);
	}
	public function update_interest_account($account_id,$data_account){
		$this->db->where("account_id",$account_id);
		$this->db->update('account',$data_account);
	}
	public function update_account($account_id,$data_account){
		$this->db->where("account_id",$account_id);
		$this->db->update('account',$data_account);
	}
	public function update_edu_level($tb,$id,$data){
		$this->db->where($tb."_id",$id);
		$this->db->update($tb,$data);
	}
	public function update_stock_cash($id,$data){
		$this->db->where("stock_id",$id);
		$this->db->update("stock_cash",$data);
	}
}
