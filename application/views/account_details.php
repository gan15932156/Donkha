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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
  <script src="https://twitter.github.io/typeahead.js/js/handlebars.js"></script>
  <script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>
  
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
    .schooller{
      height:250px;
      overflow:auto;
    }
    thead tr:nth-child(1) th{
      position: sticky;
      top: 0;
      z-index: 10;
    } 
  </style>
  <script type="text/javascript">
    
    function logout(){
      location.replace("<?php  echo base_url()."Project_controller/logout"; ?>");
    }
    $(document).ready(function(){
      $("#filter").change(function(){
        $.ajax({
          url:"<?php echo base_url("index.php/Project_controller/filter_transaction_table"); ?>",
          method:"POST",
          data:{
                'filter':$(this).val(),
                'accoint_id':$("#ac_id").val(),
              },
          success:function(data){
            $('#result_table').html(data);
            $('#data_table').remove();
          }
        })        
      });
      $("#print").click(function(){
        $.ajax({
          url:"<?php echo base_url("index.php/Project_controller/print_report_statement"); ?>",
          method:"POST",
          xhrFields: {
            responseType: "blob"
          },
          data:{
                filter:$("#filter").val(),
                account_id:$("#ac_id").val()
                },
          success:function(response)
          { 
            url = window.URL.createObjectURL(response);
            window.open(url, '_blank');
          }
        })
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
        <div class="row" style="margin-right:1px ;background-color: #EFFEFD;">
          <div class="col-md-12 text-center" >
            <div class="row text-center">
              <div class="col-md-12">
                <div  class="row">
                  <div class="col-md-12 ">
                    <h4 class="text-center"><B>บัญชีธนาคาร</B></h4>
                     <div class="row">
                    <?php 
                      foreach($account->result() as $row){ 
                    ?>
                        <div class="form-group col-6"><label><B>หมายเลขบัญชี : </B><?php echo $row->account_id; ?></label>
                          <input type="hidden" name="ac_id" id="ac_id" value="<?php echo $row->account_id; ?>">
                        </div>
                        <div class="form-group col-6"><label><B>ชื่อบัญชี : </B><?php echo $row->account_name; ?></label>
                        </div>                       
                  </div>  
                  </div>
                  <div class="col-md-12 "><hr>        
                <h4 class="text-center"><B>รายละเอียดการฝาก - ถอน - โอน</B></h4><br>
                   
                  </div>
                  <div class="col-md-12 text-center">
                    <div class="row">                                      
                    <div class="form-group col-2">
                      <label><B>การแสดงผล</B></label>
                    </div>
                    <div class="form-group col-2">
                      <select  id="filter" name="filter" class="form-control" >
                        <option value="all">ทั้งหมด</option>
                        <option value="deposit">รายการฝาก</option>
                        <option value="withdraw">รายการถอน</option>
                        <option value="tranfer">รายการโอน</option>
                      </select>
                    </div> 
                    <div class="form-group col-2">
                      <label style="width: 120px"><B>ยอดเงินคงเหลือ</B></label>
                    </div>
                    <div class="form-group col-2" align="left">   
                      <label><?php echo number_format($row->account_balance,2); ?> บาท</label>
                    </div> 
                    <div class="form-group col-4">
                       <a href="<?=base_url("index.php/Project_controller/manage_account");?>" class="btn btn-warning">ย้อนกลับ</a>
                      <button class="btn btn-success" id="print">พิมพ์รายงาน</button> 
                    </div>     
                  <?php  }  ?>          
                  </div>
                </div>
                <div class="form-group col-12 schooller">
                  <div id="result_table"></div>
                  <table class="table table-striped table-hover table-sm" id="data_table">
                    <thead   class="thead-light table-bordered">
                      <tr >
                        <th width="5%" scope="col">ลำดับ</th>
                        <th width="30%" scope="col">วันที่</th>
                        <th width="10%" scope="col">รายการ</th>
                        <th width="10%" scope="col">จำนวนเงิน</th>
                        <th width="10%" scope="col">คงเหลือ</th>
                        <th width="35%" scope="col">พนักงานที่ทำรายการ</th>
                      </tr>
                    </thead>
                    <tbody class="table-bordered">
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
                        foreach($account_detail->result() as $row){ ?>
                      <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td><?php echo DateThai($row->record_date)." ".$row->record_time; ?></td>
                        <td><?php
                          if($row->action == "deposit"){echo "<span class='text-success'>ฝาก</span>";}
                          elseif($row->action == "withdraw"){echo "<span class='text-danger'>ถอน</span>";}
                          elseif($row->action == "add_interest"){echo "<span class='text-success'>เพิ่มดอกเบี้ย</span>";}
                          else{
                            echo "<span class='text-danger'>โอน</span>";
                          }
                          ?>     
                        </td>
                        <td align="right"><?php
                          if($row->action == "deposit"){echo "<span class='text-success'>+".number_format($row->trans_money,2)."</span>";}
                          elseif($row->action == "withdraw"){echo  "<span class='text-danger'>-".number_format($row->trans_money,2)."</span>";}
                          elseif($row->action == "add_interest"){echo  "<span class='text-success'>+".number_format($row->trans_money,2)."</span>";}
                          else{echo  "<span class='text-danger'>-".number_format($row->trans_money,2)."</span>";}
                          ?>  
                        </td>
                        <td align="right"><?php
                          echo number_format($row->account_detail_balance,2);
                          ?> 
                        </td>
                        <td><?php echo $row->staff_title."".$row->staff_name; ?></td>
                      </tr>
                      <?php $i++; }  ?>  
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


