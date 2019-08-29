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
  <script type="text/javascript" src="<?php  echo base_url(); ?>bootstrap000/datatable/datatables.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>bootstrap000/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php  echo base_url(); ?>bootstrap000/datatable/datatables.css">
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
    font-size:16px;
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
      var table = $('#data_table').DataTable({
        pageLength: 6,
        serverSide: true,
        processing: true,
        "language": {
            "search":"ค้นหา:",
            "zeroRecords": "ไม่พบข้อมูล",
            "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
            "infoEmpty": "ไม่พบข้อมูล",
            "infoFiltered": "(กรองจาก _MAX_ รายการทั้งหมด)",
            "paginate": {
              "first":      "หน้าแรก",
              "last":       "หน้าสุดท้าย",
              "next":       "ถัดไป",
              "previous":   "ก่อนหน้า"
            },
        },   
        "lengthChange": false,
        ajax: {
          url:'<?php echo base_url("index.php/Project_controller/fetch_member_datatable"); ?>'
        },
        'columns':[
        {
          data:'member_name'
        },
        {
          data:'member_status',
          render: function (data,type,row){
            var active = '<span class="text-success">ใช้งาน</span>';
            var inactive = '<span class="text-danger">ยกเลิก</span>';
            var status = (data==1) ? active : inactive;
            return status;
          }
        },
        {
          data:'member_id',
          render: function(data, type, row){
            var string =  "ต้องการเปลี่ยนสถานะการใช้งานหรือไม่";
            var divv = ' <div class="dropdown">';
                divv+='<button style="font-size:16px;"><i class="fa fa-cog" aria-hidden="true"></i></button><div>';   
                divv+='<a style="color:black;" href="<?php  echo site_url('Project_controller/member_detail/');?>'+row['member_id']+'"><i class="fa fa-address-book" aria-hidden="true"></i> รายละเอียด</a>';
                divv+='<a style="color:black;" href="<?php  echo site_url('Project_controller/member_update_form/');?>'+row['member_id']+'" ><i class="fa fa-pencil" aria-hidden="true"></i> แก้ไขข้อมูล</a>';
                divv+='<a style="color:black;" id="onclickchangestatus" href="<?php  echo site_url('Project_controller/member_change_status/');?>'+row['member_id']+'" ><i class="fa fa-times" aria-hidden="true"></i> เปลี่ยนสถานะ</a>';
                divv+='</div></div>';                                     
            return divv;
          }
        }
        ]
      });
      $('#data_table tbody ').on('click', '#onclickchangestatus', function () {
        return confirm('ต้องการเปลี่ยนสถานะการใช้งานหรือไม่');
    } );  
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
        <h4><a style="color: black" href="<?php  echo base_url("Project_controller/index_admin/"); ?>"><B>หน้าแรก</B></a></h4>
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
                    <h4 class="text-center"><B>ข้อมูลสมาชิก</B></h4>
                  </div>
                  
                <div class="col-md-12 text-center">
                  <div id="result_search"></div>
                  <table class="table table-striped table-hover table-sm " id="data_table">
                    <thead class="thead-light table-bordered">
                      <tr>
                      <th width="30%" scope="col">ชื่อ-นามสกุล</th>
                        <th width="30%" scope="col">สถานะ</th>
                        <th width="10%" scope="col">การกระทำ</th>
                      </tr>
                      </thead>
                      <tbody class="table-bordered" style="background-color: #EFFEFD">
                      </tbody>
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
