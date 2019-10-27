<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/helper.js"></script> 
<script type="text/javascript">
  $(document).ready(function(){
    $("#remain_form").submit(function(event) {
      event.preventDefault();
        $.ajax({
		    url: "<?=base_url("Project_controller/remain_print/");?>",
		    type:"post",
        data:new FormData($(this)[0]),
       /* xhrFields: {
          responseType: "blob"
        },*/
        processData:false,
        contentType:false,
        cache:false,
        async:false,
        dataType: "JSON",		
        error: function(){ alert("error"); }
        }).done(function(data){
            console.log(data);
            /*url = window.URL.createObjectURL(response);
            window.open(url, '_blank');*/
        });
    });
    $("#print").click(function(){
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
    });
  });
</script>
<div class="col-md-12 text-center">
  <div class="row text-center">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 ">
          <h5 class="text-center"><B>รายงานตรวจนับเงินสดคงเหลือ</B></h5>
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
            <span style="font-size:22px;"><b>ประจำวันที่ <?php echo DateThai(date('Y-m-d'));?></b></span>
          </div>                                 
          <div class="form-group col-4">
             <a href="<?=base_url("index.php/Project_controller/index_staff");?>" class="btn btn-warning">ย้อนกลับ</a>
            <button class="btn btn-success" id="print">พิมพ์รายงาน</button> 
          </div>     
        </div>
      </div>
      <div class="form-group col-2"></div>
      <div class="form-group col-8">
        <div id="result_table"></div>
        <form name="remain_form" id="remain_form">
            <table class="table table-striped table-hover table-sm" id="data_table" style="width:100%;">
            <thead class="thead-light table-bordered text-center">
                <tr>
                <th width="20%" scope="col">รายการตรวจนับ</th>
                <th width="12%" scope="col">มูลค่าต่อหน่วย</th>
                <th width="10%" scope="col">จำนวนหน่วย</th>
                <th width="15%" scope="col">จำนวนเงิน</th>
                <th width="15%" scope="col">ยอดรวม</th>
                </tr>
            </thead>
            <tbody class="table-bordered" style="font-size:16px;">
            </tbody>
            <tfoot class="tf">
                <tr>
                    <th scope="col" class="text-center" colspan="3">รวม</th>
                    <th scope="col" class="text-right" id="sum_dep" colspan="1"></th>
                    <th scope="col" class="text-right" id="sum_wd" colspan="1"></th>
                </tr>
            </tfoot>
            </table>
            <button type="submit">asda</button>
        </form>
      </div>  
      <div class="form-group col-2"></div>                                   
    </div>
  </div>                   
</div>        