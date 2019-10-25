<div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12"><br>
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-4">
          <a href="<?php  echo base_url()."Project_controller/noti_dep/"; ?>" class="btn btn-success notification">แจ้งเตือนรายการฝาก<span class="badge "><?php echo $not_confirm_dep; ?></span></a>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-4">
          <a href="<?php  echo base_url()."Project_controller/noti_wd/"; ?>" class="btn btn-success notification">แจ้งเตือนรายการถอน<span class="badge"><?php echo $not_confirm_wd; ?></span></a>
        </div>
        <div class="col-md-1"></div>
      </div>    
      <!--<a href="<?php  echo base_url()."Project_controller/noti_tdf/"; ?>" class="btn btn-outline-success notification">แจ้งเตือนรายการโอน<span class="badge"><?php echo $not_confirm_tdf; ?></span></a>-->
    </div>
    <div class="col-md-12"><br>
      <div class="row">
        <div class="col-md-12">
          <div class="dropdown">
            <button class="btn btn-primary btn_index" style="border: 4px solid #CBCBCB;">
              <span style="font-size: 4em; color: #FFFFFF;">
                <i class="fa fa-university" aria-hidden="true"><h5 style="margin-top:3px;">บัญชี</h5></i>
              </span>
            </button>
            <div>
              <a href="<?php  echo base_url()."Project_controller/manage_account/"; ?>">ข้อมูลบัญชี</a>
              <a href="<?php  echo base_url('Project_controller/account_insert_form/'); ?>">เปิดบัญชี</a>
              <a href="<?php  echo base_url()."Project_controller/close_account/"; ?>">ปิดบัญชี</a>
            </div>
          </div>
          <div class="dropdown">
            <button class="btn btn-primary btn_index" style="border: 4px solid #CBCBCB;">
              <span style="font-size: 4em; color: #FFFFFF;">
                <i class="fa fa-user-o" aria-hidden="true"><h5 style="margin-top:3px;">สมาชิก</h5></i>
              </span>
            </button>
            <div>
              <a href="<?php  echo base_url()."Project_controller/manage_member_staff/"; ?>">ข้อมูลสมาชิก</a>
              <a href="<?php  echo base_url('Project_controller/member_insert_form_staff/'); ?>">เพิ่มสมาชิก</a>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <!--<a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/passbook_display/"; ?>">พิมพ์สมุดคู่ฝาก</a>-->
         <br><br> <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/deposit_insert_form/"; ?>">ฝากเงิน</a>
          <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/withdraw_insert_form/"; ?>">ถอนเงิน</a>
          <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/tranfer_money_insert_form/"; ?>">โอนเงิน</a>
          <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/today_statement_report/"; ?>">รายงานรายวัน</a>
        </div>
      </div>
    </div>
  </div>
</div>