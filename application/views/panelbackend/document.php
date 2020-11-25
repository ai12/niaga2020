<table class="table">
	<tr>
		<td colspan="2">
			<div class="alert alert-success">
				Dokumen 
			</div>
		</td>
	</tr>
	<tr>
		<td width="50%">
			<table class="table">
				<thead>
					<tr>
						<th>Jenis</th>
						<th>Lampiran</th>
						<th></th>
					</tr>
				</thead>
				<tbody id="result-dokumen-list">
				<?php foreach ($dokumen_detail as $r) : ?>
					<tr id="<?= $r->id ?>">
						<td><?=$r->jenis_dokumen?></td>
						<td><a href="<?= base_url('uploads/dokumen'); ?>/<?=$r->lampiran_dokumen?>" target="_blank">Open</a></td>
						<td>
							<a class="btn btn-xs btn-danger" onclick="deleteDokumenClick('<?=$r->id?>')">Del</a>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
				<tfoot>
					<tr>
						<td class="col-md-3"><input id="JENIS_DOKUMEN" name="JENIS_DOKUMEN" class="form-control"></td>
						<td class="col-md-2"><input type="file" id="LAMPIRAN_DOKUMEN" name="LAMPIRAN_DOKUMEN" class="form-control"></td>
						<td class="col-md-2"><button type="button" class="btn-save btn btn-sm btn-success pull-right" onclick="saveDokumenList()"><span class="glyphicon glyphicon-floppy-save"></span> </button></td>
					</tr>
				</tfoot>
			</table>
		</td>
	</tr>
	
</table>
<script type="text/javascript">
	function saveDokumenList() {
		var fd = new FormData();
        var files = $('#LAMPIRAN_DOKUMEN')[0].files[0];
        fd.append('LAMPIRAN_DOKUMEN',files);
        fd.append('JENIS_DOKUMEN',$("#JENIS_DOKUMEN").val());
        fd.append('KONTRAK_PROYEK_ID',<?= $this->uri->segment(4) ?>);
		
		$.ajax({
			type:'POST',
			url:"<?= base_url('om/mon_settelment_proyek/save_dokumen_list') ?>",
			data:fd,
			contentType: false,
            processData: false,
			success:function(e){
				var r =eval("("+e+")");
				if(r.status)
				{
					var JENIS_DOKUMEN = r.jenis_dokumen;
					var LAMPIRAN_DOKUMEN = "<a href='<?= base_url('uploads/dokumen') ?>/"+r.lampiran_dokumen+"' target='_blank'>Open</a>";
					var DELETEBTN = "<a class='btn btn-xs btn-danger' onclick=\"deleteDokumenClick('"+r.id+"')\">Del</a>";
					$("#result-dokumen-list").append("<tr id='"+r.id+"'><td>"+JENIS_DOKUMEN+"</td><td>"+LAMPIRAN_DOKUMEN+"</td><td>"+DELETEBTN+"</td></tr>");
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
	function deleteDokumenClick(id) {
		if(confirm('Anda yakin akan menghapus data ini?'))
		{
			$.ajax({
				url:"<?= base_url('om/mon_settelment_proyek/delete_dokumen_detail') ?>/"+id,
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