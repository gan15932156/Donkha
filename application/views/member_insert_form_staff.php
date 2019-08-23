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
    .scroller{
      height:500px;
      overflow:auto;
    }                       
  </style>
  <script type="text/javascript">
    function readURL_profile(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#show_image_pic').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    function readURL_singa(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#show_image_signa').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    $(document).ready(function()
    {
      $("#id_card").blur(function()
      {
        var pid = $(this).val();
        pid = pid.toString().replace(/\D/g,'');
        if(pid.length == 13)
        {
          var sum = 0;
          for(var i = 0; i < pid.length-1; i++)
          {
            sum += Number(pid.charAt(i))*(pid.length-i);
          }
          var last_digit = (11 - sum % 11) % 10;    
          if(pid.charAt(12) != last_digit)
          {
            $("#id_card").val("กรอกไม่ถูกต้อง");
          }
        }
        else
        {
          $("#id_card").val('กรอกไม่ครบ');
        }
      });
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      function check_std_code(query){
        $.ajax({
          url:"<?php echo base_url("index.php/Project_controller/check_std_code_member"); ?>",
          method:"POST",
          data:{query:query},
          success:function(data){
            $('#result_std_code').html(data);
          }
        })
      }
      function check_username(username){
        $.ajax({
          url:"<?php echo base_url("index.php/Project_controller/check_username"); ?>",
          method:"POST",
          data:{username:username},
          success:function(data){
            $('#result_username').html(data);
          }
        })
      }
      $("#std_code").change(function(){
        var stu_code = $(this).val();
        check_std_code(stu_code);  
      });
      $("#username").change(function(){
        var username = $(this).val();
        check_username(username);  
      });
      $('#PROVINCE_ID').change(function(){
        var prov_id=$(this).val();
        $.ajax({
          url:'<?=base_url("index.php/Project_controller/getAmphur/")?>',
          method:'post',
          data:{prov_id: prov_id},
          dataType:'json',
          success: function(response)
          {
            $('#AMPHUR_ID').find('option').not(':first').remove();
            $.each(response,function(index,data)
            {
              $('#AMPHUR_ID').append('<option value="'+data['AMPHUR_ID']+'">'+data['AMPHUR_NAME']+'</option>');
            });
          }
        });
      });
      $('#AMPHUR_ID').change(function(){
        var amp_id=$(this).val();
        $.ajax({
          url:'<?=base_url("index.php/Project_controller/getDist/")?>',
          method:'post',
          data:{amp_id: amp_id},
          dataType:'json',
          success: function(response)
          {       
            $('#DISTRICT_CODE').find('option').not(':first').remove();
            $.each(response,function(index,data)
            {
              $('#DISTRICT_CODE').append('<option value="'+data['DISTRICT_CODE']+'">'+data['DISTRICT_NAME']+'</option>');
            });
          }
        });
      });
      $('#DISTRICT_CODE').change(function(){
        var dist_id=$(this).val();
        if(dist_id != '')
        {
          $.ajax({
            url:"<?=base_url()?>index.php/Project_controller/getZip/",
            method:"POST",
            data:{dist_id:dist_id},
            success:function(data)
            {
              $('#zipcode').val(data);
            }
          });
        }
        else
        {
          $('#zipcode').val('asdasd');
        }
      }); 
      $('#member_form').hide();
      $('#career').change(function(){
        var career = $(this).val();
        if(career == 'นักเรียน'){
          $('#member_form').show();
          $('#career').remove();
          $('#job').val("นักเรียน");
          $('#job option[value=2]').attr('selected','selected');
          $('#job').prop("disabled", true);
        }
        else{
          $('#member_form').show();
          $('#career').remove();
          $('#std_code').val("0");
          $('#std_code').prop('readonly', true);
          $("#edu_level").val("");
          $('#edu_level').prop('disabled', true);
          $('#job option[value=2]').remove();
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
                <div  class="row scroller">
                  <div class="col-md-12 ">
                    <h4 class="text-center"><B>ฟอร์มเพิ่มสมาชิก</B></h4>
                  </div>
                  <div class="col-md-12 ">
                    <div class="row">
                      <div class="col-4"></div>
                      <div class="col-4">
                        <select class="form-control" id="career" name="career">
                          <option >เลือกสถานภาพ</option>
                          <option value="นักเรียน">นักเรียน</option>
                          <option value="บุคลากร">บุคลากร</option>
                        </select>
                      </div>
                      <div class="col-4"></div>
                    </div>
                  </div>                      

                  <div class="col-md-12 text-center">
            <form  method="post" action="<?=base_url("index.php/Project_controller/member_insert_staff");?>" enctype="multipart/form-data" name="member_form" id="member_form">
              <div class="row">
                <div class="form-group col-4" align="center">
                  <img id="show_image_pic" width="120px" height= "140px" src="<?php  echo base_url()."picture/No_person.jpg"; ?>" alt="your image" style="border: solid 1px #c0c0c0;" /> 
                  <figcaption>รูปประจำตัว</figcaption>
                  <input onchange="readURL_profile(this);" type="file" class="form-control " name="pic_member" id="pic_member" required=""><br>
                  <img id="show_image_signa" width="120px" height= "140px" src="<?php  echo base_url()."picture/blague-Monsieur-et-Madame-27-300x300.jpg"; ?>" alt="your image" style="border: solid 1px #c0c0c0;" /> 
                  <figcaption>รูปลายเซ็น</figcaption>
                  <input onchange="readURL_singa(this);" type="file" class="form-control " name="pic_singna" id="pic_singna" required="">                                                  
                </div>  
                <div class="form-group col-8" align="left">
                  <div class="row">
                    <div class="col-12">
                      <div class="row">
                        <div class="form-group col-3"><label for="name">รหัสนักเรียน</label></div>
                        <div class="form-group col-4">
                          <input type="text" class="form-control " id="std_code" name="std_code" placeholder="รหัสนักเรียน" required="" onKeyUp="if(this.value*1!=this.value){ alert('กรุณากรอกเฉพาะตัวเลข'); this.value='';}">
                          <div id="result_std_code"></div>
                        </div>
                        <div class="form-group col-3">
                          <label for="name">คำนำหน้า</label>
                        </div>
                        <div class="form-group col-2">
                          <select  id="title" name="title" class="form-control">
                            <option value="ด.ช.">ด.ช.</option>
                            <option value="ด.ญ.">ด.ญ.</option>
                            <option value="นาย">นาย</option>
                            <option value="น.ส.">น.ส.</option>
                            <option value="นาง">นาง</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-3">
                          <label for="name">ชื่อ-นามสกุล</label>
                        </div>
                        <div class="form-group col-4">
                          <input type="text" class="form-control " id="name" name="name" required="" placeholder="ชื่อ นามสกุล">
                        </div>
                        <div class="form-group col-md-3">
                          <label for="name">ระดับการศึกษา</label>
                        </div>
                        <div class="form-group col-md-2"> 
                          <select  id="edu_level" name="edu_level" class="form-control" >
                            <?php 
                            foreach ($edu_level->result() as $row) {
                            ?>
                            <option value="<?php echo $row->edu_id; ?>"><?php echo $row->edu_name; ?></option><?php } ?>
                          </select>
                        </div>
                      </div> 
                      <div class="row">
                        <div class="form-group col-md-3">
                          <label for="name">เลขบัตรประชาชน</label>
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control " name="id_card" id="id_card" required="" placeholder="เลขบัตรประชาชน">
                        </div>
                        <div class="form-group col-md-2">
                          <label for="name">ตำแหน่ง</label>
                        </div> 
                        <div class="form-group col-md-3">
                          <select  id="permiss" name="permiss" class="form-control" >
                          <?php 
                            foreach ($permiss->result() as $row) {
                          ?>
                            <option value="<?php echo $row->level_id; ?>"><?php echo $row->level_name; ?></option>  
                          <?php } ?>
                          </select>
                        </div>
                      </div>  
                      <div class="row">
                        <div class="form-group col-md-3">
                          <label >วัน/เดือน/ปีเกิด</label>
                        </div>   
                        <div class="form-group col-md-4">
                          <input type="date" class="form-control " name="b_date" id="b_date" required="">
                        </div> 
                        <div class="form-group col-md-2">
                          <label style="width:100px;">เบอร์โทรศัพท์</label>
                        </div>   
                        <div class="form-group col-md-3">
                          <input type="text" class="form-control " name="phone_number" id="phone_number" required="" placeholder="เช่น 09xxxxxxxx">
                        </div>                                          
                      </div>
                      <div class="row">
                        <div class="form-group col-md-2">
                          <label for="name">ที่อยู่</label>
                        </div>   
                        <div class="form-group col-md-5">
                          <input type="text" class="form-control " name="address" id="address" required="" placeholder="บ้านเลขที่ หมู่ ถนน ซอย">
                        </div> 
                        <div class="form-group col-md-2">
                          <label for="name">อาชีพ</label>
                        </div>   
                        <div class="form-group col-md-3">
                          <select class="form-control"  name="job" id="job">
                          <?php 
                            foreach ($job->result() as $row) {
                          ?>
                            <option value="<?php echo $row->job_id; ?>"><?php echo $row->job_name; ?></option>
                          <?php } ?>
                          </select>
                        </div>                                          
                      </div>
                      <div class="row">
                        <div class="form-group col-md-2">
                          <label for="name">จังหวัด</label>
                        </div>  
                        <div class="form-group col-md-4">
                          <select  id="PROVINCE_ID" name="PROVINCE_ID" class="form-control" >
                            <option value="">เลือกจังหวัด</option>
                          <?php 
                            foreach ($province->result() as $row) {
                          ?>
                            <option value="<?php echo $row->PROVINCE_ID; ?>"><?php echo $row->PROVINCE_NAME; ?></option>  
                          <?php } ?>
                          </select>
                        </div>
                        <div class="form-group col-md-2">
                          <label for="name">อำเภอ</label>
                        </div>
                        <div class="form-group col-md-4">
                          <select  id="AMPHUR_ID" name="AMPHUR_ID" class="form-control" ></select>
                        </div>                                         
                      </div> 
                      <div class="row">
                        <div class="form-group col-md-2">
                          <label for="name">ตำบล</label>
                        </div>
                      <div class="form-group col-md-4">
                        <select  id="DISTRICT_CODE" name="DISTRICT_CODE" class="form-control"></select>
                      </div>
                      <div class="form-group col-md-2">
                        <label style="width:100px;" for="name">รหัสไปรษณีย์</label>
                      </div>
                      <div class="form-group col-md-4">
                        <input type="text" class="form-control " name="zipcode" id="zipcode">
                      </div>    
                    </div>
                    <div class="row">
                      <div class="form-group col-md-2">
                       <label for="name">ชื่อผู้ใช้</label>
                      </div>  
                      <div class="form-group col-md-4">
                        <input type="text" class="form-control " name="username" id="username" required="" placeholder="ชื่อผู้ใช้">
                        <div id="result_username"></div>
                      </div> 
                      <div class="form-group col-md-2">
                        <label  for="name">รหัสผ่าน</label>
                      </div> 
                      <div class="form-group col-md-4">
                        <input type="password" class="form-control " name="password" id="password" required="" placeholder="รหัสผ่าน">
                      </div>   
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group col-12" align="left">
                <div class="row">
                  <div class="form-group col-md-12 text-center">
                    <a href="<?=base_url("index.php/Project_controller/manage_member_staff");?>" class="btn btn-outline-success">ย้อนกลับ</a>
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

