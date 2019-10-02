<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Project_controller extends CI_Controller {
	public $ip = "127.0.0.1";
	public $picture_path = "picture/"/*"/opt/lampp/htdocs/Donkha/picture/"*/;
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->database();
		$this->load->model('User_model');
		$this->load->library('pagination');
		$this->load->library('Pdf');
	}
	public function DateThai($strDate)
   { 
		$strYear = date("Y",strtotime($strDate))+543;
		$thaiyear = $strYear;
      $strMonth= date("n",strtotime($strDate));
      $strDay= date("j",strtotime($strDate));
      $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
      $strMonthThai=$strMonthCut[$strMonth];
      return "$strDay $strMonthThai $thaiyear";
   } 

	////////////////////////////////////////////////////////////
	//////////////////////  PAGE    //////////////////////////

 	public function index_admin(){
		$this->load->view('templates/header');
		$this->load->view('index_admin');
		$this->load->view('templates/footer');
  	}
  	public function index_manager(){
		$this->load->view('templates/header');
		$this->load->view('index_manager');
		$this->load->view('templates/footer');
	}
	public function test_page(){
		$data['not_confirm_dep'] = $this->User_model->count_not_confirm_record_dep();
    	$data['not_confirm_wd'] = $this->User_model->count_not_confirm_record_wd();
		$data['test']=$this->User_model->getProvince();
		$this->load->view('templates/header');
		$this->load->view('test',$data);
		$this->load->view('templates/footer');
	}
   public function index_staff(){
    	$data['not_confirm_dep'] = $this->User_model->count_not_confirm_record_dep();
		$data['not_confirm_wd'] = $this->User_model->count_not_confirm_record_wd();
		$data['not_confirm_tdf'] = $this->User_model->count_not_confirm_record_tdf();
		$this->load->view('templates/header');
		$this->load->view('index_staff',$data);
		$this->load->view('templates/footer');	
   }
    public function manage_staff(){
		$this->load->view('templates/header');
		$this->load->view('manage_staff');
		$this->load->view('templates/footer');	
	}
	public function staff_detail(){
		$staff_id=$this->uri->segment(3);
		$data['staff']=$this->User_model->get_everything_staff($staff_id);
		$this->load->view('templates/header');
		$this->load->view('staff_detail',$data);
		$this->load->view('templates/footer');	
		
	}
	public function member_detail(){
		$member_id=$this->uri->segment(3);
		$data['member']=$this->User_model->get_member($member_id);
		$member=$data['member']->result();
		foreach ($member as $row) {
			$std_id=$row->std_code;
		}
		if($std_id == '0'){ //บุคลากร
			$data['member_after']=$this->User_model->get_personal_member($member_id);
		}
		else{ //นักเรียน
			$data['member_after']=$this->User_model->get_student_member($member_id);
		}
		$this->load->view('templates/header');
		$this->load->view('member_detail',$data);
		$this->load->view('templates/footer');		
	}
	public function member_detail_staff(){
		$member_id=$this->uri->segment(3);
		$data['member']=$this->User_model->get_member($member_id);
		$member=$data['member']->result();
		foreach ($member as $row) {
			$std_id=$row->std_code;
		}
		if($std_id == '0'){ //บุคลากร
			$data['member_after']=$this->User_model->get_personal_member($member_id);
		}
		else{ //นักเรียน
			$data['member_after']=$this->User_model->get_student_member($member_id);
		}
		$this->load->view('templates/header');
		$this->load->view('member_detail_staff',$data);
		$this->load->view('templates/footer');				
	}
	public function manage_member(){
		$this->load->view('templates/header');
		$this->load->view('manage_member');
		$this->load->view('templates/footer');			
	}
	public function manage_member_staff(){
		$this->load->view('templates/header');
		$this->load->view('manage_member_staff');
		$this->load->view('templates/footer');					
	}
	public function manage_account(){
		$this->load->view('templates/header');
		$this->load->view('manage_account');
		$this->load->view('templates/footer');							
	}
	public function noti_dep(){
		$data['unconfirm_deposit'] =  $this->User_model->select_unconfirm_deposit();
		$this->load->view('templates/header');
		$this->load->view('noti_dep',$data);
		$this->load->view('templates/footer');						
	}
	public function account_detail(){
		$account_id=$this->uri->segment(3);
		$data['account']=$this->User_model->select_account_with_parameter($account_id);
		$data['account_detail']=$this->User_model->select_account_detail_parameter_account_id($account_id);
		$this->load->view('templates/header');
		$this->load->view('account_details',$data);
		$this->load->view('templates/footer');									
	}
	public function noti_wd(){
		$data['unconfirm_withdraw'] =  $this->User_model->select_unconfirm_withdraw();		
		$this->load->view('templates/header');
		$this->load->view('noti_wd',$data);
		$this->load->view('templates/footer');						
	}
	public function noti_tdf(){
		$data['unconfirm_tdf'] =  $this->User_model->select_unconfirm_tranfer_money();		
		$this->load->view('templates/header');
		$this->load->view('noti_tdf',$data);
		$this->load->view('templates/footer');						
	}
	public function passbook_display(){
		$this->load->view('templates/header');
		$this->load->view('passbook_display');
		$this->load->view('templates/footer');					
	}
	public function test_report(){
		$this->load->view('templates/header');
		$this->load->view('report_test');
		$this->load->view('templates/footer');				
	}
	public function test_get_data_repost(){
		$respon->cols[] = array(
			"label" => "ชื่อบัญชี",
			"type" => "string"
		);
		$respon->cols[] = array(
			"label" => "ยอดเงินคงเหลือ",
			"type" => "number"
		);
		$result = $this->User_model->select_repost_test();
		foreach ($result as $row) {
			$respon->rows[]['c'] = array(
				array(
					"v" =>$row->account_name
				),
				array(
					"v" =>$row->account_balance
				)
			);
		}
		echo json_encode($respon);
	}
	public function manager_member_report(){
		$this->load->view('templates/header');
		$this->load->view('manager_member_report');
		$this->load->view('templates/footer');					
	}


	////////////////////////////////////////////////////////////
	//////////////////////  FORM    //////////////////////////

	public function index(){
		$this->cal_end_day();
		//$this->cal_interest_auto();
		$this->cal_edu_level_auto();
		$this->load->view('index');
    }
    public function staff_insert_form(){
    	$data['province']=$this->User_model->getProvince();
    	$data['edu_level']=$this->User_model->getEdu_level();
		$data['permiss']=$this->User_model->getPermission();
		$this->load->view('templates/header');
		$this->load->view('staff_insert_form',$data);
		$this->load->view('templates/footer');	
	}
	public function staff_update_form(){
		$staff_id=$this->uri->segment(3);
		$data['staff']=$this->User_model->get_everything_staff($staff_id);
		$staff=$data['staff']->result();
		foreach ($staff as $row) {
			$pro_id=$row->PROVINCE_ID;
			$amp_id=$row->AMPHUR_ID;
			$dist_id=$row->DISTRICT_CODE;
		}
    	$data['base_edu_level']=$this->User_model->getEdu_level();
    	$data['base_permiss']=$this->User_model->getPermission();
    	$data['base_province']=$this->User_model->getProvince();
    	$data['base_amphures']=$this->User_model->getAllAmp($pro_id);
		$data['base_districts']=$this->User_model->getAllDist($amp_id);
		$data['base_zipcode']=$this->User_model->getAllZip($dist_id);
		$this->load->view('templates/header');
		$this->load->view('staff_update_form',$data);
		$this->load->view('templates/footer');		
	}
	public function member_insert_form(){
    	$data['province']=$this->User_model->getProvince();
    	$data['edu_level']=$this->User_model->getEdu_level();
    	$data['permiss']=$this->User_model->getPermission();
		$data['job']=$this->User_model->getJob();
		$this->load->view('templates/header');
		$this->load->view('member_insert_form',$data);
		$this->load->view('templates/footer');			
	}
	public function member_insert_form_staff(){
    	$data['province']=$this->User_model->getProvince();
    	$data['edu_level']=$this->User_model->getEdu_level();
    	$data['permiss']=$this->User_model->getPermission();
    	$data['job']=$this->User_model->getJob();		
		$this->load->view('templates/header');
		$this->load->view('member_insert_form_staff',$data);
		$this->load->view('templates/footer');			
	}

	public function member_update_form(){
		$member_id=$this->uri->segment(3);
		$data['member']=$this->User_model->get_member($member_id);
		$member=$data['member']->result();
		foreach ($member as $row) {
			$std_id=$row->std_code;
			$pro_id=$row->PROVINCE_ID;
			$amp_id=$row->AMPHUR_ID;
			$dist_id=$row->DISTRICT_CODE;
		}
		if($std_id == '0'){ //บุคลากร
			$data['member_after']=$this->User_model->get_personal_member($member_id);
			$data['base_permiss']=$this->User_model->getPermission();
			$data['base_edu_level']=$this->User_model->getEdu_level();
	    	$data['base_province']=$this->User_model->getProvince();
	    	$data['base_job']=$this->User_model->getJob();
	    	$data['base_amphures']=$this->User_model->getAllAmp($pro_id);
			$data['base_districts']=$this->User_model->getAllDist($amp_id);
			$data['base_zipcode']=$this->User_model->getAllZip($dist_id);
			$this->load->view('templates/header');
			$this->load->view('member_update_form',$data);
			$this->load->view('templates/footer');					
		}
		else{ //นักเรียน
			$data['member_after']=$this->User_model->get_student_member($member_id);
			$data['base_edu_level']=$this->User_model->getEdu_level();
	    	$data['base_permiss']=$this->User_model->getPermission();
	    	$data['base_province']=$this->User_model->getProvince();
	    	$data['base_job']=$this->User_model->getJob();
	    	$data['base_amphures']=$this->User_model->getAllAmp($pro_id);
			$data['base_districts']=$this->User_model->getAllDist($amp_id);
			$data['base_zipcode']=$this->User_model->getAllZip($dist_id);
			$this->load->view('templates/header');
			$this->load->view('member_update_form',$data);
			$this->load->view('templates/footer');					
		}
	}
	public function account_insert_form(){
		$staff_id=$this->uri->segment(3);
		$data['staff_id']=$staff_id;
		$data['student']=$this->User_model->getMember_student();
		$data['person']=$this->User_model->getMember_person();
		$data['accode']=$this->User_model->auto_generate_account_code();
		$data['member']=$this->User_model->get_member_noparameter();
		$this->load->view('templates/header');
		$this->load->view('account_insert_form',$data);
		$this->load->view('templates/footer');		
	}
	public function member_update_form_staff(){
		$member_id=$this->uri->segment(3);
		$data['member']=$this->User_model->get_member($member_id);
		$member=$data['member']->result();
		foreach ($member as $row) {
			$std_id=$row->std_code;
			$pro_id=$row->PROVINCE_ID;
			$amp_id=$row->AMPHUR_ID;
			$dist_id=$row->DISTRICT_CODE;
		}
		if($std_id == '0'){ //บุคลากร
			$data['member_after']=$this->User_model->get_personal_member($member_id);
			$data['base_permiss']=$this->User_model->getPermission();
			$data['base_edu_level']=$this->User_model->getEdu_level();
	    	$data['base_province']=$this->User_model->getProvince();
	    	$data['base_job']=$this->User_model->getJob();
	    	$data['base_amphures']=$this->User_model->getAllAmp($pro_id);
			$data['base_districts']=$this->User_model->getAllDist($amp_id);
			$data['base_zipcode']=$this->User_model->getAllZip($dist_id);			
			$this->load->view('templates/header');
			$this->load->view('member_update_form_staff',$data);
			$this->load->view('templates/footer');				
		}
		else{ //นักเรียน
			$data['member_after']=$this->User_model->get_student_member($member_id);
			$data['base_edu_level']=$this->User_model->getEdu_level();
	    	$data['base_permiss']=$this->User_model->getPermission();
	    	$data['base_province']=$this->User_model->getProvince();
	    	$data['base_job']=$this->User_model->getJob();
	    	$data['base_amphures']=$this->User_model->getAllAmp($pro_id);
			$data['base_districts']=$this->User_model->getAllDist($amp_id);
			$data['base_zipcode']=$this->User_model->getAllZip($dist_id);			
			$this->load->view('templates/header');
			$this->load->view('member_update_form_staff',$data);
			$this->load->view('templates/footer');				
		}
	}
	public function account_insert_form_continue_admin(){
		$member_id=$this->uri->segment(3);
		$data['member']=$this->User_model->get_member($member_id);
		$data['accode']=$this->User_model->auto_generate_account_code();
		$this->load->view('templates/header');
		$this->load->view('account_insert_form_continue_admin',$data);
		$this->load->view('templates/footer');						
	}
	public function account_insert_form_continue_staff(){
		$member_id=$this->uri->segment(3);
		$data['member']=$this->User_model->get_member($member_id);
		$data['accode']=$this->User_model->auto_generate_account_code();		
		$this->load->view('templates/header');
		$this->load->view('account_insert_form_continue_staff',$data);
		$this->load->view('templates/footer');		
	}
	public function deposit_insert_form(){
		$this->load->view('templates/header');
		$this->load->view('deposit_insert_form');
		$this->load->view('templates/footer');				
	}
	public function withdraw_insert_form(){
		$this->load->view('templates/header');
		$this->load->view('withdraw_insert_form');
		$this->load->view('templates/footer');				
	}
	public function tranfer_money_insert_form(){
		$this->load->view('templates/header');
		$this->load->view('tranfer_money_insert_form');
		$this->load->view('templates/footer');			
	}
	public function close_account(){
		$this->load->view('templates/header');
		$this->load->view('close_account_form');
		$this->load->view('templates/footer');				
	}
	public function account_update_form(){
		$account_id=$this->uri->segment(3);

	}
	public function manager_deposit_report(){
		$this->load->view('templates/header');
		$this->load->view('manager_deposit_report');
		$this->load->view('templates/footer');		
	}
	public function manager_withdraw_report(){
		$this->load->view('templates/header');
		$this->load->view('manager_withdraw_report');
		$this->load->view('templates/footer');
	}
	public function manager_account_report(){
		$this->load->view('templates/header');
		$this->load->view('manager_account_report');
		$this->load->view('templates/footer');
	}
	

	////////////////////////////////////////////////////////////
	//////////////////////  INSERT    //////////////////////////

	public function staff_insert(){
		date_default_timezone_set('Asia/Bangkok');
		$username=$this->input->post("username");
		$password=base64_encode($this->input->post("password"));
		$temp;
		$newfilename;
		if(file_exists($_FILES['pic']['tmp_name']) && is_uploaded_file($_FILES['pic']['tmp_name'])) {
			$temp = null;
			$newfilename = null;
			$temp = explode(".", $_FILES["pic"]["name"]);
			$newfilename = time()."-staff_picture".'.'.end($temp);
			if(move_uploaded_file($_FILES["pic"]["tmp_name"],$this->picture_path.$newfilename)){
				$pic = "http://".$this->ip."/Donkha/picture/".$newfilename ;
				chmod($this->picture_path.$newfilename,0755);
			}
		}
		$data_staff=array(
			'edu_id'=>$this->input->post("edu_level"),
			'level_id'=>$this->input->post("permiss"),
			'DISTRICT_CODE'=>$this->input->post("DISTRICT_CODE"),
			'stu_code'=>$this->input->post("std_code"),
			'staff_title'=>$this->input->post("title"),
			'staff_name'=>$this->input->post("name"),
			'staff_id_card'=>$this->input->post("id_card"),
			'staff_status'=>'1',
			'staff_address'=>$this->input->post("address"),
			'staff_pic' => $pic,
			'staff_regis_date' =>date('Y-m-d'),
			'staff_close_date' =>'0',
			'staff_yofadmis'=>intval($this->input->post('yofadmis'))-543
		);
		$this->User_model->insert_staff($data_staff);
		$data['staff'] = $this->User_model->select_staff_latest();
		$staff=$data['staff']->result();
		foreach ($staff as $row) {
			$staff_id=$row->staff_id;
		}
		$data_user=array(
			'staff_id'=>$staff_id,
			'member_id'=>'0',
			'username'=>$username,
			'password'=>$password
		);
		$this->User_model->insert_user($data_user);
	}
	public function member_insert(){
		date_default_timezone_set('Asia/Bangkok');
		$username=$this->input->post("username");
		$password=base64_encode($this->input->post("password"));
		$pic_member;
		$pic_singna;
		$temp;
		$newfilename;
		if(file_exists($_FILES['pic_member']['tmp_name']) && is_uploaded_file($_FILES['pic_member']['tmp_name'])) {
			$temp = null;
			$newfilename = null;
			$temp = explode(".", $_FILES["pic_member"]["name"]);
			$newfilename = time()."-member_picture".'.'.end($temp);
			if(move_uploaded_file($_FILES["pic_member"]["tmp_name"],$this->picture_path.$newfilename)){
				$pic_member = "http://".$this->ip."/Donkha/picture/".$newfilename ;
				chmod($this->picture_path.$newfilename,0755);
			}
		}
		if(file_exists($_FILES['pic_singna']['tmp_name']) && is_uploaded_file($_FILES['pic_singna']['tmp_name'])) {
			$temp = null;
			$newfilename = null;
			$temp = explode(".", $_FILES["pic_singna"]["name"]);
			$newfilename = time()."-member_singature".'.'.end($temp);
			if(move_uploaded_file($_FILES["pic_singna"]["tmp_name"],$this->picture_path.$newfilename)){
				$pic_singna = "http://".$this->ip."/Donkha/picture/".$newfilename ;
				chmod($this->picture_path.$newfilename,0755);
			} 
		}	
		$data_member=array(
			'level_id'=>$this->input->post("permiss"),
			'DISTRICT_CODE'=>$this->input->post("DISTRICT_CODE"),
			'job_id'=>$this->input->post("job"),
			'edu_id'=>($this->input->post("edu_level") == "" ? "0" : $this->input->post("edu_level")),
			'std_code'=>$this->input->post("std_code"),
			'member_id_card'=>$this->input->post("id_card"),
			'member_name'=>$this->input->post("name"),
			'member_birth_date'=>$this->input->post("b_date"),
			'member_yofadmis'=>intval($this->input->post('yofadmis'))-543,
			'address'=>$this->input->post("address"),
			'phone_number'=>$this->input->post("phone_number"),
			'member_pic'=>$pic_member,
			'member_signa_pic'=>$pic_singna,
			'member_regis_date'=>date('Y-m-d'),
			'member_title'=>$this->input->post("title"),
			'member_status' => "1"
		);
		$this->User_model->insert_member($data_member);
		$data['member'] = $this->User_model->select_member_latest();
		$member=$data['member']->result();
		foreach ($member as $row) {
			$member_id=$row->member_id;
		}
		$data_user=array(
			'staff_id'=>'0',
			'member_id'=>$member_id,
			'username'=>$username,
			'password'=>$password
		);
		$this->User_model->insert_user($data_user);
		$url1 = base_url('Project_controller/account_insert_form_continue_admin/').$member_id;
		$url2 = base_url('Project_controller/manage_member/');
		echo '
        	<script type="text/javascript">
        		var confirn =  confirm("ต้องการเปิดบัญชีหรือไม่");
        		if(confirn == true){ window.open("'.$url1.'", "_self");}
        		else{ window.open("'.$url2.'", "_self"); }
        	</script>
        	';
	}
	public function member_insert_staff(){
		date_default_timezone_set('Asia/Bangkok');
		$username=$this->input->post("username");
		$password=base64_encode($this->input->post("password"));
		$pic_member;
		$pic_singna;
		$temp;
		$newfilename;
		if(file_exists($_FILES['pic_member']['tmp_name']) && is_uploaded_file($_FILES['pic_member']['tmp_name'])) {
			$temp = null;
			$newfilename = null;
			$temp = explode(".", $_FILES["pic_member"]["name"]);
			$newfilename = time()."-member_picture".'.'.end($temp);
			if(move_uploaded_file($_FILES["pic_member"]["tmp_name"],$this->picture_path.$newfilename)){
				$pic_member = "http://".$this->ip."/Donkha/picture/".$newfilename ;
				chmod($this->picture_path.$newfilename,0755);
			}
		}
		if(file_exists($_FILES['pic_singna']['tmp_name']) && is_uploaded_file($_FILES['pic_singna']['tmp_name'])) {
			$temp = null;
			$newfilename = null;
			$temp = explode(".", $_FILES["pic_singna"]["name"]);
			$newfilename = time()."-member_singature".'.'.end($temp);
			if(move_uploaded_file($_FILES["pic_singna"]["tmp_name"],$this->picture_path.$newfilename)){
				$pic_singna = "http://".$this->ip."/Donkha/picture/".$newfilename ;
				chmod($this->picture_path.$newfilename,0755);
			} 
		}	
		$data_member=array(
			'level_id'=>$this->input->post("permiss"),
			'DISTRICT_CODE'=>$this->input->post("DISTRICT_CODE"),
			'job_id'=>$this->input->post("job"),
			'edu_id'=>($this->input->post("edu_level") == "" ? "0" : $this->input->post("edu_level")),
			'std_code'=>$this->input->post("std_code"),
			'member_id_card'=>$this->input->post("id_card"),
			'member_name'=>$this->input->post("name"),
			'member_birth_date'=>$this->input->post("b_date"),
			'member_yofadmis'=>intval($this->input->post('yofadmis'))-543,
			'address'=>$this->input->post("address"),
			'phone_number'=>$this->input->post("phone_number"),
			'member_pic'=>$pic_member,
			'member_signa_pic'=>$pic_singna,
			'member_regis_date'=>date('Y-m-d'),
			'member_title'=>$this->input->post("title"),
			'member_status' => "1"
		);
		$this->User_model->insert_member($data_member);
		$data['member'] = $this->User_model->select_member_latest();
		$member=$data['member']->result();
		foreach ($member as $row) {
			$member_id=$row->member_id;
		}
		$data_user=array(
			'staff_id'=>'0',
			'member_id'=>$member_id,
			'username'=>$username,
			'password'=>$password
		);
		$this->User_model->insert_user($data_user);
		$url1 = base_url('Project_controller/account_insert_form_continue_staff/').$member_id;
		$url2 = base_url('Project_controller/manage_member_staff/');
		echo '
            	<script type="text/javascript">
            		var confirn =  confirm("ต้องการเปิดบัญชีหรือไม่");
            		if(confirn == true){ window.open("'.$url1.'", "_self");}
            		else{ window.open("'.$url2.'", "_self"); }
            	</script>
            	';	
	}
	public function account_insert(){
		date_default_timezone_set('Asia/Bangkok');
		$now_time= date('H:i:s');
		$data_acc=array(
			'account_id'=>$this->input->post("ac_code"),
			'member_id'=>$this->input->post("member_id"),
			'staff_open_id'=>$this->input->post("staff_id"),
			'account_open_date'=>$this->input->post("date"),
			'account_name'=>$this->input->post("ac_name"),
			'account_status'=>'1',
		);
		$this->User_model->insert_account($data_acc);
		$dep_code = $this->User_model->auto_generate_deposit_code();
		$data_dep=array(
			'deposit_id'=>$dep_code,
			'account_id'=>$this->input->post("ac_code"),
			'money_deposit'=>$this->input->post("money")
		);
		$this->User_model->insert_deposit($data_dep);
		$data_account_detail=array(
			'trans_id'=>$dep_code,
			'account_id'=>$this->input->post("ac_code"),
			'staff_record_id'=>$this->input->post("staff_id"),
			'action'=>'deposit',
			'record_date'=>$this->input->post("now_date"),
			'record_time'=>$now_time,
			'account_detail_balance'=>$this->input->post("money"),
			'trans_money'=>$this->input->post("money"),
			'account_detail_confirm'=>'0',
		);
		$this->User_model->insert_account_details($data_account_detail);
	}
	public function account_insert_staff(){
 		date_default_timezone_set('Asia/Bangkok');
		$now_time= date('H:i:s');
		$data_acc=array(
			'account_id'=>$this->input->post("ac_code"),
			'member_id'=>$this->input->post("member_id"),
			'staff_open_id'=>$this->input->post("staff_id"),
			'account_open_date'=>$this->input->post("date"),
			'account_name'=>$this->input->post("ac_name"),
			'account_status'=>'1',
		);
		$this->User_model->insert_account($data_acc);
		$dep_code = $this->User_model->auto_generate_deposit_code();
		$data_dep=array(
			'deposit_id'=>$dep_code,
			'account_id'=>$this->input->post("ac_code"),
			'money_deposit'=>$this->input->post("money")
		);
		$this->User_model->insert_deposit($data_dep);
		$data_account_detail=array(
			'trans_id'=>$dep_code,
			'account_id'=>$this->input->post("ac_code"),
			'staff_record_id'=>$this->input->post("staff_id"),
			'action'=>'open_account',
			'record_date'=>$this->input->post("date"),
			'record_time'=>$now_time,
			'account_detail_balance'=>$this->input->post("money"),
			'trans_money'=>$this->input->post("money"),
			'account_detail_confirm'=>'0',
		);
		$this->User_model->insert_account_details($data_account_detail);
	}
	public function deposit_insert(){
		date_default_timezone_set('Asia/Bangkok');
		$now_time= date('H:i:s');
		$dep_code = $this->User_model->auto_generate_deposit_code();
		$data_dep=array(
			'deposit_id'=>$dep_code,
			'account_id'=>$this->input->post("acc_code"),
			'money_deposit'=>$this->input->post("deposit_money")
		);
		$this->User_model->insert_deposit($data_dep);
		$data_account_detail=array(
			'trans_id'=>$dep_code,
			'account_id'=>$this->input->post("acc_code"),
			'staff_record_id'=>$this->input->post("staff_id"),
			'action'=>'deposit',
			'record_date'=>$this->input->post("date"),
			'record_time'=>$now_time,
			'account_detail_balance'=>$this->input->post("new_balance"),
			'trans_money'=>$this->input->post("deposit_money"),
			'account_detail_confirm'=>'0',
		);
		$this->User_model->insert_account_details($data_account_detail);
	}
	public function withdraw_insert(){
		date_default_timezone_set('Asia/Bangkok');
		$now_time= date('H:i:s');
		$wd_code = $this->User_model->auto_generate_withdraw_code();
		$data_wd=array(
			'withdraw_id'=>$wd_code,
			'account_id'=>$this->input->post("acc_code"),
			'money_withdraw'=>$this->input->post("withdraw_money")
		);
		$this->User_model->insert_withdraw($data_wd);
		$data_account_detail=array(
			'trans_id'=>$wd_code,
			'account_id'=>$this->input->post("acc_code"),
			'staff_record_id'=>$this->input->post("staff_id"),
			'action'=>'withdraw',
			'record_date'=>$this->input->post("date"),
			'record_time'=>$now_time,
			'account_detail_balance'=>$this->input->post("new_balance"),
			'trans_money'=>$this->input->post("withdraw_money"),
			'account_detail_confirm'=>'0',
		);
		$this->User_model->insert_account_details($data_account_detail);
	}

	public function tranfer_money_insert(){
		date_default_timezone_set('Asia/Bangkok');
		$now_time= date('H:i:s');
		$td_code = $this->User_model->auto_generate_tranfer_money_code();
		$data_tdf=array(
			'tranfer_money_id'=>$td_code,
			'account_id'=>$this->input->post("acc_code"),
			'account_id_tranfer'=>$this->input->post("ac_tranfer"),
			'money_tranfer'=>$this->input->post("tranfer_money")
		);
		$this->User_model->insert_tranfer_money($data_tdf);
		$data_account_detail=array(
			'trans_id'=>$td_code,
			'account_id'=>$this->input->post("acc_code"),
			'staff_record_id'=>$this->input->post("staff_id"),
			'action'=>'tranfer_money',
			'record_date'=>$this->input->post("date"),
			'record_time'=>$now_time,
			'account_detail_balance'=>$this->input->post("new_balance"),
			'trans_money'=>$this->input->post("tranfer_money"),
			'account_detail_confirm'=>'0',
		);
		$this->User_model->insert_account_details($data_account_detail);
		//ผู้รับ
		$rec_code = $this->User_model->auto_generate_recive_money_code();
		foreach ($this->User_model->select_account_with_parameter($this->input->post("ac_tranfer"))->result() as $row) {
			$account_balance=$row->account_balance;
		}
		$new_balance = $account_balance+$this->input->post('tranfer_money',true);

		$data_account_detail_reciver=array(
			'trans_id'=>$rec_code, //recive tranfer money
			'account_id'=>$this->input->post("ac_tranfer"),
			'staff_record_id'=>$this->input->post("staff_id"),
			'action'=>'recive_money',
			'record_date'=>$this->input->post("date"),
			'record_time'=>$now_time,
			'account_detail_balance'=>$new_balance,
			'trans_money'=>$this->input->post("tranfer_money"),
			'account_detail_confirm'=>'1',
		);
		$data_rec=array(
			'tranfer_money_id'=>$rec_code,
			'account_id'=>$this->input->post("ac_tranfer"),
			'account_id_tranfer'=>$this->input->post("acc_code"),
			'money_tranfer'=>$this->input->post("tranfer_money")
		);
		$this->User_model->insert_tranfer_money($data_rec);
		$this->User_model->insert_account_details($data_account_detail_reciver);
		$this->User_model->update_confirm_account_tranfer($this->input->post("ac_tranfer"),$new_balance);
	}
	public function close_account_insert(){
		$data_clsoe_account=array(
			'account_id'=>$this->input->post("acc_code"),
			'account_balance'=>$this->input->post("acc_balance_hidden"),
			'interest'=>$this->input->post("bonus_hidden"),
			'new_balance'=>round(floatval($this->input->post("new_balance_hidden")),2),
		);
		print_r($data_clsoe_account);
	}


	////////////////////////////////////////////////////////////
	//////////////////////  UPDATE    //////////////////////////

	public function staff_update(){
		$staff_id=$this->input->post("staff_id");
		$pic = $this->input->post("show_image");
		$temp;
		$newfilename;
		if(file_exists($_FILES['pic']['tmp_name']) || is_uploaded_file($_FILES['pic']['tmp_name'])) {
			$temp = null;
			$newfilename = null;
			$temp = explode(".", $_FILES["pic"]["name"]);
			$newfilename = time()."-staff_picture".'.'.end($temp);
			if(move_uploaded_file($_FILES["pic"]["tmp_name"], $this->picture_path.$newfilename)){
				$pic = "http://".$this->ip."/Donkha/picture/".$newfilename ;
				chmod($this->picture_path.$newfilename,0755);
			} 
		}
		$data_staff=array(
			'edu_id'=>$this->input->post("edu_level"),
			'level_id'=>$this->input->post("permiss"),
			'DISTRICT_CODE'=>$this->input->post("DISTRICT_CODE"),
			'stu_code'=>$this->input->post("std_code"),
			'staff_title'=>$this->input->post("title"),
			'staff_name'=>$this->input->post("name"),
			'staff_id_card'=>$this->input->post("id_card"),
			'staff_status'=>'1',
			'staff_address'=>$this->input->post("address"),
			'staff_pic' => $pic,
			'staff_yofadmis'=>intval($this->input->post('yofadmis'))-543
		);
		$this->User_model->update_staff($data_staff,$staff_id);
	}
	public function member_update(){
	 	$pic_member = $this->input->post("show_member_pic");
		$pic_singna = $this->input->post("show_member_signa_pic");
		$stdid=$this->input->post("std_code");
		$member_id=$this->input->post("member_id");		
		$temp;
		$newfilename;
		if(file_exists($_FILES['pic_member']['tmp_name']) && is_uploaded_file($_FILES['pic_member']['tmp_name'])) {
			$temp = null;
			$newfilename = null;
			$temp = explode(".", $_FILES["pic_member"]["name"]);
			$newfilename = time()."-member_picture".'.'.end($temp);
			if(move_uploaded_file($_FILES["pic_member"]["tmp_name"], $this->picture_path.$newfilename)){
				$pic_member = "http://".$this->ip."/Donkha/picture/".$newfilename ;
				chmod($this->picture_path.$newfilename,0755);
			} ///opt/lampp/htdocs/Donkha/picture/
		}
		if(file_exists($_FILES['pic_singna']['tmp_name']) && is_uploaded_file($_FILES['pic_singna']['tmp_name'])) {
			$temp = null;
			$newfilename = null;
			$temp = explode(".", $_FILES["pic_singna"]["name"]);
			$newfilename = time()."-member_singature".'.'.end($temp);
			if(move_uploaded_file($_FILES["pic_singna"]["tmp_name"],$this->picture_path.$newfilename)){
				$pic_singna = "http://".$this->ip."/Donkha/picture/".$newfilename ;
				chmod($this->picture_path.$newfilename,0755);
			} //
		}	
		$data_member=array(
			'std_code'=>($stdid == "ไม่มี" ? "0" : $stdid),
			'level_id'=>$this->input->post("permiss"),
			'DISTRICT_CODE'=>$this->input->post("DISTRICT_CODE"),
			'job_id' => $this->input->post("job"),
			'edu_id'=>$this->input->post("edu_level"),
			'member_id_card'=>$this->input->post("id_card"),
			'member_name'=>$this->input->post("name"),
			'member_birth_date'=>$this->input->post("b_date"),
			'member_yofadmis'=>intval($this->input->post('yofadmis'))-543,
			'address'=>$this->input->post("address"),
			'phone_number'=>$this->input->post("phone_number"),
			'member_pic'=>$pic_member,
			'member_signa_pic'=>$pic_singna,
			'member_title'=>$this->input->post("title")
		);
		$this->User_model->update_member($data_member,$member_id);
	}
	public function member_update_staff(){
		$pic_member = $this->input->post("show_member_pic");
		$pic_singna = $this->input->post("show_member_signa_pic");
		$stdid=$this->input->post("std_code");
		$member_id=$this->input->post("member_id");		
		$temp;
		$newfilename;
		if(file_exists($_FILES['pic_member']['tmp_name']) || is_uploaded_file($_FILES['pic_member']['tmp_name'])) {
			$temp = null;
			$newfilename = null;
			$temp = explode(".", $_FILES["pic_member"]["name"]);
			$newfilename = time()."-member_picture".'.'.end($temp);
			if(move_uploaded_file($_FILES["pic_member"]["tmp_name"],$this->picture_path.$newfilename)){
				$pic_member = "http://".$this->ip."/Donkha/picture/".$newfilename ;
				chmod($this->picture_path.$newfilename,0755);
				echo "if upload pic_member<br>";
			}
		}
		if(file_exists($_FILES['pic_singna']['tmp_name']) || is_uploaded_file($_FILES['pic_singna']['tmp_name'])) {
			$temp = null;
			$newfilename = null;
			$temp = explode(".", $_FILES["pic_singna"]["name"]);
			$newfilename = time()."-member_singature".'.'.end($temp);
			if(move_uploaded_file($_FILES["pic_singna"]["tmp_name"],$this->picture_path.$newfilename)){
				$pic_singna = "http://".$this->ip."/Donkha/picture/".$newfilename ;
				chmod($this->picture_path.$newfilename,0755);
				echo "if upload pic_singna<br>";
			}
		}	
		$data_member=array(
			'std_code'=>($stdid == "ไม่มี" ? "0" : $stdid),
			'level_id'=>$this->input->post("permiss"),
			'DISTRICT_CODE'=>$this->input->post("DISTRICT_CODE"),
			'job_id' => $this->input->post("job"),
			'edu_id'=>$this->input->post("edu_level"),
			'member_id_card'=>$this->input->post("id_card"),
			'member_name'=>$this->input->post("name"),
			'member_birth_date'=>$this->input->post("b_date"),
			'member_yofadmis'=>intval($this->input->post('yofadmis'))-543,
			'address'=>$this->input->post("address"),
			'phone_number'=>$this->input->post("phone_number"),
			'member_pic'=>$pic_member,
			'member_signa_pic'=>$pic_singna,
			'member_title'=>$this->input->post("title")
		);
		$this->User_model->update_member($data_member,$member_id);
		 
	}
	public function staff_change_status(){
		$staff_id=$this->uri->segment(3);
		$data['staff']=$this->User_model->get_everything_staff($staff_id);
		$staff=$data['staff']->result();
		foreach ($staff as $row) {
			$status=$row->staff_status;
		}
		$this->User_model->staff_change_status($staff_id,$status);
		redirect(base_url()."Project_controller/manage_staff");
	}
	public function member_change_status(){
		$member_id=$this->uri->segment(3);
		$data['member']=$this->User_model->get_member($member_id);
		$member=$data['member']->result();
		foreach ($member as $row) {
			$status=$row->member_status;
		}
		$this->User_model->member_change_status($member_id,$status);
		redirect(base_url()."Project_controller/manage_member");
	}
	public function member_change_status_staff(){
		$member_id=$this->uri->segment(3);
		$data['member']=$this->User_model->get_member($member_id);
		$member=$data['member']->result();
		foreach ($member as $row) {
			$status=$row->member_status;
		}
		$this->User_model->member_change_status($member_id,$status);
		redirect(base_url()."Project_controller/manage_member_staff");
	}
	public function edit_table_confirm_deposit_money(){
		if( $_SERVER['REQUEST_METHOD']  != 'POST'  ){
            redirect(base_url()."Project_controller/noti_dep");
        }
        $data['account_detail'] = $this->User_model->select_account_detail_parameter($this->input->post('account_detail_id',true));
		$account_detail=$data['account_detail']->result();
		foreach ($account_detail as $row) {
			$account_id=$row->account_id;
		}
		$data['account'] = $this->User_model->select_account_with_parameter($account_id);
		$account=$data['account']->result();
		foreach ($account as $row) {
			$account_balance=$row->account_balance;
		}
		$new_balance = $account_balance+$this->input->post('money',true);

		$data_account_detail=array(
			'trans_money'=>$this->input->post('money',true),
			'account_detail_balance'=>$new_balance,
		);
		$data_deposit=array(
			'money_deposit'=>$this->input->post('money',true),
		);

		$this->User_model->update_table_confirm_deposit_money_tb_account_detail($this->input->post('account_detail_id',true),$data_account_detail);
	    $this->User_model->update_table_confirm_deposit_money_tb_deposit($this->input->post('trand_id',true),$data_deposit);
        echo '<script type="text/javascript">location.reload();</script>';
	}
	public function edit_table_confirm_withdraw_money(){
		if( $_SERVER['REQUEST_METHOD']  != 'POST'  ){
            redirect(base_url()."Project_controller/noti_wd");
        }
        $data['account_detail'] = $this->User_model->select_account_detail_parameter($this->input->post('account_detail_id',true));
		$account_detail=$data['account_detail']->result();
		foreach ($account_detail as $row) {
			$account_id=$row->account_id;
		}
		$data['account'] = $this->User_model->select_account_with_parameter($account_id);
		$account=$data['account']->result();
		foreach ($account as $row) {
			$account_balance=$row->account_balance;
		}
		$new_balance = $account_balance-$this->input->post('money',true);

		$data_account_detail=array(
			'trans_money'=>$this->input->post('money',true),
			'account_detail_balance'=>$new_balance,
		);
		$data_withdraw=array(
			'money_withdraw'=>$this->input->post('money',true),
		);
		$this->User_model->update_table_confirm_withdraw_money_tb_account_detail($this->input->post('account_detail_id',true),$data_account_detail);
	   $this->User_model->update_table_confirm_withdraw_money_tb_withdraw($this->input->post('trand_id',true),$data_withdraw);
      echo '<script type="text/javascript">
           	location.reload();
            </script>';
	}
	public function edit_table_confirm_tranfer_money(){
		if( $_SERVER['REQUEST_METHOD']  != 'POST'  ){
            redirect(base_url()."Project_controller/noti_tdf");
      }
      $data['account_detail'] = $this->User_model->select_account_detail_parameter($this->input->post('account_detail_id',true));
		$account_detail=$data['account_detail']->result();
		foreach ($account_detail as $row) {
			$account_id=$row->account_id;
		}
		$data['account'] = $this->User_model->select_account_with_parameter($account_id);
		$account=$data['account']->result();
		foreach ($account as $row) {
			$account_balance=$row->account_balance;
		}
		$new_balance = $account_balance-$this->input->post('money',true);

		$data_account_detail=array(
			'trans_money'=>$this->input->post('money',true),
			'account_detail_balance'=>$new_balance,
		);
		$data_tranfer_money=array(
			'money_tranfer'=>$this->input->post('money',true),
		);
		$this->User_model->update_table_confirm_withdraw_money_tb_account_detail($this->input->post('account_detail_id',true),$data_account_detail);

		$this->User_model->update_table_confirm_tranfer_money_tb_recive($this->input->post('trand_id',true),$data_tranfer_money);
		
		$this->User_model->update_table_confirm_tranfer_money_tb_tranfer($this->input->post('trand_id',true),$data_tranfer_money);
        echo '<script type="text/javascript">
           	location.reload();
            </script>';
	}

	////////////////////////////////////////////////////////////
	//////////////////////  SELECT    //////////////////////////

	public function getAmphur(){
		$p_id=$this->input->post();
		$data=$this->User_model->getAmphur($p_id);
		echo json_encode($data);
	}
	public function getDist(){
		$amp_id=$this->input->post();
		$data=$this->User_model->getDist($amp_id);
		echo json_encode($data);
	}
	public function getZip(){
		if($this->input->post("dist_id")){
			echo $this->User_model->getZip($this->input->post("dist_id"));
		}
	}
	public function get_account_details_modal(){
		$result='<script>
		$(document).ready(function(){
			$("#filter").change(function(){
				$.ajax({
					url:"'.base_url("index.php/Project_controller/filter_transaction_table_manager_report_modal").'",
					method:"POST",
					data:{
						  "filter":$(this).val(),
						  "account_id":$("#ac_id").val(),
						},
					success:function(data){
						$("table").remove("#result_table");
					  	$("#result_table").html(data);				  
					}
				  })        
			});
		});
		</script>
		<style type="text/css">     
			.schooller{height:48vh;overflow:auto;}
			table{width:20px;}
			thead tr:nth-child(1) th{position: sticky;top: 0;z-index: 10;} 
		</style>
		
		<div class="row">';
		foreach($this->User_model->select_account_with_parameter($this->input->post('account_id'))->result() as $row){
			$result.= '<div class="col-md-6"><B>หมายเลขบัญชี :</B>'." ".$row->account_id.'</div>
			<div class="col-md-6"><B>ชื่อบัญชี :</B>'." ".$row->account_name.'</div>';
			//echo $row->account_name." ".$row->account_id;
		}
		$result.='<div class="col-2"></div>';
		$result.=' <div class="form-group col-2"><br><label><B>การแสดงผล</B></label></div>';	
		$result.='<div class="form-group col-2"><br>
				<select  id="filter" name="filter" class="form-control" >
					<option value="all">ทั้งหมด</option>
					<option value="deposit">รายการฝาก</option>
					<option value="withdraw">รายการถอน</option>
					<option value="tranfer">รายการโอน</option>
				</select>
			</div> ';
		$result.='<div class="form-group col-2"><br><label style="width: 100%"><B>ยอดเงินคงเหลือ</B></label></div>';	
		$result.='<div class="form-group col-2" align="left"><br><label>'.number_format($row->account_balance,2)." ".'บาท</label></div> ';
		$result.='<div class="col-2"></div>'; 

		//table div
		$result.='<div class="form-group col-12 schooller"><input type="hidden" name="ac_id" id="ac_id" value="'.$row->account_id.'">';
		$result.='<div id="result_table"></div>';
		$result.='<table class="table  table-hover table-sm" id="result_table">
		<thead class="thead-light table-bordered text-center">
		  <tr>
			<th width="5%" scope="col">ลำดับ</th>
			<th width="26%" scope="col">วันที่</th>
			<th width="10%" scope="col">รายการ</th>
			<th width="12%" scope="col">จำนวนเงิน</th>
			<th width="12%" scope="col">คงเหลือ</th>
			<th width="35%" scope="col">พนักงานที่ทำรายการ</th>
		  </tr>
		</thead>
		<tbody class="table-bordered text-center">';
		$i = 1;
		foreach($this->User_model->select_account_detail_parameter_account_id($this->input->post('account_id'))->result() as $row2){
			if($row2->action == "deposit"){
				$action="<span class='text-success'>ฝาก</span>";
				$trans_money="<span class='text-success'>+".number_format($row2->trans_money,2)."</span>";
			}
			elseif($row2->action == "withdraw"){
				$action="<span class='text-danger'>ถอน</span>";
				$trans_money="<span class='text-danger'>+".number_format($row2->trans_money,2)."</span>";
			}
			elseif($row2->action == "add_interest"){
				$action="<span class='text-success'>เพิ่มดอกเบี้ย</span>";
				$trans_money="<span class='text-success'>+".number_format($row2->trans_money,2)."</span>";
			}
			elseif($row2->action == "open_account"){
				$action="<span class='text-success'>เปิดบัญชี</span>";
				$trans_money="<span class='text-success'>+".number_format($row2->trans_money,2)."</span>";
			}
			elseif($row2->action == "tranfer_money"){
				$action="<span class='text-danger'>โอน</span>";
				$trans_money="<span class='text-danger'>-".number_format($row2->trans_money,2)."</span>";
			}
			elseif($row2->action == "recive_money"){
				$action="<span class='text-success'>รับเงินโอน</span>";
				$trans_money="<span class='text-success'>+".number_format($row2->trans_money,2)."</span>";
			}
			else{
				$action="<span class='text-danger'>โอน</span>";
				$trans_money="<span class='text-danger'>+".number_format($row2->trans_money,2)."</span>";
			}
			$result.='<tr>';
				$result.='<td>'.$i.'</td>';
				$result.='<td>'.$this->DateThai($row2->record_date).'</td>';
				$result.='<td>'.$action.'</td>';
				$result.='<td>'.$trans_money.'</td>';
				$result.='<td>'.number_format($row2->account_detail_balance,2).'</td>';
				$result.='<td>'.$row2->staff_title."".$row2->staff_name.'</td>';
			$result.='</tr>';
			$i++;
		}

		$result.='</tbody></table>';
		$result.='</div>';
		//end table div

		$result.='</div>';
		echo $result;
		
	}
	public function show_modal_tranfer(){
		$ac = $this->input->post('account_detail_id');
		$action = $this->input->post('action');
		$result = '<div class="row">';
		if($data['statement']=$this->User_model->select_account_detail_id_tranfer_money($ac,$action)){
			foreach($data['statement']->result() as $row){
				if($row->action == "tranfer_money"){
					$stringggg = '<div class="col-md-6"><br><B>โอนให้บัญชี :</B>'." ".$row->account_id_tranfer.'</div>';
					$actionn = "โอน";
				}
				else{
					$stringggg = '<div class="col-md-6"><br><B>รับเงินจากบัญชี :</B>'." ".$row->account_id_tranfer.'</div>';
					$actionn = "รับเงินโอน";			
				}
				$result.= '<div class="col-md-4"><B>วันที่ :</B>'." ".$this->DateThai($row->record_date)." ".$row->record_time.'</div>
				<div class="col-md-4"><B>รายการ :</B>'." ".$actionn.'</div>
				<div class="col-md-4"><B>จำนวนเงิน :</B>'." ".number_format($row->trans_money,2)." บาท".'</div>';
				$result.=$stringggg;
			}
		}
		else{
			$result.= '<div class="col-md-12"><B>ไม่พบข้อมูล</B></div>';
		}
		$result.= '</div>';
		echo $result; 
	}
	public function get_member_detail_modal(){
		foreach ($this->User_model->get_member($this->input->post('member_id'))->result() as $row) {
			$std_id=$row->std_code;
		}
		if($std_id == '0'){ //บุคลากร
			$data['member_after']=$this->User_model->get_personal_member($this->input->post('member_id'));
		}
		else{ //นักเรียน
			$data['member_after']=$this->User_model->get_student_member($this->input->post('member_id'));
		}
		$result = '<div class="row">';		
		foreach($data['member_after']->result() as $row2){
			if($row2->std_code == '0'){
				$std_code = 'ไม่มี';
				$edu_id = 'ไม่มี';
				$job = $row2->job_name;
			} 
			else{
			$std_code = $row2->std_code;
			$edu_id = $row2->edu_name;
			$job = 'นักเรียน';
			}
			$result.='<div class="form-group col-md-1"></div>';
			$result.= '
			<div class="form-group col-md-2" style="margin-right:1%">
				<div class="row">
					<div class="form-group col-md-12"><img width="150px" height= "150px" src="'.$row2->member_pic.'" alt="your image" style="border: solid 1px #c0c0c0;" /> 
					<figcaption><B>รูปประจำตัว</B></figcaption><br></div>
					<div class="form-group col-md-12"><img width="150px" height= "150px" src="'.$row2->member_signa_pic.'" alt="your image" style="border: solid 1px #c0c0c0;" /> 
					<figcaption><B>รูปลายเซ็น</B></figcaption></div>
					<input type="hidden" id="member_id_hidden" name="member_id_hidden" value="'.$row2->member_id.'">
				</div>				
			</div>';
			$result.='
			<div class=" form-group col-md-8" align="left">
				<div class="row">
					<div class="form-group col-md-6"><B>วันที่สมัคร :</B>'." ".$this->DateThai($row2->member_regis_date).'</div>
					<div class="form-group col-md-6"><B>วัน/เดือน/ปีเกิด :</B>'." ".$this->DateThai($row2->member_birth_date).'</div>
					<div class="form-group col-md-6"><B>รหัสนักเรียน :</B>'." ".$std_code.'</div>
					<div class="form-group col-md-6"><B>เลขบัตรประชาชน :</B>'." ".$row2->member_id_card.'</div>
					<div class="form-group col-md-12"><B>ชื่อ :</B>'." ".$row2->member_title." ".$row2->member_name.'</div>
					<div class="form-group col-md-6"><B>ระดับการศึกษา :</B>'." ".$edu_id.'</div>
					<div class="form-group col-md-6"><B>ตำแหน่ง :</B>'." ".$row2->level_name.'</div>
					<div class="form-group col-md-12"><B>ที่อยู่ :</B>'." ".$row2->address." ตำบล".$row2->DISTRICT_NAME." อำเภอ".$row2->AMPHUR_NAME." จังหวัด".$row2->PROVINCE_NAME." รหัสไปรษณีย์ ".$row2->zipcode.'</div>
					<div class="form-group col-md-6"><B>อาชีพ :</B>'." ".$job.'</div>
					<div class="form-group col-md-6"><B>ชื่อผู้ใช้ :</B>'." ".$row2->username.'</div>
				</div>
			</div>';
		}
		$result.='</div>';
		echo $result;
	}
	public function searchMember(){
		echo json_encode($this->User_model->get_memberr($this->input->post('member_name')));
	}
	public function searchAccount(){
		echo json_encode($this->User_model->get_search_account_id($this->input->post('account')));
	}
	public function searchAccount_passbook(){
		echo json_encode($this->User_model->get_search_account_id_passbook($this->input->post('account_id')));
	}
	public function filter_transaction_table_manager_report_modal(){
	  	$result='<table class="table  table-hover table-sm" id="result_table">
	  	<thead class="thead-light table-bordered text-center">
			<tr>
			  <th width="5%" scope="col">ลำดับ</th>
			  <th width="26%" scope="col">วันที่</th>
			  <th width="10%" scope="col">รายการ</th>
			  <th width="12%" scope="col">จำนวนเงิน</th>
			  <th width="12%" scope="col">คงเหลือ</th>
			  <th width="35%" scope="col">พนักงานที่ทำรายการ</th>
			</tr>
	  	</thead>
		  <tbody class="table-bordered text-center">';
		$data['data'] = $this->User_model->select_filter_transaction($this->input->post('account_id'),$this->input->post('filter'));
		$i = 1;
		if($data['data']->num_rows() >0){
			foreach($data['data']->result() as $row2){
				if($row2->action == "deposit"){
					$action="<span class='text-success'>ฝาก</span>";
					$trans_money="<span class='text-success'>+".number_format($row2->trans_money,2)."</span>";
				}
				elseif($row2->action == "withdraw"){
					$action="<span class='text-danger'>ถอน</span>";
					$trans_money="<span class='text-danger'>+".number_format($row2->trans_money,2)."</span>";
				}
				elseif($row2->action == "open_account"){
					$action="<span class='text-success'>เปิดบัญชี</span>";
					$trans_money="<span class='text-success'>+".number_format($row2->trans_money,2)."</span>";
				}
				elseif($row2->action == "recive_money"){
					$action="<span class='text-success'>รับเงินโอน</span>";
					$trans_money="<span class='text-success'>+".number_format($row2->trans_money,2)."</span>";
				}
				elseif($row2->action == "tranfer_money"){
					$action="<span class='text-danger'>โอน</span>";
					$trans_money="<span class='text-danger'>-".number_format($row2->trans_money,2)."</span>";
				}
				elseif($row2->action == "add_interest"){
					$action="<span class='text-success'>เพิ่มดอกเบี้ย</span>";
					$trans_money="<span class='text-success'>+".number_format($row2->trans_money,2)."</span>";
				}
				else{
					$action="<span class='text-danger'>โอน</span>";
					$trans_money="<span class='text-danger'>+".number_format($row2->trans_money,2)."</span>";
				}
				$result.='<tr>';
					$result.='<td>'.$i.'</td>';
					$result.='<td>'.$this->DateThai($row2->record_date).'</td>';
					$result.='<td>'.$action.'</td>';
					$result.='<td>'.$trans_money.'</td>';
					$result.='<td>'.number_format($row2->account_detail_balance,2).'</td>';
					$result.='<td>'.$row2->staff_title."".$row2->staff_name.'</td>';
				$result.='</tr>';
				$i++;
			}
		}else{
			$result.='<tr> <th class="text-center" scope="col" colspan="7">ไม่พบข้อมูลที่ค้นหา</th> </tr>';
		}
	  	$result.='</tbody></table>';
		echo $result;
	}
	public function filter_transaction_table(){
		$output='';
		$data['result'] = $this->User_model->select_filter_transaction($this->input->post('accoint_id'),$this->input->post('filter'));
		if($this->input->post('filter') == "deposit"){
			$output.='
				<table class="table table-striped table-hover table-sm">
	                <thead class="thead-light table-bordered text-center">
	                    <tr>
	                        <th width="5%" scope="col">ลำดับ</th>
	                        <th width="30%" scope="col">วันที่</th>
	                        <th width="10%" scope="col">รายการ</th>
	                        <th width="10%" scope="col">จำนวนเงิน</th>
	                        <th width="10%" scope="col">คงเหลือ</th>
	                        <th width="35%" scope="col">พนักงานที่ทำรายการ</th>
	                    </tr>
	                </thead>
	                <tbody class="table-bordered" style="background-color: #EFFEFD">
				';
				if($data['result']->num_rows() >0){
					$i=1;
					foreach ($data['result']->result() as $row) {
						if($row->action == "deposit"){
							$action = 'ฝาก';
						}
						elseif($row->action == "recive_money"){
							$action = 'รับเงินโอน';
						}
						elseif($row->action == "add_interest"){
							$action = 'เพิ่มดอกเบี้ย';
						}
						else{
							$action = 'เปิดบัญชี';
						}
						$output.='
							<tr onclick="onmouseover_foo('."'".$row->account_detail_id."'".','."'".$row->action."'".')">
		                        <th class="text-center" scope="row">'.$i.'</th>
		                        <td class="text-center">'.$this->DateThai($row->record_date)." ".$row->record_time.'</td>
		                        <td class="text-center"><span class="text-success">'.$action.'</span></td>
		                        <td align="right"><span class="text-success">+'.number_format($row->trans_money,2).'</span></td>
		                        <td align="right">'.number_format($row->account_detail_balance,2).'</td>
		                        <td class="text-center">'.$row->staff_title."".$row->staff_name.'</td>
		                    </tr>';
		                $i++;
					}
				}
				else{
					$output.='
						<tr>
		                	<th class="text-center" scope="col" colspan="7">ไม่พบข้อมูลที่ค้นหา</th>
		                </tr>';
				}
		}
		elseif($this->input->post('filter') == "withdraw"){
			$output.='
			<table class="table table-striped table-hover table-sm">
	            <thead class="thead-light table-bordered text-center">
	                <tr>
	                    <th width="5%" scope="col">ลำดับ</th>
	                    <th width="30%" scope="col">วันที่</th>
	                    <th width="10%" scope="col">รายการ</th>
	                    <th width="10%" scope="col">จำนวนเงิน</th>
	                    <th width="10%" scope="col">คงเหลือ</th>
	                    <th width="35%" scope="col">พนักงานที่ทำรายการ</th>
	                </tr>
	            </thead>
	            <tbody class="table-bordered" style="background-color: #EFFEFD">
			';
			if($data['result']->num_rows() >0){
				$i=1;
				$result=$data['result']->result();
				foreach ($result as $row) {
					$output.='
						<tr>
							<th class="text-center" scope="row">'.$i.'</th>
		                    <td class="text-center">'.$this->DateThai($row->record_date)." ".$row->record_time.'</td>
		                    <td class="text-center"><span class="text-danger">ถอน</span></td>
		                    <td align="right"><span class="text-danger">-'.number_format($row->trans_money,2).'</span></td>
		                    <td align="right">'.number_format($row->account_detail_balance,2).'</td>
		                    <td class="text-center">'.$row->staff_title."".$row->staff_name.'</td>
		                </tr>';
		            $i++;
				}
			}
			else{
				$output.='
					<tr>
		            	<th class="text-center" scope="col" colspan="7">ไม่พบข้อมูลที่ค้นหา</th>
		            </tr>';
			}
		}
		elseif($this->input->post('filter') == "tranfer_money"){
			$output.='
			<table class="table table-striped table-hover table-sm">
	            <thead class="thead-light table-bordered text-center">
	                <tr>
	                   <th width="5%" scope="col">ลำดับ</th>
	                   <th width="30%" scope="col">วันที่</th>
	                   <th width="10%" scope="col">รายการ</th>
	                   <th width="10%" scope="col">จำนวนเงิน</th>
	                   <th width="10%" scope="col">คงเหลือ</th>
	                   <th width="35%" scope="col">พนักงานที่ทำรายการ</th>
	                </tr>
	            </thead>
	            <tbody class="table-bordered" style="background-color: #EFFEFD">
			';
			if($data['result']->num_rows() >0){
				$i=1;
				$result=$data['result']->result();
				foreach ($result as $row) {
					$output.='
						<tr onclick="onmouseover_foo('."'".$row->account_detail_id."'".','."'".$row->action."'".')">
							<th class="text-center" scope="row">'.$i.'</th>
		                    <td class="text-center">'.$this->DateThai($row->record_date)." ".$row->record_time.'</td>
		                    <td class="text-center"><span class="text-danger">โอน</span></td>
		                    <td align="right"><span class="text-danger">-'.number_format($row->trans_money,2).'</span></td>
		                    <td align="right">'.number_format($row->account_detail_balance,2).'</td>
		                    <td class="text-center">'.$row->staff_title."".$row->staff_name.'</td>
		                </tr>';
		            $i++;
				}
			}
			else{
				$output.='
					<tr>
		            	<th class="text-center" scope="col" colspan="7">ไม่พบข้อมูลที่ค้นหา</th>
		            </tr>';
			}
		}
		else{
			$output.='
			<table class="table table-striped table-hover table-sm">
	            <thead class="thead-light table-bordered text-center">
	                <tr>
	                    <th width="5%" scope="col">ลำดับ</th>
	                    <th width="30%" scope="col">วันที่</th>
	                    <th width="10%" scope="col">รายการ</th>
	                    <th width="10%" scope="col">จำนวนเงิน</th>
	                    <th width="10%" scope="col">คงเหลือ</th>
	                    <th width="35%" scope="col">พนักงานที่ทำรายการ</th>
	                </tr>
	            </thead>
	            <tbody class="table-bordered" style="background-color: #EFFEFD">
			';
			if($data['result']->num_rows() >0){
				$i=1;
				$sadasd=$data['result']->result();
				foreach ($sadasd as $row) {
					$action = '';
					$money = '';
					if($row->action == "deposit"){
						$action = '<span class="text-success">ฝาก</span>';
						$money = '<span class="text-success">+'.number_format($row->trans_money,2).'</span>';
					}
					elseif($row->action == "withdraw"){
						$action = '<span class="text-danger">ถอน</span>';
						$money = '<span class="text-danger">-'.number_format($row->trans_money,2).'</span>';
					}
					elseif($row->action == "add_interest"){
						$action = '<span class="text-success">เพิ่มดอกเบี้ย</span>';
						$money = '<span class="text-success">+'.number_format($row->trans_money,2).'</span>';
					}
					elseif($row->action == "tranfer_money"){
						$action = '<span class="text-danger">โอน</span>';
						$money = '<span class="text-danger">-'.number_format($row->trans_money,2).'</span>';
					}
					elseif($row->action == "recive_money"){
						$action = '<span class="text-success">รับเงินโอน</span>';
						$money = '<span class="text-success">+'.number_format($row->trans_money,2).'</span>';
					}
					elseif($row->action == "open_account"){
						$action = '<span class="text-success">เปิดบัญชี</span>';
						$money = '<span class="text-success">+'.number_format($row->trans_money,2).'</span>';
					}
					else{
						$action = '<span class="text-danger">โอน</span>';
						$money = '<span class="text-danger">-'.number_format($row->trans_money,2).'</span>';
					}
					$output.='
						<tr onclick="onmouseover_foo('."'".$row->account_detail_id."'".','."'".$row->action."'".')">
		                    <th class="text-center" scope="row">'.$i.'</th>
		                    <td class="text-center">'.$this->DateThai($row->record_date)." ".$row->record_time.'</td>
		                    <td class="text-center">'.$action.'</td>
		                    <td align="right">'.$money.'</td>
		                    <td align="right">'.number_format($row->account_detail_balance,2).'</td>
		                    <td class="text-center">'.$row->staff_title."".$row->staff_name.'</td>
		                </tr>';
		            $i++;
				}
			}
			else{
				$output.='
					<tr>
		            	<th class="text-center" scope="col" colspan="7">ไม่พบข้อมูลที่ค้นหา</th>
		            </tr>';
			}
		}
		$output.='
		    </tbody>
	            <tfoot>
	            </tfoot>
	        </table>';
		echo $output;
	}
	public function select_con_print(){
		$output='';
		$data['result'] = $this->User_model->select_account_detail_with_account_id_not_print($this->input->post('account_id'));
		$output.='
			<a href="'.base_url("index.php/Project_controller/check_next_passbook_page_account_id")."/".$this->input->post('account_id').'" class="btn btn-warning print">พิมพ์</a> <br><br>
			<table class="table table-striped table-hover table-sm" id="search_table">
                <thead class="thead-light table-bordered">
                    <tr>
                     	<th scope="col">ลำดับ</th>
                        <th scope="col">วันที่</th>
                        <th scope="col">รายการ</th>
                        <th scope="col">จำนวนเงิน</th>
                        <th scope="col">คงเหลือ</th>
                    </tr>
                </thead>
            	<tbody class="table-bordered" style="background-color: #EFFEFD">
		';
		if($data['result']->num_rows() >0){
			$i=1;
			$result=$data['result']->result();
			foreach ($result as $row) {
				if($row->action == "deposit"){
					$action = "<span class='text-success'>ฝาก</span>";
					$trans_money = "<span class='text-success'>+".number_format($row->trans_money,2)."</span>";
				}
				elseif($row->action == "withdraw"){
					$action = "<span class='text-danger'>ถอน</span>";
					$trans_money = "<span class='text-danger'>-".number_format($row->trans_money,2)."</span>";
				}
				elseif($row->action == "add_interest"){
					$action = "<span class='text-success'>เพิ่มดอกเบี้ย</span>";
					$trans_money = "<span class='text-success'>+".number_format($row->trans_money,2)."</span>";
				}
				else{
					$action = "<span class='text-danger'>โอน</span>";
					$trans_money = "<span class='text-danger'>-".number_format($row->trans_money,2)."</span>";
				}
				$output.='
					<tr>
						<th width="2%" scope="row">'.$i.'</th>
                        <td width="30%">'.$this->DateThai($row->record_date)." ".$row->record_time.'</td>
                        <td width="20%">'.$action.'</td>
                        <td align="right">'.$trans_money.'</td>
                        <td align="right">'.number_format($row->account_detail_balance,2).'</td>
                    </tr>';
                $i++;
			}
		}
		else{
			$output.='<tr><th scope="col" colspan="5">ไม่พบข้อมูล</th></tr>';
		}
		$output.='
			</tbody><tfoot></tfoot>
            </table>';
		echo $output;
	}
	public function select_new_print(){
		$output='';
		$data['result'] = $this->User_model->select_account_detail_with_account_id_not_print($this->input->post('account_id'));
		$output.='
			<style type="text/css">
			    .removeRow
			    {
			     background-color: #FF0000;
			        color:#FFFFFF;
			    }
  			</style>
			<script type="text/javascript">
           		$(document).ready(function(){
					$(".delete_checkbox").click(function(){
						if($(this).is(":checked"))
					  	{
					   		$(this).closest("tr").addClass("removeRow");
					  	}
					  	else
					  	{
					   		$(this).closest("tr").removeClass("removeRow");
					  	}
					});
					$("#print_new").click(function(){
						var checkbox = $(".delete_checkbox:checked");
					  	if(checkbox.length > 0)
					  	{
					   		var checkbox_value = [];
					   		$(checkbox).each(function(){
					    		checkbox_value.push($(this).val());
					   		});
					   		$.ajax({
					    		url:"'.base_url("index.php/Project_controller/print_passbook_new").'",
					    		method:"POST",
					    		xhrFields: {
            					responseType: "blob"
        						},
					    		data:{checkbox_value:checkbox_value},
					    		success:function(response)
					    		{
					    			url = window.URL.createObjectURL(response);
            						window.open(url, "_blank");
					     			$(".removeRow").fadeOut(1500);
					    		}
					   		})
					  	}
					  	else
					  	{
					   	alert("กรุณาเลือกรายการ");
					  	}
					});
           		});
            </script>
            <button class="btn btn-warning" name="print_new" id="print_new">พิมพ์</button>
			 <br><br>
			<table class="table table-hover table-sm" id="search_table">
                <thead class="thead-light table-bordered">
                    <tr>
                    	<th scope="col">เลือก</th>
                     	<th scope="col">ลำดับ</th>
                        <th scope="col">วันที่</th>
                        <th scope="col">รายการ</th>
                        <th scope="col">จำนวนเงิน</th>
                        <th scope="col">คงเหลือ</th>
                    </tr>
                </thead>
            	<tbody class="table-bordered" style="background-color: #EFFEFD">
		';
		if($data['result']->num_rows() >0){$i=1;
			$result=$data['result']->result();
			foreach ($result as $row) {
				if($row->action == "deposit"){
					$action = "<span class='text-success'>ฝาก</span>";
					$trans_money = "<span class='text-success'>+".number_format($row->trans_money,2)."</span>";
				}
				elseif($row->action == "withdraw"){
					$action = "<span class='text-danger'>ถอน</span>";
					$trans_money = "<span class='text-danger'>-".number_format($row->trans_money,2)."</span>";
				}
				elseif($row->action == "add_interest"){
					$action = "<span class='text-success'>เพิ่มดอกเบี้ย</span>";
					$trans_money = "<span class='text-success'>+".number_format($row->trans_money,2)."</span>";
				}
				else{
					$action = "<span class='text-danger'>โอน</span>";
					$trans_money = "<span class='text-danger'>-".number_format($row->trans_money,2)."</span>";
				}
				$output.='
					<tr>
						<th width="2%" scope="row"><input type="checkbox" class="delete_checkbox" value="'.$row->account_detail_id.'" /></th>
						<th width="2%" scope="row">'.$i.'</th>
                        <td width="30%">'.$this->DateThai($row->record_date)." ".$row->record_time.'</td>
                        <td width="20%">'.$action.'</td>
                        <td align="right">'.$trans_money.'</td>
                        <td align="right">'.number_format($row->account_detail_balance,2).'</td>
                    </tr>';
                $i++;
			}
		}
		else{
			$output.='<tr><th scope="col" colspan="6">ไม่พบข้อมูล</th></tr>';
		}
		$output.='
			</tbody><tfoot></tfoot>
            </table>
            <div id="result"></div>';
		echo $output;
	}
	public function fetch_member(){
        if (isset($_GET['term'])) {
            $result = $this->User_model->fetch_member_auto_complete($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = $row->member_name;
                echo json_encode($arr_result);
            }
        }
	}
	public function fetch_account(){
      if (isset($_GET['term'])) {
         $result = $this->User_model->fetch_account_auto_complete($_GET['term']);
         if (count($result) > 0) {
				foreach ($result as $row){
					$arr_result[] = $row->account_id." ".$row->account_name;
					echo json_encode($arr_result);
				}
			}
      }
	}
	public function fetch_account_tranfer(){
		if (isset($_GET['term'])) {
		   $result = $this->User_model->fetch_account_tranfer_auto_complete($_GET['term']);
		   if (count($result) > 0) {
				  foreach ($result as $row){
					  $arr_result[] = $row->account_id;
					  echo json_encode($arr_result);
				  }
			  }
		}
	  }
	public function fetch_report_open_account(){
		date_default_timezone_set('Asia/Bangkok');
		$output='';
		$data['result'] = $this->User_model->select_open_account_between_date($this->input->post('start_date'),$this->input->post('stop_date'));
		$output.='
			<table class="table table-striped table-hover table-sm text-center" id="job-table">
				<thead class="thead-light table-bordered">
						<tr>
								<th width="2%" scope="col">ลำดับ</th>
								<th width="15%" scope="col">หมายเลขบัญชี</th>
								<th width="22%" scope="col">ชื่อบัญชี</th>
								<th width="25%" scope="col">ชื่อ - นามสกุล</th>					
								<th width="20%" scope="col">วัน-เดือน-ปี ที่เปิด</th>
								<th width="20%" scope="col">จำนวนเงินที่เปิดบัญชี</th>
						</tr>
				</thead>
				<tbody class="table-bordered" style="background-color: #EFFEFD">
		';
		if($data['result']->num_rows() >0){
			$i=1;
			$sum_total = 0.0 ;
			$result=$data['result']->result();
			foreach ($result as $row) {
				$open_money = 0.0 ;
				
				foreach ($this->User_model->select_account_detail_open($row->account_id,$row->account_open_date)->result() as $row2) {
					$open_money = $row2->account_detail_balance;
					$sum_total+=floatval($row2->account_detail_balance);
				}
				$output.='
					<tr>
						<th id="count"  scope="row">'.$i.'</th>
						<td id="ac_code">'.$row->account_id.'</td>
						<td id="ac_name" align="left"  >'.$row->account_name.'</td>
						<td id="ac_ac_nae" align="left" >'.$row->member_title." ".$row->member_name.'</td>
						<td id="date_open" >'.$this->DateThai($row->account_open_date).'</td>
						<td id="open_money" align="right" >'.number_format($open_money,2).'</td>
					</tr>';
				$i++;
			}
			$link =base_url("index.php/Project_controller/print_report_account_betwwen_date")."/".$this->input->post('start_date')."/".$this->input->post('stop_date');
		$output.='
			<tr><th colspan="4" scope="col"></th><th colspan="1" scope="col">รวมจำนวนเงิน</th><td align="right" colspan="1" scope="col">'.number_format($sum_total,2).'</td></tr>
			</tbody><tfoot></tfoot>
		</table>
		<a href="'.$link.'" target="_blank" class="btn btn-warning print">พิมพ์</a> 
		 ';
		}
		else{
			$output.='
			<tr><th colspan="10" scope="col">ไม่พบข้อมูล</th></tr>
			';
		$output.='
			</tbody><tfoot></tfoot>
		</table>
		
		 ';	
		}	
		echo $output;
	}	
	public function report_deposit_per_year(){
		$sumofyear=0.0;
		$result='<div class="row">
					<div class="col-4"></div>
					<div class="col-4">
					<table class="table table-striped table-hover text-center" id="job-table">
					<thead class="thead-light table-bordered">
							<tr>
									<th width="20%" scope="col">ปี</th>
									<th width="50%" scope="col">จำนวนเงิน</th>
							</tr>
					</thead>
					<tbody class="table-bordered" style="background-color: #EFFEFD">
					';
		foreach ($this->User_model->select_deposit_year()->result() as $row) {
			foreach ($this->User_model->select_sum_deposit_year($row->year)->result() as $row2) {
				$sumofyear+=floatval($row2->sum_year);
				$thaiyear= intval($row->year)+543;
				//echo $row->year." ".$row2->sum_year."<br>";
				$result.='<tr>
				<th id="count"  scope="row">'.$thaiyear.'</th>
				<td align="right" id="ac_code">'.number_format($row2->sum_year,2)." บาท".'</td>
						</tr>';
			}
		}
		//echo $sumofyear;
		$link =base_url("index.php/Project_controller/print_report_transaction")."/"."deposit"."/"."year";
		$result.='<tr><th scope="col">รวม</th><td align="right" scope="col">'.number_format($sumofyear,2)." บาท".'</td></tr></tbody><tfoot></tfoot>
		</table></div>
		<div class="col-4"><a href="'.$link.'" target="_blank" class="btn btn-warning print">พิมพ์</a></div>
		  </div>';
		echo $result;
	}
	public function report_withdraw_per_year(){
		$sumofyear=0.0;
		$result='<div class="row">
					<div class="col-4"></div>
					<div class="col-4">
					<table class="table table-striped table-hover text-center" id="job-table">
					<thead class="thead-light table-bordered">
							<tr>
									<th width="20%" scope="col">ปี</th>
									<th width="50%" scope="col">จำนวนเงิน</th>
							</tr>
					</thead>
					<tbody class="table-bordered" style="background-color: #EFFEFD">
					';
		foreach ($this->User_model->select_withdraw_year()->result() as $row) {
			foreach ($this->User_model->select_sum_withdraw_year($row->year)->result() as $row2) {
				$sumofyear+=floatval($row2->sum_year);
				$thaiyear= intval($row->year)+543;
				//echo $row->year." ".$row2->sum_year."<br>";
				$result.='<tr>
				<th id="count"  scope="row">'.$thaiyear.'</th>
				<td align="right" id="ac_code">'.number_format($row2->sum_year,2)." บาท".'</td>
						</tr>';
			}
		}
		//echo $sumofyear;
		$link =base_url("index.php/Project_controller/print_report_transaction")."/"."withdraw"."/"."year";
		$result.='<tr><th scope="col">รวม</th><td align="right" scope="col">'.number_format($sumofyear,2)." บาท".'</td></tr></tbody><tfoot></tfoot>
		</table></div>
		<div class="col-4"><a href="'.$link.'" target="_blank" class="btn btn-warning print">พิมพ์</a></div>
		  </div>';
		echo $result;
	}

	////////////////////////////////////////////////////////////
	//////////////////////  FUNCTION    //////////////////////////

	public function login_check(){
		$user=$this->input->post("username");
		$pass=base64_encode($this->input->post("password"));
		if($data['login']=$this->User_model->check_login($user, $pass))  {
        	foreach($data['login']->result() as $row){
	            if($row->level_id == '1'){ $level = "สมาชิก";}
	            elseif ($row->level_id == '2'){$level = "พนักงาน";}
	            elseif ($row->level_id == '3') {$level = "ผู้จัดการ";}
	            else{ $level = "ผู้ดูแลระบบ";}
							$session_data = array(
	                'id' => $row->staff_id ,
	                'lid' => $row->level_id,
	                'stitle' => $row->staff_title,
	                'sname' => $row->staff_name,
	                'sstatus' => $row->staff_status,
	                'spic' => $row->staff_pic,
	                'slevel' => $level
								);
        	}
          $this->session->set_userdata($session_data);
          $level_id = $this->session->userdata('lid');
         	if($level_id == '4'){ redirect(base_url() . 'Project_controller/index_admin');}
         	else if($level_id == '3'){ // 3 = manager
         		redirect(base_url() . 'Project_controller/index_manager');
         	}
         	else{ redirect(base_url() . 'Project_controller/index_staff');}
        }
        else{
            $this->session->set_flashdata('error', 'กรอกชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
            redirect(base_url() . 'Project_controller/index');
        }
	}
	public function logout(){
		$this->session->sess_destroy();
        redirect(base_url() . 'Project_controller/index');
	}
	public function check_std_code(){
		$query='';
		if($this->input->post('query')){
			$query = $this->input->post('query');
			$result = $this->User_model->check_std_code($query);
			echo $result;
		}

	}
	public function check_std_code_member(){
		$query='';
		if($this->input->post('query')){
			$query = $this->input->post('query');
			$result = $this->User_model->check_std_code_member($query);
			echo $result;
		}

	}
	public function check_username(){
		$query='';
		if($this->input->post('username')){
			$query = $this->input->post('username');
		}
		$result = $this->User_model->check_username($query);
		echo $result;
	}
	public function confirm_deposit(){
		$account_detail_id=$this->uri->segment(3);
		$data['account_detail'] = $this->User_model->select_account_detail_parameter($account_detail_id);
		$account_detail=$data['account_detail']->result();
		foreach ($account_detail as $row) {
			$account_id=$row->account_id;
			$trans_id=$row->trans_id;
			$account_detail_balance=$row->account_detail_balance;
		}
		$this->User_model->update_confirm_deposit($account_detail_id,$trans_id);
		$this->User_model->update_confirm_account_deposit($account_id,$account_detail_balance);
		$url1 = base_url('Project_controller/check_next_passbook_page_accountdetail_id/').$account_detail_id;
		$url2 = base_url('Project_controller/noti_dep/');
		echo '
            <script type="text/javascript">
            	var confirn =  confirm("ทำรายการเรียบร้อย\nต้องการพิมพ์สมุดคู่ฝาก หรือไม่");
            	if(confirn == true){ window.open("'.$url1.'", "_self");}
            	else{ window.open("'.$url2.'", "_self"); }
            </script>
            ';
	}
	public function confirm_withdraw(){
		$account_detail_id=$this->uri->segment(3);
		$data['account_detail'] = $this->User_model->select_account_detail_parameter($account_detail_id);
		$account_detail=$data['account_detail']->result();
		foreach ($account_detail as $row) {
			$account_id=$row->account_id;
			$trans_id=$row->trans_id;
			$account_detail_balance=$row->account_detail_balance;
		}
		$this->User_model->update_confirm_withdraw($account_detail_id,$trans_id);
		$this->User_model->update_confirm_account_withdraw($account_id,$account_detail_balance);
		$url1 = base_url('Project_controller/check_next_passbook_page_accountdetail_id/').$account_detail_id;
		$url2 = base_url('Project_controller/noti_wd/');
		echo '
            <script type="text/javascript">
            	var confirn =  confirm("ทำรายการเรียบร้อย\nต้องการพิมพ์สมุดคู่ฝาก หรือไม่");
            	if(confirn == true){ window.open("'.$url1.'", "_self");}
            	else{ window.open("'.$url2.'", "_self"); }
            </script>
            ';
	}
	public function confirm_tranfer_money(){
		$account_detail_id=$this->uri->segment(3);
		$data['account_detail'] = $this->User_model->select_account_detail_parameter($account_detail_id);
		$account_detail=$data['account_detail']->result();
		foreach ($account_detail as $row) {
			$account_id=$row->account_id;
			$trans_id=$row->trans_id;
			$account_detail_balance=$row->account_detail_balance;
		}
		$this->User_model->update_confirm_tranfer_money($account_detail_id,$trans_id);
		$this->User_model->update_confirm_account_tranfer($account_id,$account_detail_balance);
		$url1 = base_url('Project_controller/check_next_passbook_page_accountdetail_id/').$account_detail_id;
		$url2 = base_url('Project_controller/noti_tdf/');
		echo '
            <script type="text/javascript">
            	var confirn =  confirm("ทำรายการเรียบร้อย\nต้องการพิมพ์สมุดคู่ฝาก หรือไม่");
            	if(confirn == true){ window.open("'.$url1.'", "_self");}
            	else{ window.open("'.$url2.'", "_self"); }
            </script>
            ';
	}
	public function check_next_passbook_page_accountdetail_id(){
		$data['account_detail'] = $this->User_model->select_account_detail_parameter($this->uri->segment(3));
		$url1 = base_url('Project_controller/print_passbook_continue_transaction/').$this->uri->segment(3);
		$url2 = base_url('Project_controller/index_staff/');
		foreach ($data['account_detail']->result() as $row) {
			if($row->passbook_line > 29){
				echo '
            		<script type="text/javascript">
            			var confirn =  confirm("กรุณาเปลี่ยนหน้าสมุดคุ่ฝาก");
            			if(confirn == true){ window.open("'.$url2.'", "_self");window.open("'.$url1.'", "_blank");}
            			else{ window.open("'.$url2.'", "_self"); }
            		</script>
            		';
			}
			else{
				echo '
            		<script type="text/javascript">
            			window.open("'.$url2.'", "_self");window.open("'.$url1.'", "_blank");
            		</script>
            		';
			}
		}
	}
	public function check_next_passbook_page_account_id(){
		$url1 = base_url('Project_controller/print_passbook_continue/').$this->uri->segment(3);
		$url2 = base_url('Project_controller/passbook_display/');
		foreach ($this->User_model->select_account_with_parameter($this->uri->segment(3))->result() as $row) {
			if($row->passbook_line > 29){
				echo '
            		<script type="text/javascript">
            			var confirn =  confirm("กรุณาเปลี่ยนหน้าสมุดคุ่ฝาก");
            			if(confirn == true){ window.open("'.$url2.'", "_self");window.open("'.$url1.'", "_blank");}
            			else{ window.open("'.$url2.'", "_self"); }
            		</script>
            		';
			}
			else{
				echo '
            		<script type="text/javascript">
            			window.open("'.$url2.'", "_self");window.open("'.$url1.'", "_blank");
            		</script>
            		';
			}
		}
	}
	public function print_report_account_betwwen_date(){
		$pdf = new Pdf('P','mm','A4');
      $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING);
      $pdf->setFooterData(array(0,64,0), array(0,64,128));
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
      $pdf->setFontSubsetting(true);
      $pdf->SetFont('thsarabun', '', 16, '', true);
		$pdf->setPrintHeader(false);
		$pdf->setCellPadding(1,1,1,1);
		$pdf->setCellmargins(1,1,1,1);
		$pdf->SetTitle("รายงานบัญชี");
		$pdf->AddPage();
		$pdf->Image(base_url()."picture/donkha.png", 91,5, 25, 30, 'PNG', 'http://www.mindphp.com');
		$pdf->Ln(8);
		$content = '<h3>รายงานเปิดบัญชี</h3><span align="center">วันที่'." ".DateThai($this->uri->segment(3))." ถึง ".DateThai($this->uri->segment(4)).'</span><br>
			<span>ธนาคารโรงเรียน โรงเรียนดอนคาวิทยา ต.ดอนคา อ.อู่ทอง จ.สุพรรณบุรี 72160</span>
		';
		$pdf->writeHTMLCell(0,0,'','',$content,0,1,0,true,'C',true);
		$pdf->Ln(5);
		$table='<table style="border:1px solid black">';
		$table.='<tr>
	               <th style="border:1px solid black" width="6%" scope="col">ลําดับ</th>
	               <th style="border:1px solid black" width="15%" scope="col">หมายเลขบัญชี	</th>
	               <th style="border:1px solid black" width="18%" scope="col">ชื่อบัญชี</th>
	               <th style="border:1px solid black" width="25%" scope="col">ชื่อ - นามสกุล</th>
				   <th style="border:1px solid black" width="17%" scope="col">วัน-เดือน-ปี ที่เปิด</th>
				   <th style="border:1px solid black" width="19%" scope="col">จำนวนเงินที่เปิดบัญชี</th>
    			</tr>';
		$i=1;
		$sum_total=0.0;
		foreach ($this->User_model->select_open_account_between_date($this->uri->segment(3),$this->uri->segment(4))->result() as $row) {
			$open_money=0.0;
			foreach($this->User_model->select_account_detail_open($row->account_id,$row->account_open_date)->result() as $row2){
				$open_money = $row2->account_detail_balance;
				$sum_total+=floatval($row2->account_detail_balance);
			}
			$table.='<tr>
				<td style="border:1px solid black">'.$i.'</td>
				<td style="border:1px solid black">'.$row->account_id.'</td>
				<td align="left" style="border:1px solid black">'.$row->account_name.'</td>
				<td align="left" style="border:1px solid black">'.$row->member_title."".$row->member_name.'</td>
				<td style="border:1px solid black">'.$this->DateThai($row->account_open_date).'</td>
				<td align="right" style="border:1px solid black">'.number_format($open_money,2).'</td>
			</tr>';		
			$i++;
		}
		$table.='<tr><th colspan="4" scope="col"></th><th style="border-right:1px solid black" colspan="1" scope="col">รวมจำนวนเงิน</th><td align="right" colspan="1" scope="col">'.number_format($sum_total,2).'</td></tr>
		</tbody><tfoot></tfoot></table>';
		$pdf->writeHTMLCell(0,0,'','',$table,0,1,0,true,'C',true);
		$count="<span>จํานวนผูที่เปิดบัญชีทั้งหมด ".$this->User_model->count_account_opendate_between($this->uri->segment(3),$this->uri->segment(4))." คน</span><br>";
		$count.="<span>วันที่ออกรายงาน ".$this->DateThai(date('Y-m-d'))."</span>";
		$pdf->writeHTMLCell(0,0,'','',$count,0,1,0,true,'R',true);
		ob_clean();
		$pdf->Output('example_001.pdf', 'I');
		ob_end_clean();
	}
	public function print_passbook_continue_transaction(){
		$data['account_detail'] = $this->User_model->select_account_detail_parameter($this->uri->segment(3));
		function DateThai($strDate)
		{
			date_default_timezone_set('Asia/Bangkok');
			$strYear = date("Y",strtotime($strDate))+543;
			$strMonth= date("m",strtotime($strDate));
			$strDay= date("d",strtotime($strDate));
			return "$strDay/$strMonth/$strYear";
		}
		$pdf = new Pdf('P','mm','A4');
      $pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
      $pdf->setFontSubsetting(true);
      $pdf->SetFont('thsarabun', '', 13, '', true);
		$pdf->setPrintHeader(false);
		$pdf->SetTitle("สมุดคู่ฝาก");
		$pdf->AddPage();
		$pdf->SetMargins(33,0,0);
		$table='<table  style="border-spacing: 0">';
		# cm-px"=>37.795276
		$y = 5;
		foreach ($data['account_detail']->result() as $row) {
			$account_id = $row->account_id;
			if($row->passbook_line > 29 ){
				$line = 1 ;
				$data_account=array(
					'passbook_line'=>$line,
				);
			}
			else{
				$line = intval($row->passbook_line) ;
				$data_account=array(
					'passbook_line'=>$line+1,
				);
			}
			$dep="";
			$wd="";
			if($row->action == "deposit"){
				$action = "C";
				$dep = number_format($row->trans_money,2);
			}
			elseif($row->action == "withdraw"){
				$action ="C";
				$wd = number_format($row->trans_money,2);
			}
			elseif($row->action == "tranfer"){
				$action ="C";
			}
			else{
				$action ="IN";
				$dep = number_format($row->trans_money,2);
			}
			$y*=$line;
			$table.='<tr>
				<td style="height:16px;width:76px;border-spacing: 0">'.DateThai($row->record_date).'</td>
				<td style="height:16px;width:34px;border-spacing: 0">'.$action.'</td>
				<td alizgn="right" style="height:16px;width:117px;border-spacing: 0">'.$wd.'</td>
				<td align="right" style="height:16px;width:117px;border-spacing: 0">'.$dep.'</td>
				<td align="right" style="height:16px;width:121px;border-spacing: 0">'.number_format($row->account_detail_balance,2).'</td>
				<td align="right" style="height:16px;width:35px;border-spacing: 0"></td>
				<td align="right" style="height:16px;width:35px;border-spacing: 0"></td>
			</tr>';
		}
		$table.='</table>';
		$data_account_detail=array(
				'passbook_row_status'=>"1",
			);
		$this->User_model->update_end_day_account_detail($this->uri->segment(3),$data_account_detail);
		$this->User_model->update_account($account_id,$data_account);
		$pdf->SetY(25+$y);
		$pdf->writeHTMLCell(0,0,'','',$table,0,1,0,true,'C',true);
		$pdf->Output('example_001.pdf', 'I');
	}
	public function print_passbook_continue(){
		function DateThai($strDate)
		{
			date_default_timezone_set('Asia/Bangkok');
			$strYear = date("Y",strtotime($strDate))+543;
			$strMonth= date("m",strtotime($strDate));
			$strDay= date("d",strtotime($strDate));
			return "$strDay/$strMonth/$strYear";
		}
		$pdf = new Pdf('P','mm','A4');
      $pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
      $pdf->setFontSubsetting(true);
      $pdf->SetFont('thsarabun', '', 13, '', true);
		$pdf->setPrintHeader(false);
		$pdf->SetTitle("สมุดคู่ฝาก");
		$pdf->AddPage();
		$pdf->SetMargins(33,0,0);
		$table='<table  style="border-spacing: 0">';
		# cm-px"=>37.795276
		$y = 5;
		$set = 0;
		foreach ($this->User_model->select_account_detail_with_account_id_not_print($this->uri->segment(3))->result() as $row) {
			foreach ($this->User_model->select_account_detail_with_account_id_not_print_limit($this->uri->segment(3))->result() as $row2) {
				$y = 5;
				$account_id = $row2->account_id;
				$base_line = $row2->passbook_line;
				if($base_line > 29 ){
					$line = 1;
				}
				else{
					$line = intval($base_line);
				}
				$data_account=array(
						'passbook_line'=>$line+1,
					);
				$data_account_detail=array(
					'passbook_row_status'=>"1",
				);
				$dep="";
				$wd="";
				if($row->action == "deposit"){
					$action = "C";
					$dep = number_format($row->trans_money,2);
				}
				elseif($row->action == "withdraw"){
					$action ="C";
					$wd = number_format($row->trans_money,2);
				}
				elseif($row->action == "tranfer"){
					$action ="C";
				}
				else{
					$action ="IN";
					$dep = number_format($row->trans_money,2);
				}
				$set = 25+($y*$line);
				$this->User_model->update_end_day_account_detail($row->account_detail_id,$data_account_detail);
				$this->User_model->update_account($account_id,$data_account);
				$table.='<tr>
				<td style="height:16px;width:76px;border-spacing: 0">'.DateThai($row->record_date).'</td>
				<td style="height:16px;width:34px;border-spacing: 0">'.$action.'</td>
				<td alizgn="right" style="height:16px;width:117px;border-spacing: 0">'.$wd.'</td>
				<td align="right" style="height:16px;width:117px;border-spacing: 0">'.$dep.'</td>
				<td align="right" style="height:16px;width:121px;border-spacing: 0">'.
				number_format($row->account_detail_balance,2).'</td>
				<td align="right" style="height:16px;width:35px;border-spacing: 0"></td>
				<td align="right" style="height:16px;width:35px;border-spacing: 0"></td>
			</tr>';
			}
		}
		$table.='</table>';
		$pdf->SetY($set);
		$pdf->writeHTMLCell(0,0,'','',$table,0,1,0,true,'C',true);
		$pdf->Output('example_001.pdf', 'I');
	}
	public function print_passbook_new(){
		$pdf = new TCPDF('P','mm','A4');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		if($this->input->post('checkbox_value'))
		{
		   $account_detail_id = $this->input->post('checkbox_value');
		   for($count = 0; $count < count($account_detail_id); $count++)
		   {
		   		$data['account_detail_'.$count] = $this->User_model->select_account_detail_parameter($account_detail_id[$count]);
		   }
		  	for($i =0 ; $i < count($data); $i++){
		  		foreach ($data['account_detail_'.$i]->result() as $row) {
		  			$gdfgdsgsgsg= intval($row->passbook_line)+$i.":".$row->record_date." ".$row->record_time.":";
		  			$pdf->Cell(190,10,$gdfgdsgsgsg,1,1,'L');
		  		}
		   }
		}
		$pdf->Output('example_001.pdf', 'I');

	}
	public function cal_day($strDate2,$strDate1) //return เป็นผลต่างของวันที่
	{
		date_default_timezone_set('Asia/Bangkok');
		$result = (strtotime($strDate2)-strtotime($strDate1))/  ( 60 * 60 * 24 )	;
		return $result; // 1 day = 60*60*24
	}
	public function cal_inerest_close_account(){
		date_default_timezone_set('Asia/Bangkok');
		foreach($this->User_model->select_account_with_parameter($this->input->post('account_id'))->result() as $row) {
			if($row->interest_update == "0000-00-00"){ # ไม่เคยคำนวณ
				$this->cal_interest_close_account_between_date($this->input->post('account_id'),"0000-00-00",date('Y-m-d'),$this->input->post('staff_id'));
			}
			elseif($row->interest_update == substr($row->interest_update,0,4)."-04-01"){ # คำนวณ phase 1 แล้ว
				$this->cal_interest_close_account_between_date($this->input->post('account_id'),substr($row->interest_update,0,4)."-04-01",date('Y-m-d'),$this->input->post('staff_id'));
			}
			elseif($row->interest_update == substr($row->interest_update,0,4)."-10-01"){ # คำนวณ phase 2 แล้ว
				$this->cal_interest_close_account_between_date($this->input->post('account_id'),substr($row->interest_update,0,4)."-10-01",date('Y-m-d') /*"2019-12-20"*/,$this->input->post('staff_id'));
			}
			else{
				echo json_encode(array("interest"=>"คำนวณผิดพลาด"));
			}
		}

	}
	public function cal_interest_auto(){
		date_default_timezone_set('Asia/Bangkok');
 		$data["account"] = $this->User_model->select_all_account_never_cal();
 		foreach ($data["account"]->result() as $row) {
 			if($row->interest_update == "0000-00-00" && date('Y-m-d')/*"2019-04-01"*/ == date('Y-04-01') && $row->account_open_date < date('Y-04-01')){
 				$this->cal_interest_phase1($row->account_id);
 			}
 			elseif($row->interest_update == "0000-00-00" && date('Y-m-d')/*"2019-10-01"*/ == date('Y-10-01') && $row->account_open_date >= date('Y-04-01') && $row->account_open_date < date('Y-10-01')) {
 				$this->cal_interest_phase2($row->account_id);
 			}
 			elseif($row->interest_update == "0000-00-00" && date('Y-m-d') /*"2019-04-01"*/ == date('Y-04-01') && $row->account_open_date > date('Y-10-01',strtotime('-1 year')) && $row->account_open_date < date('Y-04-01')) {
 				$this->cal_interest_phase1($row->account_id);
 			}
 			elseif($row->interest_update == date('Y-04-01') && date('Y-m-d') /*"2019-10-01"*/ == date('Y-10-01')){
 				$this->cal_interest_phase2($row->account_id);
 			}
 			elseif($row->interest_update == substr($row->interest_update,0,4)."-10-01" && date('Y-m-d') /*"2019-04-01"*/ == date('Y-04-01')){
 				$this->cal_interest_phase1($row->account_id);
 			}
 			elseif($row->interest_update == substr($row->interest_update,0,4)."-04-01" && date('Y-m-d') /*"2019-10-01"*/ == date('Y-10-01')){
 				$this->cal_interest_phase2($row->account_id);
 			}
 		}
	}
	public function check_last_day_phase1($accoint_id,$date,$account_detail_id){
		$data['check_max_date'] = $this->User_model->check_next_date_phase1($accoint_id);
		foreach ($data['check_max_date']->result() as $row) {
	 	 	if($date == $row->record_date){return $account_detail_id;}
	 	 	else{return null;}
		}
	}
	public function check_last_day_phase2($accoint_id,$date,$account_detail_id){
		$data['check_max_date'] = $this->User_model->check_next_date_phase2($accoint_id);
		foreach ($data['check_max_date']->result() as $row) {
	 	 	if($date == $row->record_date){return $account_detail_id;}
	 	 	else{return null;}
		}
	}
	public function cal_interest_close_account_between_date($account_id,$start_date,$stop_date,$staff_id){
		#-----------------------ดอกเบี้ย---------------------#
		$result_int = 0.0; # ผลคำนวณดอกเบี้ยแต่ละครั้ง
		$result_all_int = 0.0; # ผลรวมการคำนวณดอกเบี้ยทั้งหมด
		static $interest_rate = 0.4; # อัตราดอกเบี้ย
		static $year = 365; # จำนวนวันของปี
		static $per_100 = 100; # ร้อยละ
		#--------------------------------------------------#
		foreach ($this->User_model->select_account_with_parameter($account_id)->result() as $row123) {$account_balance = $row123->account_balance;}

		$data['account_detail'] = $this->User_model->select_account_detail_end_day_close_account($account_id,$start_date,$stop_date);
		if($data['account_detail'] == null){echo json_encode(array("interest"=>"คำนวณผิดพลาด"));}
		else{
			foreach ($data['account_detail']->result() as $row) {
				$result = $this->check_last_day_close_account($account_id,$row->account_detail_id,$start_date,$stop_date,$row->record_date);
				if($result != null){
					foreach ($this->User_model->select_account_detail_parameter($result)->result() as $row2) {
						$date_diff = (strtotime($stop_date)-strtotime($row2->record_date))/  ( 60 * 60 * 24 );
					}
				}
				else{
					foreach ($this->User_model->select_account_detail_end_day_next_row($account_id,$row->record_date)->result() as $row2 ) {
						$date_diff = (strtotime($row2->record_date)-strtotime($row->record_date))/  ( 60 * 60 * 24 );
					}
				}
				$result_int = (floatval($row->account_detail_balance)*$interest_rate*intval($date_diff))/($per_100*$year);
				$result_all_int+=$result_int;
				$total_balance = floatval($account_balance) + $result_all_int;
				//echo "total_สะสม:".$result_all_int."<br>";
				//echo "interest="."(".$row->account_detail_balance."*".$interest_rate."*".$date_diff.")/(".$per_100."*".$year.")=".$result_int."<br>";
			}
			echo json_encode(array("interest"=>round($result_all_int,2)));
			//echo "total_balance=".$total_balance."<br><br>";
			/*$data_account_detail_add_interest=array(
				'trans_id'=>'0',
				'account_id'=>$account_id,
				'staff_record_id'=>$staff_id,
				'action'=>'add_interest',
				'record_date'=>date('Y-m-d'),
				'record_time'=>date('H:i:s'),
				'account_detail_balance'=>round($total_balance,2),
				'trans_money'=>round($result_all_int,2),
				'account_detail_confirm'=>'1',
				'passbook_row_status'=>'0',
				'end_day'=>'0',
			);
			$data_interest_history=array(
				'account_id'=>$account_id,
				'interest_money'=>round($result_all_int,2),
				'interest_date'=>date('Y-m-d')
			);
			$data_account=array(
				'interest_update'=>date('Y-m-d'),
				'account_balance'=>round($total_balance,2),
			);
			$this->User_model->insert_account_details($data_account_detail_add_interest);
			$this->User_model->insert_interest_history($data_interest_history);
			$this->User_model->update_interest_account($account_id,$data_account);*/
		}

	}
	public function check_last_day_close_account($account_id,$account_detail_id,$start_date,$stop_date,$condition_date){
		foreach ($this->User_model->check_next_date_clsoe_account($account_id,$start_date,$stop_date)->result() as $row) {
	 	 	if($condition_date == $row->record_date){return $account_detail_id;}
	 	 	else{return null;}
		}
	}
	public function cal_interest_phase1($account_id){
		$data['account'] = $this->User_model->select_account_with_parameter($account_id);
			foreach ($data['account']->result() as $row) {$account_balance = $row->account_balance;}
		#-----------------------ดอกเบี้ย---------------------#
		$result_int = 0.0; # ผลคำนวณดอกเบี้ยแต่ละครั้ง
		$result_all_int = 0.0; # ผลรวมการคำนวณดอกเบี้ยทั้งหมด
		static $interest_rate = 0.4; # อัตราดอกเบี้ย
		static $year = 365; # จำนวนวันของปี
		static $per_100 = 100; # ร้อยละ
		#--------------------------------------------------#
		$data['account_detail'] = $this->User_model->select_account_detail_end_day_phase_1($account_id);
		if($data['account_detail'] == null){}
		else{
			foreach ($data['account_detail']->result() as $row) {
				$result = $this->check_last_day_phase1($account_id,$row->record_date,$row->account_detail_id);
				if($result != null){
					$data['account_detail2'] = $this->User_model->select_account_detail_parameter($result);
					foreach ($data['account_detail2']->result() as $row2) {
						$date_diff = (strtotime(date('Y-04-01'))-strtotime($row2->record_date))/  ( 60 * 60 * 24 );
					}
				}
				else{
					$data['account_detail2'] = $this->User_model->select_account_detail_end_day_next_row($account_id,$row->record_date);
					foreach ($data['account_detail2']->result() as $row2 ) {
						$date_diff = (strtotime($row2->record_date)-strtotime($row->record_date))/  ( 60 * 60 * 24 );
					}
				}
				$result_int = (floatval($row->account_detail_balance)*$interest_rate*intval($date_diff))/($per_100*$year);
				$result_all_int+=$result_int;
				$total_balance = floatval($account_balance) + $result_all_int;
				//echo "interest="."(".$row->account_detail_balance."*".$interest_rate."*".$date_diff.")/(".$per_100."*".$year.")<br>";
			}//echo "total:".$result_all_int."<br>";
			$ir_code = $this->User_model->auto_generate_interest_code();
			$data_account_detail=array(
				'trans_id'=>$ir_code,
				'account_id'=>$account_id,
				'staff_record_id'=>'1',
				'action'=>'add_interest',
				'record_date'=>date('Y-04-01'),
				'record_time'=>date('H:i:s'),
				'account_detail_balance'=>round($total_balance,2),
				'trans_money'=>round($result_all_int,2),
				'account_detail_confirm'=>'1',
				'passbook_row_status'=>'1',
				'end_day'=>'0',
			);
			
			$data_interest_history=array(
				'ih_id'=>$ir_code,
				'account_id'=>$account_id,
				'interest_money'=>round($result_all_int,2),
				'interest_date'=>date('Y-04-01')
			);
			$data_account=array(
				'interest_update'=>date('Y-04-01'),
				'account_balance'=>round($total_balance,2)
			);
			$this->User_model->insert_account_details($data_account_detail);
			$this->User_model->insert_interest_history($data_interest_history);
			$this->User_model->update_interest_account($account_id,$data_account);
		}
	}
	public function cal_interest_phase2($account_id){
		$data['account'] = $this->User_model->select_account_with_parameter($account_id);
			foreach ($data['account']->result() as $row) {$account_balance = $row->account_balance;}
		#-----------------------ดอกเบี้ย---------------------#
		$result_int = 0.0; # ผลคำนวณดอกเบี้ยแต่ละครั้ง
		$result_all_int = 0.0; # ผลรวมการคำนวณดอกเบี้ยทั้งหมด
		static $interest_rate = 0.4; # อัตราดอกเบี้ย
		static $year = 365; # จำนวนวันของปี
		static $per_100 = 100; # ร้อยละ
		#--------------------------------------------------#
		$data['account_detail'] = $this->User_model->select_account_detail_end_day_phase_2($account_id);
		if($data['account_detail'] == null){}
		else{
			foreach ($data['account_detail']->result() as $row) {
				$result = $this->check_last_day_phase2($account_id,$row->record_date,$row->account_detail_id);
				if($result != null){
					$data['account_detail2'] = $this->User_model->select_account_detail_parameter($result);
					foreach ($data['account_detail2']->result() as $row2) {
						$date_diff = (strtotime(date('Y-10-01'))-strtotime($row2->record_date))/  ( 60 * 60 * 24 );
					}
				}
				else{
					$data['account_detail2'] = $this->User_model->select_account_detail_end_day_next_row($account_id,$row->record_date);
					foreach ($data['account_detail2']->result() as $row2 ) {
						$date_diff = (strtotime($row2->record_date)-strtotime($row->record_date))/  ( 60 * 60 * 24 );
					}
				}
				$result_int = (floatval($row->account_detail_balance)*$interest_rate*intval($date_diff))/($per_100*$year);
				$result_all_int+=$result_int;
				$total_balance = floatval($account_balance) + $result_all_int;
				//echo "interest="."(".$row->account_detail_balance."*".$interest_rate."*".$date_diff.")/(".$per_100."*".$year.")<br>";
			}
			//echo "total:".$result_all_int."<br>";
			$ir_code = $this->User_model->auto_generate_interest_code();
			$data_account_detail=array(
				'trans_id'=>$ir_code,
				'account_id'=>$account_id,
				'staff_record_id'=>'1',
				'action'=>'add_interest',
				'record_date'=>date('Y-10-01'),
				'record_time'=>date('H:i:s'),
				'account_detail_balance'=>round($total_balance,2),
				'trans_money'=>round($result_all_int,2),
				'account_detail_confirm'=>'1',
				'passbook_row_status'=>'1',
				'end_day'=>'0',
			);
			$data_interest_history=array(
				'ih_id'=>$ir_code,
				'account_id'=>$account_id,
				'interest_money'=>round($result_all_int,2),
				'interest_date'=>date('Y-10-01')
			);
			$data_account=array(
				'interest_update'=>date('Y-10-01'),
				'account_balance'=>round($total_balance,2)
			);
			$this->User_model->insert_account_details($data_account_detail);
			$this->User_model->insert_interest_history($data_interest_history);
			$this->User_model->update_interest_account($account_id,$data_account);
		}
	}
	public function cal_end_day(){
		date_default_timezone_set('Asia/Bangkok');
 		$data["account"] = $this->User_model->select_all_account();
		$account=$data['account']->result();
		foreach ($account as $row) {
			if($this->cal_day(date('Y-m-d'),$row->record_date) > "0"){
				$data['max_date_record'] = $this->User_model->select_max_time_account_detail($row->account_id,$row->record_date);
				foreach ($data['max_date_record']->result() as $row_max_date_record) {
					if($row->record_time == $row_max_date_record->record_time){
						$data=array('end_day'=>"1");
						$this->User_model->update_end_day_account_detail($row->account_detail_id,$data);
					}
				}
			}
		}
	}

	public function print_report_statement(){
		if($this->input->post('filter') == "all"){
			$data['statement'] = $this->User_model->select_account_detail_parameter_account_id($this->input->post('account_id'));
		}
		else{
			$data['statement'] = $this->User_model->select_account_detail_parameter_account_id_filter($this->input->post('account_id'),$this->input->post('filter'));
		}
		$pdf = new Pdf('P','mm','A4');
      $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING);
      $pdf->setFooterData(array(0,64,0), array(0,64,128));
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
      $pdf->setFontSubsetting(true);
      $pdf->SetFont('thsarabun', '', 16, '', true);
		$pdf->setPrintHeader(false);
		$pdf->setCellPadding(1,1,1,1);
		$pdf->setCellmargins(1,1,1,1);
		$pdf->SetTitle("รายงานบัญชี");
		$pdf->AddPage();
		function DateThai($strDate)
		{
			date_default_timezone_set('Asia/Bangkok');
			$strYear = date("Y",strtotime($strDate))+543;
			$strMonth= date("m",strtotime($strDate));
			$strDay= date("d",strtotime($strDate));
			return "$strDay/$strMonth/$strYear";
		}
		$pdf->Image(base_url()."picture/donkha.png", 91,5, 25, 30, 'PNG', 'http://www.mindphp.com');
		$pdf->Ln(8);
		$heading = "<h3>รายงานบัญชี</h3>";
		$pdf->Ln(2);
		$pdf->writeHTMLCell(0,0,'','',$heading,0,1,0,true,'C',true);
		$data['account'] = $this->User_model->select_account_with_parameter($this->input->post('account_id'));
		foreach ($data['account']->result() as $row) {
			$account = '<p style="margin-right:20px"><b>หมายเลขบัญชี '.$this->input->post('account_id').'&nbsp;&nbsp;&nbsp;&nbsp;ชื่อเจ้าของบัญชี '.$row->member_title."".$row->member_name.'&nbsp;&nbsp;&nbsp;&nbsp;ชื่อบัญชี '.$row->account_name.'</b></p>';
		}
		$pdf->writeHTMLCell(0,0,'','',$account,0,1,0,true,'L',true);
		$table='<table style="border:1px solid black">';
		$table.='<tr>
	                <th style="border:1px solid black" width="10%" scope="col">ลำดับ</th>
	                <th style="border:1px solid black" width="18%" scope="col">วันที่</th>
	                <th style="border:1px solid black" width="14%" scope="col">รายการ</th>
	                <th style="border:1px solid black" width="15%" scope="col">จำนวนเงิน</th>
	                <th style="border:1px solid black" width="15%" scope="col">คงเหลือ</th>
	                <th style="border:1px solid black" width="28%" scope="col">พนักงานที่ทำรายการ</th>
    			</tr>';
		$i=1;
		foreach ($data['statement']->result() as $row) {
			if($row->action == "deposit"){$action = "ฝาก";}
			elseif($row->action == "add_interest"){$action = "เพิ่มดอกเบี้ย";}
			elseif($row->action == "recive_money"){$action = "รับเงินโอน";}
			elseif($row->action == "open_account"){$action = "เปิดบัญชี";}
			elseif($row->action == "tranfer_money"){$action = "โอนเงิน";}
			else{$action = "ถอน";}
			$table.='<tr>
						<td style="border:1px solid black">'.$i.'</td>
						<td style="border:1px solid black">'.DateThai($row->record_date).'</td>
						<td style="border:1px solid black">'.$action.'</td>
						<td align="right" style="border:1px solid black">'.number_format($row->trans_money,2).'</td>
						<td align="right"  style="border:1px solid black">'.number_format($row->account_detail_balance,2).'</td>
						<td style="border:1px solid black">'.$row->staff_title."".$row->staff_name.'</td>
					</tr>';
			$i++;
		}
		$table.='</table>';
		$pdf->writeHTMLCell(0,0,'','',$table,0,1,0,true,'C',true);
		ob_clean();
		$pdf->Output('example_001.pdf', 'I');
		ob_end_clean();
	}
	public function print_member_report(){
		foreach ($this->User_model->get_member($this->input->post('member_id'))->result() as $row) {
			$std_id=$row->std_code;
		}
		if($std_id == '0'){ //บุคลากร
			$data['member_after']=$this->User_model->get_personal_member($this->input->post('member_id'));
		}
		else{ //นักเรียน
			$data['member_after']=$this->User_model->get_student_member($this->input->post('member_id'));
		}	
		foreach($data['member_after']->result() as $row2){
			if($row2->std_code == '0'){
				$std_code = 'ไม่มี';
				$edu_id = 'ไม่มี';
				$job = $row2->job_name;
			} 
			else{
			$std_code = $row2->std_code;
			$edu_id = $row2->edu_name;
			$job = 'นักเรียน';
			}
		}
		$pdf = new Pdf('P','mm','A4');
   	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING);
   	$pdf->setFooterData(array(0,64,0), array(0,64,128));
   	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
   	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
   	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
   	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
   	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
   	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
   	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
   	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
   	$pdf->setFontSubsetting(true);
   	$pdf->SetFont('thsarabun', '', 16, '', true);
		$pdf->setPrintHeader(false);
		$pdf->setCellPadding(1,1,1,1);
		$pdf->setCellmargins(1,1,1,1);
		$pdf->SetTitle("รายงานบัญชี");
		$pdf->AddPage();
		function DateThai($strDate)
		{
			date_default_timezone_set('Asia/Bangkok');
			$strYear = date("Y",strtotime($strDate))+543;
			$strMonth= date("m",strtotime($strDate));
			$strDay= date("d",strtotime($strDate));
			return "$strDay/$strMonth/$strYear";
		}
		$pdf->Image(base_url()."picture/donkha.png", 91,5, 25, 30, 'PNG', 'http://www.mindphp.com');
		$pdf->Ln(8);
		$heading = "<h3>รายงานบัญชี</h3>";
		$pdf->Ln(2);
		$pdf->writeHTMLCell(0,0,'','',$heading,0,1,0,true,'C',true);
		$data['account'] = $this->User_model->select_account_with_parameter($this->input->post('account_id'));
		foreach ($data['account']->result() as $row) {
			$account = '<p style="margin-right:20px"><b>หมายเลขบัญชี '.$this->input->post('account_id').'&nbsp;&nbsp;&nbsp;&nbsp;ชื่อบัญชี '.$row->account_name.'</b></p>';
		}
		$pdf->writeHTMLCell(0,0,'','',$account,0,1,0,true,'L',true);
		$table='<table style="border:1px solid black">';
		$table.='<tr>
	                <th style="border:1px solid black" width="10%" scope="col">ลำดับ</th>
	                <th style="border:1px solid black" width="18%" scope="col">วันที่</th>
	                <th style="border:1px solid black" width="14%" scope="col">รายการ</th>
	                <th style="border:1px solid black" width="15%" scope="col">จำนวนเงิน</th>
	                <th style="border:1px solid black" width="15%" scope="col">คงเหลือ</th>
	                <th style="border:1px solid black" width="28%" scope="col">พนักงานที่ทำรายการ</th>
    			</tr>';
		$i=1;
		foreach ($data['statement']->result() as $row) {
			if($row->action == "deposit"){$action = "ฝาก";}
			elseif($row->action == "add_interest"){$action = "เพิ่มดอกเบี้ย";}
			else{$action = "ถอน";}
			$table.='<tr>
						<td style="border:1px solid black">'.$i.'</td>
						<td style="border:1px solid black">'.DateThai($row->record_date).'</td>
						<td style="border:1px solid black">'.$action.'</td>
						<td align="right" style="border:1px solid black">'.number_format($row->trans_money,2).'</td>
						<td align="right"  style="border:1px solid black">'.number_format($row->account_detail_balance,2).'</td>
						<td style="border:1px solid black">'.$row->staff_title."".$row->staff_name.'</td>
					</tr>';
			$i++;
		}
		$table.='</table>';
		$pdf->writeHTMLCell(0,0,'','',$table,0,1,0,true,'C',true);
		ob_clean();
		$pdf->Output('example_001.pdf', 'I');
		ob_end_clean();
	}
	public function fetch_account_datatable(){
		$order_index = $this->input->get('order[0][column]');
        $param['page_size'] = $this->input->get('length');
        $param['start'] = $this->input->get('start');
        $param['draw'] = $this->input->get('draw');
        $param['keyword'] = trim($this->input->get('search[value]'));
        $param['column'] = $this->input->get("columns[{$order_index}][data]");
        $param['dir'] = $this->input->get('order[0][dir]');
 
        $results = $this->User_model->fetch_account_datatable($param);
 
        $data['draw'] = $param['draw'];
        $data['recordsTotal'] = $results['count'];
        $data['recordsFiltered'] = $results['count_condition'];
        $data['data'] = $results['data'];
        $data['error'] = $results['error_message'];
 
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	public function fetch_member_datatable(){
		$order_index = $this->input->get('order[0][column]');
        $param['page_size'] = $this->input->get('length');
        $param['start'] = $this->input->get('start');
        $param['draw'] = $this->input->get('draw');
        $param['keyword'] = trim($this->input->get('search[value]'));
        $param['column'] = $this->input->get("columns[{$order_index}][data]");
        $param['dir'] = $this->input->get('order[0][dir]');
 
        $results = $this->User_model->fetch_member_datatable($param);
 
        $data['draw'] = $param['draw'];
        $data['recordsTotal'] = $results['count'];
        $data['recordsFiltered'] = $results['count_condition'];
        $data['data'] = $results['data'];
        $data['error'] = $results['error_message'];
 
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	public function fetch_staff_datatable(){
		$order_index = $this->input->get('order[0][column]');
        $param['page_size'] = $this->input->get('length');
        $param['start'] = $this->input->get('start');
        $param['draw'] = $this->input->get('draw');
        $param['keyword'] = trim($this->input->get('search[value]'));
        $param['column'] = $this->input->get("columns[{$order_index}][data]");
        $param['dir'] = $this->input->get('order[0][dir]');
 
        $results = $this->User_model->fetch_staff_datatable($param);
 
        $data['draw'] = $param['draw'];
        $data['recordsTotal'] = $results['count'];
        $data['recordsFiltered'] = $results['count_condition'];
        $data['data'] = $results['data'];
        $data['error'] = $results['error_message'];
 
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	public function testtt(){
		$staff_id=$this->uri->segment(3);
		echo $staff_id;
	}
	public function fetch_deposit_year(){
		$result='<script>
		$(document).ready(function(){
			$("#year").change(function(){
				if($(this).val() == ""){$(".table-responsiv").empty();$(".third").empty();}
				else{
					if('.$this->input->post('type').' == "2"){
						$.ajax({
							type: "POST",
							url: "'.site_url("/Project_controller/report_deposit_per_month").'",
							method:"POST",
							data:{
							  year:$(this).val()
							},
							success:function(response){
								$(".table-responsiv").html(response);
							},
							error: function( error ){alert( error );}
						});
					}else{
						$.ajax({
							type: "POST",
							url: "'.site_url("/Project_controller/fetch_deposit_month").'",
							method:"POST",
							data:{
							  year:$(this).val()
							},
							success:function(response){
								$(".table-responsiv").empty();
								$(".third").html(response);
							},
							error: function( error ){alert( error );}
						});
					}	
				}		
			});
		});
	 	</script>';
		$result.='<div class="row">';
		$result.='<div class="col-4">เลือกปี:</div>';
		$result.='<div class="col-5">';
		$result.='<select class="form-control" name="year" id="year">';
		$result.='<option value="">เลือกปี</option>';
		foreach ($this->User_model->select_deposit_year()->result() as $row) {
			$thaiyear = intval($row->year)+543;
			$result.='<option value="'.$row->year.'">'.$thaiyear.'</option>';
		}
		$result.='</select>';
		$result.='</div>';
		$result.='<div class="col-3"></div>';
		$result.='</div>';
		echo $result;
	}
	public function fetch_withdraw_year(){
		$result='<script>
		$(document).ready(function(){
			$("#year").change(function(){
				if($(this).val() == ""){$(".table-responsiv").empty();$(".third").empty();}
				else{
					if('.$this->input->post('type').' == "2"){
						$.ajax({
							type: "POST",
							url: "'.site_url("/Project_controller/report_withdraw_per_month").'",
							method:"POST",
							data:{
							  year:$(this).val()
							},
							success:function(response){
								$(".table-responsiv").html(response);
							},
							error: function( error ){alert( error );}
						});
					}else{
						$.ajax({
							type: "POST",
							url: "'.site_url("/Project_controller/fetch_withdraw_month").'",
							method:"POST",
							data:{
							  year:$(this).val()
							},
							success:function(response){
								$(".table-responsiv").empty();
								$(".third").html(response);
							},
							error: function( error ){alert( error );}
						});
					}	
				}		
			});
		});
	 	</script>';
		$result.='<div class="row">';
		$result.='<div class="col-4">เลือกปี:</div>';
		$result.='<div class="col-5">';
		$result.='<select class="form-control" name="year" id="year">';
		$result.='<option value="">เลือกปี</option>';
		foreach ($this->User_model->select_withdraw_year()->result() as $row) {
			$thaiyear = intval($row->year)+543;
			$result.='<option value="'.$row->year.'">'.$thaiyear.'</option>';
		}
		$result.='</select>';
		$result.='</div>';
		$result.='<div class="col-3"></div>';
		$result.='</div>';
		echo $result;
	}
	public function report_deposit_per_month(){
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$sumofmonth=0.0;
		$result='<div class="row">
					<div class="col-4"></div>
					<div class="col-4">
					<table class="table table-striped table-hover text-center" id="job-table">
					<thead class="thead-light table-bordered">
							<tr>
									<th width="20%" scope="col">เดือน</th>
									<th width="50%" scope="col">จำนวนเงิน</th>
							</tr>
					</thead>
					<tbody class="table-bordered" style="background-color: #EFFEFD">
					';
		foreach ($this->User_model->select_deposit_month($this->input->post('year'))->result() as $row) {
			foreach ($this->User_model->select_sum_deposit_month($this->input->post('year'),$row->month)->result() as $row2) {
				$sumofmonth+=floatval($row2->summonth );
				$thaimonth= $strMonthCut[intval($row->month)];
				//echo $row->year." ".$row2->sum_year."<br>";
				$result.='<tr>
				<th id="count"  scope="row">'.$thaimonth.'</th>
				<td align="right" id="ac_code">'.number_format($row2->summonth,2)." บาท".'</td>
						</tr>';
			}
		}
		//echo $sumofyear;
		$link =base_url("index.php/Project_controller/print_report_transaction")."/deposit"."/month"."/".$this->input->post('year');
		$result.='<tr><th scope="col">รวม</th><td align="right" scope="col">'.number_format($sumofmonth,2)." บาท".'</td></tr></tbody><tfoot></tfoot>
		</table></div>
		<div class="col-4"><a href="'.$link.'" target="_blank" class="btn btn-warning print">พิมพ์</a></div>
		</div>';
		echo $result;
	}
	public function report_withdraw_per_month(){
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$sumofmonth=0.0;
		$result='<div class="row">
					<div class="col-4"></div>
					<div class="col-4">
					<table class="table table-striped table-hover text-center" id="job-table">
					<thead class="thead-light table-bordered">
							<tr>
									<th width="20%" scope="col">เดือน</th>
									<th width="50%" scope="col">จำนวนเงิน</th>
							</tr>
					</thead>
					<tbody class="table-bordered" style="background-color: #EFFEFD">
					';
		foreach ($this->User_model->select_withdraw_month($this->input->post('year'))->result() as $row) {
			foreach ($this->User_model->select_sum_withdraw_month($this->input->post('year'),$row->month)->result() as $row2) {
				$sumofmonth+=floatval($row2->summonth );
				$thaimonth= $strMonthCut[intval($row->month)];
				//echo $row->year." ".$row2->sum_year."<br>";
				$result.='<tr>
				<th id="count"  scope="row">'.$thaimonth.'</th>
				<td align="right" id="ac_code">'.number_format($row2->summonth,2)." บาท".'</td>
						</tr>';
			}
		}
		//echo $sumofyear;
		$link =base_url("index.php/Project_controller/print_report_transaction")."/withdraw"."/month"."/".$this->input->post('year');
		$result.='<tr><th scope="col">รวม</th><td align="right" scope="col">'.number_format($sumofmonth,2)." บาท".'</td></tr></tbody><tfoot></tfoot>
		</table></div>
		<div class="col-4"><a href="'.$link.'" target="_blank" class="btn btn-warning print">พิมพ์</a></div>
		</div>';
		echo $result;
	}
	public function fetch_deposit_month(){
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$result='<script>
		$(document).ready(function(){
			$("#month").change(function(){
				if($(this).val() == ""){$(".table-responsiv").empty();}
				else{				
					$.ajax({
						type: "POST",
						url: "'.site_url("/Project_controller/report_deposit_per_day").'",
						method:"POST",
						data:{
							month:$(this).val(),
							year:'.$this->input->post('year').'
						},
						success:function(response){
							$(".table-responsiv").html(response);
						},
						error: function( error ){alert( error );}
					});					
				}
				
			});
		});
	 	</script>';
		$result.='<div class="row">';
		$result.='<div class="col-4">เลือกเดือน:</div>';
		$result.='<div class="col-6">';
		$result.='<select class="form-control" name="month" id="month">';
		$result.='<option value="">เลือกเดือน</option>';
		foreach ($this->User_model->select_deposit_month($this->input->post('year'))->result() as $row) {
			$result.='<option value="'.$row->month.'">'.$strMonthCut[intval($row->month)].'</option>';
		}
		$result.='</select>';
		$result.='</div>';
		$result.='<div class="col-3"></div>';
		$result.='</div>';
		echo $result;
	}
	public function fetch_withdraw_month(){
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$result='<script>
		$(document).ready(function(){
			$("#month").change(function(){
				if($(this).val() == ""){$(".table-responsiv").empty();}
				else{				
					$.ajax({
						type: "POST",
						url: "'.site_url("/Project_controller/report_withdraw_per_day").'",
						method:"POST",
						data:{
							month:$(this).val(),
							year:'.$this->input->post('year').'
						},
						success:function(response){
							$(".table-responsiv").html(response);
						},
						error: function( error ){alert( error );}
					});					
				}
				
			});
		});
	 	</script>';
		$result.='<div class="row">';
		$result.='<div class="col-4">เลือกเดือน:</div>';
		$result.='<div class="col-6">';
		$result.='<select class="form-control" name="month" id="month">';
		$result.='<option value="">เลือกเดือน</option>';
		foreach ($this->User_model->select_withdraw_month($this->input->post('year'))->result() as $row) {
			$result.='<option value="'.$row->month.'">'.$strMonthCut[intval($row->month)].'</option>';
		}
		$result.='</select>';
		$result.='</div>';
		$result.='<div class="col-3"></div>';
		$result.='</div>';
		echo $result;
	}
	public function report_deposit_per_day(){
		$sumofmonth=0.0;
		$result='<div class="row">
					<div class="col-4"></div>
					<div class="col-4">
					<table class="table table-striped table-hover text-center" id="job-table">
					<thead class="thead-light table-bordered">
							<tr>
									<th width="50%" scope="col">วันที่</th>
									<th width="40%" scope="col">จำนวนเงิน</th>
							</tr>
					</thead>
					<tbody class="table-bordered" style="background-color: #EFFEFD">
					';
		foreach ($this->User_model->select_deposit_day($this->input->post('year'),$this->input->post('month'))->result() as $row) {
			foreach ($this->User_model->select_sum_deposit_day($row->tran_date)->result() as $row2) {
				$sumofmonth+=floatval($row2->sum );
				$result.='<tr>
				<th id="count"  scope="row">'.$this->DateThai($row->tran_date).'</th>
				<td align="right" id="ac_code">'.number_format($row2->sum,2)." บาท".'</td>
						</tr>';
			}
		}
		$link =base_url("index.php/Project_controller/print_report_transaction")."/deposit"."/day"."/".$this->input->post('year')."/".$this->input->post('month');
		$result.='<tr><th scope="col">รวม</th><td align="right" scope="col">'.number_format($sumofmonth,2)." บาท".'</td></tr></tbody><tfoot></tfoot>
		</table></div>
		<div class="col-4"><a href="'.$link.'" target="_blank" class="btn btn-warning print">พิมพ์</a></div>
		</div>';
		echo $result;
	}
	public function report_withdraw_per_day(){
		$sumofmonth=0.0;
		$result='<div class="row">
					<div class="col-4"></div>
					<div class="col-4">
					<table class="table table-striped table-hover text-center" id="job-table">
					<thead class="thead-light table-bordered">
							<tr>
									<th width="50%" scope="col">วันที่</th>
									<th width="40%" scope="col">จำนวนเงิน</th>
							</tr>
					</thead>
					<tbody class="table-bordered" style="background-color: #EFFEFD">
					';
		foreach ($this->User_model->select_withdraw_day($this->input->post('year'),$this->input->post('month'))->result() as $row) {
			foreach ($this->User_model->select_sum_withdraw_day($row->tran_date)->result() as $row2) {
				$sumofmonth+=floatval($row2->sum );
				$result.='<tr>
				<th id="count"  scope="row">'.$this->DateThai($row->tran_date).'</th>
				<td align="right" id="ac_code">'.number_format($row2->sum,2)." บาท".'</td>
						</tr>';
			}
		}
		$link =base_url("index.php/Project_controller/print_report_transaction")."/withdraw"."/day"."/".$this->input->post('year')."/".$this->input->post('month');
		$result.='<tr><th scope="col">รวม</th><td align="right" scope="col">'.number_format($sumofmonth,2)." บาท".'</td></tr></tbody><tfoot></tfoot>
		</table></div>
		<div class="col-4"><a href="'.$link.'" target="_blank" class="btn btn-warning print">พิมพ์</a></div>
		</div>';
		echo $result;
	}
	public function print_report_transaction(){
		if($this->uri->segment(3) === "deposit"){$tran_name = "ฝาก";}
		else{$tran_name = "ถอน";}
		if($this->uri->segment(4) === "year"){$action_name = "รายปี";$action_name2="ปี";}
		elseif($this->uri->segment(4) === "month"){$action_name = "รายเดือน";$action_name2="เดือน";}
		else{$action_name = "รายวัน";$action_name2="วันที่";}
		$pdf = new Pdf('P','mm','A4');
      $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING);
      $pdf->setFooterData(array(0,64,0), array(0,64,128));
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
      $pdf->setFontSubsetting(true);
      $pdf->SetFont('thsarabun', '', 16, '', true);
		$pdf->setPrintHeader(false);
		$pdf->setCellPadding(1,1,1,1);
		$pdf->setCellmargins(1,1,1,1);
		$pdf->SetTitle("รายงานสรุปยอด".$tran_name." ".$action_name);
		$pdf->AddPage();
		$pdf->Image(base_url()."picture/donkha.png", 91,5, 25, 30, 'PNG', 'http://www.mindphp.com');
		$pdf->Ln(8);
		$content = '<h3>รายงานสรุปยอด'.$tran_name." ".$action_name.'</h3><span>ธนาคารโรงเรียน โรงเรียนดอนคาวิทยา ต.ดอนคา อ.อู่ทอง จ.สุพรรณบุรี 72160</span>
		';
		$pdf->writeHTMLCell(0,0,'','',$content,0,1,0,true,'C',true);
		$pdf->Ln(5);
		$table='<table style="border:1px solid black">';
		$table.='<tr>
	               <th style="border:1px solid black" width="60%" scope="col">'.$action_name2.'</th>
	               <th style="border:1px solid black" width="40%" scope="col">จำนวนเงิน</th>
    			</tr>';
		$trans = $this->uri->segment(3);
		$action = $this->uri->segment(4);
		$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$sum = 0.0;
		if($action === "year"){
			if($trans === "deposit"){
				foreach ($this->User_model->select_deposit_year()->result() as $row) {
					foreach ($this->User_model->select_sum_deposit_year($row->year)->result() as $row2) {
						$sum+=floatval($row2->sum_year);
						$thaiyear= intval($row->year)+543;
						//echo $row->year." ".$row2->sum_year."<br>";
						$table.='<tr>
						<th style="border:1px solid black" id="count"  scope="row">'.$thaiyear.'</th>
						<td style="border:1px solid black" align="right" id="ac_code">'.number_format($row2->sum_year,2)." บาท".'</td>
								</tr>';
					}
				}
			}
			elseif($trans === "withdraw"){
				foreach ($this->User_model->select_withdraw_year()->result() as $row) {
					foreach ($this->User_model->select_sum_withdraw_year($row->year)->result() as $row2) {
						$sum+=floatval($row2->sum_year);
						$thaiyear= intval($row->year)+543;
						//echo $row->year." ".$row2->sum_year."<br>";
						$table.='<tr>
						<th style="border:1px solid black" id="count"  scope="row">'.$thaiyear.'</th>
						<td style="border:1px solid black" align="right" id="ac_code">'.number_format($row2->sum_year,2)." บาท".'</td>
								</tr>';
					}
				}
			}
		}
		elseif($action === "month"){
			if($trans === "deposit"){
				foreach ($this->User_model->select_deposit_month($this->uri->segment(5))->result() as $row) {
					foreach ($this->User_model->select_sum_deposit_month($this->uri->segment(5),$row->month)->result() as $row2) {
						$sum+=floatval($row2->summonth);
						$thaiyear = intval($this->uri->segment(5))+543;
						//echo $row->year." ".$row2->sum_year."<br>";
						$table.='<tr>
						<th style="border:1px solid black" id="count"  scope="row">'.$strMonthCut[intval($row->month)]." พ.ศ. ".$thaiyear.'</th>
						<td style="border:1px solid black" align="right" id="ac_code">'.number_format($row2->summonth,2)." บาท".'</td>
								</tr>';
					}
				}
			}
			elseif($trans === "withdraw"){
				foreach ($this->User_model->select_withdraw_month($this->uri->segment(5))->result() as $row) {
					foreach ($this->User_model->select_sum_withdraw_month($this->uri->segment(5),$row->month)->result() as $row2) {
						$sum+=floatval($row2->summonth);
						$thaiyear = intval($this->uri->segment(5))+543;
						//echo $row->year." ".$row2->sum_year."<br>";
						$table.='<tr>
						<th style="border:1px solid black" id="count"  scope="row">'.$strMonthCut[intval($row->month)]." พ.ศ. ".$thaiyear.'</th>
						<td style="border:1px solid black" align="right" id="ac_code">'.number_format($row2->summonth,2)." บาท".'</td>
								</tr>';
					}
				}
			}
		}
		elseif($action === "day"){
			if($trans === "deposit"){
				foreach ($this->User_model->select_deposit_day($this->uri->segment(5),$this->uri->segment(6))->result() as $row) {
					foreach ($this->User_model->select_sum_deposit_day($row->tran_date)->result() as $row2) {
						$sum+=floatval($row2->sum);
						//echo $row->year." ".$row2->sum_year."<br>";
						$table.='<tr>
						<th style="border:1px solid black" id="count"  scope="row">'.$this->DateThai($row->tran_date).'</th>
						<td style="border:1px solid black" align="right" id="ac_code">'.number_format($row2->sum,2)." บาท".'</td>
								</tr>';
					}
				}
			}
			elseif($trans === "withdraw"){
				foreach ($this->User_model->select_withdraw_day($this->uri->segment(5),$this->uri->segment(6))->result() as $row) {
					foreach ($this->User_model->select_sum_withdraw_day($row->tran_date)->result() as $row2) {
						$sum+=floatval($row2->sum);
						//echo $row->year." ".$row2->sum_year."<br>";
						$table.='<tr>
						<th style="border:1px solid black" id="count"  scope="row">'.$this->DateThai($row->tran_date).'</th>
						<td style="border:1px solid black" align="right" id="ac_code">'.number_format($row2->sum,2)." บาท".'</td>
								</tr>';
					}
				}
			}
		}
		$table.='</table>';
		$pdf->writeHTMLCell(0,0,'','',$table,0,1,0,true,'C',true);
		$count.="<span>รวมยอดเงิน ".number_format($sum,2)." บาท"."</span><br><span>วันที่ออกรายงาน ".$this->DateThai(date('Y-m-d'))."</span>";
		$pdf->writeHTMLCell(0,0,'','',$count,0,1,0,true,'R',true);
		ob_clean();
		$pdf->Output('example_001.pdf', 'I');
		ob_end_clean();
	}
	public function cal_edu_level_auto(){
		//if(วันเปิดเรียน){		
			foreach ($this->User_model->get_all_member_with_no_edu_6()->result() as $row) {	
				$year=0;
				$cal_year=0;
				if($row->edu_id != '6'){
					$year = intval(date("Y")) - intval($row->member_yofadmis);
					if($year != 0){
						//echo "<br>".$row->member_name."<br>ปีที่เข้าศึกษา:".$row->member_yofadmis." ปีปัจจุบัน:".date("Y")." ม.".$row->edu_id." year_diff ".$year."<br>";
						$cal_year = 1 + $year;
						//echo "Year before cal:".$cal_year."<br>";
						if($cal_year > 6){
							$cal_year = 6;
							//echo "Year after cal:".$cal_year."<br>";
						}
						//echo "ปัจจุบันเรียนชั้น ม.".$cal_year."<br>";
					}
					$data=array(
						'edu_id'=>$cal_year
					);
					$this->User_model->update_edu_level("member",$row->member_id,$data);

				}

			}
			//echo"<br><br><br><br><br><br><br>พนักงาน<br><br><br>";
			foreach ($this->User_model->get_all_staff_with_no_edu_6()->result() as $row) {	
				$year=0;
				$cal_year=0;
				if($row->edu_id != '6'){
					$year = intval(date("Y")) - intval($row->staff_yofadmis);
					if($year != 0){
						//echo "<br>".$row->staff_name."<br>ปีที่เข้าศึกษา:".$row->staff_yofadmis." ปีปัจจุบัน:".date("Y")." ม.".$row->edu_id." year_diff ".$year."<br>";
						$cal_year = 1 + $year;
						//echo "Year before cal:".$cal_year."<br>";
						if($cal_year > 6){
							$cal_year = 6;
							//echo "Year after cal:".$cal_year."<br>";
						}
						//echo "ปัจจุบันเรียนชั้น ม.".$cal_year."<br>";
					}
					$data=array(
						'edu_id'=>$cal_year
					);
					$this->User_model->update_edu_level("staff",$row->staff_id,$data);

				}

			}
		//}	
	}
}
