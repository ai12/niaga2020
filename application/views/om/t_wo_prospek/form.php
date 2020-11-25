<div class="row">
	<div class="col-sm-6">
		<?php 
		$disable = $xEdit ? "":"readonly='' style='background-color:#eee'";
		echo '<div class="form-group">
			<label for="work_order" class="col-sm-4 control-label">
				Work Order
			</label>
			<div class="col-sm-8"><input autocomplete="off" value="'.$row['kode_wo'].'" type="text" name="work_order" id="work_order" '.$disable.' class="form-control " maxlength="10" size="100">
			<!-- <small><a href="#" id="session_wo">click here to view list wo number</a></small> -->
			</div>
		</div>';
		//debug($label_setting);
		foreach ($label_setting as $k => $rw) {
			if($rw['label'] != 'Work Order') {
		?>
			<div class="form-group" <?php echo (isset($rw['hidden'])) ? 'style="display:none"' : ''; ?>>
				<label for="id_proposal" class="col-sm-4 control-label"><?php echo $rw['label'] ?> <?php echo ($rw['required'] == true) ? required_sign() : ''; ?></label>
				<div class="col-sm-8">
					<?php $this->load->view('om/template/_form_field', ['k' => $k, 'row' => $row, 'rw' => $rw, 'readonly' => $readonly]); ?>
				</div>
			</div>
		<?php
		} } ?>
		<?php 
			$from = UI::createTextBox('originator',$_SESSION['SESSION_APP_EBISNIS']['username'],'200','100',$xEdit,'form-control ',"readonly='true', style='background-color:#eee'");
			echo UI::createFormGroup($from, null, "originator", "Originator");
		?>
		<?php 
		$from = UI::createTextBox('no_prk',$row['no_prk'],'200','100',$xDetail,'form-control ',"style='width:100%'");
		echo UI::createFormGroup($from, $rules["no_prk"], "no_prk", "No PRK");
		?>
	</div>
	<div class="col-sm-12">
		<?php 
		$edited = ($readonly)?false:true;
		$this->load->view('om/template/_approval', ['id' => $row_id, 'edited' => $edited, 'status'=>$this->Global_model->STATUS_WO]); ?>
	</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Wo List</h4>
      </div>
      <div class="modal-body">
        <table class="table">
        	<thead>
        		<tr>
        			<th>No</th>
	        		<th>WO NO</th>
	        		<th>WO DESC</th>
        		</tr>
        	</thead>
        	<tbody>
        		
        			<?php 
        			$no=1;
        			foreach ($session_wo as $key => $value) {
        				echo "<tr><td>$no</td>";
        				echo "<td>$key</td>";
        				echo "<td>$value</td></tr>";
        				$no++;
        			}
        			?>
        	</tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".accode").change(function(){
			var strJoin = getS(1)+''+getS(2)+''+getS(3)+''+getS(4)+''+getS(5)+''+getS(6)+''+getS(7)+''+getS(8);
			$("#account_code").val(strJoin);
		})

		$("#session_wo").click(function(e){
			$("#myModal").modal('show')
		})
	})
	function getS(arg) {
			return $("#s"+arg).val();
		}
</script>