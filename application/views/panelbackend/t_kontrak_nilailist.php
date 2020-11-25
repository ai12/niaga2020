<table class="table table-striped table-hover dataTable">
	<thead>
		<?= UI::showHeader($header, $filter_arr, $list_sort, $list_order) ?>
	</thead>
	<tbody>
		<?php
		$i = $page;
		foreach ($list['rows'] as $rows) {
			$i++;
			echo "<tr>";
			echo "<td>$i</td>";
			$total = 0;
			foreach ($header as $rows1) {
				$val = $rows[$rows1['name']];
				$total += ($rows1['name']=='harga_kontrak')?$val:0;
				if ($rows1['name'] == 'nama') {
					$rs = ($val==$before)?'..':$val;
					if ($add_param)
						{
							
							echo "<td><a href='" . ($url = base_url($page_ctrl . "/detail/$add_param/$rows[$pk]")) . "'>$rs.</a></td>";
						}
					else
						{
							if($val==$before)continue;
							echo "<td><a href='" . ($url = base_url($page_ctrl . "/detail/$rows[$pk]")) . "'>$rs</a></td>";
						}
					$before = $val;
				}elseif($rows1['name']=='harga_personil'||$rows1['name']=='harga_kontrak'){
					echo "<td style='text-align:right'>".rupiah($val,$url)."</td>";
				}else {
					switch ($rows1['type']) {
						case 'list':
							echo "<td>" . $rows1["value"][$val] . "</td>";
							break;
						case 'number':
							echo "<td style='text-align:right'>$val</td>";
							break;
						case 'date':
							echo "<td>" . Eng2Ind($val, false) . "</td>";
							break;
						case 'datetime':
							echo "<td>" . Eng2Ind($val) . "</td>";
							break;
						default:
							echo "<td>$val</td>";
							break;
					}
				}
			}
			$add = array(
				'<li><a href="'.site_url('panelbackend/t_kontrak_nilai/add/'.$rows['id_kontrak'].'/'.$rows['nama']).'" class="waves-effect"><span class="glyphicon glyphicon-share"></span> Tambah Item</a> </li>'
			);
			echo "<td style='text-align:right'>
					" . UI::showMenuMode('inlist', $rows[$pk],false,'','',null,null,$add) . "
					</td>";
			echo "</tr>";
		}
		echo '<tr><td colspan="6" align="right"><b>Total</b></td><td align="right">'.rupiah($total).'</td><td  colspan="4"></td></tr>';
		if (!count($list['rows'])) {
			echo "<tr><td colspan='" . (count($header) + 2) . "'>Data kosong</td></tr>";
		}
		?>
	</tbody>
</table>
<?= UI::showPaging($paging, $page, $limit_arr, $limit, $list) ?>