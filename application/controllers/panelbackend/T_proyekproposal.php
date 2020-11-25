<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class T_proyekproposal extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/t_proyekproposallist";
		$this->viewdetail = "panelbackend/t_proyekproposaldetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Proposal';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Proposal';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Proposal';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Proposal';
		}

		$this->data['width'] = "100%";

		$this->load->model("T_proyekproposalModel","model");
		
		$this->load->model("Mt_jenis_opportunitiesModel","mtjenisopportunities");
		$this->data['mtjenisopportunitiesarr'] = $this->mtjenisopportunities->GetCombo();

		

		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		
		// untuk upload
		$this->load->model("T_filesModel","modelfile");
		$this->plugin_arr = array(
			'datepicker','upload'
		);
		$this->data['configfile'] = $this->config->item('file_upload_config');
		$this->data['configfile']['allowed_types'] = 'pdf|doc|docx';
		$this->config->set_item('file_upload_config',$this->data['configfile']);
		//------
	}

	protected function Header(){
		return array(
			array(
				'name'=>'nama', 
				'label'=>'Nama', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'hpp', 
				'label'=>'HPP', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'proposal_penawaran', 
				'label'=>'Harga Penawaran (Rp)', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'standar_produksi', 
				'label'=>'L/R (Rp)', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'gpm', 
				'label'=>'GPM (%)', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'npm', 
				'label'=>'NPM (%)', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'raise_date', 
				'label'=>'Raised Date', 
				'width'=>"auto",
				'type'=>"date",
			),

		);
	}

	protected function Record($id=null){
		return array(
			// 'nama'=>$this->post['nama'],
			'jenis_niaga'=>1,
			'hpp'=>Rupiah2Number($this->post['hpp']),
			'proposal_penawaran'=>Rupiah2Number($this->post['proposal_penawaran']),
			'gpm'=>Rupiah2Number($this->post['gpm']),
			'npm'=>Rupiah2Number($this->post['npm']),
			'payback_perode'=>$this->post['payback_perode'],
			'lampiran'=>$this->post['lampiran'],
			'raise_date'=>$this->post['raise_date'],
			'irr'=>Rupiah2Number($this->post['irr']),
			'npv'=>Rupiah2Number($this->post['npv']),
			'standar_produksi'=>Rupiah2Number($this->post['standar_produksi']),
		);
	}

	protected function Rules(){
		return array(
			"nama"=>array(
				'field'=>'nama', 
				'label'=>'Nama', 
				'rules'=>"max_length[1000]",
			),
			"payback_perode"=>array(
				'field'=>'payback_perode', 
				'label'=>'Payback Perode', 
				'rules'=>"max_length[1000]",
			),
			"lampiran"=>array(
				'field'=>'payback_perode', 
				'label'=>'Lampiran Proposal', 
				'rules'=>"max_length[500]",
			),
			"hpp"=>array(
				'field'=>'hpp', 
				'label'=>'HPP', 
				'rules'=>"required|numeric",
			),
			"proposal_penawaran"=>array(
				'field'=>'proposal_penawaran', 
				'label'=>'Proposal Penawaran', 
				'rules'=>"required|numeric",
			),
			"standar_produksi"=>array(
				'field'=>'standar_produksi', 
				'label'=>'Standar Produksi', 
				'rules'=>"required|numeric",
			),
			"gpm"=>array(
				'field'=>'gpm', 
				'label'=>'GPM', 
				'rules'=>"required|numeric",
			),
			"npm"=>array(
				'field'=>'npm', 
				'label'=>'NPM', 
				'rules'=>"required|numeric",
			),
			"irr"=>array(
				'field'=>'irr', 
				'label'=>'IRR', 
				'rules'=>"numeric",
			),
			"npv"=>array(
				'field'=>'npv', 
				'label'=>'NPV', 
				'rules'=>"numeric",
			),
			"raise_date"=>array(
				'field'=>'raise_date', 
				'label'=>'Raised Date', 
				'rules'=>"date",
			),
			"deskripsi"=>array(
				'field'=>'deskripsi', 
				'label'=>'Catatan', 
				'rules'=>"max_length[2000]",
			),
		);
	}

	protected function _afterDetail($id)
	{
		

		if(!$this->data['row']['file']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from t_files
				where nama_ref = 'proposal_proyek' and id_ref = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file']['id'] = $r[$this->modelfile->pk];
				$this->data['row']['file']['name'] = $r['client_name'];
			}
		}
	}

	protected function _afterUpdate($id){
		return $this->_afterInsert($id);
	}

	protected function _afterInsert($id){
		$ret = true;
		
		if($ret)
			$ret = $this->_delsertFiles($id);
		
		$data_doc = $this->data['row'];
		$this->load->model("om/Global_model");
		$this->Global_model->insert_log('HIS_PROPOSAL_PROYEK',$id,'Update', $this->Global_model->STATUS_PROPOSAL,'USERS','',json_encode($data_doc));

		return $ret;
	}

	private function _delsertFiles($id = null){
		$ret = true;

		if(count($this->post['file'])){
			$ret = $this->_updateFiles(array('id_ref'=>$id,'nama_ref'=>'proposal_proyek'), $this->post['file']['id']);
		}
		
		return $ret;
	}

}