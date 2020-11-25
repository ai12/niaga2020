<table class="table">
	<tr>
		<td colspan="2">
			<div class="alert alert-success">
				Finishing 
			</div>
		</td>
	</tr>
	<tr>
		<td width="50%">
			<table class="table">
				<thead>
					<tr>
						<th>Jenis BA</th>
						<th>Nomor</th>
						<th>Tanggal</th>
						<th>Lampiran</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="result-finishing-list">
				<?php foreach ($finishing_detail as $r) : ?>
					<tr id="<?= $r->id ?>">
						<td><?=$r->jenis_finishing?></td>
						<td><?=$r->nomor_finishing?></td>
						<td><?=$r->tanggal_finishing?></td>
						<td><a href="<?= base_url('uploads/finishing'); ?>/<?=$r->lampiran_finishing?>" target="_blank">Open</a></td>
						<td>
							<a class="btn btn-xs btn-danger" onclick="deleteFinishingDetailClick('<?=$r->id?>')">Del</a>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
				<tfoot>
					<tr>
						<td class="col-md-3"><input id="JENIS_FINISHING" name="JENIS_FINISHING" class="form-control"></td>
						<td class="col-md-3"><input id="NOMOR_FINISHING" name="NOMOR_FINISHING" class="form-control"></td>
						<td class="col-md-2"><input id="TANGGAL_FINISHING" name="TANGGAL_FINISHING" class="form-control datepicker"></td>
						<td class="col-md-2"><input type="file" id="LAMPIRAN_FINISHING" name="LAMPIRAN_FINISHING" class="form-control"></td>
						<td class="col-md-2"><button type="button" class="btn-save btn btn-sm btn-success pull-right" onclick="saveFinishingList()"><span class="glyphicon glyphicon-floppy-save"></span> </button></td>
					</tr>
				</tfoot>
			</table>
		</td>
		<td>
			<table class="table">
				<tr>
					<td>Tanggal Dibayar</td>
					<td><input id="TANGGAL_DIBAYAR" name="TANGGAL_DIBAYAR" class="form-control datepicker" value="<?= $finishing->tanggal_dibayar ?>"></td>
					<td></td>
				</tr>
				<tr>
					<td>Evaluasi Pekerjaan</td>
					<td><textarea rows="3" name="EVALUASI_PEKERJAAN" id="EVALUASI_PEKERJAAN" class="form-control"><?= $finishing->evaluasi_pekerjaan ?></textarea></td>
					<td><button type="button" class="btn-save btn btn-sm btn-success pull-right" onclick="saveFinishing()"><span class="glyphicon glyphicon-floppy-save"></span> Save</button></td>
				</tr>			
			</table>
		</td>
	</tr>
	
</table>
<script type="text/javascript">
	function saveFinishingList() {
		var fd = new FormData();
        var files = $('#LAMPIRAN_FINISHING')[0].files[0];
        fd.append('LAMPIRAN_FINISHING',files);
        fd.append('JENIS_FINISHING',$("#JENIS_FINISHING").val());
        fd.append('NOMOR_FINISHING',$("#NOMOR_FINISHING").val());
        fd.append('TANGGAL_FINISHING',$("#TANGGAL_FINISHING").val());
        fd.append('KONTRAK_PROYEK_ID',<?= $this->uri->segment(4) ?>);
		
		$.ajax({
			type:'POST',
			url:"<?= base_url('om/mon_settelment_proyek/save_finishing_list') ?>",
			data:fd,
			contentType: false,
            processData: false,
			success:function(e){
				var r =eval("("+e+")");
				if(r.status)
				{
					var JENIS_FINISHING = r.jenis_finishing;
					var NOMOR_FINISHING = r.nomor_finishing;
					var TANGGAL_FINISHING = r.tanggal_finishing;
					var LAMPIRAN_FINISHING = "<a href='<?= base_url('uploads/finishing') ?>/"+r.lampiran_finishing+"' target='_blank'>Open</a>";
					var DELETEBTN = "<a class='btn btn-xs btn-danger' onclick=\"deleteFinishingDetailClick('"+r.id+"')\">Del</a>";
					$("#result-finishing-list").append("<tr id='"+r.id+"'><td>"+JENIS_FINISHING+"</td><td>"+NOMOR_FINISHING+"</td><td>"+TANGGAL_FINISHING+"</td><td>"+LAMPIRAN_FINISHING+"</td><td>"+DELETEBTN+"</td></tr>");
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
	function saveFinishing() {
		var TANGGAL_DIBAYAR = $("#TANGGAL_DIBAYAR").val();
		var EVALUASI_PEKERJAAN = $("#EVALUASI_PEKERJAAN").val();
		var KONTRAKPROYEK_ID = <?= $this->uri->segment(4) ?>;
		
		$.ajax({
			type:'POST',
			url:"<?= base_url('om/mon_settelment_proyek/save_finishing') ?>",
			data:{
				TANGGAL_DIBAYAR : TANGGAL_DIBAYAR,
				EVALUASI_PEKERJAAN : EVALUASI_PEKERJAAN,
				KONTRAKPROYEK_ID : KONTRAKPROYEK_ID,
				
			},
			success:function(e){
				alert(e)
			},
			error:function(e){
				alert('Terjadi Kesalahan, harap ulangi kembali')
			}
		})
	}
	function deleteFinishingDetailClick(id) {
		if(confirm('Anda yakin akan menghapus data ini?'))
		{
			$.ajax({
				url:"<?= base_url('om/mon_settelment_proyek/delete_finishing_detail') ?>/"+id,
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