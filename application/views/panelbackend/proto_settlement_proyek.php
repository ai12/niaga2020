<div class="container">
	<form method="post" enctype="multipart/form-data" id="main_form" class="form-horizontal">
		<input type="hidden" name="act" id="act">
		<input type="hidden" name="go" id="go">
		<input type="hidden" name="key" id="key">
		<section class="content-header" style="max-width:100%; margin-right:auto; margin-left:auto;">
			<h1>
				Daftar Kontrak Proyek </h1>
		</section>
		<section class="content" style="max-width:100%">
			<div class="box box-default">
				
				<div class="box-body">


					<table class="table table-striped table-hover dataTable">
						<thead>
							<tr>
								<td></td>
								<td style="width:auto;"><input autocomplete="off" type="text" name="list_search[nama]" id="list_search[nama]" class="form-control" placeholder="Search Nama..." style="width:100%;"></td>
								<td style="position:relative;width:auto;"><input type="number" name="list_search[kontrak_no]" id="list_search[kontrak_no]" class="form-control" placeholder="Search No Kontrak..." style="width:100%;"></td>
								<td></td>
								<td style="position:relative;width:auto;"><input type="number" name="list_search[kontrak_nilai]" id="list_search[kontrak_nilai]" class="form-control" placeholder="Search Kontrak nilai..." style="width:100%;"></td>
								<td style="position:relative;width:auto;"><input type="number" name="list_search[durasi]" id="list_search[durasi]" class="form-control" placeholder="Search Durasi..." style="width:100%;"></td>
								<td></td>
								<td></td>
								<td style="width:auto;"><input autocomplete="off" type="text" name="list_search[tipe_pekerjaan]" id="list_search[tipe_pekerjaan]" class="form-control" placeholder="Search Tipe pekerjaan..." style="width:100%;"></td>
								<td style="text-align:right; width:10px">
									<!-- <button type="submit" class='btn btn-default btn-sm' title="Filter">
			<span class="glyphicon glyphicon-search"></span>
	        </button> -->
									<button type="button" class="btn waves-effect btn-sm btn-default" onclick="goReset()" title="Reset">
										<span class="glyphicon glyphicon-refresh"></span>
									</button>
								</td>
							</tr>
							<tr>
								<th style="width:10px">#</th>
								<input type="hidden" name="list_sort" id="list_sort">
								<input type="hidden" name="list_order" id="list_order">
								<th style="text-align:center; width:auto; cursor:pointer;" class="sorting" onclick="goSort('nama','asc')">Nama</th>
								<th style="text-align:right; width:auto; cursor:pointer;" class="sorting" onclick="goSort('kontrak_no','asc')">No Kontrak</th>
								<th style="text-align:center; width:auto; cursor:pointer;" class="sorting" onclick="goSort('kontrak_tgl','asc')">Tgl. Kontrak</th>
								<th style="text-align:right; width:auto; cursor:pointer;" class="sorting" onclick="goSort('kontrak_nilai','asc')">Kontrak nilai</th>
								<th style="text-align:right; width:auto; cursor:pointer;" class="sorting" onclick="goSort('durasi','asc')">Durasi</th>
								<th style="text-align:center; width:auto; cursor:pointer;" class="sorting" onclick="goSort('tgl_mulai','asc')">Tgl mulai</th>
								<th style="text-align:center; width:auto; cursor:pointer;" class="sorting" onclick="goSort('tgl_selesai','asc')">Tgl selesai</th>
								<th style="text-align:center; width:auto; cursor:pointer;" class="sorting" onclick="goSort('tipe_pekerjaan','asc')">Tipe pekerjaan</th>
								<th></th>
							</tr>

							<script>
								$(function() {
									$("#main_form").submit(function() {
										if ($("#act").val() == '') {
											goSearch();
										}
									});
								});

								function goSort(name, order) {
									$("#list_sort").val(name);
									$("#list_order").val(order);
									$("#act").val('list_sort');
									$("#main_form").submit();
								}

								function goSearch() {
									$("#act").val('list_search');
									$("#main_form").submit();
								}

								function goReset() {
									$("#act").val('list_reset');
									$("#main_form").submit();
								}
								$("#main_form select[name^='list_search_filter'], #main_form input[name^='list_search']").not("#list_limit").change(function() {
									$("#main_form").submit();
								});
							</script>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td><a href="http://localhost:8080/niaga/panelbackend/proto/mon_settlement_ba">Tes KONTRAK</a></td>
								<td style="text-align:right">200/2020/PJBS</td>
								<td>04 Juni 2020 </td>
								<td style="text-align:right">2.100.000.000,00</td>
								<td style="text-align:right">10</td>
								<td>16 Juni 2020 </td>
								<td>15 Juni 2020 </td>
								<td>LAPANGAN</td>
								<td style="text-align:right">
									<div class="dropdown" style="display:inline">
										<a href="javascript:void(0)" class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="color:#1f91f3;display:inline-block;">
											<span class="glyphicon glyphicon-option-vertical"></span>
										</a>
										<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2" style="min-width: 10px; margin-top:-20px">
											<li><a href="javascript:void(0)" class="waves-effect " onclick="goEdit('2')"><span class="glyphicon glyphicon-edit"></span> Edit</a> </li>
											<script>
												function goEdit(id) {
													window.location = "http://localhost:8080/niaga/panelbackend/t_kontrak_proyek/edit/" + id;
												}
											</script>
											<li><a href="javascript:void(0)" class="waves-effect " onclick="goDelete('2')"><span class="glyphicon glyphicon-remove"></span> Delete</a> </li>
											<script>
												function goDelete(id) {
													if (confirm("Apakah Anda yakin akan menghapus ?")) {
														window.location = "http://localhost:8080/niaga/panelbackend/t_kontrak_proyek/delete/" + id;
													}
												}
											</script>
										</ul>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="col-sm-5 no-margin no-padding" style="margin-bottom: 0px; font-size: 11px;">
						<div class="dataTables_info dataTables_length">
							Perhalaman
							<select style="width:auto" data-placeholder="Pilih..." tabindex="2" name="list_limit" id="list_limit" class="form-control input-sm blank-form " onchange="goLimit()">
								<option value="5">5</option>
								<option value="10" selected="">10</option>
								<option value="30">30</option>
								<option value="50">50</option>
								<option value="100">100</option>
							</select> Menampilkan 1 sampai 1 dari total 1 data

						</div>
					</div>
					<div class="col-sm-7 no-margin no-padding" style="margin-bottom: 0px; margin-top: 5px !important; font-size: 11px;">
						<div class="dataTables_paginate paging_simple_numbers">
							<ul class="pagination">
							</ul>
						</div>
					</div>

					<script>
						function goLimit() {
							$("#act").val('list_limit');
							$("#main_form").submit();
						}
					</script>

					<div style="clear: both;"></div>

				</div>
			</div><!-- /.box -->
		</section>

		<style type="text/css">
			table.dataTable {
				clear: both;
				margin-bottom: 6px !important;
				max-width: none !important;
			}
		</style>

	</form>
</div>