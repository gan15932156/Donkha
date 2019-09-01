
<script type="text/javascript">
    function saveData(e,account_detail_id,trand_id,money) {
    if(e.keyCode === 13){
      if (confirm('ยืนยันการบันทึก')) {
        e.preventDefault();
        $.ajax({
          type: "POST",
          url: "<?php echo base_url("index.php/Project_controller/edit_table_confirm_withdraw_money"); ?>",
          data: {  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
              'account_detail_id': account_detail_id,
              'trand_id': trand_id,
              'money' :money,
          },
          success: function(response){
            $('#result').html(response);
          }
        });
      }
    }
  }
  $(document).ready(function(){
    function search_data(data){
      $.ajax({
        url:"<?php echo base_url("index.php/Project_controller/search_data_account"); ?>",
        method:"POST",
        data:{data:data},
        success:function(data){
          $('#result_search').html(data);
        }
      })
    }
    $("#search").keyup(function(){
      var data = $(this).val();
      search_data(data);
      $( "#data_table" ).remove();
    });
  });
</script>
<div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 ">
          <h4 class="text-center"><B>ยืนยันรายการถอน</B></h4>
        </div>
        <div class="col-md-12 text-center ">
          <div id="result_search"></div>
          <table class="table table-striped table-hover text-center table-sm" id="data_table" >
            <thead class="thead-light table-bordered">
              <tr>
                <th scope="col">ลำดับ</th>
                <th scope="col">หมายเลขถอนเงิน</th>
                <th scope="col">เลขที่บัญชี</th>
                <th scope="col">ชื่อบัญชี</th>
                <th scope="col">จำนวนเงิน(บาท)</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody class="table-bordered" style="background-color: #EFFEFD">
              <?php $i=1;  foreach($unconfirm_withdraw->result() as $row){ ?>
                <tr>
                  <th scope="row"><?php echo $i; ?></th>
                  <td><?php echo $row->trans_id; ?></td>
                  <td><?php echo $row->account_id; ?></td>
                  <td><?php echo $row->account_name; ?></td>
                  <td title="ดับเบิ้ลคลิกเพื่อแก้ไขและกดปุ่ม Enter เพื่อบันทึก" ondblclick="this.contentEditable=true;" onblur="this.contentEditable=false;" onkeypress="saveData(event,'<?php echo $row->account_detail_id; ?>','<?php echo $row->trans_id; ?>',$(this).html() )"><?php echo number_format($row->trans_money,2); ?></td>
                  <td>
                    <a onclick="return confirm('ยืนยันรายการหรือไม่');" href="<?php  echo base_url('Project_controller/confirm_withdraw/'.$row->account_detail_id); ?>" >ยืนยันรายการ</a>
                  </td><div id="result"></div>
                </tr>
              <?php $i++; }  ?>
            </tbody>
            <tfoot>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
