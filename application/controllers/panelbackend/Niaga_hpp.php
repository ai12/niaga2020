<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Niaga_hpp extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/niaga_hpplist";
		$this->viewdetail = "panelbackend/niaga_komersialdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout_rab_analisa";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah RAB Komersial';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit RAB Komersial';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Pricing';
			$this->data['edited'] = false;	
		}else{
			$this->data['no_menu'] = true;
			$this->data['page_title'] = 'Pricing';
		}

		$this->load->model("Niaga_biaya_produksiModel","model");
		$this->load->model("RabModel","rabrab");		
		$this->load->model("Proyek_pekerjaanModel","rabpekerjaan");
		$this->load->model("ProyekModel","proyek");

		$this->load->model("Mt_jabatan_proyekModel","mtjabatanproyek");
		$this->data['jabatanarr'] = $this->mtjabatanproyek->GetCombo();
		unset($this->data['jabatanarr']['']);
		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			''
		);
	}
	public function Index($id_rab=0, $page=0){
		$this->_beforeDetail($id_rab);

		#edit
		$record = array();
		$record['uraian'] = $this->post['uraian'];
		$record['keterangan'] = $this->post['keterangan'];
		$record['nilai'] = $this->post['nilai'];
		$record['vol'] = $this->post['vol'];
		$record['satuan'] = $this->post['satuan'];
		$record['std'] = $this->post['std'];
		if($this->post['act']=='save_edit'){
			$this->conn->goUpdate("niaga_biaya_produksi",$record, "id_niaga_biaya_produksi = ".$this->conn->escape($this->post['key']));
			redirect(current_url());
		}
		if($this->post['act']=='save_add'){
			$record['id_niaga_biaya_produksi_parent'] = $this->post['key'];
			$record['id_niaga_proyek'] = $this->id_niaga_proyek;
			$record['sumber_nilai'] = 5;
			$this->conn->goInsert("niaga_biaya_produksi",$record);
			redirect(current_url());
		}
		if($this->post['act']=='delete'){
			$this->conn->Execute("delete from niaga_biaya_produksi where id_niaga_biaya_produksi = ".$this->conn->escape($this->post['key']));
			redirect(current_url());
		}

		$rows = $this->conn->GetArray("select * from niaga_biaya_produksi where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek)." order by id_niaga_biaya_produksi asc");

		$isi = array();
		$header = array();
		foreach($rows as $r){
			if(!$r['id_niaga_biaya_produksi_parent'])
				$header[$r['uraian']] = $r;
			else
				$isi[$r['id_niaga_biaya_produksi_parent']][$r['sumber_nilai']][] = $r;
		}

		$this->data['header'] = $header;
		$this->data['isi'] = $isi;

		$this->View($this->viewlist);
	}

	protected function _beforeDetail($id_rab=null, $id=null){
		$this->data['rowheader3'] = $this->conn->GetRow("select * from niaga_proyek where id_rab = ".$this->conn->escape($id_rab));
		$this->data['id_niaga_proyek'] = $this->id_niaga_proyek = $this->data['rowheader3']['id_niaga_proyek'];
		$this->data['id_rab'] = $id_rab;
		$this->data['rowheader2'] = $this->rabrab->GetByPk($id_rab);
		$this->data['id_proyek_pekerjaan'] = $id_proyek_pekerjaan = $this->data['rowheader2']['id_proyek_pekerjaan'];
		$this->data['rowheader1'] = $this->rabpekerjaan->GetByPk($id_proyek_pekerjaan);
		$this->data['id_proyek'] = $id_proyek = $this->data['rowheader1']['id_proyek'];
		$this->data['rowheader'] = $this->proyek->GetByPk($id_proyek);
		$this->data['editedheader'] = false;
		$this->data['modeheader'] = 'detail';
		$this->data['add_param'] .= $id_rab;
	}
}