<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ธนาคารโรงเรียนดอนคาวิทยา</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/js/jquery.min.js"></script>
  <script type="text/javascript" src="<?php  echo base_url(); ?>bootstrap000/js/popper.min.js"></script>
  <script type="text/javascript" src="<?php  echo base_url(); ?>bootstrap000/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>bootstrap000/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>bootstrap000/css/bootstrap.min.css">
  <script type="text/javascript" src="<?php  echo base_url(); ?>bootstrap000/js/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>bootstrap000/css/jquery-ui.css">
  <style type="text/css">
    html,body { 
      background: 
      url("<?php  echo base_url()."picture/school.jpg"; ?>") no-repeat center center fixed; 
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      height: 88%;         
    } 
    .container-fluid{
      background-color: rgba(199, 223, 255,.9);
      width:90%;
      padding-bottom: 1%;
      opacity: ;
      filter: alpha(opacity=40); /* For IE8 and earlier */
    }                       
  </style>
  <script type="text/javascript">
    function logout(){location.replace("<?php  echo base_url()."Project_controller/logout"; ?>");}
    $(document).ready(function(){
      function con_print(account_id){
        $.ajax({
          type: "POST",
          url: "<?php echo site_url();?>/Project_controller/select_con_print",
          method:"POST",
          data:{account_id:account_id},
          success:function(response){
            if(response == false){alert("ไม่พบรายการ");$("#account_id").val("");}
            else{$('#result_table').html(response);}  
          },
          error: function( error ){alert( error );}
        });
      }
      function new_print(account_id){
        $.ajax({
          type: "POST",
          url: "<?php echo site_url();?>/Project_controller/select_new_print",
          method:"POST",
          data:{account_id:account_id},
          success:function(response){
            if(response == false){alert("ไม่พบรายการ");$("#account_id").val("");}
            else{$('#result_table').html(response);}  
          },
          error: function( error ){alert( error );}
        });
      }      
      function search_account(account_id){
        $.ajax({
          type: "POST",
          url: "<?php echo site_url();?>/Project_controller/searchAccount_passbook",
          method:"POST",
          data:{account_id:account_id},
          dataType: "JSON",
          success:function(response){
            if(response == false){alert("ไม่พบบัญชี");$("#account_id").val("");$("#account_name").val("");$('#result_table').hide();}
            else{           
              $.each(response,function(index,data){
                $('#account_id').val(data['account_id']);
                $('#account_name').val(data['account_name']);
              });
            }      
          },
          error: function( error ){alert( error );}
        });
      }
      $("#search_account").click(function(){
        if($("#account_id").val() == ''){alert('กรุณากรอกหมายเลขบัญชี');}
        else{search_account($("#account_id").val());$('#result_table').hide();}     
      });
      $("#con_print").click(function(){
        if($("#account_id").val() == '' && $("#account_name").val() == ''){alert('กรุณากรอกหมายเลขบัญชี');}
        else{con_print($("#account_id").val());$('#result_table').show();}     
      });
      $("#new_print").click(function(){
        if($("#account_id").val() == '' && $("#account_name").val() == ''){alert('กรุณากรอกหมายเลขบัญชี');}
        else{new_print($("#account_id").val());$('#result_table').show();}     
      });
      $("#account_id").autocomplete({
        source: "<?php echo base_url('Project_controller/fetch_account'); ?>",
      }); 
    });
  </script>
</head>
<body>
  <h1 class="text-center"><img src="<?php  echo base_url()."picture/donkha.png"; ?>" width="100px" height="120px">ธนาคารโรงเรียนดอนคาวิทยา</h1>
  <div class="container-fluid" >
    <div class="row">
      <div class="col-md-12">
        <h5 class="text-right" style="margin-top: 5px;background-color: rgb(181, 216, 232);"><?php echo "<B>ยินดีต้อนรับคุณ </B>".$this->session->userdata('sname'); ?>&nbsp</h5>
      </div>
      <div class="col-md-2" align="center" >
        <h4><a style="color: black" href="<?php  echo base_url("Project_controller/index_staff/"); ?>"><B>หน้าแรก</B></a></h4>
        <img style="border-radius: 50%;" src="<?php  echo $this->session->userdata('spic'); ?>" width="165px" height="180px">
        <h5><?php echo $this->session->userdata('sname');  ?></h5>
        <h5><?php echo "<B>ตำแหน่ง </B>".$this->session->userdata('slevel');  ?></h5>
        <button onclick="logout()" type="submit" class="btn btn-outline-danger" id="submit">ออกจากระบบ</button>
      </div>          
      <div class="col-md-10">
        <div class="row" style="margin-right:1px ;background-color: #EFFEFD; height: 100%;">
          <div class="col-md-12 text-center" >
            <div class="row text-center">
              <div class="col-md-12">
                <div  class="row">
                  <div class="col-md-12 ">
                    <h4 class="text-center"><B>พิมพ์สมุดคู่ฝาก</B></h4><br>
                    <div class="row">
                      <div class="col-2">
                        <label>หมายเลขบัญชี</label>
                      </div>
                      <div class="col-3">
                        <input placeholder="ชื่อหรือหมายเลขบัญชี" autofocus type="text" class="form-control" id="account_id" name="account_id">
                      </div>
                      <div class="col-2">
                        <button type="submit" class="btn btn-outline-success" id="search_account">ค้นหา</button> 
                      </div>
                      <div class="col-1">
                        <label>ชื่อบัญชี</label>
                      </div>
                      <div class="col-3">
                        <input placeholder="ชื่อบัญชี" autofocus type="text" class="form-control" id="account_name" name="account_name" readonly="">
                      </div>
                    </div><br>
                    <div class="row">
                      <div class="col-4" align="right"> <a href="<?=base_url("index.php/Project_controller/index_staff");?>" class="btn btn-warning">ย้อนกลับ</a></div>
                      <div class="col-4">
                        <button class="btn btn-outline-primary" id="con_print">พิมพ์สมุดต่อ</button> &nbsp;&nbsp;&nbsp;&nbsp;
                       <!-- <button class="btn btn-outline-primary" id="new_print">พิมพ์สมุดใหม่</button> -->
                      </div>
                      <div class="col-4"></div> 
                    </div>  
                    </div>  
                <div class="form-group col-12">
                  <hr><div id="result_table"></div>
                </div>                                     
              </div>
            </div>                   
          </div>        
        </div>                                   
      </div>
    </div>                     
  </div>
</div>  
</body>
</html>


