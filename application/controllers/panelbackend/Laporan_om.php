<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Laporan_om extends _adminController{
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

		// $update_pembayaran = @file_get_contents("update_pembayaran");
		// if($update_pembayaran<>date('d-m-Y')){
	
	}

	function index($awal='',$akhir='',$cetak=''){
		$this->data['awal'] = ($awal!='')?$awal:date('Y-01');
		$this->data['akhir'] = ($akhir!='')?$akhir:date('Y-12');
		$this->data['cetak'] = $cetak;
	
		$this->layout = "om/laporan/lap_unit";
		$this->View("panelbackend/home",$this->data);	
	}
	
	function lap_lr($awal='',$akhir='',$cetak=''){
		$this->data['awal'] = ($awal!='')?$awal:date('Y-01');
		$this->data['akhir'] = ($akhir!='')?$akhir:date('Y-12');
		$this->data['cetak'] = $cetak;
	
		$this->layout = "om/laporan/lap_lr";
		$this->View("panelbackend/home",$this->data);	
	}
	
	
	function biaya($awal='',$akhir='',$cetak=''){
		$this->data['awal'] = ($awal!='')?$awal:date('Y-01');
		$this->data['akhir'] = ($akhir!='')?$akhir:date('Y-12');
		$this->data['cetak'] = $cetak;
	
		$this->layout = "om/laporan/lap_biaya";
		$this->View("panelbackend/home",$this->data);	
	}
	
	function lap_sla($awal='',$akhir='',$unit='',$cetak=''){
		$this->data['awal'] = ($awal!='')?$awal:date('Y-01');
		$this->data['akhir'] = ($akhir!='')?$akhir:date('Y-12');
		$this->data['unit'] = $unit;
		$this->data['cetak'] = $cetak;
	
		$this->layout = "om/laporan/lap_sla";
		$this->View("panelbackend/home",$this->data);	
	}

	

}
