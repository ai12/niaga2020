<div class="col-sm-12">

<?php 
$prefix = $row['WORK_ORDER_PREFIX'] ? $row['WORK_ORDER_PREFIX'] : 20;
$from = UI::createTextBox('WORK_ORDER_PREFIX',$prefix,'2','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["WORK_ORDER_PREFIX"], "WORK_ORDER_PREFIX", "Work Order Prefix");

$prefix = $row['PROJECT_NUMBER'] ? $row['PROJECT_NUMBER'] : '20DN3M91' ;
$from = UI::createTextBox('PROJECT_NUMBER',$prefix,'2','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["PROJECT_NUMBER"], "PROJECT_NUMBER", "Project Number");

echo '<div class="form-group">
	<label for="work_order" class="col-sm-4 control-label">
		Work Order
	</label>
	<div class="col-sm-8"><input autocomplete="off" type="text" name="work_order" id="work_order" class="form-control " maxlength="10" size="100" style="width:100%">
	<small><a href="#" id="session_wo">click here to view list wo number</a></small>
	</div>
</div>';

// $from = UI::createTextBox('work_order',$row['work_order'],'10','100',$edited,'form-control ',"style='width:100%'");
// echo UI::createFormGroup($from, $rules["work_order"], "work_order", "Work Order");
?>

<?php 
$from = UI::createTextBox('work_order_description',$row['work_order_description'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["work_order_description"], "work_order_description", "WO Description");
?>

<?php 
$from = UI::createSelect('user_status',$userStatus,$row['user_status'],$edited,'form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["user_status"], "user_status", "User Status");

$from = UI::createSelect('work_order_type',$woType,$row['work_order_type'],$edited,'form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["work_order_type"], "work_order_type", "WO Type");


$from = UI::createSelect('maintenance_type',$mType,$row['maintenance_type'],$edited,'form-control ',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, $rules["maintenance_type"], "maintenance_type", "Maintenance Type");

?>

<?php 
$from = UI::createTextBox('work_group',$row['work_group'],'200','100',$edited,'form-control ',"style='width:100%'");
echo UI::createFormGroup($from, $rules["work_group"], "work_group", "Work Group");

$from = UI::createTextBox('account_code',$row['account_code'],'200','100',$edited,'form-control ',"readonly='true', style='background-color:#eee'");
echo UI::createFormGroup($from, $rules["account_code"], "account_code", "Account Code");

$from = UI::createSelect("s1",$s1,$row['s1'],$edited,'form-control accode',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, null, "s1", "Segment 1");

$from = UI::createSelect("s2",$s2,$row['s2'],$edited,'form-control accode',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, null, "s2", "Segment 2");

$from = UI::createSelect("s3",$s3,$row['s3'],$edited,'form-control accode',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, null, "s3", "Segment 3");

$from = UI::createSelect("s4",$s4,$row['s4'],$edited,'form-control accode',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, null, "s4", "Segment 4");

$from = UI::createSelect("s5",$s5,$row['s5'],$edited,'form-control accode',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, null, "s5", "Segment 5");

$from = UI::createSelect("s6",$s6,$row['s6'],$edited,'form-control accode',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, null, "s6", "Segment 6");

$from = UI::createSelect("s7",$s7,$row['s7'],$edited,'form-control accode',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, null, "s7", "Segment 7");

$from = UI::createSelect("s8",$ee,$row['s8'],$edited,'form-control accode',"style='width:auto; max-width:100%;'");
echo UI::createFormGroup($from, null, "s8", "Expresive Element ");

$from = UI::createTextBox('originator',$_SESSION['SESSION_APP_EBISNIS']['username'],'200','100',$edited,'form-control ',"readonly='true', style='background-color:#eee'");
echo UI::createFormGroup($from, null, "originator", "Originator");

$from = UI::createTextBox('raised_date',$row['raised_date'],'11','11',$edited,'form-control datetimepicker ',"style='text-align:right; width:100%'");
echo UI::createFormGroup($from, $rules["raised_date"], "raised_date", "Raised Date");
?>

</div>
<div class="col-sm-12">
				

<?php 
$from = UI::showButtonMode("save", null, $edited);
echo UI::createFormGroup($from, null, null, null, true);
?>
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