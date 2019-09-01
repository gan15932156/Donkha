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
   <script type="text/javascript" src="<?php  echo base_url(); ?>bootstrap000/js/jquery-ui.js"></script>
   <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>bootstrap000/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>bootstrap000/datatable/datatables.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>bootstrap000/Project_css/project_css.css">
   <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>bootstrap000/Project_css/notification_dropdown.css"> 
   <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>bootstrap000/css/jquery-ui.css">
   <script type="text/javascript">
      function logout(){
        location.replace("<?php  echo base_url()."Project_controller/logout"; ?>");
      }
   </script>
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
            <div class="top-container"><h5 class="text-right" ><?php echo "<B>ยินดีต้อนรับคุณ </B>".$this->session->userdata('sname'); ?>&nbsp</h5></div>
            <div class="row work-container">
               <div style="background-color: rgb(181, 216, 232);" class="col-2" align="center">
                  <h4><a style="color: black" href="
                     <?php  
                        if($this->session->userdata('lid') == "1"){echo "Not found";}
                        elseif($this->session->userdata('lid') == "2"){echo base_url("Project_controller/index_staff/");}
                        elseif($this->session->userdata('lid') == "3"){echo base_url("Project_controller/index_manager/");}
                        else{echo base_url("Project_controller/index_admin/");}                                                                
                     ?>
                     "><B>หน้าแรก</B></a></h4>
                  <img style="border-radius: 50%;" src="<?php  echo $this->session->userdata('spic'); ?>" width="165px" height="180px">
                  <h5><?php echo $this->session->userdata('sname');  ?></h5>
                  <h5><?php echo "<B>ตำแหน่ง </B>".$this->session->userdata('slevel');  ?></h5>
                  <button onclick="logout()" type="submit" class="btn btn-outline-danger" id="submit">ออกจากระบบ</button>
               </div>
               <div style="background-color: #EFFEFD;" class="col-10">
                  <div align="center" class="row right-work-container">