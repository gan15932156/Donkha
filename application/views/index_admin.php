<script>
  function show_modal(){
    $.ajax({
		  url: "<?=base_url("Project_controller/select_remain_system_money/");?>",
		  type:"post",
      data:{admin_id:'<?php echo $this->session->userdata('lid') ?>'},
      dataType: "JSON",		
      error: function(){ alert("error"); }
    })
    .done(function(data){
      if(!data.error){
        $('#cash').val(data.cash);
        $('#exampleModal').modal('show');
      }
      else{
        alert(data.message);
      }
    });
  }
  $(document).ready(function(){
    $("#money_increse").change(function(){
      if($(this).attr("mode_id") == null){
        $(this).val(null);
        alert("กรุณาเลือกประเภทรายการก่อน");
      }
      else if($(this).attr("mode_id") == "dep"){
        $("#total_cash").val(parseFloat($("#cash").val())+parseFloat($(this).val()));
      }
      else if($(this).attr("mode_id") == "wd"){
        $("#total_cash").val(parseFloat($("#cash").val())-parseFloat($(this).val()));
        if($("#total_cash").val() < 0 || $("#total_cash").val() == $("#cash").val()){
          alert("ไม่สามารถคำนวณได้");
          $("#total_cash").val(null);
          $(this).val(null);
        }  
      }
    });
    $('#cash_increse_form').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "<?=base_url("Project_controller/increase_money_insert/");?>",
        data: $('#cash_increse_form').serialize(),
        dataType: "JSON",	
        success: function(response) {
          if(!response.error){
            window.location.reload(true);
            alert(response.message);
          }
          else{ alert(response.message); }
        },
        error: function() { alert('Error'); }
      });
      return false;
    });
    $(".dep_mode").click(function(){
      $('#money_increse').val(null);
      $("#total_cash").val(null);
      $('#money_increse').attr('mode_id','dep');
      $("#tran_money").text("จำนวนเงินที่เพิ่ม");
    });
    $(".wd_mode").click(function(){
      $('#money_increse').val(null);
      $("#total_cash").val(null);
      $("#tran_money").text("จำนวนเงินที่ถอน");
      $('#money_increse').attr('mode_id','wd');
    });
  });
</script>
<div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12"><br><br><br>
      <div class="dropdown">
        <button style="font-size:40px;" class="btn btn-primary btn_admin">
          <span style="font-size: 3em; color: #FFFFFF;">
              <i class="fa fa-address-card-o" aria-hidden="true"><h5 style="margin-top:3px;">พนักงาน</h5></i>
          </span>  
        </button>
        <div>
          <a  href="<?php  echo base_url()."Project_controller/manage_staff/"; ?>" >ข้อมูลพนักงาน</a>
          <a  href="<?php  echo base_url()."Project_controller/staff_insert_form/"; ?>" >เพิ่มพนักงาน</a>
        </div>
      </div>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;
      &nbsp;
      &nbsp;
      &nbsp;
      
      <div class="dropdown">
        <button style="font-size:40px;" class="btn btn-primary btn_admin">
          <span style="font-size: 3em; color: #FFFFFF;">
              <i class="fa fa-user-o" aria-hidden="true"><h5 style="margin-top:3px;">สมาชิก</h5></i>
          </span>  
        </button>
        <div>
          <a  href="<?php  echo base_url()."Project_controller/manage_member/"; ?>" >ข้อมูลสมาชิก</a>
          <a  href="<?php  echo base_url()."Project_controller/member_insert_form/"; ?>" >เพิ่มสมาชิก</a>
        </div>
      </div> 
    </div>
    <div class="col-md-12">
     <br> 
     <!--<button onclick="show_modal()" style="font-size:20px;" class="btn btn-primary">เพิ่มเงินสำรอง</button>-->
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
        <h5 class="modal-title" id="exampleModalLabel">เพิ่มเงินสำรอง</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid body-container">       
            <div class="row">
                <div class="col-md-12">
                <style>
            input{
              text-align: right;
            }
            input[type=number]{
              width:100%;
            }
          </style>
                  <form id="cash_increse_form" name="cash_increse_form">
                  <input type="hidden" name="admin_id" id="admin_id" value="<?php echo $this->session->userdata('lid')?>">
                    <div class="row">
                      <div class="form-group col-md-2">
                        <label>จำนวนเงินคงเหลือ</label>
                      </div>
                      <div class="form-group col-md-2">
                        <input class="form-control" type="number" id="cash" name="cash" readonly="">
                      </div>
                      <div class="form-group col-md-2">
                        <label id="tran_money">จำนวนเงินที่เพิ่ม</label>
                      </div>
                      <div class="form-group col-md-2">
                        <input class="form-control" type="number" min="0" step="any" id="money_increse" name="money_increse" required="">
                      </div>
                      <div class="form-group col-md-2">
                        <label>จำนวนสุทธิ</label>
                      </div>
                      <div class="form-group col-md-2">
                        <input class="form-control" type="number" step="any" id="total_cash" name="total_cash" readonly="" required="">
                      </div>
                      <div class="form-group col-md-4">
                        <button class="btn btn-success dep_mode" type="button">ฝาก</button>
                        <button class="btn btn-danger wd_mode" type="button">ถอน</button>
                      </div>
                      <div class="form-group col-md-4">
                        <button class="btn btn-primary form_modal_submit" type="submit">ส่ง</button>
                      </div>
                      <div class="form-group col-md-4">
                        
                      </div>
                    </div> 
                  </form>
                    <div class="result"></div>
                </div>
            </div> 
        </div>
    </div>
    </div>
  </div>
</div>