<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Laporan_proyek extends _adminController{

	public function __construct(){
		parent::__construct();
	}

	protected function init(){
		parent::init();
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";
		$this->viewprint = "panelbackend/laporanproyekprint";
		$this->viewindex = "panelbackend/laporanproyekindex";

		if ($this->mode == 'print_detail') {
			$this->data['page_title'] = 'Laporan Proyek';
		}else{
			$this->data['page_title'] = 'Laporan Proyek';
		}

		$this->load->model("ProyekModel","model");
		
		$this->load->model("Mt_warehouseModel","mtwarehouse");
		$this->data['mtmtwarehousearr'] = $this->mtwarehouse->GetCombo();
		
		$this->load->model("CustomerModel","mtcustomer");
		$this->data['mtcustomerarr'] = $this->mtcustomer->GetCombo();

		$this->load->model("Mt_wilayah_proyekModel","mtwilayah");
		$this->data['wilayaharr'] = $this->mtwilayah->GetCombo();
		
		$this->load->model("Mt_tipe_proyekModel","mttipeproyek");
		$this->data['mttipeproyekarr'] = $this->mttipeproyek->GetCombo();
		
		$this->load->model("Mt_status_proyekModel","mtstatusproyek");
		$this->data['mtstatusproyekarr'] = $this->mtstatusproyek->GetCombo();

		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'datepicker','select2'
		);
		
	}

	function Header(){
		$norowspan_control = array();

		$this->data['type_header'] = array(
			'id_customer'=>array(
				'list'=>$this->data['mtcustomerarr']
			),
			'id_warehouse'=>array(
				'list'=>$this->data['mtmtwarehousearr']
			),
			'id_tipe_proyek'=>array(
				'list'=>$this->data['mttipeproyekarr']
			),
			'id_wilayah_proyek'=>array(
				'list'=>$this->data['wilayaharr']
			),
			'id_status_proyek'=>array(
				'list'=>$this->data['mtstatusproyekarr']
			),
			'tgl_rencana_mulai'=>'date',
			'tgl_rencana_selesai'=>'date',
			'nilai_hpp'=>'rupiah',
			'nilai_rab'=>'rupiah',
			'nilai_realisasi'=>'rupiah',
			'nilai_sisa'=>'rupiah',
			'nilai_terbayar'=>'rupiah'
		);

		$return = array(
			"nama_proyek"=>"Nama Proyek",
			"id_customer"=>"Customer",
			"id_warehouse"=>"Warehouse",
			"id_tipe_proyek"=>"Tipe Proyek",
			"id_wilayah_proyek"=>"Wilayah Proyek",
			"nama_pic"=>"Project Manager",
			"tgl_rencana_mulai"=>"Mulai",
			"tgl_rencana_selesai"=>"Selesai",
			"nilai_hpp"=>"HPP",
			"nilai_rab"=>"RAB",
			"nilai_realisasi"=>"Realisasi",
			"nilai_sisa"=>"Sisa",
			"nilai_terbayar"=>"Terbayar",
			"id_status_proyek"=>"Status Proyek",
		);

		return $return;
	}

	function Index($page=1){
		if($this->post['act']=='print'){
			$this->go_print();
		}else{
			$this->getData();

			$this->View($this->viewindex);
		}
	}

	public function go_print(){
		if(!$this->get['header'])
			$this->get['header'] = array();

		$this->data['no_header'] = true;

		$this->template = "panelbackend/main3";
		$this->layout = "panelbackend/layout3";

		$this->data['page_title'] .= " ".($this->get['tahun']?" Tahun ".$this->get['tahun']:"");

		$this->data['page_title'] = strtoupper($this->data['page_title']);

		$this->getData();

		$this->View($this->viewprint);
	}

	private function getData(){

		$this->data['tahun'] = date('Y');

		if($_REQUEST['tahun'])
			$this->data['tahun'] = $_REQUEST['tahun'];

		$this->data['header']  = $this->Header();

		$this->data['paramheader'] = array();

		if($_REQUEST['header'])
			$this->data['paramheader'] = array_keys($_REQUEST['header']);

		$this->data['rows'] = $this->conn->GetArray("select a.*, a.nilai_hpp-a.nilai_realisasi as nilai_sisa from proyek a where to_char(a.tgl_rencana_mulai,'YYYY') = ".$this->conn->escape($_REQUEST['tahun']));
	}
}
