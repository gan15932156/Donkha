<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ธนาคารโรงเรียนดอนคาวิทยา</title>
    <script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php  echo base_url(); ?>bootstrap000/js/popper.min.js"></script>
    <script type="text/javascript" src="<?php  echo base_url(); ?>bootstrap000/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php  echo base_url(); ?>bootstrap000/datatable/datatables.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>bootstrap000/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>bootstrap000/datatable/datatables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
      html,body {
        background:url("<?php  echo base_url()."picture/4k-wallpaper-blue-sky-blur-281260.jpg"; ?>") no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        margin: 0;
        padding: 0;
        border: 0;
      }
      .container-fluid{
        width:100%;
        height:64%;
        margin-top:27px;  
      }
      .head-container{
        margin-top:5px;
        height: 12%;
      }
      .work-container{
        border: 3px solid #C5C5C5 ;
        height: 84vh;
        margin-left: 1px; 
        margin-right: 1px;
      }
      .login-formm{
        top:10px;
      }
    </style>
  </head>
  <body>
    <div class="head-container">
      <h2 class="text-center">
        <img src="<?php  echo base_url()."picture/donkha.png"; ?>" width="5%" height="100%">ธนาคารโรงเรียนดอนคาวิทยา
      </h2>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 ">
          <div class="row work-container">
            <div class="col-12">
              <div style="background-color: #F1FCFF;height:100%;" align="center" class="row right-work-container"> 
                <div class="col-3"></div>
                <div class="col-6 login-formm h-25 d-inline-block" style="border:3px solid #C5C5C5 ;">
                  <h5 class="text-center"><B>เข้าสู่ระบบ</B></h5>
                  <form method="post" action="<?=base_url();?>index.php/Project_controller/login_check" enctype="multipart/form-data" name="login" id="login">
                    <div class="form-row" >
                      <div class="form-group col-md-6">
                        <label for="name"><B>ชื่อผู้ใช้</B></label>
                        <input type="text" class="form-control " name="username" required="">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="name"><B>รหัสผ่าน</B></label>
                        <input type="password" class="form-control " name="password" required="">
                      </div>     
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12 text-center">
                        <button type="submit" class="btn btn-outline-primary" id="submit">ตกลง</button>
                      </div>
                    </div>
                    <?php  
                      echo '<label class="text-danger">'.$this->session->flashdata("error").'</label>';  
                    ?> 
                  </form>
                </div>
                <div class="col-3"></div>      
              </div> 
            </div>  
          </div>
        </div>      
      </div>
    </div>
  </body>
</html>