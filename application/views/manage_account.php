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
    font-size:12px;
    float:left;
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
  <script type="text/javascript">
    $(document).ready(function(){
      function search_data(data){
        $.ajax({
          url:"<?php echo base_url("index.php/Project_controller/search_data_account"); ?>",
          method:"POST",
          data:{data:data},
          success:function(data){
            $('#result_search').html(data);
          }
        })
      }
      $("#search").keyup(function(){
        if($(this).val() == ""){
          location.replace("<?php  echo base_url()."Project_controller/manage_account"; ?>");
        }else{
          search_data($(this).val());
          $( "#data_table" ).remove();
        }
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
                    <h4 class="text-center"><B>ข้อมูลบัญชี</B></h4>
                  </div>
                  <div class="col-md-12 topnav" align="center" >
                    <div class="row">
                      <div class="col-4"></div>
                      <div class="col-4">
                        <div class="search-container">
                          <input type="text" name="search" id="search" placeholder="ใส่คำค้น" style="border-radius: 10%; ">
                          <button type="submit"><i class="fa fa-search"></i></button>
                        </div>
                      </div>
                    <div align="right" class="col-4">
                      <a class="link btn btn-outline-primary btn-sm" href="<?php  echo base_url('Project_controller/account_insert_form/'); ?>">เปิดบัญชี</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 text-center">
                  <div id="result_search"></div>
                    <table class="table table-striped table-hover table-sm" id="data_table" >
                      <thead class="thead-light table-bordered">
                        <tr>
                          <th width="5%" scope="col">ลำดับ</th>
                          <th width="25%" scope="col">หมายเลขบัญชี</th>
                          <th width="30%" scope="col">ชื่อบัญชี</th>
                          <th width="30%" scope="col">สถานะ</th>
                          <th width="10%" scope="col">การกระทำ</th>
                        </tr>
                      </thead>
                      <tbody class="table-bordered" style="background-color: #EFFEFD">
                        <?php $i=1;
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

                          foreach($account->result() as $row){ ?>
                          <tr>
                            <th scope="row"><?php echo $i; ?></th>
                            <td><?php echo $row->account_id; ?></td>
                            <td><?php echo $row->account_name; ?></td>
                            <td>
                              <?php
                                if($row->account_status =='1'){
                                  echo "<p class='text-success'>เปิดใช้งาน</p>";
                                }
                                else{
                                  echo "<p class='text-danger'>ปิดใช้งาน</p>";
                                }
                              ?>
                            </td>
                            <td>
                            <div class="dropdown">
                              <button style="font-size:16px;"><i class="fa fa-cog" aria-hidden="true"></i></button>
                              <div>
                              <a style="color:black;" href="<?php  echo base_url('Project_controller/account_detail/'.$row->account_id); ?>" ><i class="fa fa-address-book" aria-hidden="true"></i> รายละเอียดบัญชี</a>
                              <a style="color:black;" href="<?php  echo base_url('Project_controller/account_update_form/'.$row->account_id); ?>" ><i class="fa fa-pencil" aria-hidden="true"></i> แก้ไขข้อมูล</a>
                              </div>
                            </div>
                            </td>
                          </tr>
                        <?php $i++; }  ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th class="text-center" colspan="10"><div style="font-size: 2em;" class="col-md-12 text-center"><?php echo $pagination;?></div></th>
                        </tr>
                      </tfoot>
                    </table>
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
