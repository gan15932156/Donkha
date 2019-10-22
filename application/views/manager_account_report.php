<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/helper.js"></script> 
<script type="text/javascript">
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
              filter:$('[id="filter"]').val(),
              account_id:$('[id="ac_id"]').val()
              },
        success:function(response)
        { 
          url = window.URL.createObjectURL(response);
          window.open(url, '_blank');
        }
      })
    });
  });
  function show_modal_datatable(account_id){
    $.ajax({
		    url: "<?=base_url("Project_controller/get_account_details_modal/");?>",
		    type:"post",
        data:{account_id:account_id},
        dataType: "JSON",		
        error: function(){ alert("error"); }
        }).done(function(data){
          /*$.each(data, function (key, acc) {
              alert(acc.account_id);
          })*/
          var tran_money = parseFloat(data.account_balance);  
          $("#modal_title_ac_code").text("หมายเลชบัญชี "+data.account_id);
          $("#modal_title_ac_name").text("ชื่อบัญชี "+data.account_name);
          $("#modal_title_ac_balance").text("จำนวนเงินคงเหลือ "+formatNumber(tran_money.toFixed(2))+" บาท");
        });
   /* $.ajax({
      url:"<?=base_url()?>index.php/Project_controller/get_account_details_modal/",
      method:"POST",
      data:{account_id:account_id},
      dataType: "JSON",
      error: function(){ alert("error"); }
      })
    .done(function(data){
            
      $("#modal_title_ac_code").val(data.account_id);
    });*/
    $('#exampleModal').modal('show');
  }
  
</script>
<div class="col-md-12">
  <div class="row">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 ">
          <h4 class="text-center"><B>รายงานบัญชี</B></h4>
        </div>             
      <div class="col-md-12">
      <!-- Button trigger modal -->
        <!--  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          Launch demo modal
        </button>-->
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
    .modal-dialog {max-height:100vh;max-width:85vw;}  
    .modal-body{height:100%;width:100%;align:center;}  
    .body-container{background-color:white;}    
</style>
<!-- Modal -->
<div align="center" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">บัญชีธนาคาร</h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <h5 class="modal-title" id="modal_title_ac_code"></h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <h5 class="modal-title" id="modal_title_ac_name"></h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <h5 class="modal-title" id="modal_title_ac_balance"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid body-container">       
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
            </div>
          </div>
      <div class="modal-footer">
        <button type="button" id="print_report" class="btn btn-warning">พิมพ์รายงาน</button>
      </div>
    </div>
  </div>
</div>