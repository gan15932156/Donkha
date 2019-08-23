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
      height: 91%;
    }
    .container-fluid{
      background-color: rgba(199, 223, 255,.9);
      width:97%;
      height:100%;
      filter: alpha(opacity=40); /* For IE8 and earlier */
    }                 
  </style>
  <script type="text/javascript">
    function logout(){
      location.replace("<?php  echo base_url()."Project_controller/logout"; ?>");
    }
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      function search_data(member_name){
        $.ajax({
          type: "POST",
          url: "<?php echo site_url();?>/Project_controller/searchMember",
          method:"POST",
          data:{member_name:member_name},
          dataType: "JSON",
          success:function(response){
            if(response == false){
              alert("ไม่พบสมาชิก");
              $("#member_name").val("");
            }
            else
            {           
              $.each(response,function(index,data)
              {
                $('#name').val(data['member_name']);
                if(data['std_code'] == '0'){
                  $('#std_code').val('ไม่มี');
                }
                else{
                  $('#std_code').val(data['std_code']);
                }
                $("#show_image_pic").attr("src",data['member_pic']);
                var b_thai_date = data['member_birth_date'];
                var thday = new Array ("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัส","ศุกร์","เสาร์");
                var thmonth = new Array ("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                var thai_b_day = b_thai_date.substring(8,10);
                var thai_b_month = parseInt(b_thai_date.substring(5, 7));
                var thai_b_year = parseInt(b_thai_date.substring(0, 4));
                var real_thai_year = thai_b_year+543;
                $('#b_date').val(thai_b_day+" "+thmonth[thai_b_month]+" "+real_thai_year);
                $('#tel').val(data['phone_number']);
                $('#member_id').val(data['member_id']);
                $('#ac_name').val(data['member_name']);              
              });
            }      
          },
          error: function( error ){alert( error );}
        });
      }
      $("#search_member").click(function(){
        if($("#member_name").val() == ''){alert('กรุณากรอกคำค้นหา');}
        else{search_data($("#member_name").val());}     
      }); 
      $("#member_name").autocomplete({
        source: "<?php echo base_url('Project_controller/fetch_member'); ?>",
      });    
    });
  </script>
</head>
<body>
  <h1 class="text-center"><img src="<?php  echo base_url()."picture/donkha.png"; ?>" width="5%" height="22%">ธนาคารโรงเรียนดอนคาวิทยา</h1>
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
        <div class="row" style="margin-right:1px ;background-color: #EFFEFD;height:500px;">
          <div class="col-md-12 text-center" >
            <div class="row text-center">
              <div class="col-md-12">
                <div  class="row">
                  <div class="col-md-12 ">
                    <h4 class="text-center"><B>ฟอร์มเปิดบัญชี</B></h4>
                  </div>
                  <div class="col-md-12 ">
                    <div class="row">
                    <div class="col-3"></div>
                  <div class="col-6">
                    <div class="row">
                      <div class="col-3">
                        <label>ค้นหาสมาชิก</label>
                      </div>
                      <div id="prefetch" class="col-5">
                        <input placeholder="ค้นหาชื่อ" autofocus type="text" class="form-control input-lg typeahead" id="member_name" name="member_name">
                      </div>
                      <div class="col-2">

                        <button type="submit" class="btn btn-outline-success" id="search_member">ค้นหา</button> 
                      </div>
                    </div>
                  </div>
                  <div class="col-3"></div>
                  </div>                  
                  </div>
                  <div class="col-md-12 text-center"><br>
                <form  method="post" action="<?=base_url("index.php/Project_controller/account_insert_staff");?>" enctype="multipart/form-data" name="member_form" id="member_form">
                  <div class="row">
                  <div class="form-group col-4" align="center">        
                    <img id="show_image_pic" width="200px" height= "250px" src="<?php  echo base_url()."picture/No_person.jpg"; ?>" alt="your image" style="border: solid 1px #c0c0c0;" />
                    <figcaption>รูปประจำตัว</figcaption>   
                    <input type="hidden" name="staff_id" id="staff_id" value="<?php echo $this->session->userdata('id'); ?>">  
                    <input type="hidden" name="member_id" id="member_id">
                    </div>  
                    <div class="form-group col-8" align="left">
                      <div class="row">                       
                        <div class="col-12">
                          <div class="row">
                            <div class="form-group col-3"><label>วันที่ทำรายการ</label></div>
                            <div class="form-group col-3">
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
                          <div class="row">
                            <div class="form-group col-3"><label>รหัสนักเรียน</label></div>
                            <div class="form-group col-3">
                              <input type="text" class="form-control " id="std_code" name="std_code" placeholder="รหัสนักเรียน" readonly="">
                              <div id="result_std_code"></div>
                            </div>
                            <div class="form-group col-2">
                              <label style="width: 100px;">ชื่อ-นามสกุล</label>
                            </div>
                            <div class="form-group col-4">
                              <input placeholder="ชื่อ-นามสกุล" type="text" class="form-control " id="name" name="name" readonly="">
                            </div>
                          </div>
                          <div class="row">
                            <div class="form-group col-3">
                              <label>วัน/เดือน/ปีเกิด</label>
                            </div>
                            <div class="form-group col-3">
                              <input placeholder="วัน/เดือน/ปีเกิด" type="text" class="form-control " id="b_date" name="b_date" readonly="">    
                            </div>
                            <div class="form-group col-md-2">
                              <label style="width: 100px;">เบอร์โทรศัพท์</label>
                            </div>
                            <div class="form-group col-md-4"> 
                              <input placeholder="เบอร์โทรศัพท์" type="text" class="form-control " id="tel" name="tel" readonly="">
                            </div>
                          </div> 
                          <div class="row">
                            <div class="form-group col-md-3">
                              <label for="name">ชื่อบัญชี</label>
                            </div>
                            <div class="form-group col-md-4">
                              <input type="text" class="form-control " name="ac_name" id="ac_name" required="" placeholder="ชื่อบัญชี">
                            </div>
                            <div class="form-group col-md-2">
                              <label  for="name">จำนวนเงิน</label>
                            </div> 
                            <div class="form-group col-md-3">
                              <input type="text" class="form-control " name="money" id="money" required="" placeholder="จำนวนเงิน" onKeyUp="if(this.value*1!=this.value){ alert('กรุณากรอกเฉพาะตัวเลข'); this.value='';}">
                            </div>
                          </div>  
                          <div class="row">
                            <div class="form-group col-md-3">
                              <label>หมายเลขบัญชี</label>
                            </div>   
                            <div class="form-group col-md-3">
                              <input type="text" class="form-control " name="ac_code" id="ac_code" placeholder="เลขที่บัญชี" readonly="" value="<?php echo $accode; ?>">
                            </div>                                          
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

