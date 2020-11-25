<div class="row">
	<ul class="nav nav-tabs">
	  <li class="active"><a data-toggle="tab" href="#home">Detail</a></li>
	  <li><a data-toggle="tab" href="#preparation">Preparation</a></li>
	  <li><a data-toggle="tab" href="#execution">Execution</a></li>
	  <li><a data-toggle="tab" href="#document">Document</a></li>
	</ul>
	<div class="tab-content">
	  <div id="home" class="tab-pane fade in active" style="padding: 10px">
	    <?php $this->load->view('panelbackend/detail-kontrak') ?>
	  </div>
	  <div id="preparation" class="tab-pane fade">
	  	<div class="col-md-12">  		
		    <?php $this->load->view('panelbackend/preparation');?>
	  	</div>
	  </div>
	  <div id="execution" class="tab-pane fade">
	  	<?php $this->load->view('panelbackend/execution');?>
	  </div>
	  <div id="document" class="tab-pane fade">
	  	<?php $this->load->view('panelbackend/document');?>
	  </div>
	</div>
</div>