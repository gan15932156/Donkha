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
      height: 89%;         
    } 
    .container-fluid{
      background-color: rgba(199, 223, 255,.9);
      width:90%;
      height: 100%;
      opacity: ;
      filter: alpha(opacity=40); /* For IE8 and earlier */
    }                        
  </style>
  <script type="text/javascript">
    function isNumeric(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }
    function logout(){
      location.replace("<?php  echo base_url()."Project_controller/logout"; ?>");
    }
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      var acc_balance = 0 ;
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
                acc_balancec = parseFloat(data['account_balance']);
                $('#acc_code').val(data['account_id']);
                $('#acc_name').val(data['account_name']);
                $('#acc_balance').val(new Intl.NumberFormat().format(parseFloat(data['account_balance'])));
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
      $("#withdraw_money").keyup(function(){
        if(parseFloat($("#withdraw_money").val()) > acc_balancec)
        {
          alert('กรอกจำนวนเงินไม่ถูกต้อง');
          var total = '0';
          $("#withdraw_money").val(total);
          $("#new_balance").val(total);
          return false;
        }
        var total = acc_balancec-parseFloat($("#withdraw_money").val())
        parseFloat($("#new_balance").val(total));
      });
      $("#account").autocomplete({
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
        <div class="row" style="margin-right:1px ;background-color: #EFFEFD;height:460px;">
          <div class="col-md-12 text-center" >
            <div class="row text-center">
              <div class="col-md-12">
                <div  class="row">
                  <div class="col-md-12 ">
                    <h4 class="text-center"><B>ฟอร์มถอนเงิน</B></h4>
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
                    <form  method="post" action="<?=base_url("index.php/Project_controller/withdraw_insert");?>" enctype="multipart/form-data" name="member_form" id="member_form">
                    <div class="row">
                            <div class="form-group col-4"><label>วันที่ทำรายการ</label></div>
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
                            </div>
                            <div class="form-group col-1"><label>บาท</label></div>
                          </div> 
                          <div class="row">
                            <div class="form-group col-md-3">
                              <label for="name">จำนวนเงินที่ถอน</label>
                            </div>
                            <div class="form-group col-md-3">
                              <input onKeyUp="if(this.value*1!=this.value){ alert('กรุณากรอกเฉพาะตัวเลข'); this.value='0';}" placeholder="0" type="text" class="form-control " name="withdraw_money" id="withdraw_money" required="">
                            </div>
                            <div class="form-group col-1"><label>บาท</label></div>
                          </div>
                          <div class="row">
                            <div class="form-group col-3"><label>ยอดเงินคงเหลือ</label></div>
                            <div class="form-group col-3">
                              <input type="number" class="form-control " id="new_balance" name="new_balance" readonly="" placeholder="0">    
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
        </div>
      </div>                     
    </div>
  </div>  
</body>
</html>


