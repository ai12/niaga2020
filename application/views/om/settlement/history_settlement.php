<table class="table table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th>Tgl</th>
			<th>Periode</th>
			<th>Unit</th>
			<th><?php echo ($jenis == 1) ? 'Uraian' : 'Tindak Lanjut'; ?></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$i = 1;
		foreach ($settlement as $rs) { ?>
			<tr>
				<td><?php echo $i;$i++;?></td>
				<td><?php echo $rs['created_date']?></td>
				<td><?php echo $rs['periode']?></td>
				<td><?php echo $rs['unit_id']?></td>
				<td><?php echo ($jenis == 1) ? $rs['uraian'] : $rs['tindak_lanjut']; ?></th>
			</tr>
		<?php } ?>
		</thead>
</table>