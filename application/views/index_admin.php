<script>
  function show_modal(){
    $.ajax({
		  url: "<?=base_url("Project_controller/select_remain_system_money/");?>",
		  type:"post",
      dataType: "JSON",		
      error: function(){ alert("error"); }
    })
    .done(function(data){
      $('#remain_money').val(data.remain_money);
      $('#exampleModal').modal('show');
    });
  }
  $(document).ready(function(){
    
  });
</script>
<div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12"><br>
      <div class="dropdown">
        <button style="font-size:40px;" class="btn btn-primary">พนักงาน</button>
        <div>
          <a  href="<?php  echo base_url()."Project_controller/manage_staff/"; ?>" >ข้อมูลพนักงาน</a>
          <a  href="<?php  echo base_url()."Project_controller/staff_insert_form/"; ?>" >เพิ่มพนักงาน</a>
        </div>
      </div>
      <div class="dropdown">
        <button style="font-size:40px;" class="btn btn-primary">สมาชิก</button>
        <div>
          <a  href="<?php  echo base_url()."Project_controller/manage_member/"; ?>" >ข้อมูลสมาชิก</a>
          <a  href="<?php  echo base_url()."Project_controller/member_insert_form/"; ?>" >เพิ่มสมาชิก</a>
        </div>
      </div> 
    </div>
    <div class="col-md-12">
     <br> 
     <!--<button onclick="show_modal()" style="font-size:20px;" class="btn btn-primary">เพิ่มเงินในระบบ</button>-->
    </div>                   
  </div>   
</div>      



<style>
    .modal-dialog {max-height:100vh;max-width:150vh;}  
    .modal-body{height:100%;width:100%;align:center;}  
    .body-container{background-color:white;}    
</style>

<!-- Modal -->
<div align="center" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">เพิ่มเงินในระบบ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid body-container">       
            <div class="row">
                <div class="col-md-12">
                  <form method="post" action="<?=base_url("index.php/Project_controller/increase_money_insert");?>">
                    <div class="row">
                      <div class="form-group col-md-2">
                        
                      </div>
                      <div class="form-group col-md-2">
                        <label for="txt_title">จำนวนเงินคงเหลือ</label>
                      </div>
                      <div class="form-group col-md-2">
                        <input class="form-control" type="text" id="remain_money">
                      </div>
                      <div class="form-group col-md-12">
                        <button class="btn btn-primary" type="submit">ส่ง</button>
                      </div>
                    </div> 
                  </form>
                    <div class="result"></div>
                </div>
            </div> 
        </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิดหน้าต่าง</button>
        <!--<button type="button" id="print_report" class="btn btn-warning">พิมพ์รายงาน</button>-->
      </div>
    </div>
  </div>
</div>