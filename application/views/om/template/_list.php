<SCRIPT LANGUAGE='JavaScript'>
	var table;
	//jquery
	$(document).ready(function() {

		// var crud = '<?= $crud ?>';
		// listCrud(crud);
		//datatables
		table = $('#table').DataTable({
			"searching": false,
			"lengthChange": false,
			'processing': true, //Feature control the processing indicator.
			'serverSide': true, //Feature control DataTables' server-side processing mode.
			'order': [], //Initial no order.
			"columns": [
				<?php foreach ($label_setting as $k => $row) {
					echo '{ "width": "' . $row['width'] . '"';
					echo (isset($row['align'])) ? ',align:"' . $row['align'] . '"' : '';
					echo '},';
				} ?> {
					"width": "1%"
				},
			],

			// Load data for the table's content from an Ajax source
			'ajax': {
				'url': '<?php echo site_url('om/' . $modul . '/ajax_list') ?>',
				'type': 'POST',
				'data': function(data) {
					<?php foreach ($label as $k => $row) {
						echo 'data.' . $k . ' = $("#' . $k . '").val();';
					} ?>

				}
			},

			//Set column definition initialisation properties.
			'columnDefs': [{
				'defaultContent': '-',
				'targets': '_all',
			}, ],

		});

		$('select,input').change(function() { //button filter event click
			table.ajax.reload(); //just reload table
		});
		$('#btn-reset').click(function() { //button reset event click
			<?php foreach ($label as $k => $row) {
				echo '$("#' . $k . '").val("");';
			} ?>
			table.ajax.reload(); //just reload table
		});
	});


	function deleteData(kode) {
		if (confirm('Anda Yakin Hapus Data ' + kode)) {

			var url = '<?= base_url() .'/om/'. $modul ?>/delete'; // the script where you handle the form input.
			var isi;

			$.ajax({
				type: 'POST',
				url: url,
				data: {
					kode: kode
				}, // serializes the form's elements.
				success: function(data) {
					if (data == 1) {
						isi = 'Data Berhasil Dihapus';
					} else if (data == 0) {

						isi = 'Data Gagal Dihapus';
						alert(isi);
						return false;

					} else {
						isi = data;
						alert(isi);
						return false;
					}

					alert(isi);
					table.ajax.reload(); //just reload table

				}
			});
		}
		return false; // avoid to execute the actual submit of the form.
	}
</SCRIPT>

<div class="content-wrapper">

	<section class="content wow ">
		<div class="row main-content">
			<div class="col-sm-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">

							<span class='fa fa-print'></span>
							<?= $title ?>
							<?php if ($subtitle) { ?> <small><?= $subtitle ?></small> <?php } ?>
						</h3>
						<div class="pull-right"><?php echo linkToAdd(base_url()."om/".$modul."/form/0");?></div>
					</div>
					<div class="box-body">
						<form id='form-filter' class='form-horizontal'>
							<?php $this->load->view($isi, $data) ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>