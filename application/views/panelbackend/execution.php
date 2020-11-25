<table class="table">
	<tr>
		<td colspan="2">
			<div class="alert alert-success">
				Execution
			</div>
		</td>
	</tr>
	<tr>
		<td width="65%">
			<table class="table">
				<tr>
					<td>Kontrak</td>
					<td style="text-align:right">Nomor </td>
					<td class="col-md-2"><input name="KONTRAK_NOMOR" id="KONTRAK_NOMOR" value="<?= $exe->kontrak_nomor ?>" class="form-control"></td>
					<td style="text-align:right">Tanggal </td>
					<td class="col-md-2"><input name="KONTRAK_TGL" id="KONTRAK_TGL" class="form-control datepicker" value="<?= $exe->kontrak_tgl ?>"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right">Nilai </td>
					<td class="col-md-2"><input name="KONTRAK_NILAI" id="KONTRAK_NILAI" class="form-control rupiah" value="<?= $exe->kontrak_nilai ?>"></td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td colspan="2">Durasi</td>
					<td><input name="DURASI" id="DURASI" class="form-control" value="<?= $exe->durasi ?>"></td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td colspan="5">Tanggal Pelaksanaan</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right">Rencana Mulai </td>
					<td><input name="RENCANA_MULAI" id="RENCANA_MULAI" class="form-control datepicker" value="<?= $exe->rencana_mulai ?>"></td>
					<td style="text-align:right">Aktual Mulai </td>
					<td><input name="AKTUAL_MULAI" id="AKTUAL_MULAI" class="form-control datepicker" value="<?= $exe->akual_mulai ?>"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right">Rencana Selesai </td>
					<td><input name="RENCANA_SELESAI" id="RENCANA_SELESAI" class="form-control datepicker" value="<?= $exe->rencana_selesai ?>"></td>
					<td style="text-align:right">Aktual Selesai </td>
					<td><input name="AKTUAL_SELESAI" id="AKTUAL_SELESAI" class="form-control datepicker" value="<?= $exe->aktual_selesai ?>"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right">Tipe Pekerjaan </td>
					<td><input name="TIPE_PEKERJAAN" id="TIPE_PEKERJAAN" class="form-control" value="<?= $exe->tipe_pekerjaan ?>"></td>
					<td style="text-align:right">No. PRK </td>
					<td><input name="NO_PRK" id="NO_PRK" class="form-control" value="<?= $exe->no_prk ?>"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right">Manajer Proyek </td>
					<td><input name="MANAJER_PROYEK" id="MANAJER_PROYEK" class="form-control" value="<?= $exe->manajer_proyek ?>"></td>
					<td style="text-align:right">Tgl Buka PRK </td>
					<td><input name="TGL_BUKA_PRK" id="TGL_BUKA_PRK" class="form-control datepicker" value="<?= $exe->tgl_buka_prk ?>"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right">Jumlah Personil </td>
					<td><input name="JUMLAH_PERSONIL" id="JUMLAH_PERSONIL" class="form-control" value="<?= $exe->jumlah_personil ?>"></td>
					<td colspan="2"><small>Orang</small></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right">Progress Fisik </td>
					<td><input name="PROGRESS_FISIK" id="PROGRESS_FISIK" class="form-control" value="<?= $exe->progress_fisik ?>"></td>
					<td colspan="2"><small>%</small></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right">Laporan </td>
					<td><input name="LAPORAN" id="LAPORAN" class="form-control" value="<?= $exe->laporan ?>"></td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td colspan="5">
						Kendala dan Tindak Lanjut
						<textarea name="KENDALA_TINDAK_LANJUT" id="KENDALA_TINDAK_LANJUT" class="form-control" rows="3"><?= $exe->kendala_tindak_lanjut ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="5">
						<button type="button" class="btn-save btn btn-sm btn-success pull-right" onclick="saveExecution()"><span class="glyphicon glyphicon-floppy-save"></span> Save</button>
					</td>
				</tr>
			</table>
		</td>
		<td>
			<table class="table">
				<tr bgcolor="#ccceee">
					<td colspan="5" align="center">
						Daftar Pekerjaan Pihak Ketiga
					</td>
				</tr>
				<tr>
					<td colspan="5">
						<table class="table">
							<thead>
							<tr>
								<th>Nama Perusahaan</th>
								<th>Nama Pekerjaan</th>
								<th>Nilai Pekerjaan</th>
								<th></th>
							</tr>
							</thead>
							<tbody id="result-pihak-ketiga">
								<?php foreach ($pihak3 as $r) : ?>
								<tr id="<?= $r->id ?>">
									<td><?=$r->nama_perusahaan?></td>
									<td><?=$r->nama_pekerjaan?></td>
									<td><?=formatRp($r->nilai_pekerjaan)?></td>
									<td>
										<a class="btn btn-xs btn-danger" onclick="deletePihakKetigaClick('<?=$r->id?>')">Del</a>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
							<tfoot>
							<tr>
								<td class="col-md-4"><input id="NAMA_PERUSAHAAN" name="NAMA_PERUSAHAAN" class="form-control"></td>
								<td class="col-md-4"><input id="NAMA_PEKERJAAN" name="NAMA_PEKERJAAN" class="form-control"></td>
								<td class="col-md-2"><input id="NILAI_PEKERJAAN" name="NILAI_PEKERJAAN" class="form-control"></td>
								<td><button type="button" class="btn-save btn btn-sm btn-success pull-right" onclick="savePihakKetiga()"><span class="glyphicon glyphicon-floppy-save"></span> Save</button></td>
							</tr>
							</tfoot>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script type="text/javascript">
	function savePihakKetiga() {
		var NAMA_PERUSAHAAN = $("#NAMA_PERUSAHAAN").val();
		var NAMA_PEKERJAAN = $("#NAMA_PEKERJAAN").val();
		var NILAI_PEKERJAAN = $("#NILAI_PEKERJAAN").val();
		var KONTRAKPROYEK_ID = <?= $this->uri->segment(4) ?>;
		$.ajax({
			type:'POST',
			url:"<?= base_url('om/mon_settelment_proyek/save_pihak_ketiga') ?>",
			data:{
				NAMA_PERUSAHAAN : NAMA_PERUSAHAAN,
				NAMA_PEKERJAAN : NAMA_PEKERJAAN,
				NILAI_PEKERJAAN : NILAI_PEKERJAAN,
				KONTRAKPROYEK_ID : KONTRAKPROYEK_ID
			},
			success:function(e){
				var r =eval("("+e+")");
				if(r.status)
				{
					var NAMA_PERUSAHAAN = r.nama_perusahaan;
					var NAMA_PEKERJAAN = r.nama_pekerjaan;
					var NILAI_PEKERJAAN = r.nilai_pekerjaan;
					var DELETEBTN = "<a class='btn btn-xs btn-danger' onclick=\"deletePihakKetigaClick('"+r.id+"')\">Del</a>";
					$("#result-pihak-ketiga").append("<tr id='"+r.id+"'><td>"+NAMA_PERUSAHAAN+"</td><td>"+NAMA_PEKERJAAN+"</td><td>"+NILAI_PEKERJAAN+"</td><td>"+DELETEBTN+"</td></tr>");
				}
				else
				{
					alert(r.msg)
				}
			},
			error:function(e){
				alert('Terjadi Kesalahan, harap ulangi kembali')
			}
		})
	}
	function saveExecution() {
		var KONTRAK_NOMOR = $("#KONTRAK_NOMOR").val();
		var KONTRAK_TGL = $("#KONTRAK_TGL").val();
		var KONTRAK_NILAI = $("#KONTRAK_NILAI").val();
		var DURASI = $("#DURASI").val();
		var RENCANA_MULAI = $("#RENCANA_MULAI").val();
		var AKTUAL_MULAI = $("#AKTUAL_MULAI").val();
		var RENCANA_SELESAI = $("#RENCANA_SELESAI").val();
		var AKTUAL_SELESAI = $("#AKTUAL_SELESAI").val();
		var TIPE_PEKERJAAN = $("#TIPE_PEKERJAAN").val();
		var MANAJER_PROYEK = $("#MANAJER_PROYEK").val();
		var NO_PRK = $("#NO_PRK").val();
		var JUMLAH_PERSONIL = $("#JUMLAH_PERSONIL").val();
		var PROGRESS_FISIK = $("#PROGRESS_FISIK").val();
		var LAPORAN = $("#LAPORAN").val();
		var TGL_BUKA_PRK = $("#TGL_BUKA_PRK").val();
		var KENDALA_TINDAK_LANJUT = $("#KENDALA_TINDAK_LANJUT").val();
		var KONTRAKPROYEK_ID = <?= $this->uri->segment(4) ?>;
		$.ajax({
			type:'POST',
			url:"<?= base_url('om/mon_settelment_proyek/save_execution') ?>",
			data:{
				KONTRAK_NOMOR : KONTRAK_NOMOR,
				KONTRAK_TGL : KONTRAK_TGL,
				KONTRAK_NILAI : KONTRAK_NILAI,
				DURASI : DURASI,
				RENCANA_MULAI : RENCANA_MULAI,
				AKTUAL_MULAI : AKTUAL_MULAI,
				RENCANA_SELESAI : RENCANA_SELESAI,
				AKTUAL_SELESAI : AKTUAL_SELESAI,
				TIPE_PEKERJAAN : TIPE_PEKERJAAN,
				MANAJER_PROYEK : MANAJER_PROYEK,
				JUMLAH_PERSONIL : JUMLAH_PERSONIL,
				PROGRESS_FISIK : PROGRESS_FISIK,
				LAPORAN : LAPORAN,
				TGL_BUKA_PRK : TGL_BUKA_PRK,
				NO_PRK : NO_PRK,
				KENDALA_TINDAK_LANJUT : KENDALA_TINDAK_LANJUT,
				KONTRAKPROYEK_ID : KONTRAKPROYEK_ID,
			},
			success:function(e){
				alert(e)
			}
		})
	}
	function deletePihakKetigaClick(id) {
		if(confirm('Anda yakin akan menghapus data ini?'))
		{
			$.ajax({
				url:"<?= base_url('om/mon_settelment_proyek/delete_pihak_ketiga') ?>/"+id,
				success:function(e){
					$("#"+e).remove()
				},
				error:function(e){
					alert('Terjadi Kesalahan, harap ulangi kembali')
				}
			})
		}
	}
</script>