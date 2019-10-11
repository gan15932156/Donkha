<style type="text/css">
  .table-responsive{
    height:65vh;
    overflow:auto;
  }
  thead tr:nth-child(1) th{
    position: sticky;
    top: 0;
    z-index: 10;
  }
</style>
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
          url: "<?php echo site_url();?>/Project_controller/fetch_report_close_account",
          method:"POST",
          data:{
            start_date:$("#start_date").val(),
            stop_date:$("#stop_date").val()
          },
          success:function(response){
            if(response == false){alert("ไม่พบรายการ");}
            else{$('.table-responsive').html(response);}
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
<div class="col-md-12 text-center" ><a href=""></a>
  <div class="row ">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 t">
          <h4 class=""><B>รายงานปิดบัญชี</B></h4>
          <div class="row">
            <div class="col-2">
              <label>ค้นหาวันที่</label>
            </div>
            <div class="col-3">
              <input autofocus type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="col-2">
              <label >ถึงวันที่</label>
            </div>
            <div class="col-3">
              <input type="date" class="form-control" id="stop_date" name="stop_date" max="<?=date('Y-m-d');?>" required>
            </div>
            <div class="col-1">
              <button type="submit" class="btn btn-outline-success " id="display_report">แสดงรายงาน</button>
            </div>
          </div><hr>
          <!--<div id="chart_div"></div>-->
        </div>
        <div class="col-md-12 text-center">
          <div class="table-responsive"></div>
        </div>
      </div>
    </div>
  </div>
</div>
