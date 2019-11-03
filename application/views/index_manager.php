
<div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12"><br><br>
      <div class="row">
        <div class="col-md-12">
          <div class="dropdown">
            <button class="btn btn-primary btn_manager">
              <span style="font-size: 3em; color: #FFFFFF;">
                <i class="fa fa-address-card-o" aria-hidden="true"><h5 style="margin-top:3px;">รายงานบัญชี</h5></i>
              </span>  
            </button>
            <div>
              <a href="<?php  echo base_url()."Project_controller/test_report/"; ?>">รายงานเปิดบัญชี</a>
              <a href="<?php  echo base_url('Project_controller/manager_close_account/'); ?>">รายงานปิดบัญชี</a>
              <a href="<?php  echo base_url()."Project_controller/manager_account_report/"; ?>">รายงานการเคลื่อนไหวบัญชี</a>
            </div>
          </div>&nbsp;&nbsp;&nbsp;&nbsp;
          <div class="dropdown">
            <button class="btn btn-primary btn_manager">
              <span style="font-size: 3em; color: #FFFFFF;">
                <i class="fa fa-university" aria-hidden="true"><h5 style="margin-top:3px;">รายงานการทำธุรกรรม</h5></i>
              </span>               
            </button>
            <div>
              <a href="<?php  echo base_url()."Project_controller/manager_deposit_report/"; ?>">รายงานสรุปยอดฝาก</a>
              <a href="<?php  echo base_url('Project_controller/manager_withdraw_report/'); ?>">รายงานสรุปยอดถอน</a>
              <a href="<?php  echo base_url('Project_controller/manager_tranfer_report/'); ?>">รายงานสรุปยอดโอน</a>
            </div>
          </div>&nbsp;&nbsp;&nbsp;&nbsp;
          <a class="btn btn-primary btn_manager" href="<?php  echo base_url()."Project_controller/manager_member_report/"; ?>">
            <span style="font-size: 3em; color: #FFFFFF;">
              <i class="fa fa-user-o" aria-hidden="true"><h5 style="margin-top:3px;">รายงานข้อมูลสมาชิก</h5></i>
            </span>        
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
