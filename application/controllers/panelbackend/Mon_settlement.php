<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Mon_settlement extends _adminController{
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


	function index($awal='',$akhir=''){
		$this->data['awal'] = ($awal!='')?$awal:date('Y-01');
		$this->data['akhir'] = ($akhir!='')?$akhir:date('Y-12');
	
		$this->layout = "om/settlement/mon_settlement";
		$this->View("panelbackend/home",$this->data);	
	}
    
    function radir($awal='',$akhir=''){
		$this->data['awal'] = ($awal!='')?$awal:date('Y-01');
		$this->data['akhir'] = ($akhir!='')?$akhir:date('Y-12');
	
		$this->layout = "om/settlement/mon_settlement_radir";
		$this->View("panelbackend/home",$this->data);	
	}
    
    function detail($awal='',$akhir=''){
		$this->data['awal'] = ($awal!='')?$awal:date('Y-01');
		$this->data['akhir'] = ($akhir!='')?$akhir:date('Y-12');
	
		$this->layout = "om/settlement/mon_settlement_detail";
		$this->View("panelbackend/home",$this->data);	
	}
	function nilai($unit,$periode){
		
		$data['settlement'] = $this->Global_model->nilai_settlement($unit,$periode);
		//$this->layout = "om/settlement/form_settlement";
		// $this->View("panelbackend/home",$data);	
		$this->load->view("om/settlement/form_settlement",$data);	
	}
	function history($unit){
		$jenis = 2;
		$data['settlement'] = $this->Global_model->history_settlement($unit);
		$data['jenis'] = $jenis;
		$this->load->view("om/settlement/history_settlement",$data);	
	}
	function nilai_update(){
		
		$kode = $this->input->post('row_id');

		$data['STATUS'] = $this->input->post('status');	
		$data['PERIODE'] = $this->input->post('periode');	
		$data['UNIT_ID'] = $this->input->post('unit_id');	
		$data['NILAI_KONTRAK'] = Rupiah2Number($this->input->post('nilai_kontrak'));	
		$data['NILAI_TAGIHAN'] = Rupiah2Number($this->input->post('nilai_tagihan'));	
		$data['NILAI_TERBAYAR'] = Rupiah2Number($this->input->post('nilai_terbayar'));	
		$data['NILAI_BIAYA'] = Rupiah2Number($this->input->post('nilai_biaya'));	
		$data['NILAI_HPP'] = Rupiah2Number($this->input->post('nilai_hpp',0));	
		$data['PERSEN_SLA'] = $this->input->post('persen_sla');	
		$data['URAIAN'] = $this->input->post('uraian');	
		$data['TINDAK_LANJUT'] = $this->input->post('tindak_lanjut');	
		$data['JENIS'] = 2;	
		// print_r($data);exit;

		$result = $this->Global_model->save('t_settlement','id',$kode,$data);
		echo $result;
	}

	function bruto($awal='',$akhir=''){
		$this->data['awal'] = ($awal!='')?$awal:date('Y-01');
		$this->data['akhir'] = ($akhir!='')?$akhir:date('Y-12');
		$this->load->model("Mt_brutoModel", "brutomodel");
		$this->data['arrbruto'] = $this->brutomodel->GetCombo();
	
		$this->layout = "om/settlement/bruto";
		$this->View("panelbackend/home",$this->data);	
	}
	function mon_sla($awal='',$akhir=''){
		$this->data['awal'] = ($awal!='')?$awal:date('Y-01');
		$this->data['akhir'] = ($akhir!='')?$akhir:date('Y-12');
	
		$this->layout = "om/settlement/mon_sla";
		$this->View("panelbackend/home",$this->data);	
	}

	function lap_unit($awal='',$akhir=''){
		$this->data['awal'] = ($awal!='')?$awal:date('Y-01');
		$this->data['akhir'] = ($akhir!='')?$akhir:date('Y-12');
	
		$this->layout = "om/laporan/lap_unit";
		$this->View("panelbackend/home",$this->data);	
	}


	

}
