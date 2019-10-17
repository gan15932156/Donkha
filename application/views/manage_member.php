<script type="text/javascript">
  $(document).ready(function(){
    var table = $('#data_table').DataTable({
      columnDefs: [
        {targets: [1,2],className: 'dt-body-center'},
        {targets: [0],className: 'dt-body-left'}
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
          return row['member_title']+""+row['member_name'];
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
      },
      {
        data:'member_id',
        render: function(data, type, row){
          var string =  "ต้องการเปลี่ยนสถานะการใช้งานหรือไม่";
          var divv = ' <div class="dropdown">';
              divv+='<button style="font-size:16px;"><i class="fa fa-cog" aria-hidden="true"></i></button><div>';   
              divv+='<a style="color:black;" href="<?php  echo site_url('Project_controller/member_detail/');?>'+row['member_id']+'"><i class="fa fa-address-book" aria-hidden="true"></i> รายละเอียด</a>';
              divv+='<a style="color:black;" href="<?php  echo site_url('Project_controller/member_update_form/');?>'+row['member_id']+'" ><i class="fa fa-pencil" aria-hidden="true"></i> แก้ไขข้อมูล</a>';
              divv+='<a style="color:black;" id="onclickchangestatus" href="<?php  echo site_url('Project_controller/member_change_status/');?>'+row['member_id']+'" ><i class="fa fa-times" aria-hidden="true"></i> เปลี่ยนสถานะ</a>';
              divv+='</div></div>';                                     
          return divv;
        }
      }
      ]
    });
    $('#data_table tbody ').on('click', '#onclickchangestatus', function () {
      return confirm('ต้องการเปลี่ยนสถานะการใช้งานหรือไม่');
    });  
  });
</script>       
<div class="col-md-12">
  <div class="row">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 ">
          <h4 class="text-center"><B>ข้อมูลสมาชิก</B></h4>
        </div>       
        <div class="col-md-12">
          <div id="result_search"></div>
          <table class="table table-striped table-hover table-sm " id="data_table">
            <thead class="thead-light table-bordered text-center">
              <tr>
                <th width="30%" scope="col">ชื่อ-นามสกุล</th>
                <th width="30%" scope="col">สถานะ</th>
                <th width="10%" scope="col">การกระทำ</th>
              </tr>
            </thead>
            <tbody class="table-bordered" style="background-color: #EFFEFD"></tbody>
          </table>
        </div>
      </div>
    </div>                   
  </div>        
</div>            
