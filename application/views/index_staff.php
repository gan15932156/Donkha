<div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12"><br>
      <a href="<?php  echo base_url()."Project_controller/noti_dep/"; ?>" class="btn btn-outline-success notification">แจ้งเตือนรายการฝาก<span class="badge "><?php echo $not_confirm_dep; ?></span></a>
      <a href="<?php  echo base_url()."Project_controller/noti_wd/"; ?>" class="btn btn-outline-success notification">แจ้งเตือนรายการถอน<span class="badge"><?php echo $not_confirm_wd; ?></span></a>
      <!--<a href="<?php  echo base_url()."Project_controller/noti_tdf/"; ?>" class="btn btn-outline-success notification">แจ้งเตือนรายการโอน<span class="badge"><?php echo $not_confirm_tdf; ?></span></a>-->
    </div>
    <div class="col-md-12"><br>
      <div class="row">
        <div class="col-md-12">
          <div class="dropdown">
            <button style="font-size:20px;" class="btn btn-primary">บัญชี</button>
            <div>
              <a href="<?php  echo base_url()."Project_controller/manage_account/"; ?>">ข้อมูลบัญชี</a>
              <a href="<?php  echo base_url('Project_controller/account_insert_form/'); ?>">เปิดบัญชี</a>
              <a href="<?php  echo base_url()."Project_controller/close_account/"; ?>">ปิดบัญชี</a>
            </div>
          </div>
          <div class="dropdown">
            <button style="font-size:20px;" class="btn btn-primary">สมาชิก</button>
            <div>
              <a href="<?php  echo base_url()."Project_controller/manage_member_staff/"; ?>">ข้อมูลสมาชิก</a>
              <a href="<?php  echo base_url('Project_controller/member_insert_form_staff/'); ?>">เพิ่มสมาชิก</a>
            </div>
          </div>
          <!--<a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/passbook_display/"; ?>">พิมพ์สมุดคู่ฝาก</a>-->
          <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/deposit_insert_form/"; ?>">ฝากเงิน</a>
          <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/withdraw_insert_form/"; ?>">ถอนเงิน</a>
          <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/tranfer_money_insert_form/"; ?>">โอนเงิน</a>
        </div>
      </div>
    </div>
  </div>
</div>