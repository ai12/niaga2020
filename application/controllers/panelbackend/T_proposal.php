<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class T_proposal extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/t_proposallist";
		$this->viewdetail = "panelbackend/t_proposaldetail";
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

		$this->load->model("T_proposalModel","model");
		$this->load->model("Mt_jenis_opportunitiesModel","mtjenisopportunities");
		$this->data['mtjenisopportunitiesarr'] = $this->mtjenisopportunities->GetCombo();

		// untuk upload
		$this->load->model("T_filesModel","modelfile");
		$this->plugin_arr = array(
			'upload'
		);
		$this->data['configfile'] = $this->config->item('file_upload_config');
		$this->data['configfile']['allowed_types'] = 'pdf|doc|docx';
		$this->config->set_item('file_upload_config',$this->data['configfile']);
		//------

		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		
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
		);
	}

	protected function Record($id=null){
		return array(
			// 'nama'=>$this->post['nama'],
			'jenis_niaga'=>2,
			'hpp'=>Rupiah2Number($this->post['hpp']),
			'proposal_penawaran'=>Rupiah2Number($this->post['proposal_penawaran']),
			'gpm'=>Rupiah2Number($this->post['gpm']),
			'npm'=>Rupiah2Number($this->post['npm']),
			'payback_periode'=>$this->post['payback_periode'],
			'lampiran'=>$this->post['lampiran'],
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
			"payback_periode"=>array(
				'field'=>'payback_periode', 
				'label'=>'Payback Periode', 
				'rules'=>"max_length[100]",
			),
			"lampiran"=>array(
				'field'=>'lampiran', 
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
				'rules'=>"required|max_length[5]",
			),
			"npm"=>array(
				'field'=>'npm', 
				'label'=>'NPM', 
				'rules'=>"required|max_length[5]",
			),
			"irr"=>array(
				'field'=>'irr', 
				'label'=>'IRR', 
				'rules'=>"max_length[5]",
			),
			"npv"=>array(
				'field'=>'npv', 
				'label'=>'NPV', 
				'rules'=>"numeric",
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
				where nama_ref = 'proposal' and id_ref = ".$this->conn->escape($id));

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

		// echo '<pre>';print_r($this->data['row']);exit;
		$data_doc = $this->data['row'];
		$this->load->model("om/Global_model");
		$this->Global_model->insert_log('HIS_PROPOSAL',$id,'Update', $this->Global_model->STATUS_PROPOSAL,'USERS','',json_encode($data_doc));

		return $ret;
	}

	private function _delsertFiles($id = null){
		$ret = true;

		if(count($this->post['file'])){
			$ret = $this->_updateFiles(array('id_ref'=>$id,'nama_ref'=>'proposal'), $this->post['file']['id']);
		}
		
		return $ret;
	}


}