<table id='table' class='table table-striped table-hover'>
	<thead>
		<tr>
			<?php foreach ($label_setting as $k => $row) { ?>
				<td>
					<?php if (!isset($row['value'])) { ?>
						<input type='text' class='form-control' id='<?php echo $k; ?>' placeholder="Search <?php echo $row['label'] ?>..">
				</td>
		<?php } else {
						echo form_dropdown($k, $row['value'], '', 'class="form-control" id="' . $k . '"');
					}
				} ?>
		<td width='10'>
			<button type='button' id='btn-reset' class='btn  btn-xs btn-default'><span class="glyphicon glyphicon-refresh"></span></button>
		</td>
		</tr>
		<tr style='background:#32C2CD;color:white;'>
			<?php foreach ($label_setting as $k => $row) {
			?>
				<th><?php echo $row['label']  ?></th>
			<?php
			} ?>

			<th width='10'></th>
		</tr>

	</thead>
	<tbody id='iBody'>
	</tbody>
</table>