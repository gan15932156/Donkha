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
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
      height: 100%;
      opacity: ;
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
      $("#display_report").click(function(){
        if($("#start_date").val() == "" && $("#stop_date").val() == ""){
          alert("กรุณากรอกวันที่ให้ครบ");
        }
        else if($("#start_date").val() == ""){
          alert("กรุณากรอกวันที่ให้ครบ");
        }
        else if($("#stop_date").val() == ""){
          alert("กรุณากรอกวันที่ให้ครบ");
        }
        else{
          $.ajax({
            type: "POST",
            url: "<?php echo site_url();?>/Project_controller/fetch_report_open_account",
            method:"POST",
            data:{
              start_date:$("#start_date").val(),
              stop_date:$("#stop_date").val()
            },
            success:function(response){
              if(response == false){alert("ไม่พบรายการ");}
              else{$('#result_table').html(response);}
            },
            error: function( error ){alert( error );}
          });
          //console.log(start_date+" "+stop_date);
        }
      });
      /*google.charts.load('current', {packages: ['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawBasic);
      function drawBasic() {
      var jsonData = $.ajax({
          url: "echo base_url('Project_controller/test_get_data_repost/') ?>",
          dataType: "json",
          async:false
      }).responseText;
      var data = new google.visualization.DataTable(jsonData);
      var options = {
        title: 'Motivation Level Throughout the Day',
        focusTarget: 'category',
        width: 800,
        height: 400,
        hAxis:{
          title: 'Time of Day',
          viewWindow:{
            min:[7,30,0],
            max:[17,30,0]
          },
          textStyle:{
            fontSize:14,
            color: '#053061',
            bold:true,
            italic:false
          },
        }
      };
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      var formatter = new google.visualization.NumberFormat({suffix: ' บาท', negativeColor: 'red', negativeParens: true});
      formatter.format(data, 1); // Apply formatter to second column
      chart.draw(data, options);
    }*/

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
        <h4><a style="color: black" href="<?php  echo base_url("Project_controller/index_manager/"); ?>"><B>หน้าแรก</B></a></h4>
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
                  <div class="col-md-12 text-center">
                    <h4 class="text-center"><B>รายงานเปิดบัญชี</B></h4>
                    <div class="row">
                      <div class="col-2">
                        <label>ค้นหาวันที่</label>
                      </div>
                      <div class="col-3">
                        <input autofocus type="date" class="form-control" id="start_date" name="start_date" required>
                      </div>
                      <div class="col-2">
                        <label>ถึงวันที่</label>
                      </div>
                      <div class="col-3">
                        <input type="date" class="form-control" id="stop_date" name="stop_date" required>
                      </div>
                      <div class="col-1">
                        <button type="submit" class="btn btn-outline-success" id="display_report">แสดงรายงาน</button>
                      </div>
                    </div><hr>
                    <!--<div id="chart_div"></div>-->
                  </div>
                  <div class="col-md-12 text-center">
                    <div id="result_table"></div>
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
