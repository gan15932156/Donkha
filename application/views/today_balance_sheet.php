<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/helper.js"></script> 
<script type="text/javascript">
  $(document).ready(function(){
   $("#balance_form").submit(function(event) {
      event.preventDefault();
      if($("#account_st_total").val() != ''){
        $.ajax({
          url: "<?=base_url("Project_controller/balance_print/");?>",
          type:"POST",
          data:new FormData($(this)[0]),
          processData: false,
          contentType: false,
         /* xhrFields: {
            responseType: "blob"
          },	*/
          success:function(response)
          { 
             alert(response);
          /*  url = window.URL.createObjectURL(response);
            window.open(url, '_blank');*/
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
          <h5 class="text-center"><B>รายงานงบดุล</B></h5>
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
          <form id="balance_form" name="balance_form">
             <a href="<?=base_url("index.php/Project_controller/index_staff");?>" class="btn btn-warning">ย้อนกลับ</a>
            
            <button class="btn btn-primary" id="print">พิมพ์รายงาน</button> 
          </div>     
        </div>
      </div>
      <div class="form-group col-3"></div>
      <div class="form-group col-6">
      <style>
            input{
              text-align: right;
            }
          </style>
      <table class="table table-striped table-hover table-sm" id="data_table" style="width:100%;">
         <thead class="thead-light table-bordered text-center">
            <tr>
              <th colspan="2" width="20%" scope="col">สินทรัพย์</th>            
            </tr>
          </thead>
          <tbody class="table-bordered" style="font-size:16px;">
            <tr>
               <td align="left">เงินสด</td>
               <td align="right"><input min="0" type="number" step=any id="cash" name="cash" required=""></td>
            </tr>
            <tr>
               <td align="left">เงินฝากธนาคาร</td>
               <td align="right"><input min="0" type="number" step=any id="bank_cash" name="bank_cash" required=""></td>
            </tr>
          </tbody>
          <tfoot >
               <tr class="table-info">
                  <th scope="col" class="text-center" colspan="1">รวม</th>
                  <th scope="col" class="text-right" id="sum_asset" colspan="1"><input style="text-decoration: underline" min="0" step=any type="number"  id="b20" name="b20" required=""></th>
               </tr>
          </tfoot>
        </table>

        <br>

        <table class="table table-striped table-hover table-sm" id="data_table" style="width:100%;">
         <thead class="thead-light table-bordered text-center">
               <tr>
                  <th colspan="2" width="20%" scope="col">หนี้สินและทุน</th>            
               </tr>
            </thead>
          <tbody class="table-bordered" style="font-size:16px;">
            <tr>
               <td align="left">เงินรับฝากสมาชิก</td>
               <td align="right"><input min="0" type="number" step=any id="cash_2" name="cash_2" required=""></td>
            </tr>
            <tr>
               <td align="left">กำไรสุทธิ</td>
               <td align="right"><input min="0" type="number" step=any id="bank_cash_2" name="bank_cash_2" required=""></td>
            </tr>
          </tbody>
          <tfoot >
               <tr class="table-info">
                  <th scope="col" class="text-center" colspan="1">รวม</th>
                  <th scope="col" class="text-right" id="sum_capital" colspan="1"><input style="text-decoration: underline" step=any min="0" type="number"  id="b20" name="b20" required=""></th>
               </tr>
          </tfoot>
        </table>
        </form>
      </div>  
      <div class="form-group col-3"></div>                                   
    </div>
  </div>                   
</div>        