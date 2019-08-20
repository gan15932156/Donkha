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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
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
    .notification {
      margin-right:1%;
      text-decoration: none;
      padding: 15px 26px;
      position: relative;
      display: inline-block;
      font-size: 25px;
    }
    .notification .badge {
      background-color: #28A745;
      position: absolute;
      top: -10px;
      right: -10px;
      padding: 5px 10px;
      border-radius: 50%;
      border: 2px solid;
      border-color: #28A745;
      color: white;
      font-size: 20px;
    }
    .notification:hover .badge {
      color: #28A745;
      background-color: #ffffff;
    }
    .dropdown{
    display:inline-block;
    position:relative;
  }

  .dropdown button{
    transition:.3s;
    cursor:pointer;
  }


  .dropdown div{
    background-color:#fff;
    box-shadow:0 4px 8px rgba(0,0,0,0.2);
    z-index:1;
    visibility:hidden;
    position:absolute;
    min-width:100%;
    opacity:0;
    transition:.3s;
  }

  .dropdown:hover div{
    visibility:visible;
    opacity:1;
  }

  .dropdown div a{
    display:block;
    text-decoration:none;
    padding:8px;
    color:#000;
    transition:.1s;
    white-space:nowrap;
  }

  .dropdown div a:hover{
    background-color:#D6EAF8;
  }
  </style>
  <script type="text/javascript">
    function logout(){
      location.replace("<?php  echo base_url()."Project_controller/logout"; ?>");
    }
  </script>
</head>
<body>
  <h1 class="text-center"><img src="<?php  echo base_url()."picture/donkha.png"; ?>" width="100px" height="120px">ธนาคารโรงเรียนดอนคาวิทยา</h1>
  <div class="container-fluid h-100" >
    <div class="row">
      <div class="col-md-12">
        <h5 class="text-right" style="margin-top: 5px;background-color: rgb(181, 216, 232);"><?php echo "<B>ยินดีต้อนรับคุณ </B>".$this->session->userdata('sname'); ?>&nbsp</h5>
      </div>
      <div class="col-md-2" align="center" >
        <h4><a style="color: black" href="<?php  echo base_url("Project_controller/index_manager/"); ?>"><B>หน้าแรก</B></a></h4>
        <img style="border-radius: 50%;" src="<?php  echo $this->session->userdata('spic'); ?>" width="165px" height="180px">
        <h5><?php echo $this->session->userdata('sname');  ?></h5>
        <h5><?php echo "<B>ตำแหน่ง </B>".$this->session->userdata('slevel');  ?></h5>
        <button onclick="logout()" type="submit" class="btn btn-outline-danger" id="submit">ออกจากระบบ</button>
      </div>
      <div class="col-md-10">
        <div class="row" style="margin-right:1px ;background-color: #EFFEFD;height:460px;">
          <div class="col-md-12 text-center" ><br>
            <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/test_report/"; ?>">รายงานเปิดบัญชี</a>
            <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/passbook_display/"; ?>">พิมพ์สมุดคู่ฝาก</a>
            <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/passbook_display/"; ?>">พิมพ์สมุดคู่ฝาก</a>
            <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/passbook_display/"; ?>">พิมพ์สมุดคู่ฝาก</a>
            <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/passbook_display/"; ?>">พิมพ์สมุดคู่ฝาก</a>
            <a class="btn btn-primary" style="font-size:20px;" href="<?php  echo base_url()."Project_controller/passbook_display/"; ?>">พิมพ์สมุดคู่ฝาก</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
