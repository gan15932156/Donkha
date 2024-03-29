<style type="text/css">     
.schooller{
  height:50vh;
  overflow:auto;
}
thead tr:nth-child(1) th{
  position: sticky;
  top: 0;
  z-index: 10;
} 
</style>
<script type="text/javascript">
  function logout(){location.replace("<?php  echo base_url()."Project_controller/logout"; ?>");}
  $(document).ready(function(){
    function con_print(account_id){
      $.ajax({
        type: "POST",
        url: "<?php echo site_url();?>/Project_controller/select_con_print",
        method:"POST",
        data:{account_id:account_id},
        success:function(response){
          if(response == false){alert("ไม่พบรายการ");$("#account_id").val("");}
          else{$('#result_table').html(response);}  
        },
        error: function( error ){alert( error );}
      });
    }
    function new_print(account_id){
      $.ajax({
        type: "POST",
        url: "<?php echo site_url();?>/Project_controller/select_new_print",
        method:"POST",
        data:{account_id:account_id},
        success:function(response){
          if(response == false){alert("ไม่พบรายการ");$("#account_id").val("");}
          else{$('#result_table').html(response);}  
        },
        error: function( error ){alert( error );}
      });
    }      
    function search_account(account_id){
      $.ajax({
        type: "POST",
        url: "<?php echo site_url();?>/Project_controller/searchAccount_passbook",
        method:"POST",
        data:{account_id:account_id},
        dataType: "JSON",
        success:function(response){
          if(response == false){alert("ไม่พบบัญชี");$("#account_id").val("");$("#account_name").val("");$('#result_table').hide();}
          else{           
            $.each(response,function(index,data){
              $('#account_id').val(data['account_id']);
              $('#account_name').val(data['account_name']);
            });
          }      
        },
        error: function( error ){alert( error );}
      });
    }
    $("#search_account").click(function(){
      if($("#account_id").val() == ''){alert('กรุณากรอกหมายเลขบัญชี');}
      else{search_account($("#account_id").val());$('#result_table').hide();}     
    });
    $("#con_print").click(function(){
      if($("#account_id").val() == '' && $("#account_name").val() == ''){alert('กรุณากรอกหมายเลขบัญชี');}
      else{con_print($("#account_id").val());$('#result_table').show();}     
    });
    $("#new_print").click(function(){
      if($("#account_id").val() == '' && $("#account_name").val() == ''){alert('กรุณากรอกหมายเลขบัญชี');}
      else{new_print($("#account_id").val());$('#result_table').show();}     
    });
    $("#account_id").autocomplete({
      source: "<?php echo base_url('Project_controller/fetch_account'); ?>",
    }); 
  });
</script>
<div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 ">
          <h4 class="text-center"><B>พิมพ์สมุดคู่ฝาก</B></h4><br>
          <div class="row">
            <div class="col-2">
              <label>หมายเลขบัญชี</label>
            </div>
            <div class="col-3">
              <input placeholder="ชื่อหรือหมายเลขบัญชี" autofocus type="text" class="form-control" id="account_id" name="account_id">
            </div>
            <div class="col-2">
              <button type="submit" class="btn btn-outline-success" id="search_account">ค้นหา</button> 
            </div>
            <div class="col-1">
              <label>ชื่อบัญชี</label>
            </div>
            <div class="col-3">
              <input placeholder="ชื่อบัญชี" autofocus type="text" class="form-control" id="account_name" name="account_name" readonly="">
            </div>
          </div><br>
          <div class="row">
            <div class="col-4" align="right"> <a href="<?=base_url("index.php/Project_controller/index_staff");?>" class="btn btn-warning">ย้อนกลับ</a></div>
            <div class="col-4">
              <button class="btn btn-outline-primary" id="con_print">พิมพ์สมุดต่อ</button> &nbsp;&nbsp;&nbsp;&nbsp;
             <!-- <button class="btn btn-outline-primary" id="new_print">พิมพ์สมุดใหม่</button> -->
            </div>
            <div class="col-4"></div> 
          </div>  
          </div>  
      <div class="form-group col-12">
        <hr><div class="schooller" id="result_table"></div>
      </div>                                     
    </div>
  </div>                   
</div>        