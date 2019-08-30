<div class="head-container">
    <h2 class="text-center">
        <img src="<?php  echo base_url()."picture/donkha.png"; ?>" width="5%" height="100%">ธนาคารโรงเรียนดอนคาวิทยา
    </h2>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 ">
            <div class="top-container"><h5 class="text-right" ><?php echo "<B>ยินดีต้อนรับคุณ </B>".$this->session->userdata('sname'); ?>&nbsp</h5></div>
            <div class="row work-container">
               <div style="background-color: rgb(181, 216, 232);" class="col-2" align="center">
                    <h4><a style="color: black" href="<?php  echo base_url("Project_controller/index_staff/"); ?>"><B>หน้าแรก</B></a></h4>
                    <img style="border-radius: 50%;" src="<?php  echo $this->session->userdata('spic'); ?>" width="165px" height="180px">
                    <h5><?php echo $this->session->userdata('sname');  ?></h5>
                    <h5><?php echo "<B>ตำแหน่ง </B>".$this->session->userdata('slevel');  ?></h5>
                    <button onclick="logout()" type="submit" class="btn btn-outline-danger" id="submit">ออกจากระบบ</button>
                </div>
                <div style="background-color: #EFFEFD;" class="col-10">
                    <div align="center" class="row right-work-container">  



                        <div class="col-md-12"><br>
                            <a href="<?php  echo base_url()."Project_controller/noti_dep/"; ?>" class="btn btn-outline-success notification">แจ้งเตือนรายการฝาก<span class="badge "><?php echo $not_confirm_dep; ?></span></a>
                            <a href="<?php  echo base_url()."Project_controller/noti_wd/"; ?>" class="btn btn-outline-success notification">แจ้งเตือนรายการถอน<span class="badge"><?php echo $not_confirm_wd; ?></span></a>
                            <a href="<?php  echo base_url()."Project_controller/noti_wd/"; ?>" class="btn btn-outline-success notification">แจ้งเตือนรายการโอน<span class="badge"><?php echo $not_confirm_wd; ?></span></a>
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
                                    <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/passbook_display/"; ?>">พิมพ์สมุดคู่ฝาก</a>
                                    <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/deposit_insert_form/"; ?>">ฝากเงิน</a>
                                    <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/withdraw_insert_form/"; ?>">ถอนเงิน</a>
                                    <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/manage_withdraw/"; ?>">โอนเงิน</a>
                                </div>
                            </div>
                        </div>


                        
                    </div> 
                </div>  
            </div>
        </div>      
    </div>
</div>