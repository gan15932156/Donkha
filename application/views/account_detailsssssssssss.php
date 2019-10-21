<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/helper.js"></script> 
<script type="text/javascript">
  var table;
  function logout(){
    location.replace("<?php  echo base_url()."Project_controller/logout"; ?>");
  }
  function onload_datatable(url){
    table = $('#data_table').DataTable({
      columnDefs: [
        {targets: [0,1],className: 'dt-body-center'},
        {targets: [2,3],className: 'dt-body-right'},
        { orderable: false, targets: '_all' }
      ],     
      "searching": false,
      "lengthChange": false,
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
        url:url
      },
      'columns':[
      {
        data:'record_date',
        render: function (data,type,row){
          var dateee = row['record_date'];
          var t_year =  parseInt(dateee.substring(0,4))+543;
          var t_month = new Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
          var t_day = Number(dateee.substring(8));
          var th_dateeee = t_day+" "+t_month[parseInt(dateee.substring(5,7))]+" "+t_year;
          return th_dateeee+" "+row['record_time'];
        }
      },
      {
        data:'action',
        render: function (data,type,row){
          var action;
          if(row['action'] == "deposit"){
            action = "<span class='text-success'>ฝาก</span>";
          }
          else if(row['action'] == "withdraw"){
            action = "<span class='text-danger'>ถอน</span>";
          }
          else if(row['action'] == "open_account"){
            action = "<span class='text-success'>เปิดบัญชี</span>";
          }
          else if(row['action'] == "add_interest"){
            action = "<span class='text-success'>เพิ่มดอกเบี้ย</span>";
          }
          else if(row['action'] == "tranfer_money"){
            action = "<span class='text-danger'>โอน</span>";
          }
          else if(row['action'] == "recive_money"){
            action = "<span class='text-success'>รับเงินโอน</span>";
          }
          else{
            action = "<span class='text-danger'>ปิดบัญชี</span>";
          }               
          return action;
        }
      },
      {
        data:'trans_money',
        render: function (data,type,row){
          var tran_money = parseFloat(row['trans_money']);
          var action;
          if(row['action'] == "deposit"){
            action = "<span class='text-success'>++"+formatNumber(tran_money.toFixed(2))+"</span>";
          }
          else if(row['action'] == "withdraw"){
            action = "<span class='text-danger'>--"+formatNumber(tran_money.toFixed(2))+"</span>";
          }
          else if(row['action'] == "open_account"){
            action = "<span class='text-success'>++"+formatNumber(tran_money.toFixed(2))+"</span>";
          }
          else if(row['action'] == "add_interest"){
            action = "<span class='text-success'>++"+formatNumber(tran_money.toFixed(2))+"</span>";
          }
          else if(row['action'] == "tranfer_money"){
            action = "<span class='text-danger'>--"+formatNumber(tran_money.toFixed(2))+"</span>";
          }
          else if(row['action'] == "recive_money"){
            action = "<span class='text-success'>++"+formatNumber(tran_money.toFixed(2))+"</span>";
          }
          else{
            action = "<span class='text-danger'>--"+formatNumber(tran_money.toFixed(2))+"</span>";
          }  
          return action;
        }
      },
      {
        data:'account_detail_id',
        render: function(data, type, row){
          var balance = parseFloat(row['account_detail_balance']);                       
          return formatNumber(balance.toFixed(2));
        }
      },
      {
        data:'staff_name',
        render: function(data, type, row){                      
          return "<span style='margin-left:10px;'>"+row['staff_title']+""+row['staff_name']+"</span>";
        }
      }
    ]
  });
  }
  function onmouseover_foo(ac,action){
    if(action == "recive_money" || action == "tranfer_money"){
      $.ajax({
        url:"<?php echo base_url("index.php/Project_controller/show_modal_tranfer"); ?>",
        method:"POST",
        data:{
          'account_detail_id':ac,
          'action':action,
        },
        success:function(data){
          $('.result').html(data);
          $('#exampleModal').modal('show');
        }
      })
    }
  }
  $(document).ready(function(){
    onload_datatable('<?php echo base_url("index.php/Project_controller/filter_previous_account_detail_datatable/").$account_id."/"; ?>'+$("#filter").val()+"/"+$("#previous").val());
    /*table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();*/
    $('#data_table tbody').on( 'click', 'tr', function () {
      var data = table.row( this ).data();
      onmouseover_foo(data.account_detail_id,data.action);
    });
    $('#data_table tbody').on( 'mouseover', 'tr', function () {
        var data = table.row( this ).data();
        if(data.action == "recive_money" || data.action == "tranfer_money"){
          $(this).css("cursor","pointer");
        }    
    });
    $("#filter").change(function(){
      $("tbody").empty();
      //alert($(this).val()+" "+$("#previous").val());
      onload_datatable('<?php echo base_url("index.php/Project_controller/filter_previous_account_detail_datatable/").$account_id."/"; ?>'+$(this).val()+"/"+$("#previous").val());
    });
    $("#previous").change(function(){
      $("tbody").empty();
      //alert($("#filter").val()+" "+$(this).val());
      onload_datatable('<?php echo base_url("index.php/Project_controller/filter_previous_account_detail_datatable/").$account_id."/"; ?>'+$("#filter").val()+"/"+$(this).val());
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
          <h5 class="text-center">บัญชีธนาคาร</h5>
          <div class="row">
            <?php 
            foreach($account->result() as $row){ 
            ?>  
            <div class="form-group col-3"><label><B>ชื่อเจ้าของบัญชี : </B><?php echo $row->member_name; ?></label></div>
            <div class="form-group col-3"><label><B>หมายเลขบัญชี : </B><?php echo $row->account_id; ?></label>
                <input type="hidden" name="ac_id" id="ac_id" value="<?php echo $row->account_id; ?>">
            </div>
            <div class="form-group col-3"><label><B>ชื่อบัญชี : </B><?php echo $row->account_name; ?></label></div>                       
            <div class="form-group col-3"><label  ><B>ยอดเงินคงเหลือ </B><?php echo number_format($row->account_balance,2); ?> บาท</label></div>
          </div>  
        </div>
        <div class="col-md-12 text-center">
          <div class="row">                                      
            <div class="form-group col-2"><label><B>การแสดงผล</B></label></div>
            <div class="form-group col-2">
              <select  id="filter" name="filter" class="form-control" >
                <option value="all">ทั้งหมด</option>
                <option value="deposit">รายการฝาก</option>
                <option value="withdraw">รายการถอน</option>
                <option value="tranfer_money">รายการโอน</option>
              </select>
            </div> 
            <div class="form-group col-2"><label><B>ย้อนหลัง</B></label></div>
            <div class="form-group col-2">
              <select  id="previous" name="previous" class="form-control" >
                <option value="3">3 เดือน</option>
                <option value="6">6 เดือน</option>
              </select>
            </div> 
          <div class="form-group col-4">
             <a href="<?=base_url("index.php/Project_controller/manage_account");?>" class="btn btn-warning">ย้อนกลับ</a>
            <button class="btn btn-success" id="print">พิมพ์รายงาน</button> 
          </div>     
        <?php  }  ?>          
        </div>
      </div>
      <div class="form-group col-12">
        <div id="result_table"></div>
        <table class="table table-striped table-hover table-sm" id="data_table" style="width:100%;">
          <thead class="thead-light table-bordered text-center">
            <tr>
              <th width="15%" scope="col">วันที่</th>
              <th width="10%" scope="col">รายการ</th>
              <th width="15%" scope="col">จำนวนเงิน(บาท)</th>
              <th width="15%" scope="col">คงเหลือ(บาท)</th>
              <th width="25%" scope="col">พนักงานที่ทำรายการ</th>
            </tr>
          </thead>
          <tbody class="table-bordered" style="font-size:14px;">
          </tbody>
        </table>
      </div>                                     
    </div>
  </div>                   
</div>        




<style>
    .modal-dialog {max-height:100vh;max-width:150vh;}  
    .modal-body{height:100%;width:100%;align:center;}  
    .body-container{background-color:white;}    
</style>

<!-- Modal -->
<div align="center" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">บัญชีธนาคาร</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid body-container">       
            <div class="row">
                <div class="col-md-12">
                    <div class="result"></div>
                </div>
            </div> 
        </div>
    </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>