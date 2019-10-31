<script type="text/javascript" src="<?php  echo base_url();?>bootstrap000/Project_js/check_information.js"></script> 
<script type="text/javascript">
  $(document).ready(function(){
    var table = $('#data_table').DataTable({
      columnDefs: [
        {targets: [1],className: 'dt-body-center'}
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
        url:'<?php echo base_url("index.php/Project_controller/fetch_member_datatable"); ?>'
      },
      'columns':[
      {
        data:'member_name',
        render: function(data,type,row){       
            return '<a href="#" onclick="show_modal('+row['member_id']+')"  >'+row['member_name']+'</a>';
        }
      },
      {
        data:'member_status',
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
        url:"<?php echo base_url("index.php/Project_controller/print_member_report"); ?>",
        method:"POST",
        xhrFields: {
          responseType: "blob"
        },
        data:{
              member_id:$('[id="member_id_hidden"]').val(),
              },
        success:function(response)
        { 
          url = window.URL.createObjectURL(response);
          window.open(url, '_blank');
        }
      })
    });
  });
  function show_modal(member_id){
    $.ajax({
      url:"<?=base_url()?>index.php/Project_controller/get_member_detail_modal/",
      method:"POST",
      data:{member_id:member_id},
      success:function(data)
      {
        $('.result').html(data);
        $('#exampleModal').modal('show');
      }
    }); 
  }
</script>      
<div class="col-md-12">
  <div class="row">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 ">
          <h4 class="text-center"><B>รายงานสมาชิก</B></h4>
        </div>       
        <div class="col-md-12 ">
          <div id="result_search"></div>
          <table class="table table-striped table-hover table-sm " id="data_table">
            <thead class="thead-light table-bordered text-center">
              <tr>
                <th width="20%" scope="col">ชื่อ-นามสกุล</th>
                <th width="30%" scope="col">สถานะ</th>
              </tr>
            </thead>
            <tbody class="table-bordered" style="background-color: #EFFEFD"></tbody>
          </table>
        </div>
      </div>
    </div>                   
  </div>        
</div> 

<style>
    .modal-dialog {max-height:80vh;max-width:80vw;}  
    .modal-body{height:70vh;width:100%;align:center;}  
    .body-container{background-color:white;}    
</style>

<!-- Modal -->
<div align="center" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">รายละเอียดสมาชิก</h5>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิดหน้าต่าง</button>
        <!--<button type="button" id="print_report" class="btn btn-warning">พิมพ์รายงาน</button>-->
      </div>
    </div>
  </div>
</div>
