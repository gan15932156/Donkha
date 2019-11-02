<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/cal_trails_balance.js"></script> 
<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/helper.js"></script> 
<script type="text/javascript">
  $(document).ready(function(){
   $("#trails_form").submit(function(event) {
      event.preventDefault();
      if($("#account_st_total").val() != ''){
        $.ajax({
          url: "<?=base_url("Project_controller/trails_print/");?>",
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
      }
      else{
        alert("ไม่สามารถพิมพ์รายการได้");
      }
    });
  });
</script>
<div class="col-md-12 text-center">
  <div class="row text-center">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 ">
          <h5 class="text-center"><B>รายงานงบทดลอง</B></h5>
        </div>
        
        <div class="col-md-12 text-center">
          <div class="row">    
          <div class="form-group col-4">
          </div> 
          <div class="form-group col-4">
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
            <span style="font-size:18px;"><b>สิ้นสุด ณ <?php echo DateThai(date('Y-m-d'));?></b></span>
          </div>                                 
          <div class="form-group col-4">
          <form id="trails_form" name="trails_form">
             <a href="<?=base_url("index.php/Project_controller/index_staff");?>" class="btn btn-warning">ย้อนกลับ</a>
            
            <button class="btn btn-primary" id="print">พิมพ์รายงาน</button> 
          </div>     
        </div>
      </div>
      <div class="form-group col-1"></div>
      <div class="form-group col-10">
      <style>
        input{
          text-align: right;
          width:200px;
        }
        
      </style>
      <table class="table table-striped table-hover table-sm" id="data_table" style="width:100%;">
         <thead class="thead-light table-bordered text-center">
               <tr>
                  <th  width="15%" scope="col">เลขที่บัญชี</th>            
                  <th  width="35%" scope="col">ลำดับรายการ</th> 
                  <th  width="5%" scope="col"> </th> 
                  <th  width="20%" scope="col">ยอดคงเหลือบัญชีหมวดสินทรัพย์/ค่าใช้จ่าย</th>  
                  <th  width="5%" scope="col"> </th> 
                  <th  width="20%" scope="col">ยอดคงเหลือบัญชีหมวดหนี้สิน/ทุน/รายได้</th>             
               </tr>
            </thead>
          <tbody class="table-bordered" style="font-size:16px;">
            <tr>
               <td align="center">101</td>
               <td align="left">เงินสด</td>
               <td align="left"> </td>
               <td align="right"><input min="0" type="number" step=any id="cash_asset" name="cash_asset" required=""></td>
               <td align="left"> </td>
               <td align="right"><input min="0" type="number" step=any id="cash_capital" name="cash_capital" required=""></td>
            </tr>
            <tr>
               <td align="center">102</td>
               <td align="left">เงินฝากธนาคาร</td>
               <td align="left"> </td>
               <td align="right"><input min="0" type="number" step=any id="bank_cash_asset" name="bank_cash_asset" required=""></td>
               <td align="left"> </td>
               <td align="right"><input min="0" type="number" step=any id="bank_cash_capital" name="bank_cash_capital" required=""></td>
            </tr>
            <tr>
               <td align="center">201</td>
               <td align="left">เงินรับฝากสมาชิก</td>
               <td align="left"> </td>
               <td align="right"><input min="0" type="number" step=any id="deposit_member_asset" name="deposit_member_asset" required=""></td>
               <td align="left"> </td>
               <td align="right"><input min="0" type="number" step=any id="deposit_member_capital" name="deposit_member_capital" required=""></td>
            </tr>
            <tr>
               <td align="center">402</td>
               <td align="left">รายได้ดอกเบี้ยเงินฝากธนาคาร</td>
               <td align="left"> </td>
               <td align="right"><input min="0" type="number" step=any id="bank_interest_asset" name="bank_interest_asset" required=""></td>
               <td align="left"> </td>
               <td align="right"><input min="0" type="number" step=any id="bank_interest_capital" name="bank_interest_capital" required=""></td>
            </tr>
            <tr>
               <td align="center">512</td>
               <td align="left">ค่าดอกเบี้ยเงินฝากสมาชิก</td>
               <td align="left"> </td>
               <td align="right"><input min="0" type="number" step=any id="interest_member_asset" name="interest_member_asset" required=""></td>
               <td align="left"> </td>
               <td align="right"><input min="0" type="number" step=any id="interest_member_capital" name="interest_member_capital" required=""></td>
            </tr>
            
          </tbody>
          <tfoot >
               <tr class="table-info">
                  <th scope="col" class="text-center" colspan="2"> </th>
                  <th scope="col" class="text-right" colspan="1"><span >รวม</span></th>
                  <th scope="col" class="text-right" colspan="1">
                    <input style="text-align:center;" type="button" value="คำนวณ" id="cal_asset" name="cal_asset">
                    <input size="10" step=any style="text-decoration: underline" min="0" type="number" id="sum_asset" name="sum_asset" required="">
                  </th>
                  <th scope="col" class="text-right" colspan="1"><span >รวม</span></th>
                  <th scope="col" class="text-right" colspan="1">
                    <input style="text-align:center;" type="button" value="คำนวณ" id="cal_capital" name="cal_capital">
                    <input size="10" step=any style="text-decoration: underline" min="0" type="number" id="sum_capital" name="sum_capital" required="">
                    </th>
               </tr>
          </tfoot>
        </table>
        </form>
      </div>  
      <div class="form-group col-1"></div>                                   
    </div>
  </div>                   
</div>        