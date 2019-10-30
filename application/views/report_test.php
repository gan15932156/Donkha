
<script type="text/javascript">
  $(document).ready(function(){
    var table;
    var open_money;
    $("table#data_table tfoot").css({ 
      'background-color': '#99c0ff',
      'border' : '1px solid black',
      'color' : 'black',
      'font-size': '16px',
      
    });
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
        table = $('#data_table').DataTable({
      columnDefs: [
        {targets: [0,1,4],className: 'dt-body-center'},
        {targets: [2,3],className: 'dt-body-left'},
        {targets: [5],className: 'dt-body-right'},
        { orderable: false, targets: '_all' },
      ], 
      "order": [[ 1, 'asc' ]],  
      "lengthChange": false,
      "searching": false,
      "orderable": false,
      pageLength: 3, // 8
      destroy: true,
      serverSide: true,
      processing: true,
      "language": {
        "search":"ค้นหา:",
        "zeroRecords": "ไม่พบข้อมูล",
        "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
        "infoEmpty": "ไม่พบข้อมูล",
        "infoFiltered": "(กรองจาก _MAX_ รายการทั้งหมด)",
        "paginate": {
          "first":      "หน้าแรก",
          "last":       "หน้าสุดท้าย",
          "next":       "ถัดไป",
          "previous":   "ก่อนหน้า"
        },
      },      
      ajax: {
        url:'<?php echo base_url("index.php/Project_controller/fetch_report_open_account/"); ?>'+$("#start_date").val()+"/"+$("#stop_date").val()
      },
      'columns':[
      {
        data:'account_id',
        render: function (data, type, full, counter ){
          return  null;
        }
      },
      {
        data:'account_id',
      },
      {
        data:'account_name',
      },
      {
        data:'member_name',
      },
      {
        data:'account_open_date',
        render: function (data,type,row){

          var dateee = row['account_open_date'];
          var t_year =  parseInt(dateee.substring(0,4))+543;
          var t_month = new Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
          var t_day = Number(dateee.substring(8));
          var th_dateeee = t_day+" "+t_month[parseInt(dateee.substring(5,7))]+" "+t_year;
          return th_dateeee;
        }
      },
      {
        data:'account_id',
        render: function (data, type, full, meta){
          var currentCell = $("#data_table").DataTable().cells({"row":meta.row, "column":meta.col}).nodes(0);
            $.ajax({
                url: '<?=base_url("Project_controller/select_open_account_open_money/");?>' + data,
                processData:false,
                contentType:false,
                cache:false,
                async:false,
                dataType: "JSON",		
            }).done(function (data) {
                console.log(data);
                $(currentCell).text(data.trans_money);
            });
            return null;
        }
      }
    ]
  });
  table.on( 'draw.dt', function () {
        var PageInfo = $('#data_table').DataTable().page.info();
        table.column(0, { page: 'current' }).nodes().each( function (cell, i) {
          cell.innerHTML = i + 1 + PageInfo.start;
        });
    });
      }
    });

  });
</script>
<div class="col-md-12 text-center" ><a href=""></a>
  <div class="row ">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 t">
          <h4 class=""><B>รายงานเปิดบัญชี</B></h4>
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
        <table class="table table-striped table-hover table-sm" id="data_table" style="width:100%;">
          <thead class="thead-light table-bordered text-center">
            <tr>
              <th width="2%" scope="col">ลำดับ</th>
              <th width="15%" scope="col">หมายเลขบัญชี</th>
              <th width="22%" scope="col">ชื่อบัญชี</th>
              <th width="25%" scope="col">ชื่อ - นามสกุล</th>					
              <th width="20%" scope="col">วัน-เดือน-ปี ที่เปิด</th>
              <th width="20%" scope="col">จำนวนเงินที่เปิดบัญชี</th>
            </tr>
          </thead>
          <tbody class="table-bordered" style="font-size:16px;">
          </tbody>
          <tfoot class="tf">
            <tr>
                <th scope="col" class="text-center" colspan="5">จำนวนที่เปิด</th>
                <th scope="col" class="text-right" id="sum_open_account" colspan="1"></th>
            </tr>
          </tfoot>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>
