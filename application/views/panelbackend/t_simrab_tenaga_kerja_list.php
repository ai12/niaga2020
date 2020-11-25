  <table class="table table-striped table-hover">
    <thead>
    <tr>
      <th>No</th>
      <th>Jabatan</th>
      <th>Fungsi</th>
      <th>Jumlah Orang</th>
      <th>Jumlah Hari</th>
      <th>Jumlah Hari Orang</th>
      <th>Biaya</th>
      <th>Total</th>
      <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $no = 1;
    $ttl = 0;
    foreach ($results as $r) {
      $jmlHariOrang = $r['jml_orang'] * $r['jml_hari'];
      $total = $jmlHariOrang * $r['biaya'];
      $ttl += $total;
      $btn = "<a href='".base_url('panelbackend/t_simrab_tenaga_kerja/edit/'.$r['id'])."' class='btn btn-sm btn-info'>Edit</a>";
      $btn .= "<a href='#' class='btn btn-sm btn-danger' onclick=\"goDelete('".$r['id']."')\">Delete</a>";
      echo "<tr><td>$no</td><td>$r[jabatan_proyek]</td><td>$r[fungsi]</td><td >$r[jml_hari]</td><td >$r[jml_orang]</td><td >$jmlHariOrang</td>
      <td align='right'>".numIndo($r['biaya'])."</td>
      <td align='right'>".numIndo($total)."</td>
      <td align='right'>$btn</td>
      </tr>";
      $no++;
    }
    ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="7" style="text-align: right">Total Biaya Man Power</th>
        <th style="text-align: right"><?= numIndo($ttl) ?></th>
        <th></th>
      </tr>
    </tfoot>
  </table>
  <script type="text/javascript">
  
        function goDelete(id){
            if(confirm("Apakah Anda yakin akan menghapus ?")){
                window.location = "<?=base_url('panelbackend/t_simrab_tenaga_kerja/delete')?>/"+id;
            }
        }
        
</script>