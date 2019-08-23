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
  </style>
  <script type="text/javascript">
    function saveData(e,account_detail_id,trand_id,money) {
      if(e.keyCode === 13){
        if (confirm('ยืนยันการบันทึก')) {
          e.preventDefault();
          $.ajax({
            type: "POST",
            url: "<?php echo base_url("index.php/Project_controller/edit_table_confirm_deposit_money"); ?>",
            data: {  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
                'account_detail_id': account_detail_id,
                'trand_id': trand_id,
                'money' :money,
            },
            success: function(response){

              $('#result').html(response);
            }
          });
        }
      }
    }
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
        var data = $(this).val();
        search_data(data);
        $( "#data_table" ).remove();
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
                    <h4 class="text-center"><B>ยืนยันรายการฝาก</B></h4>
                  </div>
                  <div class="col-md-12 text-center ">
                    <div id="result_search"></div>
                    <table class="table table-striped table-hover table-sm" id="data_table" >
                      <thead class="thead-light table-bordered">
                        <tr>
                          <th scope="col">ลำดับ</th>
                          <th scope="col">หมายเลขฝากเงิน</th>
                          <th scope="col">เลขที่บัญชี</th>
                          <th scope="col">ชื่อบัญชี</th>
                          <th scope="col">จำนวนเงิน(บาท)</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody class="table-bordered" style="background-color: #EFFEFD">
                        <?php $i=1;  foreach($unconfirm_deposit->result() as $row){ ?>
                          <tr>
                            <th scope="row"><?php echo $i; ?></th>
                            <td><?php echo $row->trans_id; ?></td>
                            <td><?php echo $row->account_id; ?></td>
                            <td><?php echo $row->account_name; ?></td>
                            <td title="ดับเบิ้ลคลิกเพื่อแก้ไขและกดปุ่ม Enter เพื่อบันทึก" ondblclick="this.contentEditable=true;" onblur="this.contentEditable=false;" onkeypress="saveData(event,'<?php echo $row->account_detail_id; ?>','<?php echo $row->trans_id; ?>',$(this).html() )"><?php echo number_format($row->trans_money,2); ?></td>
                            <td>
                              <a onclick="return confirm('ยืนยันรายการหรือไม่');" href="<?php  echo base_url('Project_controller/confirm_deposit/'.$row->account_detail_id); ?>" >ยืนยันรายการ</a>
                            </td><div id="result"></div>
                          </tr>
                        <?php $i++; }  ?>
                      </tbody>
                      <tfoot>
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
