<table class="table" style="width:80%">
	<tr>
		<td colspan="5">
			<div class="alert alert-success">
				Preparation
			</div>
		</td>
	</tr>
	<tr>
		<td style="width:150px">Permintaan IH</td>
		<td style="text-align:right">Nomor </td>
		<td  width="100px" class="col-md-2"><input type="text" name="PERMINTAAN_IH_NOMOR" id="PERMINTAAN_IH_NOMOR" class="form-control" value="<?= $prep->permintaan_ih_nomor ?>"></td>
		<td style="text-align:right">Tanggal </td>
		<td  width="100px" class="col-md-2"><input name="PERMINTAAN_IH_TGL" id="PERMINTAAN_IH_TGL" class="form-control datepicker" value="<?= $prep->permintaan_ih_tgl ?>"></td>
	</tr>
	<tr>
		<td>Informasi Harga</td>
		<td style="text-align:right">Nomor </td>
		<td><input name="INFORMASI_HARGA_NOMOR" id="INFORMASI_HARGA_NOMOR" class="form-control" value="<?= $prep->informasi_harga_nomor ?>"></td>
		<td style="text-align:right">Tanggal </td>
		<td><input name="INFORMASI_HARGA_TGL" id="INFORMASI_HARGA_TGL" class="form-control datepicker" value="<?= $prep->informasi_harga_tgl ?>"></td>
	</tr>
	<tr>
		<td>Kesepakatan Harga</td>
		<td style="text-align:right">Nomor </td>
		<td><input name="KESEPAKATAN_HARGA_NOMOR" id="KESEPAKATAN_HARGA_NOMOR" class="form-control" value="<?= $prep->kesepakatan_harga_nomor ?>"></td>
		<td style="text-align:right">Tanggal </td>
		<td><input name="KESEPAKATAN_HARGA_TGL" id="KESEPAKATAN_HARGA_TGL" class="form-control datepicker" value="<?= $prep->kesepakatan_harga_tgl ?>"></td>
	</tr>
	<tr>
		<td></td>
		<td style="text-align:right">Nilai </td>
		<td colspan="3"><input name="KESEPAKATAN_HARGA_NILAI" id="KESEPAKATAN_HARGA_NILAI" class="form-control rupiah" value="<?= $prep->kesepakatan_harga_nilai ?>"><small>(inc VAT)</small></td>
	</tr>
	<tr>
		<td>RAB Rendal</td>
		<td style="text-align:right">Tanggal </td>
		<td><input name="RAB_RENDAL_TGL" id="RAB_RENDAL_TGL" class="form-control datepicker" value="<?= $prep->rab_rendal_tgl ?>"></td>
		<td style="text-align:right">Nilai </td>
		<td><input name="RAB_RENDAL_NILAI" id="RAB_RENDAL_NILAI" class="form-control rupiah" value="<?= $prep->rab_rendal_nilai ?>"><small>(inc VAT)</small></td>
	</tr>
	<tr>
		<td>RAB Komersial / HPP</td>
		<td style="text-align:right"></td>
		<td><input name="RAB_KOMERSIAL" id="RAB_KOMERSIAL" class="form-control rupiah" value="<?= $prep->rab_komersial ?>"><small>(inc VAT)</small></td>
		<td style="text-align:right">Pricing</td>
		<td><input name="PRICING" id="PRICING" class="form-control rupiah" value="<?= $prep->pricing ?>"><small>(inc VAT)</small></td>
	</tr>
	<tr>
		
	</tr>
	<tr>
		<td>Analisa L/R</td>
		<td style="text-align:right">NPM</td>
		<td><input name="ANALISA_LR_NPM" id="ANALISA_LR_NPM" class="form-control" value="<?= $prep->analisa_lr_npm ?>"><small>%</small></td>
		<td style="text-align:right">GPM</td>
		<td><input name="ANALISA_LR_GPM" id="ANALISA_LR_GPM" class="form-control" value="<?= $prep->analisa_lr_gpm ?>"><small>%</small></td>
	</tr>
	<tr>
		<td colspan="5">
			<button type="button" class="btn-save btn btn-sm btn-success pull-right" onclick="savePreparation()"><span class="glyphicon glyphicon-floppy-save"></span> Save</button>
		</td>
	</tr>
</table>
<script type="text/javascript">
	function savePreparation() {
		var PRICING = $("#PRICING").val();
		var RAB_KOMERSIAL = $("#RAB_KOMERSIAL").val();
		var PERMINTAAN_IH_NOMOR = $("#PERMINTAAN_IH_NOMOR").val();
		var PERMINTAAN_IH_TGL = $("#PERMINTAAN_IH_TGL").val();
		var INFORMASI_HARGA_NOMOR = $("#INFORMASI_HARGA_NOMOR").val();
		var INFORMASI_HARGA_TGL = $("#INFORMASI_HARGA_TGL").val();
		var KESEPAKATAN_HARGA_NOMOR = $("#KESEPAKATAN_HARGA_NOMOR").val();
		var KESEPAKATAN_HARGA_TGL = $("#KESEPAKATAN_HARGA_TGL").val();
		var KESEPAKATAN_HARGA_NILAI = $("#KESEPAKATAN_HARGA_NILAI").val();
		var RAB_RENDAL_TGL = $("#RAB_RENDAL_TGL").val();
		var RAB_RENDAL_NILAI = $("#RAB_RENDAL_NILAI").val();
		var ANALISA_LR_NPM = $("#ANALISA_LR_NPM").val();
		var ANALISA_LR_GPM = $("#ANALISA_LR_GPM").val();
		var KONTRAKPROYEK_ID = <?= $this->uri->segment(4) ?>;

		$.ajax({
			type:'POST',
			url:"<?= base_url('om/mon_settelment_proyek/save_preparation') ?>",
			data:{
				PRICING : PRICING,
				RAB_KOMERSIAL : RAB_KOMERSIAL,
				PERMINTAAN_IH_NOMOR : PERMINTAAN_IH_NOMOR,
				PERMINTAAN_IH_TGL : PERMINTAAN_IH_TGL,
				INFORMASI_HARGA_NOMOR : INFORMASI_HARGA_NOMOR,
				INFORMASI_HARGA_TGL : INFORMASI_HARGA_TGL,
				KESEPAKATAN_HARGA_NOMOR : KESEPAKATAN_HARGA_NOMOR,
				KESEPAKATAN_HARGA_TGL : KESEPAKATAN_HARGA_TGL,
				KESEPAKATAN_HARGA_NILAI : KESEPAKATAN_HARGA_NILAI,
				RAB_RENDAL_TGL : RAB_RENDAL_TGL,
				RAB_RENDAL_NILAI : RAB_RENDAL_NILAI,
				ANALISA_LR_NPM : ANALISA_LR_NPM,
				ANALISA_LR_GPM : ANALISA_LR_GPM,
				KONTRAKPROYEK_ID : KONTRAKPROYEK_ID,
			},
			success:function(e){
				alert(e)
			}
		})
	}
</script>