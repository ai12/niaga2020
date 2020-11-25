<table class="table table-striped table-hover">
  <thead>
    <th>No</th>
    <th>KODE</th>
    <th>URAIAN BIAYA</th>
    <th>ANGGARAN</th>
    <th>&nbsp;</th>
  </thead>
  <tbody>
    <?php 
      $no=1;
      $ttl = 0;
      foreach ($versiarr as $row) {
        if($row['parent_id'] == 'first-data')
        {
          $action = "<a href='".base_url('panelbackend/t_simrab_detail/add/'.$row['id'])."' class='btn btn-sm btn-info'>Add</a><a href='".base_url('panelbackend/t_simrab_detail/edit/'.$row['id'])."'  class='btn btn-sm btn-warning'>Edit</a><a href='#' onclick=\"goDelete('$row[id]')\" class='btn btn-sm btn-danger'>Delete</a>";

          echo "<tr><td>$no</td><td>$row[kode]</td><td>$row[nama]</td><td>$row[hrg_satuan]</td><td align='right'>$action</td></tr>";
          $no++;
          foreach ($versiarr as $r) {
            if($row['id'] == $r['parent_id'])
            {
          $action = "<a href='".base_url('panelbackend/t_simrab_detail/add/'.$row['id'])."' class='btn btn-sm btn-info'>Add</a><a href='".base_url('panelbackend/t_simrab_detail/edit/'.$row['id'])."'  class='btn btn-sm btn-warning'>Edit</a><a href='#' onclick=\"goDelete('$row[id]')\" class='btn btn-sm btn-danger'>Delete</a>";
          $rHrg = '';
          if($r['hrg_satuan'])
          {
          $ttl += $r['hrg_satuan'];
            $rHrg = numIndo($r['hrg_satuan']);
          }
              echo "<tr><td>&nbsp;</td><td>$r[kode]</td><td>&nbsp;&nbsp;&nbsp;&nbsp; $r[nama]</td><td align='right'>$rHrg</td><td align='right'>$action</td></tr>";
              foreach ($versiarr as $rdetail) {
                if($r['id'] == $rdetail['parent_id'])
                {
          $action = "<a href='".base_url('panelbackend/t_simrab_detail/add/'.$row['id'])."' class='btn btn-sm btn-info'>Add</a><a href='".base_url('panelbackend/t_simrab_detail/edit/'.$row['id'])."'  class='btn btn-sm btn-warning'>Edit</a><a href='#' onclick=\"goDelete('$row[id]')\" class='btn btn-sm btn-danger'>Delete</a>";
                  $ttl += $rdetail['hrg_satuan'];
                  echo "<tr><td>&nbsp;</td><td>$rdetail[kode]</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $rdetail[nama]</td><td align='right'>".numIndo($rdetail['hrg_satuan'])."</td><td align='right'>$action</td></tr>";
                }
              }
            }
          }
        }
      }
    ?>
  </tbody>
  <tfoot>
    <tr>
      <th colspan="3">Total</th>
      <th style="text-align: right"><?= numIndo($ttl) ?></th>
      <th></th>
    </tr>
  </tfoot>
</table>
<script type="text/javascript">
  
        function goDelete(id){
            if(confirm("Apakah Anda yakin akan menghapus ?")){
                window.location = "<?=base_url('panelbackend/t_simrab_detail/delete')?>/"+id;
            }
        }

</script>