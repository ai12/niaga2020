<div class="row">
	<ul class="nav nav-tabs">
	  <li class="active"><a data-toggle="tab" href="#home">Detail</a></li>
	  
	  <li><a data-toggle="tab" href="#finishing">Finishing</a></li>
	</ul>
	<div class="tab-content">
	  <div id="home" class="tab-pane fade in active" style="padding: 10px">
	    <?php $this->load->view('panelbackend/detail-kontrak') ?>
	  </div>
	  
	  <div id="finishing" class="tab-pane fade">
	  	<?php $this->load->view('panelbackend/finishing');?>
	  </div>
	</div>
</div>