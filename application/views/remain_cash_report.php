<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/helper.js"></script>
<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/cal_remain_cash.js"></script>  
<script type="text/javascript">
  $(document).ready(function(){
    $("#remain_form").submit(function(event) {
      event.preventDefault();
        $.ajax({
		    url: "<?=base_url("Project_controller/remain_print/");?>",
		    type:"POST",
        data:new FormData($(this)[0]),
        processData: false,
        contentType: false,
        xhrFields: {
          responseType: "blob"
        },	
        success:function(response)
        { 
          url = window.URL.createObjectURL(response);
          window.open(url, '_blank');
        }
      })
    });
    /*$("#print").click(function(){
      $.ajax({  
        url:"<?php echo base_url("index.php/Project_controller/print_today_statement"); ?>",
        method:"POST",
        xhrFields: {
          responseType: "blob"
        },
        data:{
          filter:$("#filter").val(),
          previous:$("#previous").val(),
          account_id:$("#ac_id").val()
        },
        success:function(response)
        { 
          url = window.URL.createObjectURL(response);
          window.open(url, '_blank');
        }
      })
    });*/
  });
</script>
<div class="col-md-12 text-center">
  <div class="row text-center">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 "> 
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
          ?>
          <h5 class="text-center"><B>รายงานตรวจนับเงินสดคงเหลือ <b>ประจำวันที่ <?php echo DateThai(date('Y-m-d'));?></b></B></h5>
         
        </div>
        <br><br>
      <div class="form-group col-8">
        <form name="remain_form" id="remain_form">
          <style>
            input{
              text-align: right;
            }
          </style>
          <table class="table table-striped table-hover table-sm" id="data_table" style="width:100%;">
          <thead class="thead-light table-bordered text-center">
              <tr>
              <th width="20%" scope="col">มูลค่าต่อหน่วย</th>
              <th width="15%" scope="col">จำนวนหน่วย</th>
              <th width="20%" scope="col">จำนวนเงิน</th>
              <th width="15%" scope="col">ยอดรวม</th>
              </tr>
          </thead>
          <tbody class="table-bordered" style="font-size:16px;">
            <tr>
              <td align="center">ธนบัตร 1,000</td>
              <td><input placeholder="1,000" min="0" type="number"  id="b1000" name="b1000" required=""></td>
              <td align="right"><input type="number"  id="cal1000" name="cal1000"></td>
              <td align="right"><input type="number"  id="" name=""></td>
            </tr>
            <tr>
              <td align="center">ธนบัตร 500</td>
              <td align="left"><input placeholder="500" min="0" type="number"  id="b500" name="b500" required=""></td>
              <td align="left"><input type="number"  id="cal500" name="cal500"></td>
              <td align="left"><input type="number"  id="" name=""></td>
            </tr>
            <tr>
              <td align="center">ธนบัตร 100</td>
              <td align="left"><input placeholder="100" min="0" type="number"  id="b100" name="b100" required=""></td>
              <td align="left"><input type="number"  id="cal100" name="cal100"></td>
              <td align="left"><input type="number"  id="" name=""></td>
            </tr>
            <tr>
              <td align="center">ธนบัตร 50</td>
              <td align="left"><input placeholder="50" min="0" type="number"  id="b50" name="b50" required=""></td>
              <td align="left"><input type="number"  id="cal50" name="cal50"></td>
              <td align="left"><input type="number"  id="" name=""></td>
            </tr>
            <tr>
              <td align="center">ธนบัตร 20</td>
              <td align="left"><input placeholder="20" min="0" type="number"  id="b20" name="b20" required=""></td>
              <td align="left"><input type="number"  id="cal20" name="cal20"></td>
              <td align="left"><input type="number"  id="" name=""></td>
            </tr>
            <tr>
              <td align="center">เหรียญ 10</td>
              <td align="center"><input placeholder="10" min="0" type="number"  id="c10" name="c10" required=""></td>
              <td align="center"><input type="number"  id="cal10" name="cal10"></td>
              <td align="center"><input type="number"  id="" name=""></td>
            </tr>
            <tr>
              <td align="center">เหรียญ 5</td>
              <td align="center"><input placeholder="5" min="0" type="number"  id="c5" name="c5" required=""></td>
              <td align="center"><input type="number"  id="cal5" name="cal5"></td>
              <td align="center"><input type="number"  id="" name=""></td>
            </tr>
            <tr>
              <td align="center">เหรียญ 2</td>
              <td align="center"><input placeholder="2" min="0" type="number"  id="c2" name="c2" required=""></td>
              <td align="center"><input type="number"  id="cal2" name="cal2"></td>
              <td align="center"><input type="number"  id="" name=""></td>
            </tr>
            <tr>
              <td align="center">เหรียญ 1</td>
              <td align="center"><input placeholder="1" min="0" type="number"  id="c1" name="c1" required=""></td>
              <td align="center"><input type="number"  id="cal1" name="cal1"></td>
              <td align="center"><input type="number"  id="" name=""></td>
            </tr>
            <tr>
              <td align="center">เหรียญ 0.50</td>
              <td align="center"><input placeholder="0.50" min="0" type="number"  id="c0_5" name="c0_5" required=""></td>
              <td align="center"><input type="text"  id="cal0_5" name="cal0_5"></td>
              <td align="center"><input type="number"  id="" name=""></td>
            </tr>
            <tr>
              <td align="center">เหรียญ 0.25</td>
              <td align="center"><input placeholder="0.25" min="0" type="number"  id="c0_25" name="c0_25" required=""></td>
              <td align="center"><input type="text"  id="cal0_25" name="cal0_25"></td>
              <td align="center"><input type="number"  id="" name=""></td>
            </tr>       
          </tbody>
          </table>
      </div>
      <div class="form-group col-4 " align="center">
        <table class="table table-striped table-hover table-sm"  style="width:100%;">
          <tbody class="table-bordered" style="font-size:16px;">
            <tr>
              <th width="70%" scope="col">ยอมรวมธนบัตรและเหรียญ</th>
              <td align="right" width="30%">
                <input style="width:100%;text-align:center;" type="button" value="คำนวณ" id="cal_total" name="cal_total">
                <input style="width:120px;" type="text" id="cash_total">
              </td>
            </tr>
            <tr>
              <th width="70%" scope="col">ยอดตามบัญชี</th>
              <td align="right" width="30%"><input style="width:120px;" type="text" name="account_st_total" id="account_st_total" value="<?php echo $total;?>"></td>
            </tr>
            <tr>
              <th width="70%" scope="col">ผลต่าง</th>
              <td align="right" width="30%"><input style="width:120px;" type="text" name="diff_total" id="diff_total"></td>
            </tr>
          </tbody>
        </table>
        <a href="<?=base_url("index.php/Project_controller/index_staff");?>" class="btn btn-warning">ย้อนกลับ</a>
        <button class="btn btn-primary" type="submit">พิมพ์</button>
      </div>    
      </form>                               
    </div>
  </div>                   
</div>        