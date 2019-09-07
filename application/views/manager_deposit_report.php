<script type="text/javascript">
  $(document).ready(function(){
    $("#type").change(function(){
      if($(this).val() == "1"){ //วัน
        $.ajax({
          type: "POST",
          url: "<?php echo site_url();?>/Project_controller/fetch_deposit_year",
          method:"POST",
          data:{
            type:$(this).val()
          },
          success:function(response){
              $('.table-responsiv').empty();
              $('.second').html(response);
          },
          error: function( error ){alert( error );}
        });
      }
      else if($(this).val() == "2"){ //เดือน
        $.ajax({
          type: "POST",
          url: "<?php echo site_url();?>/Project_controller/fetch_deposit_year",
          method:"POST",
          data:{
            type:$(this).val()
          },
          success:function(response){
            $('.table-responsiv').empty();
            $('.second').empty();
            $('.third').empty();
            $('.second').html(response);
          },
          error: function( error ){alert( error );}
        });
      }
      else if($(this).val() == "3"){ //ปี
        $.ajax({
          type: "POST",
          url: "<?php echo site_url();?>/Project_controller/report_deposit_per_year",
          method:"POST",
          data:{
            type:$(this).val()
          },
          success:function(response){
            $('.second').empty();
            $('.third').empty();
            $('.table-responsiv').empty();
            $('.table-responsiv').html(response);
          },
          error: function( error ){alert( error );}
        });
      }
      else{
        $('.table-responsiv').empty();
        $('.second').empty();
        $('.third').empty();
      }
    });   
  });
</script>
<div class="col-md-12 text-center" >
  <div class="row ">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 t">
          <h4><B>รายงานสรุปยอดฝาก</B></h4>
          <div class="row">
            <div class="col-2">
              <label>ประเภทการแสดง :</label>
            </div>
            <div class="col-2">
              <select name="type" id="type" class="form-control">
                <option>เลือกรายการ</option>
                <option value="1">รายวัน</option>
                <option value="2">รายเดือน</option>
                <option value="3">รายปี</option>
              </select>
            </div>
            <div class="col-4 second"></div>
            <div class="col-4 third"></div>
          </div><hr>
          <!--<div id="chart_div"></div>-->
        </div>  
        <div class="col-md-12 text-center">
          <div class="table-responsiv"></div>
        </div>
      </div>
    </div>
  </div>
</div>



