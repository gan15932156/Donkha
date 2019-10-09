
<script type="text/javascript">
    function saveData(e,account_detail_id,trand_id,money) {
      if(e.keyCode === 13){
        if (confirm('ยืนยันการบันทึก')) {
          e.preventDefault();
          $.ajax({
            type: "POST",
            url: "<?php echo base_url("index.php/Project_controller/edit_table_confirm_tranfer_money"); ?>",
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
  
</script>
<div class="col-md-12 text-center" >
  <div class="row text-center">
    <div class="col-md-12">
      <div  class="row">
        <div class="col-md-12 ">
          <h4 class="text-center"><B>ยืนยันรายการโอน</B></h4>
        </div>
        <div class="col-md-12 text-center ">
          <div id="result_search"></div>
          <table class="table table-striped table-hover text-center table-sm" id="data_table" >
            <thead class="thead-light table-bordered">
              <tr>
               
                <th width="5%" scope="col">ลำดับ</th>
                <th width="15%" scope="col">เลขที่โอนเงิน</th>
                <th width="15%" scope="col">เลขที่บัญชีผู้โอน</th>
                <th width="15%" scope="col">ชื่อบัญชีผู้โอน</th>
                <th width="15%" scope="col">เลขที่บัญชีผู้รับ</th>
                <th scope="col">จำนวนเงิน(บาท)</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody class="table-bordered" style="background-color: #EFFEFD">
              <?php $i=1;  foreach($unconfirm_tdf->result() as $row){ ?>
                <tr>
                  <th scope="row"><?php echo $i; ?></th>
                  <td><?php echo $row->trans_id; ?></td>
                  <td><?php echo $row->account_id; ?></td>
                  <td><?php echo $row->account_name; ?></td>
                  <td><?php echo $row->account_id_tranfer; ?></td>
                  <td title="ดับเบิ้ลคลิกเพื่อแก้ไขและกดปุ่ม Enter เพื่อบันทึก"><?php echo number_format($row->trans_money,2); ?></td>
                  <td>
                    <a onclick="return confirm('ยืนยันรายการหรือไม่');" href="<?php  echo base_url('Project_controller/confirm_tranfer_money/'.$row->account_detail_id)."/".$this->session->userdata('id'); ?>" >ยืนยันรายการ</a>
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
