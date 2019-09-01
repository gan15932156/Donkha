
<script type="text/javascript">
  $(document).ready(function(){
    var balacnce = 0;
    function search_data(account){
      $.ajax({
        type: "POST",
        url: "<?php echo site_url();?>/Project_controller/searchAccount",
        method:"POST",
        data:{account:account},
        dataType: "JSON",
        success:function(response){
          if(response == false){
            alert("ไม่พบบัญชี");
            $("#account").val("");
          }
          else
          {           
            $.each(response,function(index,data)
            {
              balacnce = parseFloat(data['account_balance']);
              $('#acc_code').val(data['account_id']);
              $('#acc_name').val(data['account_name']);
              $('#acc_balance').val(new Intl.NumberFormat().format(parseFloat(data['account_balance'])));
              $('#acc_balance_hidden').val(parseFloat(data['account_balance']));
              $("#show_image_pic").attr("src",data['member_pic']);             
            });
          }      
        },
        error: function( error ){alert( error );}
      });
    }
    $("#search_account").click(function(){
      if($("#account").val() == '')
      {
        alert('กรุณากรอกคำค้นหา');
      }
      else
      {
        search_data($("#account").val()); 
      }     
    });
    $("#cal_interest").click(function(){
      $.ajax({
        type: "POST",
        url: "<?php echo site_url();?>/Project_controller/cal_inerest_close_account",
        method:"POST",
        data:{
          account_id:$("#acc_code").val(),
          staff_id:$("#staff_id").val(),
        },
        dataType: "JSON",
        success:function(response){
          //$("#bonus").val(new Intl.NumberFormat().format(parseFloat(response.interest)));
          //$("#bonus_hidden").val(response.interest);
          if(response.interest == "คำนวณผิดพลาด"){
            $("#new_balance").val("คำนวณผิดพลาด");
            $("#bonus").val("คำนวณผิดพลาด");
            //$("#new_balance_hidden").val($('#acc_balance_hidden').val());
          }else{
            $("#bonus").val(new Intl.NumberFormat().format(parseFloat(response.interest)));
            $("#bonus_hidden").val(response.interest);
            $("#new_balance").val(new Intl.NumberFormat().format(response.interest+Number($('#acc_balance_hidden').val())));
            $("#new_balance_hidden").val(response.interest+Number($('#acc_balance_hidden').val()));
          }
        },
        error: function( error ){alert( error );}
      });
    });
    $("#account").autocomplete({
      source: "<?php echo base_url('Project_controller/fetch_account'); ?>",
    });       
  });
</script>
<div class="col-md-12 text-center" >
            <div class="row text-center">
              <div class="col-md-12">
                <div  class="row">
                  <div class="col-md-12 ">
                    <h4 class="text-center"><B>ปิดบัญชี</B></h4>
                  </div>
                  <div class="col-md-12 ">
                   <div class="row">
                  <div class="col-1"></div>
                  <div class="col-5">
                    <div class="row">
                      <div class="col-2">
                        <label>ค้นหา</label>
                      </div>
                      <div class="col-6">
                        <input placeholder="ชื่อหรือหมายเลขบัญชี" autofocus type="text" class="form-control" id="account" name="account">
                      </div>
                      <div class="col-2">
                        <button type="submit" class="btn btn-outline-success" id="search_account">ค้นหา</button> 
                      </div>
                    </div>
                  </div>
                  <div class="col-5">
                    <form  method="post" action="<?=base_url("index.php/Project_controller/close_account_insert");?>" enctype="multipart/form-data" name="member_form" id="member_form">
                    <div class="row">
                            <div class="form-group col-4"><label>วันที่ปิดบัญชี</label></div>
                            <div class="form-group col-6">
                              <?php
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
                                $regis_date = date('Y-m-d');
                                $thai_date=DateThai($regis_date);
                              ?>
                              <input type="text" class="form-control" value="<?php echo $thai_date; ?>" id="now_date" name="now_date" readonly="">
                              <input type="hidden" class="form-control" value="<?php echo $regis_date; ?>" id="date" name="date" readonly="">
                            </div>
                    </div>
                  </div>
                  <div class="col-1"></div>
                </div><br>          
                  </div>
                  <div class="col-md-12 text-center">
                    <div class="row">
                  <div class="form-group col-4" align="center">        
                    <img id="show_image_pic" width="200px" height= "220px" src="<?php  echo base_url()."picture/No_person.jpg"; ?>" alt="your image" style="border: solid 1px #c0c0c0;" />
                    <figcaption>รูปประจำตัว</figcaption>   
                    <input type="hidden" name="staff_id" id="staff_id" value="<?php echo $this->session->userdata('id'); ?>">  
                    <input type="hidden" name="member_id" id="member_id">
                    </div>  
                    <div class="form-group col-8" align="left">
                      <div class="row">                       
                        <div class="col-12">
                          <div class="row">
                            <div class="form-group col-3"><label>หมายเลขบัญชี</label></div>
                            <div class="form-group col-3">
                              <input type="text" class="form-control " id="acc_code" name="acc_code"  readonly="">
                            </div>
                            <div class="form-group col-2"><label>ชื่อบัญชี</label></div>
                            <div class="form-group col-4">
                              <input  type="text" class="form-control " id="acc_name" name="acc_name" readonly="">
                            </div>
                          </div>
                          <div class="row">
                            <div class="form-group col-3"><label>ยอดเงินในบัญชี</label></div>
                            <div class="form-group col-3">
                              <input type="text" class="form-control " id="acc_balance" name="acc_balance" readonly=""> 
                               <input type="hidden" class="form-control " id="acc_balance_hidden" name="acc_balance_hidden" readonly="">   
                            </div>
                            <div class="form-group col-1"><label>บาท</label></div>
                          </div> 
                          <div class="row">
                            <div class="form-group col-md-3">
                              <label for="name">ผลตอบแทน</label>
                            </div>
                            <div class="form-group col-md-3">
                              <input  type="text" class="form-control " name="bonus" id="bonus" required="" readonly="">
                              <input  type="hidden" class="form-control " name="bonus_hidden" id="bonus_hidden" required="" readonly="">
                            </div>
                            <div class="form-group col-1"><label>บาท</label></div>
                            <div class="form-group col-md-3">
                              <a  class="btn btn-warning" id="cal_interest">คำนวณผลตอบแทน</a>
                            </div>
                          </div>
                          <div class="row">
                            <div class="form-group col-3"><label>ยอดเงินสุทธิ</label></div>
                            <div class="form-group col-3">
                              <input type="text" class="form-control " id="new_balance" name="new_balance" readonly="" placeholder="0">    
                               <input type="hidden" class="form-control " id="new_balance_hidden" name="new_balance_hidden" readonly="" placeholder="0">   
                            </div>
                            <div class="form-group col-1"><label>บาท</label></div>
                          </div>   
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-12" align="left">
                      <div class="row">
                        <div class="form-group col-md-12 text-center">
                          <a href="<?=base_url("index.php/Project_controller/index_staff");?>" class="btn btn-outline-success">ย้อนกลับ</a>
                          <button type="submit" class="btn btn-outline-primary" id="submit">ตกลง</button>
                        </div>
                      </div>
                    </div>                          
                  </div>                                                
                </form> 


                  </div>
                </div>
              </div>                   
            </div>        
          </div>                                   