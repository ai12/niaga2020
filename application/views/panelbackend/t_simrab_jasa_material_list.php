<table class="table table-striped table-hover dataTable">
  <thead>
    <tr>
      <th>#</th>
      <th>Uraian</th>
      <th>Vol</th>
      <th>Satuan</th>
      <th>Harga Satuan</th>
      <th>Jumlah</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php
    $no=1;
    $total = 0;
    foreach ($optDetails as $detail) {
      echo "<tr>
        <td>$no</td>
        <td colspan='6'>$detail[group_name]</td>
      </tr>";
      $subTotal= 0;
      foreach ($dataResults as $r) {
        if($r['group_id'] == $detail['id'])
        {
          $btn = "<a href='".base_url('panelbackend/t_simrab_jasa_material/edit/'.$r['id'])."'  class='btn btn-sm btn-warning'>Edit</a><a href='#' onclick=\"goDelete('$r[id]')\" class='btn btn-sm btn-danger'>Delete</a>";
          $jumlah = $r['hrg_satuan'] * $r['vol'];
          echo "<tr>
            <td></td>
            <td>$r[nama]</td>
            <td>$r[vol]</td>
            <td>$r[satuan]</td>
            <td align='right'>".numIndo($r['hrg_satuan'])."</td>
            <td align='right'>".numIndo($jumlah)."</td>
            <td align='right'>$btn</td>
          </tr>"; 
          $subTotal += $jumlah;
        }
      }
      echo "<tr>
        <td colspan='5' align='right'><b>Total</b></td>
        <td align='right'><b>".numIndo($subTotal)."</b></td>
        <td></td>
      </tr>";
      $no++;
      $total += $subTotal;
    }
  ?>
  </tbody>
  <tfoot>
    <tr>
      <th style="text-align: right;" colspan="5" align="right">Total</th>
      <th style="text-align: right;"><?= numIndo($total) ?></th>
      <th></th>
    </tr>
  </tfoot>
</table>
<script type="text/javascript">
  
        function goDelete(id){
            if(confirm("Apakah Anda yakin akan menghapus ?")){
                window.location = "<?=base_url('panelbackend/t_simrab_jasa_material/delete')?>/"+id;
            }
        }

</script>