<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/helper.js"></script> 
<script type="text/javascript">
  $(document).ready(function(){
    var table = $('#data_table').DataTable({
        drawCallback:function(settings)
        {
            console.log(settings.json.recordsFiltered);
            $('#sum_dep').html(settings.json.recordsFiltered);
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
      pageLength: 2,
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
          if(row['action'] =='recive_money' ||
		    	row['action'] =='add_interest' ||
		    	row['action'] =='deposit' ||
		    	row['action'] =='open_account' 
		    ){
		    	return formatNumber(balance.toFixed(2));
		    }
		    else{
		    	return null;
		    }                           
        }
      },
      {
        data:'trans_money',
        render: function(data, type, row){
            var balance = parseFloat(row['trans_money']);     
            if(row['action'] =='recive_money' ||
                    row['action'] =='add_interest' ||
                    row['action'] =='deposit' ||
                    row['action'] =='open_account' 
                ){
                    return null;
                }
                else{
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
  /*  $('#data_table tbody').on( 'click', 'tr', function () {
      var data = table.row( this ).data();
      onmouseover_foo(data.account_detail_id,data.action);
    });
    $('#data_table tbody').on( 'mouseover', 'tr', function () {
        var data = table.row( this ).data();
        if(data.action == "recive_money" || data.action == "tranfer_money"){
          $(this).css("cursor","pointer");
        }    
    });*/
   /* $("#print").click(function(){
      $.ajax({
        url:"<?php echo base_url("index.php/Project_controller/print_report_statement"); ?>",
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
          <h5 class="text-center"><B>รายงานฝาก ถอนประจำวัน</B></h5>
        </div>
        <div class="col-md-12 text-center">
          <div class="row">                                      
          <div class="form-group col-4">
             <a href="<?=base_url("index.php/Project_controller/manage_account");?>" class="btn btn-warning">ย้อนกลับ</a>
            <button class="btn btn-success" id="print">พิมพ์รายงาน</button> 
          </div>     
        </div>
      </div>
      <div class="form-group col-12">
        <div id="result_table"></div>
        <table class="table table-striped table-hover table-sm" id="data_table" style="width:100%;">
          <thead class="thead-light table-bordered text-center">
            <tr>
              <th width="10%" scope="col">ลำดับ</th>
              <th width="15%" scope="col">เลขที่บัญชี</th>
              <th width="20%" scope="col">ชื่อบัญชี</th>
              <th width="12%" scope="col">ฝาก(บาท)</th>
              <th width="12%" scope="col">ถอน(บาท)</th>
            </tr>
          </thead>
          <tbody class="table-bordered" style="font-size:16px;">
          </tbody>
          <tfoot>
            <tr>
                <th class="text-center" colspan="3">รวม</th>
                <th class="text-right" id="sum_dep" colspan="1">123,123.00</th>
                <th class="text-right" id="sum_wd" colspan="1">123,123.00</th>
            </tr>
          </tfoot>
        
        </table>
      </div>                                     
    </div>
  </div>                   
</div>        