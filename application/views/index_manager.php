
<div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12"><br>
      <div class="row">
        <div class="col-md-12">
          <div class="dropdown">
            <button style="font-size:20px;" class="btn btn-primary">รายงานบัญชี</button>
            <div>
              <a href="<?php  echo base_url()."Project_controller/test_report/"; ?>">รายงานเปิดบัญชี</a>
              <a href="<?php  echo base_url('Project_controller/account_insert_form/'); ?>">รายงานปิดบัญชี</a>
              <a href="<?php  echo base_url()."Project_controller/manager_account_report/"; ?>">รายงานการเคลื่อนไหวบัญชี</a>
            </div>
          </div>
          <div class="dropdown">
            <button style="font-size:20px;" class="btn btn-primary">รายงานการทำธุรกรรม</button>
            <div>
              <a href="<?php  echo base_url()."Project_controller/manager_deposit_report/"; ?>">รายงานสรุปยอดฝาก</a>
              <a href="<?php  echo base_url('Project_controller/manager_withdraw_report/'); ?>">รายงานสรุปยอดถอน</a>
            </div>
          </div>
          <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/manager_member_report/"; ?>">รายงานข้อมูลสมาชิก</a>
        </div>
      </div>
    </div>
  </div>
</div>
