<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Proto extends _adminController{
	public $limit = 5;
	public $limit_arr = array('5','10','30','50','100');

	public function __construct(){
		parent::__construct();
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout";
		$this->load->model("Global_model");
	}
	protected function init(){
		parent::init();

		$update_pembayaran = @file_get_contents("update_pembayaran");
		// if($update_pembayaran<>date('d-m-Y')){
	
	}


	function mon_settlement($awal='',$akhir=''){
		$this->data['awal'] = ($awal!='')?$awal:date('Y-01');
		$this->data['akhir'] = ($akhir!='')?$akhir:date('Y-12');
	
		$this->layout = "panelbackend/proto_mon_settlement";
		$this->View("panelbackend/home",$data);	
	}
	function mon_settlement_bruto(){
		$this->layout = "panelbackend/proto_settlement_bruto";
		$this->View("panelbackend/home");	
	}
	function mon_settlement_sla(){
		$this->layout = "panelbackend/proto_settlement_sla";
		$this->View("panelbackend/home");	
	}
	function mon_settlement_proyek(){
		$this->layout = "panelbackend/proto_settlement_proyek";
		$this->View("panelbackend/home");	
	}
	function mon_settlement_ba(){
		$this->layout = "panelbackend/proto_settlement_ba";
		$this->View("panelbackend/home");	
	}
	function lap_unit(){
		$this->layout = "panelbackend/lap_unit";
		$this->View("panelbackend/home");	
	}
	function lap_biaya(){
		$this->layout = "panelbackend/lap_sla";
		$this->View("panelbackend/home");	
	}
	function lap_laba(){
		$this->layout = "panelbackend/lap_laba";
		$this->View("panelbackend/home");	
	}
}
