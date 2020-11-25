<script src="<?php echo base_url() ?>assets/js/datepicker/js/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/datepicker/js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo base_url() ?>assets/js/select2/select2.full.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/js/select2/select2.css" />
<SCRIPT LANGUAGE='JavaScript'>
	//jquery
	$(document).ready(function() {

		// var row = '<?= $row_id ?>';
		// var crud = '<?= $crud ?>';
		// formCrud(crud, row);
		$('.datepicker').datetimepicker({
			format: "DD-MM-YYYY",
			useCurrent: false
		});
		$('.select2').select2();
		$(".rupiah").autoNumeric('init', {aSep: '.',              
			aDec: ','}); 
		$(".rupiah").attr('style','text-align:right;width:200px');
		$('#cancel').click(function() {
			window.location = '<?= base_url() . $modul ?>';
		});
		$('#btnSave').click(function() {

			var url = '<?= base_url() . 'om/' . $modul ?>/form_action'; // the script where you handle the form input.
			var isi;
			var isvalidate = $("form")[0].checkValidity();
			if (isvalidate) {
				$.ajax({
					type: 'POST',
					url: url,
					data: $('#main_form').serialize(), // serializes the form's elements.
					success: function(data) {
						if (data == 1) {
							isi = 'Perubahan berhasil dilakukan.';
						} else if (data == 0) {

							isi = 'Perubahan Gagal dilakukan.';
							alert(isi);
							return false;

						} else {
							isi = data;
							alert(isi);
							return false;
						}

						alert(isi);
						// location.reload();
						//getData();
						window.location = '<?= base_url() . 'om/' . $modul ?>';

					}
				});
			} else {
				$("form")[0].reportValidity();
			}

			return false; // avoid to execute the actual submit of the form.
		});


	});
</SCRIPT>
<form id='isi'>
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
							<div class="pull-right"><?php echo linkToBack(base_url() . "om/" . $modul); ?></div>
						</div>
						<div class="box-body">
							<?php $this->load->view($isi, $data) ?>
						</div>
						<div class='box-footer'>
							<div class="row">
								<div class="col-sm-6">
									<input type='hidden' name='row_id' value='<?php echo $row_id ?>'>
									<div class="form-group">
										<label class="col-sm-4 control-label"></label>
										<div class="col-sm-8">
											<?php
											echo (!isset($data['readonly'])) ? linkToSave() : ''; ?>
											<?php echo linkToReload(); ?>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</form>