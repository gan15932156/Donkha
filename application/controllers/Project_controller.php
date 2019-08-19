<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Project_controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->database();
		$this->load->model('User_model');
		$this->load->library('pagination');
		$this->load->library('Pdf');
    }

	////////////////////////////////////////////////////////////
	//////////////////////  PAGE    //////////////////////////

 	public function index_admin(){
		$this->load->view('index_admin');
  }
  public function index_manager(){
		$this->load->view('index_manager');
  }
    public function index_staff(){
    	$data['not_confirm_dep'] = $this->User_model->count_not_confirm_record_dep();
    	$data['not_confirm_wd'] = $this->User_model->count_not_confirm_record_wd();
    	$this->load->view('index_staff',$data);
    }
    public function manage_staff(){
    	$config['base_url'] = site_url('Project_controller/manage_staff');
        $config['total_rows'] = $this->User_model->record_count_staff();
        $config['per_page'] = "6";
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['staff'] = $this->User_model->select_staff_between($config["per_page"], $data['page']);
        $data['pagination'] = $this->pagination->create_links();
		$this->load->view('manage_staff',$data);
	}
	public function staff_detail(){
		$staff_id=$this->uri->segment(3);
		$data['staff']=$this->User_model->get_everything_staff($staff_id);
		$this->load->view('staff_detail',$data);
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
		$this->load->view('member_detail',$data);
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
		$this->load->view('member_detail_staff',$data);
	}
	public function manage_member(){
		$config['base_url'] = site_url('Project_controller/manage_member');
        $config['total_rows'] = $this->User_model->record_count_member();
        $config['per_page'] = "6";
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['member'] = $this->User_model->select_member_between($config["per_page"], $data['page']);
        $data['pagination'] = $this->pagination->create_links();
		$this->load->view('manage_member',$data);
	}
	public function manage_member_staff(){
		$config['base_url'] = site_url('Project_controller/manage_member_staff');
        $config['total_rows'] = $this->User_model->record_count_member();
        $config['per_page'] = "6";
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['member'] = $this->User_model->select_member_between($config["per_page"], $data['page']);
        $data['pagination'] = $this->pagination->create_links();
		$this->load->view('manage_member_staff',$data);
	}
	public function manage_account(){
		$config['base_url'] = site_url('Project_controller/manage_account');
        $config['total_rows'] = $this->User_model->record_count_account();
        $config['per_page'] = "5";
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['account'] = $this->User_model->select_account_between($config["per_page"], $data['page']);
        $data['pagination'] = $this->pagination->create_links();
		$this->load->view('manage_account',$data);
	}
	public function noti_dep(){
		$data['unconfirm_deposit'] =  $this->User_model->select_unconfirm_deposit();
		$this->load->view('noti_dep',$data);
	}
	public function account_detail(){
		$account_id=$this->uri->segment(3);
		$data['account']=$this->User_model->select_account_with_parameter($account_id);
		$data['account_detail']=$this->User_model->select_account_detail_parameter_account_id($account_id);
		$this->load->view('account_details',$data);
	}
	public function noti_wd(){
		$data['unconfirm_withdraw'] =  $this->User_model->select_unconfirm_withdraw();
		$this->load->view('noti_wd',$data);
	}
	public function passbook_display(){
		$this->load->view('passbook_display');
	}
	public function test_report(){
		$data['unconfirm_withdraw'] =  $this->User_model->select_unconfirm_withdraw();
		$this->load->view('report_test',$data);
	}

	////////////////////////////////////////////////////////////
	//////////////////////  FORM    //////////////////////////

	public function index(){
		$this->cal_end_day();
		$this->cal_interest_auto();
		$this->load->view('index');
    }
    public function staff_insert_form(){
    	$data['province']=$this->User_model->getProvince();
    	$data['edu_level']=$this->User_model->getEdu_level();
    	$data['permiss']=$this->User_model->getPermission();
		$this->load->view('staff_insert_form',$data);
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
		$this->load->view('staff_update_form',$data);
	}
	public function member_insert_form(){
    	$data['province']=$this->User_model->getProvince();
    	$data['edu_level']=$this->User_model->getEdu_level();
    	$data['permiss']=$this->User_model->getPermission();
    	$data['job']=$this->User_model->getJob();
		$this->load->view('member_insert_form',$data);
	}
	public function member_insert_form_staff(){
    	$data['province']=$this->User_model->getProvince();
    	$data['edu_level']=$this->User_model->getEdu_level();
    	$data['permiss']=$this->User_model->getPermission();
    	$data['job']=$this->User_model->getJob();
		$this->load->view('member_insert_form_staff',$data);
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
			$this->load->view('member_update_form',$data);
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
			$this->load->view('member_update_form',$data);
		}
	}
	public function account_insert_form(){
		$staff_id=$this->uri->segment(3);
		$data['staff_id']=$staff_id;
		$data['student']=$this->User_model->getMember_student();
		$data['person']=$this->User_model->getMember_person();
		$data['accode']=$this->User_model->auto_generate_account_code();
		$data['member']=$this->User_model->get_member_noparameter();
		$this->load->view('account_insert_form',$data);
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
			$this->load->view('member_update_form_staff',$data);
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
			$this->load->view('member_update_form_staff',$data);
		}
	}
	public function account_insert_form_continue_admin(){
		$member_id=$this->uri->segment(3);
		$data['member']=$this->User_model->get_member($member_id);
		$data['accode']=$this->User_model->auto_generate_account_code();
		$this->load->view('account_insert_form_continue_admin',$data);
	}
	public function account_insert_form_continue_staff(){
		$member_id=$this->uri->segment(3);
		$data['member']=$this->User_model->get_member($member_id);
		$data['accode']=$this->User_model->auto_generate_account_code();
		$this->load->view('account_insert_form_continue_staff',$data);
	}
	public function deposit_insert_form(){
		$this->load->view('deposit_insert_form');
	}
	public function withdraw_insert_form(){
		$this->load->view('withdraw_insert_form');
	}
	public function close_account(){
		$this->load->view('close_account_form');
	}
	public function account_update_form(){
		$account_id=$this->uri->segment(3);

	}

	////////////////////////////////////////////////////////////
	//////////////////////  INSERT    //////////////////////////

	public function staff_insert(){
		date_default_timezone_set('Asia/Bangkok');
		$stdid=$this->input->post("std_code");
		$title=$this->input->post("title");
		$name=$this->input->post("name");
		$idcard=$this->input->post("id_card");
		$edulevel=$this->input->post("edu_level");
		$address=$this->input->post("address");
		$pid=$this->input->post("PROVINCE_ID");
		$aip=$this->input->post("AMPHUR_ID");
		$did=$this->input->post("DISTRICT_CODE");
		$zip=$this->input->post("zipcode");
		$username=$this->input->post("username");
		$password=md5($this->input->post("password"));
		$regis_date = date('Y-m-d');
		$permiss=$this->input->post("permiss");
		$config['overwrite'] = TRUE;
		$config['upload_path'] = './picture/';
		$config['allowed_types'] = '*';
		$this->load->library('upload',$config);
		$this->upload->do_upload('pic');
		$up_file_name = $this->upload->data();
		$data_staff=array(
			'edu_id'=>$edulevel,
			'level_id'=>$permiss,
			'DISTRICT_CODE'=>$did,
			'stu_code'=>$stdid,
			'staff_title'=>$title,
			'staff_name'=>$name,
			'staff_id_card'=>$idcard,
			'staff_status'=>'1',
			'staff_address'=>$address,
			'staff_pic' => "http://127.0.0.1/Donkha/picture/".$up_file_name['file_name'],
			'staff_regis_date' =>$regis_date,
			'staff_close_date' =>'0'
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
		redirect(base_url()."Project_controller/manage_staff");
	}
	public function member_insert(){
		date_default_timezone_set('Asia/Bangkok');
		$level_id=$this->input->post("permiss");
		$dist_code=$this->input->post("DISTRICT_CODE");
		$id_card=$this->input->post("id_card");
		$name=$this->input->post("name");
		$b_date=$this->input->post("b_date");
		$address=$this->input->post("address");
		$phone=$this->input->post("phone_number");
		$title=$this->input->post("title");
		$stdid=$this->input->post("std_code");
		$username=$this->input->post("username");
		$password=md5($this->input->post("password"));
		$regis_date = date('Y-m-d');
		$config['upload_path'] = './picture/';
		$config['allowed_types'] = '*';
		$config['overwrite'] = TRUE;
		$this->load->library('upload',$config);
		$this->upload->do_upload('pic_member');
		$pic_member = $this->upload->data();
		$this->upload->do_upload('pic_singna');
		$pic_singna = $this->upload->data();
		if($stdid == '0'){
			 //บุคลากร
			$job=$this->input->post("job");
			$data_member=array(
				'level_id'=>$level_id,
				'DISTRICT_CODE'=>$dist_code,
				'job_id'=>$job,
				'edu_id'=>'0',
				'std_code'=>'0',
				'member_id_card'=>$id_card,
				'member_name'=>$name,
				'member_birth_date'=>$b_date,
				'address'=>$address,
				'phone_number'=>$phone,
				'member_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_member['file_name'],
				'member_signa_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_singna['file_name'],
				'member_regis_date'=>$regis_date,
				'member_title'=>$title,
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
		else{
			$edu_id=$this->input->post("edu_level");
			$std_code=$this->input->post("std_code");    //นร
			$data_member=array(
				'level_id'=>$level_id,
				'DISTRICT_CODE'=>$dist_code,
				'job_id'=>'2',
				'edu_id'=>$edu_id,
				'std_code'=>$std_code,
				'member_id_card'=>$id_card,
				'member_name'=>$name,
				'member_birth_date'=>$b_date,
				'address'=>$address,
				'phone_number'=>$phone,
				'member_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_member['file_name'],
				'member_signa_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_singna['file_name'],
				'member_regis_date'=>$regis_date,'member_title'=>$title,
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
	}
	public function member_insert_staff(){
		date_default_timezone_set('Asia/Bangkok');
		$level_id=$this->input->post("permiss");
		$dist_code=$this->input->post("DISTRICT_CODE");
		$id_card=$this->input->post("id_card");
		$name=$this->input->post("name");
		$b_date=$this->input->post("b_date");
		$address=$this->input->post("address");
		$phone=$this->input->post("phone_number");
		$title=$this->input->post("title");
		$stdid=$this->input->post("std_code");
		$username=$this->input->post("username");
		$password=md5($this->input->post("password"));
		$regis_date = date('Y-m-d');
		$config['upload_path'] = './picture/';
		$config['allowed_types'] = '*';
		$config['overwrite'] = TRUE;
		$this->load->library('upload',$config);
		$this->upload->do_upload('pic_member');
		$pic_member = $this->upload->data();
		$this->upload->do_upload('pic_singna');
		$pic_singna = $this->upload->data();
		if($stdid == '0'){
			 //บุคลากร
			$job=$this->input->post("job");
			$data_member=array(
				'level_id'=>$level_id,
				'DISTRICT_CODE'=>$dist_code,
				'job_id'=>$job,'edu_id'=>'0',
				'std_code'=>'0',
				'member_id_card'=>$id_card,
				'member_name'=>$name,
				'member_birth_date'=>$b_date,
				'address'=>$address,
				'phone_number'=>$phone,
				'member_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_member['file_name'],
				'member_signa_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_singna['file_name'],
				'member_regis_date'=>$regis_date,
				'member_title'=>$title,
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
			$url2 = base_url('Project_controller/manage_member/');
			echo '
            	<script type="text/javascript">
            		var confirn =  confirm("ต้องการเปิดบัญชีหรือไม่");
            		if(confirn == true){ window.open("'.$url1.'", "_self");}
            		else{ window.open("'.$url2.'", "_self"); }
            	</script>
            	';
		}
		else{
			$edu_id=$this->input->post("edu_level");
			$std_code=$this->input->post("std_code");    //นร
			$data_member=array(
				'level_id'=>$level_id,
				'DISTRICT_CODE'=>$dist_code,
				'job_id'=>'2',
				'edu_id'=>$edu_id,
				'std_code'=>$std_code,
				'member_id_card'=>$id_card,
				'member_name'=>$name,
				'member_birth_date'=>$b_date,
				'address'=>$address,
				'phone_number'=>$phone,
				'member_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_member['file_name'],
				'member_signa_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_singna['file_name'],
				'member_regis_date'=>$regis_date,
				'member_title'=>$title,
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
				'password'=>$password);
			$this->User_model->insert_user($data_user);
			$url1 = base_url('Project_controller/account_insert_form_continue_staff/').$member_id;
			$url2 = base_url('Project_controller/manage_member/');
			echo '
            	<script type="text/javascript">
            		var confirn =  confirm("ต้องการเปิดบัญชีหรือไม่");
            		if(confirn == true){ window.open("'.$url1.'", "_self");}
            		else{ window.open("'.$url2.'", "_self"); }
            	</script>
            	';
		}
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
		redirect(base_url()."Project_controller/index_admin");
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
			'action'=>'deposit',
			'record_date'=>$this->input->post("date"),
			'record_time'=>$now_time,
			'account_detail_balance'=>$this->input->post("money"),
			'trans_money'=>$this->input->post("money"),
			'account_detail_confirm'=>'0',
		);
		$this->User_model->insert_account_details($data_account_detail);
		redirect(base_url()."Project_controller/noti_dep");
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
		redirect(base_url()."Project_controller/noti_dep");
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
		redirect(base_url()."Project_controller/noti_wd");
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
		$stdid=$this->input->post("std_code");
		$title=$this->input->post("title");
		$name=$this->input->post("name");
		$idcard=$this->input->post("id_card");
		$edulevel=$this->input->post("edu_level");
		$address=$this->input->post("address");
		$pid=$this->input->post("PROVINCE_ID");
		$aip=$this->input->post("AMPHUR_ID");
		$did=$this->input->post("DISTRICT_CODE");
		$zip=$this->input->post("zipcode");
		$permiss=$this->input->post("permiss");
		$config['upload_path'] = './picture/';
		$config['allowed_types'] = '*';
		$config['overwrite'] = TRUE;
		$this->load->library('upload',$config);
		if($this->upload->do_upload('pic')){
			$up_file_name = $this->upload->data();
			$data_staff=array(
				'edu_id'=>$edulevel,
				'level_id'=>$permiss,
				'DISTRICT_CODE'=>$did,
				'stu_code'=>$stdid,
				'staff_title'=>$title,
				'staff_name'=>$name,
				'staff_id_card'=>$idcard,
				'staff_status'=>'1',
				'staff_address'=>$address,
				'staff_pic' => "http://127.0.0.1/Donkha/picture/".$up_file_name['file_name']
			);
		}
		else{
			$data_staff=array(
				'edu_id'=>$edulevel,
				'level_id'=>$permiss,
				'DISTRICT_CODE'=>$did,
				'stu_code'=>$stdid,
				'staff_title'=>$title,
				'staff_name'=>$name,
				'staff_id_card'=>$idcard,
				'staff_status'=>'1',
				'staff_address'=>$address
			);
		}
		$this->User_model->update_staff($data_staff,$staff_id);
		redirect(base_url()."Project_controller/manage_staff");
	}
	public function member_update(){
		$member_id=$this->input->post("member_id");
		$level_id=$this->input->post("permiss");
		$dist_code=$this->input->post("DISTRICT_CODE");
		$id_card=$this->input->post("id_card");
		$name=$this->input->post("name");
		$b_date=$this->input->post("b_date");
		$address=$this->input->post("address");
		$phone=$this->input->post("phone_number");
		$title=$this->input->post("title");
		$stdid=$this->input->post("std_code");
		$config['upload_path'] = './picture/';
		$config['overwrite'] = TRUE;
		$config['allowed_types'] = '*';
		$this->load->library('upload',$config);
		if($stdid == 'ไม่มี'){
			$job=$this->input->post("job");
			if($this->upload->do_upload('pic_member') == null &&  $this->upload->do_upload('pic_singna') == null)
			{
				$data_member=array(
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id'=>$job,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_title'=>$title
				);
			}
			elseif ($this->upload->do_upload('pic_member') && $this->upload->do_upload('pic_singna') == null) {
				$up_file_name = $this->upload->data();
				$data_member=array(
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id'=>$job,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_pic'=>"http://127.0.0.1/Donkha/picture/".$up_file_name['file_name'],
					'member_title'=>$title
				);
			}
			elseif ($this->upload->do_upload('pic_singna') && $this->upload->do_upload('pic_member') == null) {
				$up_file_name = $this->upload->data();
				$data_member=array(
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id'=>$job,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_signa_pic'=>"http://127.0.0.1/Donkha/picture/".$up_file_name['file_name'],
					'member_title'=>$title
				);
			}
			else{
				$this->upload->do_upload('pic_member');
				$pic_member = $this->upload->data();
				$this->upload->do_upload('pic_singna');
				$pic_singna =$this->upload->data();
				$data_member=array(
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id'=>$job,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_member['file_name'],
					'member_signa_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_singna['file_name'],
					'member_title'=>$title
				);
			}
		}
		else{
			$edu_id=$this->input->post("edu_level");
			if($this->upload->do_upload('pic_member') == null && $this->upload->do_upload('pic_singna') == null)
			{
				$data_member=array(
					'std_code'=>$stdid,
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id' => '2',
					'edu_id'=>$edu_id,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_title'=>$title
				);
			}
			elseif ($this->upload->do_upload('pic_member') && $this->upload->do_upload('pic_singna') == null) {
				$up_file_name = $this->upload->data();
				$data_member=array(
					'std_code'=>$stdid,
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id' => '2',
					'edu_id'=>$edu_id,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_pic'=>"http://127.0.0.1/Donkha/picture/".$up_file_name['file_name'],
					'member_title'=>$title
				);
			}
			elseif ($this->upload->do_upload('pic_singna') && $this->upload->do_upload('pic_member') == null) {
				$up_file_name = $this->upload->data();
				$data_member=array(
					'std_code'=>$stdid,
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id' => '2',
					'edu_id'=>$edu_id,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_signa_pic'=>"http://127.0.0.1/Donkha/picture/".$up_file_name['file_name'],
					'member_title'=>$title
				);
			}
			else{
				$this->upload->do_upload('pic_member');
				$pic_member = $this->upload->data();
				$this->upload->do_upload('pic_singna');
				$pic_singna =$this->upload->data();
				$data_member=array(
					'std_code'=>$stdid,
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id' => '2','edu_id'=>$edu_id,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_member['file_name'],
					'member_signa_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_singna['file_name'],
					'member_title'=>$title
				);
			}
		}
		$this->User_model->update_member($data_member,$member_id);
		redirect(base_url()."Project_controller/manage_member");
	}
	public function member_update_staff(){
		$member_id=$this->input->post("member_id");
		$level_id=$this->input->post("permiss");
		$dist_code=$this->input->post("DISTRICT_CODE");
		$id_card=$this->input->post("id_card");
		$name=$this->input->post("name");
		$b_date=$this->input->post("b_date");
		$address=$this->input->post("address");
		$phone=$this->input->post("phone_number");
		$title=$this->input->post("title");
		$stdid=$this->input->post("std_code");
		$config['upload_path'] = './picture/';
		$config['allowed_types'] = '*';
		$config['overwrite'] = TRUE;
		$this->load->library('upload',$config);
		if($stdid == 'ไม่มี'){
			$job=$this->input->post("job");
			if($this->upload->do_upload('pic_member') == null &&  $this->upload->do_upload('pic_singna') == null)
			{
				$data_member=array(
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id'=>$job,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_title'=>$title
				);

			}
			elseif ($this->upload->do_upload('pic_member') && $this->upload->do_upload('pic_singna') == null) {
				$up_file_name = $this->upload->data();
				$data_member=array(
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id'=>$job,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_pic'=>"http://127.0.0.1/Donkha/picture/".$up_file_name['file_name'],
					'member_title'=>$title
				);
			}
			elseif ($this->upload->do_upload('pic_singna') && $this->upload->do_upload('pic_member') == null) {
				$up_file_name = $this->upload->data();
				$data_member=array(
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id'=>$job,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_signa_pic'=>"http://127.0.0.1/Donkha/picture/".$up_file_name['file_name'],
					'member_title'=>$title
				);
			}
			else{
				$this->upload->do_upload('pic_member');
				$pic_member = $this->upload->data();
				$this->upload->do_upload('pic_singna');
				$pic_singna =$this->upload->data();
				$data_member=array(
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id'=>$job,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_member['file_name'],
					'member_signa_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_singna['file_name'],
					'member_title'=>$title
				);
			}
		}
		else{
			$edu_id=$this->input->post("edu_level");
			if($this->upload->do_upload('pic_member') == null && $this->upload->do_upload('pic_singna') == null)
			{
				$data_member=array(
					'std_code'=>$stdid,
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id' => '2',
					'edu_id'=>$edu_id,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_title'=>$title
				);
			}
			elseif ($this->upload->do_upload('pic_member') && $this->upload->do_upload('pic_singna') == null) {
				$up_file_name = $this->upload->data();
				$data_member=array(
					'std_code'=>$stdid,
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id' => '2',
					'edu_id'=>$edu_id,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_pic'=>"http://127.0.0.1/Donkha/picture/".$up_file_name['file_name'],
					'member_title'=>$title
				);
			}
			elseif ($this->upload->do_upload('pic_singna') && $this->upload->do_upload('pic_member') == null) {
				$up_file_name = $this->upload->data();
				$data_member=array(
					'std_code'=>$stdid,
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id' => '2',
					'edu_id'=>$edu_id,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_signa_pic'=>"http://127.0.0.1/Donkha/picture/".$up_file_name['file_name'],
					'member_title'=>$title
				);
			}
			else{
				$this->upload->do_upload('pic_member');
				$pic_member = $this->upload->data();
				$this->upload->do_upload('pic_singna');
				$pic_singna =$this->upload->data();
				$data_member=array(
					'std_code'=>$stdid,
					'level_id'=>$level_id,
					'DISTRICT_CODE'=>$dist_code,
					'job_id' => '2',
					'edu_id'=>$edu_id,
					'member_id_card'=>$id_card,
					'member_name'=>$name,
					'member_birth_date'=>$b_date,
					'address'=>$address,
					'phone_number'=>$phone,
					'member_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_member['file_name'],
					'member_signa_pic'=>"http://127.0.0.1/Donkha/picture/".$pic_singna['file_name'],
					'member_title'=>$title
				);
			}
		}
		$this->User_model->update_member($data_member,$member_id);
		redirect(base_url()."Project_controller/manage_member_staff");
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
	public function search_data_staff(){
		$output='';
		$keyword='';
		if($this->input->post('data')){
			$keyword=$this->input->post('data');
		}
		$data['result'] = $this->User_model->select_search_staff_data($keyword);
		$output.='
			<table class="table table-striped table-hover table-sm ">
                <thead class="thead-light table-bordered">
                    <tr>
                        <th width="5%" scope="col">ลำดับ</th>
                        <th width="15%" scope="col">รหัสนักเรียน</th>
                        <th width="25%" scope="col">ชื่อ-นามสกุล</th>
                        <th width="15%" scope="col">ตำแหน่ง</th>
                        <th width="20%" scope="col">สถานะ</th>
                        <th width="15%" scope="col">การกระทำ</th>
                    </tr>
                </thead>
                <tbody class="table-bordered" style="background-color: #EFFEFD">
		';
		if($data['result']->num_rows() >0){
			$i=1;
			$result=$data['result']->result();
			foreach ($result as $row) {
				if($row->staff_status =='1'){
                    $status="<p class='text-success'>เปิดใช้งาน</p>";
                }
                else{
                    $status="<p class='text-danger'>ปิดใช้งาน</p>";
                }

                if($row->level_id == '1'){
                	$level = "สมาชิก";
                }
                elseif ($row->level_id == '2') {
                	$level = "พนักงาน";
                }
                elseif ($row->level_id == '3') {
                	$level = "ผู้จัดการ";
                }
                else{ // 4
                	$level = "ผู้ดูแลระบบ";
                }

				$output.='
					<tr>
						<th scope="row">'.$i.'</th>
                        <td>'.$row->stu_code.'</td>
                        <td>'.$row->staff_name.'</td>
                        <td>'.$level.'</td>
                        <td>'.$status.'</td>
                        <td>
                        <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle btn-sm" type="button" data-toggle="dropdown"><i class="fa fa-cog" aria-hidden="true"></i></button>
                        <ul style="background-color:#E8ECEF;"  class="dropdown-menu">
                          <li><a style="color:black;" href="'.base_url("Project_controller/staff_detail/".$row->staff_id).'" ><i class="fa fa-address-book" aria-hidden="true"></i> ดูรายละเอียด</a></li>
                          <li><a style="color:black;" href="'.base_url("Project_controller/staff_update_form/".$row->staff_id).'" ><i class="fa fa-pencil" aria-hidden="true"></i> แก้ไขข้อมูล</a></li>
                          <li><a style="color:black;" onclick="return confirm("ต้องการเปลี่ยนสถานะการใช้งานหรือไม่");" href="'.base_url('Project_controller/staff_change_status/'.$row->staff_id).'" ><i class="fa fa-times" aria-hidden="true"></i> เปลี่ยนสถานะ</a></li>
                        </ul>
                      </div>
                        </td>
                    </tr>';
                $i++;
			}
		}
		else{
			$output.='
				<tr>
            		<th scope="col" colspan="7">ไม่พบข้อมูลที่ค้นหา</th>
                </tr>';
		}
		$output.='
			</tbody>
            	<tfoot>
                </tfoot>
            </table>';
		echo $output;
	}
	public function search_data_member(){
		$output='';
		$keyword='';
		if($this->input->post('data')){
			$keyword=$this->input->post('data');
		}
		$data['result'] = $this->User_model->select_search_member_data($keyword);
		$output.='
			<table class="table table-striped table-hover table-sm" id="search_table">
                <thead class="thead-light table-bordered">
                    <tr>
		                <th width="5%" scope="col">ลำดับ</th>
		                <th width="30%" scope="col">ชื่อ-นามสกุล</th>
		                <th width="30%" scope="col">สถานะ</th>
		                <th width="10%" scope="col">การกระทำ</th>
                    </tr>
                </thead>
            	<tbody class="table-bordered" style="background-color: #EFFEFD">
		';
		if($data['result']->num_rows() >0){
			$i=1;
			$result=$data['result']->result();
			foreach ($result as $row) {
				if($row->member_status =='1'){
                    $status="<p class='text-success'>เปิดใช้งาน</p>";
                }
                else{
                    $status="<p class='text-danger'>ปิดใช้งาน</p>";
                }

                if($row->level_id == '1'){
                	$level = "สมาชิก";
                }
                elseif ($row->level_id == '2') {
                	$level = "พนักงาน";
                }
                elseif ($row->level_id == '3') {
                	$level = "ผู้จัดการ";
                }
                else{ // 4
                	$level = "ผู้ดูแลระบบ";
                }
				$output.='
					<tr>
						<th scope="row">'.$i.'</th>
                        <td>'.$row->member_name.'</td>
                        <td>'.$status.'</td>
                        <td>
                        	<div class="dropdown">
                        <button class="btn btn-default dropdown-toggle btn-sm" type="button" data-toggle="dropdown"><i class="fa fa-cog" aria-hidden="true"></i></button>
                        <ul style="background-color:#E8ECEF;"  class="dropdown-menu">
                          <li><a style="color:black;" href="'.base_url("Project_controller/member_detail/".$row->member_id).'" ><i class="fa fa-address-book" aria-hidden="true"></i> ดูรายละเอียด</a></li>
                          <li><a style="color:black;" href="'.base_url("Project_controller/member_update_form/".$row->member_id).'" ><i class="fa fa-pencil" aria-hidden="true"></i> แก้ไขข้อมูล</a></li>
                          <li><a style="color:black;" onclick="return confirm("ต้องการเปลี่ยนสถานะการใช้งานหรือไม่");" href="'.base_url('Project_controller/member_change_status/'.$row->member_id).'" ><i class="fa fa-times" aria-hidden="true"></i> เปลี่ยนสถานะ</a></li>
                        </ul>
                      </div>
                        </td>
                    </tr>';
                $i++;
			}
		}
		else{
			$output.='
				<tr>
                    <th scope="col" colspan="7">ไม่พบข้อมูลที่ค้นหา</th>
                </tr>';
		}
		$output.='
			</tbody>
                <tfoot>
                </tfoot>
            </table>';
		echo $output;
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
	public function search_data_account(){
		$output='';
		$keyword='';
		if($this->input->post('data')){
			$keyword=$this->input->post('data');
		}
		$data['result'] = $this->User_model->select_search_account_data($keyword);
		$output.='
			<table class="table table-striped table-hover table-sm" id="search_table">
                <thead class="thead-light table-bordered">
                    <tr>
                          <th width="5%" scope="col">ลำดับ</th>
                          <th width="25%" scope="col">หมายเลขบัญชี</th>
                          <th width="30%" scope="col">ชื่อบัญชี</th>
                          <th width="30%" scope="col">สถานะ</th>
                          <th width="10%" scope="col">การกระทำ</th>
                    </tr>
                </thead>
                <tbody class="table-bordered" style="background-color: #EFFEFD">
		';
		if($data['result']->num_rows() >0){
			$i=1;
			$result=$data['result']->result();
			foreach ($result as $row) {
				if($row->account_status =='1'){
                    $status="<p class='text-success'>เปิดใช้งาน</p>";
                }
                else{
                    $status="<p class='text-danger'>ปิดใช้งาน</p>";
                }
				$output.='
					<tr>
                        <th scope="row">'.$i.'</th>
                        <td>'.$row->account_id.'</td>
                        <td>'.$row->account_name.'</td>
                        <td>'.$status.'</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle btn-sm" type="button" data-toggle="dropdown"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <ul style="background-color:#E8ECEF;"  class="dropdown-menu">
                                  <li><a style="color:black;" href="'.base_url("Project_controller/account_detail/".$row->account_id).'" ><i class="fa fa-address-book" aria-hidden="true"></i> ดูรายละเอียด</a></li>
                                  <li><a style="color:black;" href="'.base_url("Project_controller/member_update_form_staff/".$row->member_id).'" ><i class="fa fa-pencil" aria-hidden="true"></i> แก้ไขข้อมูล</a></li>
                                </ul>
                              </div>
                        </td>
                    </tr>';
                $i++;
			}
		}
		else{
			$output.='
				<tr>
                	<th scope="col" colspan="7">ไม่พบข้อมูลที่ค้นหา</th>
                </tr>';
		}
		$output.='
		    </tbody>
                <tfoot>
                </tfoot>
            </table>';
		echo $output;
	}
	public function search_data_member_staff(){
		$output='';
		$keyword='';
		if($this->input->post('data')){
			$keyword=$this->input->post('data');
		}
		$data['result'] = $this->User_model->select_search_member_staff_data($keyword);
		$output.='
			<table class="table table-striped table-hover table-sm" id="search_table">
                <thead class="thead-light table-bordered">
                    <tr>
                        <th width="5%" scope="col">ลำดับ</th>
                		<th width="30%" scope="col">ชื่อ-นามสกุล</th>
                		<th width="30%" scope="col">สถานะ</th>
                		<th width="10%" scope="col">การกระทำ</th>
                    </tr>
                </thead>
                <tbody class="table-bordered" style="background-color: #EFFEFD">
		';
		if($data['result']->num_rows() >0){
			$i=1;
			$result=$data['result']->result();
			foreach ($result as $row) {
				if($row->member_status =='1'){
                    $status="<p class='text-success'>เปิดใช้งาน</p>";
                }
                else{
                    $status="<p class='text-danger'>ปิดใช้งาน</p>";
                }

                if($row->level_id == '1'){
                	$level = "สมาชิก";
                }
                elseif ($row->level_id == '2') {
                	$level = "พนักงาน";
                }
                elseif ($row->level_id == '3') {
                	$level = "ผู้จัดการ";
                }
                else{ // 4
                	$level = "ผู้ดูแลระบบ";
                }
				$output.='
					<tr>
						<th scope="row">'.$i.'</th>
                        <td>'.$row->member_name.'</td>
                        <td>'.$status.'</td>
                        <td>
                        	<div class="dropdown">
                        		<button class="btn btn-default dropdown-toggle btn-sm" type="button" data-toggle="dropdown"><i class="fa fa-cog" aria-hidden="true"></i></button>
                        		<ul style="background-color:#E8ECEF;"  class="dropdown-menu">
                          			<li><a style="color:black;" href="'.base_url("Project_controller/member_detail_staff/".$row->member_id).'" ><i class="fa fa-address-book" aria-hidden="true"></i> ดูรายละเอียด</a></li>
                          			<li><a style="color:black;" href="'.base_url("Project_controller/member_update_form_staff/".$row->member_id).'" ><i class="fa fa-pencil" aria-hidden="true"></i> แก้ไขข้อมูล</a></li>
                          			<li><a style="color:black;" onclick="return confirm("ต้องการเปลี่ยนสถานะการใช้งานหรือไม่");" href="'.base_url('Project_controller/member_change_status_staff/'.$row->member_id).'" ><i class="fa fa-times" aria-hidden="true"></i> เปลี่ยนสถานะ</a></li>
                        		</ul>
                      		</div>
                        </td>
                    </tr>';
                $i++;
			}
		}
		else{
			$output.='
				<tr>
                    <th scope="col" colspan="7">ไม่พบข้อมูลที่ค้นหา</th>
                </tr>';
		}
		$output.='
			</tbody>
                <tfoot>
                </tfoot>
            </table>';
		echo $output;
	}
	public function filter_transaction_table(){
		function DateThai($strDate)
	    {
	        $strYear = date("Y",strtotime($strDate))+543;
	        $strMonth= date("n",strtotime($strDate));
	        $strDay= date("j",strtotime($strDate));
	        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	        $strMonthThai=$strMonthCut[$strMonth];
	        return "$strDay $strMonthThai $strYear";
	    }
	    date_default_timezone_set('Asia/Bangkok');
		$output='';
		$data['result'] = $this->User_model->select_filter_transaction($this->input->post('accoint_id'),$this->input->post('filter'));
		if($this->input->post('filter') == "deposit"){
			$output.='
				<table class="table table-striped table-hover table-sm">
	                <thead class="thead-light table-bordered">
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
		                        <th scope="row">'.$i.'</th>
		                        <td>'.DateThai($row->record_date)." ".$row->record_time.'</td>
		                        <td><span class="text-success">ฝาก</span></td>
		                        <td align="right"><span class="text-success">+'.number_format($row->trans_money,2).'</span></td>
		                        <td align="right">'.number_format($row->account_detail_balance,2).'</td>
		                        <td>'.$row->staff_title."".$row->staff_name.'</td>
		                    </tr>';
		                $i++;
					}
				}
				else{
					$output.='
						<tr>
		                	<th scope="col" colspan="7">ไม่พบข้อมูลที่ค้นหา</th>
		                </tr>';
				}
		}
		elseif($this->input->post('filter') == "withdraw"){
			$output.='
			<table class="table table-striped table-hover table-sm">
	            <thead class="thead-light table-bordered">
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
							<th scope="row">'.$i.'</th>
		                    <td>'.DateThai($row->record_date)." ".$row->record_time.'</td>
		                    <td><span class="text-danger">ถอน</span></td>
		                    <td align="right"><span class="text-danger">-'.number_format($row->trans_money,2).'</span></td>
		                    <td align="right">'.number_format($row->account_detail_balance,2).'</td>
		                    <td>'.$row->staff_title."".$row->staff_name.'</td>
		                </tr>';
		            $i++;
				}
			}
			else{
				$output.='
					<tr>
		            	<th scope="col" colspan="7">ไม่พบข้อมูลที่ค้นหา</th>
		            </tr>';
			}
		}
		elseif($this->input->post('filter') == "tranfer"){
			$output.='
			<table class="table table-striped table-hover table-sm">
	            <thead class="thead-light table-bordered">
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
							<th scope="row">'.$i.'</th>
		                    <td>'.DateThai($row->record_date)." ".$row->record_time.'</td>
		                    <td><span class="text-danger">โอน</span></td>
		                    <td align="right"><span class="text-danger">-'.number_format($row->trans_money,2).'</span></td>
		                    <td align="right">'.number_format($row->account_detail_balance,2).'</td>
		                    <td>'.$row->staff_title."".$row->staff_name.'</td>
		                </tr>';
		            $i++;
				}
			}
			else{
				$output.='
					<tr>
		            	<th scope="col" colspan="7">ไม่พบข้อมูลที่ค้นหา</th>
		            </tr>';
			}
		}
		else{
			$output.='
			<table class="table table-striped table-hover table-sm">
	            <thead class="thead-light table-bordered">
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
					else{
						$action = '<span class="text-danger">โอน</span>';
						$money = '<span class="text-danger">-'.number_format($row->trans_money,2).'</span>';
					}
					$output.='
						<tr>
		                    <th scope="row">'.$i.'</th>
		                    <td>'.DateThai($row->record_date)." ".$row->record_time.'</td>
		                    <td>'.$action.'</td>
		                    <td align="right">'.$money.'</td>
		                    <td align="right">'.number_format($row->account_detail_balance,2).'</td>
		                    <td>'.$row->staff_title."".$row->staff_name.'</td>
		                </tr>';
		            $i++;
				}
			}
			else{
				$output.='
					<tr>
		            	<th scope="col" colspan="7">ไม่พบข้อมูลที่ค้นหา</th>
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
		function DateThai($strDate)
	    {
	        $strYear = date("Y",strtotime($strDate))+543;
	        $strMonth= date("n",strtotime($strDate));
	        $strDay= date("j",strtotime($strDate));
	        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	        $strMonthThai=$strMonthCut[$strMonth];
	        return "$strDay $strMonthThai $strYear";
	    }
	    date_default_timezone_set('Asia/Bangkok');
		$output='';
		$data['result'] = $this->User_model->select_account_detail_with_account_id_not_print($this->input->post('account_id'));
		$output.='
			<a href="'.base_url("index.php/Project_controller/check_next_passbook_page_account_id")."/".$this->input->post('account_id').'" class="btn btn-warning">พิมพ์</a> <br><br>
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
                        <td width="30%">'.DateThai($row->record_date)." ".$row->record_time.'</td>
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
		function DateThai($strDate)
	    {
	        $strYear = date("Y",strtotime($strDate))+543;
	        $strMonth= date("n",strtotime($strDate));
	        $strDay= date("j",strtotime($strDate));
	        $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	        $strMonthThai=$strMonthCut[$strMonth];
	        return "$strDay $strMonthThai $strYear";
	    }
	    date_default_timezone_set('Asia/Bangkok');
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
                        <td width="30%">'.DateThai($row->record_date)." ".$row->record_time.'</td>
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
            foreach ($result as $row)
                $arr_result[] = $row->account_id." ".$row->account_name;
                echo json_encode($arr_result);
            }
        }
	}

	////////////////////////////////////////////////////////////
	//////////////////////  FUNCTION    //////////////////////////

	public function login_check(){
		$user=$this->input->post("username");
		$pass=md5($this->input->post("password"));
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
	public function thaidate(){
		function DateThai($strDate)
		{
			date_default_timezone_set('Asia/Bangkok');
			$regis_date = date('Y-m-d');
			$strYear = date("Y",strtotime($regis_date))+543;
			$strMonth= date("n",strtotime($regis_date));
			$strDay= date("j",strtotime($regis_date));
			$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
			$strMonthThai=$strMonthCut[$strMonth];
			return "$strDay $strMonthThai $strYear";
		}
	}
	public function test_PDF(){
		// สร้าง object สำหรับใช้สร้าง pdf
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // กำหนดรายละเอียดของ pdf
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 001');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // กำหนดข้อมูลที่จะแสดงในส่วนของ header และ footer
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

        // กำหนดรูปแบบของฟอนท์และขนาดฟอนท์ที่ใช้ใน header และ footer
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // กำหนดค่าเริ่มต้นของฟอนท์แบบ monospaced
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // กำหนด margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // กำหนดการแบ่งหน้าอัตโนมัติ
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // กำหนดรูปแบบการปรับขนาดของรูปภาพ
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // กำหนดฟอนท์
        // ฟอนท์ freeserif รองรับภาษาไทย
        $pdf->SetFont('freeserif', '', 14, '', true);

        // เพิ่มหน้า pdf
        // การกำหนดในส่วนนี้ สามารถปรับรูปแบบต่างๆ ได้ ดูวิธีใช้งานที่คู่มือของ tcpdf เพิ่มเติม
        $pdf->AddPage();

        // กำหนดเงาของข้อความ
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// กำหนดเนื้อหาข้อมูลที่จะสร้าง pdf ในที่นี้เราจะกำหนดเป็นแบบ html โปรดระวัง EOD; โค้ดสุดท้ายต้องชิดซ้ายไม่เว้นวรรค
    $html = <<<EOD
<h1>ทดสอบข้อความภาษาไทย Welcome to <a href="http://www.tcpdf.org"
style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;
<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
<i>This is the first example of TCPDF library. ทดสอบข้อความภาษาไทย</i>
<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use:
<i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
<p>Please check the source code documentation and other examples for further information.</p>
<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE
<a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION
ทดสอบข้อความภาษาไทย!</a></p>
<span style="font-size:12px;">ทดสอบข้อความภาษาไทย มีสระ วรรณยุกต์</span>
EOD;

    // สร้างข้อเนื้อหา pdf ด้วยคำสั่ง writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

    // จบการทำงานและแสดงไฟล์ pdf
    // การกำหนดในส่วนนี้ สามารถปรับรูปแบบต่างๆ ได้ เช่นให้บันทึกเป้นไฟล์ หรือให้แสดง pdf เลย ดูวิธีใช้งานที่คู่มือของ tcpdf เพิ่มเติม
    $pdf->Output('example_001.pdf', 'I');
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
				<td align="right" style="height:16px;width:121px;border-spacing: 0">'.
				number_format($row->account_detail_balance,2).'</td>
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
		#-----------------------ดอกเบี้ย---------------------#
		$result_int = 0.0; # ผลคำนวณดอกเบี้ยแต่ละครั้ง
		$result_all_int = 0.0; # ผลรวมการคำนวณดอกเบี้ยทั้งหมด
		static $interest_rate = 0.4; # อัตราดอกเบี้ย
		static $year = 365; # จำนวนวันของปี
		static $per_100 = 100; # ร้อยละ
		#--------------------------------------------------#
		foreach($this->User_model->select_account_with_parameter($this->input->post('account_id'))->result() as $row) {
				if($row->interest_update == substr($row->interest_update,0,4)."-04-01"){ # คำนวณ phase 1 แล้ว
					$this->cal_interest_close_account_between_date($this->input->post('account_id'),substr($row->interest_update,0,4)."-04-01",date('Y-m-d'),$this->input->post('staff_id'));
				}
				elseif($row->interest_update == substr($row->interest_update,0,4)."-10-01"){ # คำนวณ phase 2 แล้ว
					$this->cal_interest_close_account_between_date($this->input->post('account_id'),substr($row->interest_update,0,4)."-10-01",/*date('Y-m-d')*/ "2019-12-20",$this->input->post('staff_id'));
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
 			if($row->interest_update == "0000-00-00" && date('Y-m-d') == date('Y-04-01') && $row->account_open_date < date('Y-04-01')){
 				$this->cal_interest_phase1($row->account_id);
 			}
 			elseif($row->interest_update == "0000-00-00" && date('Y-m-d') == date('Y-10-01') && $row->account_open_date >= date('Y-04-01') && $row->account_open_date < date('Y-10-01')) {
 				$this->cal_interest_phase2($row->account_id);
 			}
 			elseif($row->interest_update == "0000-00-00" && date('Y-m-d') == date('Y-04-01') && $row->account_open_date > date('Y-10-01',strtotime('-1 year')) && $row->account_open_date < date('Y-04-01')) {
 				$this->cal_interest_phase1($row->account_id);
 			}
 			elseif($row->interest_update == date('Y-04-01') && date('Y-m-d') == date('Y-10-01')){
 				$this->cal_interest_phase2($row->account_id);
 			}
 			elseif($row->interest_update == substr($row->interest_update,0,4)."-10-01" && date('Y-m-d') == date('Y-04-01')){
 				$this->cal_interest_phase1($row->account_id);
 			}
 			elseif($row->interest_update == substr($row->interest_update,0,4)."-04-01" && date('Y-m-d') == date('Y-10-01')){
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
		if($data['account_detail'] == null){}
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
			}
			$data_account_detail=array(
				'trans_id'=>'0',
				'account_id'=>$account_id,
				'staff_record_id'=>'1',
				'action'=>'add_interest',
				'record_date'=>date('Y-m-d'),
				'record_time'=>date('H:i:s'),
				'account_detail_balance'=>round($total_balance,2),
				'trans_money'=>round($result_all_int,2),
				'account_detail_confirm'=>'1',
				'passbook_row_status'=>'1',
				'end_day'=>'0',
			);
			$data_interest_history=array(
				'account_id'=>$account_id,
				'interest_money'=>round($result_all_int,2),
				'interest_date'=>date('Y-m-d')
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
			$data_account_detail=array(
				'trans_id'=>'0',
				'account_id'=>$account_id,
				'staff_record_id'=>'1',
				'action'=>'add_interest',
				'record_date'=>date('Y-m-d'),
				'record_time'=>date('H:i:s'),
				'account_detail_balance'=>round($total_balance,2),
				'trans_money'=>round($result_all_int,2),
				'account_detail_confirm'=>'1',
				'passbook_row_status'=>'1',
				'end_day'=>'0',
			);
			$data_interest_history=array(
				'account_id'=>$account_id,
				'interest_money'=>round($result_all_int,2),
				'interest_date'=>date('Y-m-d')
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


}
