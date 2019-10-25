<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/helper.js"></script> 
<script type="text/javascript">
  var table_account_detal;
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
          $('.rexposne').empty();
          $('.rexposne').html(data);
          
          $('#tranfer_modal').modal('show');
          var filterVal = 'blur(3px)';
            $('#exampleModal')
              .css('filter',filterVal)
              .css('webkitFilter',filterVal)
              .css('mozFilter',filterVal)
              .css('oFilter',filterVal)
              .css('msFilter',filterVal);
        }
      })
    }
  }
  function onload_datatable(url){
    table_account_detal = $('#data_table_modal').DataTable({
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
  function show_modal_datatable(account_id){
    $.ajax({
		  url: "<?=base_url("Project_controller/get_account_details_modal/");?>",
		  type:"post",
      data:{account_id:account_id},
      dataType: "JSON",		
      error: function(){ alert("error"); }
      })
      .done(function(data){
        /*$.each(data, function (key, acc) {
            alert(acc.account_id);
        })*/
        var tran_money = parseFloat(data.account_balance);  
        $("#modal_title_ac_code").text(data.account_id);
        $("#modal_title_ac_name").text("ชื่อบัญชี "+data.account_name);
        $("#modal_title_ac_balance").text("จำนวนเงินคงเหลือ "+formatNumber(tran_money.toFixed(2))+" บาท");

        $(".tbody_modal").empty();
        $('#filter option:first').prop('selected',true);
        $('#previous option:first').prop('selected',true);

        onload_datatable('<?php echo base_url("index.php/Project_controller/filter_previous_account_detail_datatable/"); ?>'+account_id+"/"+$("#filter").val()+"/"+$("#previous").val());
      });
    $('#exampleModal').modal('show');
  } 
  $(document).ready(function(){  
    var table = $('#data_table').DataTable({
      columnDefs: [
        {targets: [0,2],className: 'dt-body-center'}
      ],
      pageLength: 8,
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
      "lengthChange": false,
      ajax: {
        url:'<?php echo base_url("index.php/Project_controller/fetch_account_datatable"); ?>'
      },
      'columns':[
      {
        data:'account_id'
      },
      {
        data:'account_name',
        render: function(data,type,row){       
          return '<a href="#" onclick="show_modal_datatable('+row['account_id']+')"  >'+row['account_name']+'</a>';
        }
      },
      {
        data:'account_status',
        render: function (data,type,row){
          var active = '<span class="text-success">ใช้งาน</span>';
          var inactive = '<span class="text-danger">ยกเลิก</span>';
          var status = (data==1) ? active : inactive;
          return status;
        }
      }
      ]
    });
    $('[id="print_report"]').click(function(){
        $.ajax({
        url:"<?php echo base_url("index.php/Project_controller/print_report_statement"); ?>",
        method:"POST",
        xhrFields: {
          responseType: "blob"
        },
        data:{
          previous:$('[id="previous"]').val(),
          filter:$('[id="filter"]').val(),
          account_id:$('[id="modal_title_ac_code"]').text()
        },
        success:function(response)
        { 
          url = window.URL.createObjectURL(response);
          window.open(url, '_blank');
        }
      })
    });
    $("#filter").change(function(){
      $(".tbody_modal").empty();
      onload_datatable('<?php echo base_url("index.php/Project_controller/filter_previous_account_detail_datatable/"); ?>'+$("#modal_title_ac_code").text()+"/"+$("#filter").val()+"/"+$("#previous").val());
    });
    $("#previous").change(function(){
      $(".tbody_modal").empty();
      onload_datatable('<?php echo base_url("index.php/Project_controller/filter_previous_account_detail_datatable/"); ?>'+$("#modal_title_ac_code").text()+"/"+$("#filter").val()+"/"+$("#previous").val());
    });
    $('#data_table_modal tbody').on( 'click', 'tr', function () {
      var data = table_account_detal.row( this ).data();
      onmouseover_foo(data.account_detail_id,data.action);
    });
    $('#data_table_modal tbody').on( 'mouseover', 'tr', function () {
      var data = table_account_detal.row( this ).data();
      if(data.action == "recive_money" || data.action == "tranfer_money"){
        $(this).css("cursor","pointer");
      }    
    });
    $("#tranfer_modal_btn").click(function(){
      var filterVal = 'blur(0px)';
        $('#exampleModal')
          .css('filter',filterVal)
          .css('webkitFilter',filterVal)
          .css('mozFilter',filterVal)
          .css('oFilter',filterVal)
          .css('msFilter',filterVal);
    });
    
  });
</script>
<div class="col-md-12">
  <div class="row">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 ">
          <h4 class="text-center"><B>รายงานบัญชี</B></h4>
        </div>             
      <div class="col-md-12">
        <div id="result_search"></div>
          <table class="table table-striped table-hover table-sm" id="data_table" style="width:100%;">
            <thead class="thead-light table-bordered text-center">
              <tr>
                <th width="20%" scope="col">หมายเลขบัญชี</th>
                <th width="30%" scope="col">ชื่อบัญชี</th>
                <th width="10%" scope="col">สถานะ</th>
              </tr>
            </thead>
            <tbody class="table-bordered" style="background-color: #EFFEFD">
            </tbody>
          </table>                    
        </div>
      </div>
    </div>
  </div>
</div>


<style>
    .modal_dialog_account_detail {max-height:100vh;max-width:80vw;}  
    .modal_body_account_detail{height:70vh;width:100%;align:center;}  
    .modal_container_account_detail{background-color:white;}    

    .modal_dialog_trafer {max-height:100vh;max-width:150vh;}  
    .modal_body_tranfer{height:100%;width:100%;align:center;}  
    .modal_container_tranfer{background-color:white;}    
</style>

<!-- Modal -->
<div align="center" class="modal fade" id="exampleModal">
  <div class="modal-dialog modal_dialog_account_detail" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">บัญชีธนาคาร</h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <h5 class="modal-title" >หมายเลชบัญชี</h5>&nbsp;&nbsp;
        <h5 class="modal-title" id="modal_title_ac_code"></h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <h5 class="modal-title" id="modal_title_ac_name"></h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <h5 class="modal-title" id="modal_title_ac_balance"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body modal_body_account_detail">
        <div class="container-fluid body-container modal_container_account_detail">       
            <div class="row"> 
                <div class="col-md-12">
                  <div class="result"></div>
                  <div class="row">
                    <div class="form-group col-2"></div>
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
                    <div class="form-group col-2"></div>
                    <div class="form-group col-12">
                    <table class="table table-striped table-hover table-sm" id="data_table_modal" style="width:100%;">
                      <thead class="thead-light table-bordered text-center">
                        <tr>
                          <th width="15%" scope="col">วันที่</th>
                          <th width="10%" scope="col">รายการ</th>
                          <th width="15%" scope="col">จำนวนเงิน(บาท)</th>
                          <th width="15%" scope="col">คงเหลือ(บาท)</th>
                          <th width="25%" scope="col">พนักงานที่ทำรายการ</th>
                        </tr>
                      </thead>
                      <tbody class="table-bordered tbody_modal" style="font-size:16px;">
                      </tbody>
                    </table>
                    </div>
                  </div>
                </div>
              </div> 
            </div>
          </div>
      <div class="modal-footer">
        <button type="button" id="print_report" class="btn btn-warning">พิมพ์รายงาน</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tranfer-Receiver-->
<div align="center" class="modal fade" id="tranfer_modal" name="tranfer_modal" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal_dialog_trafer" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="tranfer_modal_btn" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body modal_body_tranfer">
        <div class="container-fluid body-container modal_container_tranfer">       
            <div class="row">
                <div class="col-md-12">
                    <div class="rexposne"></div>
                </div>
            </div> 
        </div>
    </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>