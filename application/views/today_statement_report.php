<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/helper.js"></script> 
<script type="text/javascript">
  $(document).ready(function(){
    var table = $('#data_table').DataTable({
        drawCallback:function(settings)
        { 
          var sum_dep = parseFloat(settings.json.sum_dep); 
          var sum_wd = parseFloat(settings.json.sum_wd); 
          var sum_dep_limit = parseFloat(settings.json.sum_dep_limit); 
          var sum_wd_limit = parseFloat(settings.json.sum_wd_limit); 
          $('#sum_wd').html(formatNumber(sum_wd_limit.toFixed(2))+"(ทั้งหมด "+formatNumber(sum_wd.toFixed(2))+")");
          $('#sum_dep').html(formatNumber(sum_dep_limit.toFixed(2))+"(ทั้งหมด "+formatNumber(sum_dep.toFixed(2))+")");
        },
      columnDefs: [
        {targets: [0,1],className: 'dt-body-center'},
        {targets: [2],className: 'dt-body-left'},
        {targets: [3,4],className: 'dt-body-right'},
        { orderable: false, targets: '_all' },
      ],   
      "order": [[ 1, 'asc' ]],  
      "lengthChange": false,
      "searching": false,
      "orderable": false,
      pageLength: 8,
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
        url:'<?php echo base_url("index.php/Project_controller/select_today_statement/"); ?>'
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
        data:'trans_money',
        render: function(data, type, row){
          var balance = parseFloat(row['trans_money']);     
          if(row['action'] =='deposit' || row['action'] =='open_account'){
		    	  return formatNumber(balance.toFixed(2));
		      }
          else if(row['action'] =='withdraw' || row['action'] =='close_account'){
            return null;
          }                           
        }
      },
      {
        data:'trans_money',
        render: function(data, type, row){
            var balance = parseFloat(row['trans_money']);     
            if(row['action'] =='deposit' || row['action'] =='open_account'){
              return null;
            }
            else if(row['action'] =='withdraw' || row['action'] =='close_account'){
              return formatNumber(balance.toFixed(2));
            }                  
        }
      }
    ]
  });
    table.on( 'draw.dt', function () {
        var PageInfo = $('#data_table').DataTable().page.info();
        table.column(0, { page: 'current' }).nodes().each( function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        } );
    } );
    $("table#data_table tfoot").css({ 
      'background-color': '#99c0ff',
      'border' : '20px solid black',
      'color' : 'black',
      'font-size': '16px',
      
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
          <h5 class="text-center"><B>รายงานทะเบียนเงินสด ประจำวัน</B></h5>
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
      <div class="form-group col-1"></div>
      <div class="form-group col-10">
        <div id="result_table"></div>
        <table class="table table-striped table-hover table-sm" id="data_table" style="width:100%;">
          <thead class="thead-light table-bordered text-center">
            <tr>
              <th width="5%" scope="col">ลำดับ</th>
              <th width="15%" scope="col">เลขที่บัญชี</th>
              <th width="20%" scope="col">ชื่อบัญชี</th>
              <th width="30%" scope="col">ฝาก(บาท)</th>
              <th width="30%" scope="col">ถอน(บาท)</th>
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
      </div>  
      <div class="form-group col-1"></div>                                   
    </div>
  </div>                   
</div>        