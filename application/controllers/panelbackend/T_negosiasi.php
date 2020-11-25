<?php
defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . "core/_adminController.php";
class T_negosiasi extends _adminController
{

	public function __construct()
	{
		parent::__construct();
	}

	protected function init()
	{
		parent::init();
		$this->viewlist = "panelbackend/t_negosiasilist";
		$this->viewdetail = "panelbackend/t_negosiasidetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Negosiasi';
			$this->data['edited'] = true;
		} elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Negosiasi';
			$this->data['edited'] = true;
		} elseif ($this->mode == 'detail') {
			$this->data['page_title'] = 'Detail Negosiasi';
			$this->data['edited'] = false;
		} else {
			$this->data['page_title'] = 'Daftar Negosiasi';
		}

		$this->data['width'] = "100%";

		$this->load->model("T_negosiasiModel", "model");
		$this->load->model("T_proposalModel", "proposalModel");
		$this->data['proposalarr'] = $this->proposalModel->GetCombo();
		$this->data['statusarr'] = array('' => '', '0' => 'Not Finishied', '1' => 'Finished');
	
		// untuk upload
		$this->load->model("T_filesModel","modelfile");
		$this->plugin_arr = array(
			'upload'
		);
		$this->data['configfile'] = $this->config->item('file_upload_config');
		$this->data['configfile']['allowed_types'] = 'pdf|doc|docx';
		$this->config->set_item('file_upload_config',$this->data['configfile']);
		//------

		$this->config->set_item("file_upload_config",$this->data['configfile']);
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
	
	}

	protected function Header()
	{
		return array(
		// array(
		// 	'name' => 'id_proposal',
		// 	'label' => 'Proposal',
		// 	'width' => "auto",
		// 	'type' => "list",
		// 	'value' => $this->data['proposalarr'],
		// ), 
		array(
			'name' => 'judul_nego',
			'label' => 'Judul Nego',
			'width' => "auto",
			'type' => "varchar2",
		), 
		array(
			'name' => 'kesepakatan_harga',
			'label' => 'Kesepakatan Harga',
			'width' => "auto",
			'type' => "number",
		), 
		array(
			'name' => 'hpp',
			'label' => 'HPP',
			'width' => "auto",
			'type' => "number",
		), 
		
		array(
			'name' => 'ba_nego',
			'label' => 'Ba Nego',
			'width' => "auto",
			'type' => "varchar2",
		), array(
			'name' => 'deskripsi',
			'label' => 'Catatan',
			'width' => "auto",
			'type' => "varchar2",
		), 
		// array(
		// 	'name' => 'status',
		// 	'label' => 'Status',
		// 	'width' => "auto",
		// 	'type' => "list",
		// 	'value' => $this->data['statusarr'],
		// ),
	);
	}

	protected function Record($id){
			return array('jenis_niaga'=>2,
			'kesepakatan_harga'=>Rupiah2Number($this->post['kesepakatan_harga']),
			'hpp'=>Rupiah2Number($this->post['hpp']),
			'id_proposal'=>$this->post['id_proposal'],
			'judul_nego'=>$this->post['judul_nego'],'ba_nego'=>$this->post['ba_nego'],'deskripsi'=>$this->post['deskripsi'],
			// 'status'=>$this->post['status'],
		);
	}

	

	protected function Rules()
	{
		return array(
		"id_proposal" => array(
			'field' => 'id_proposal',
			'label' => 'Proposal',
			'rules' => "required|numeric",
		),
		"kesepakatan_harga" => array(
			'field' => 'kesepakatan_harga',
			'label' => 'Kesepakatan Harga',
			'rules' => "required|numeric",
		),"hpp" => array(
			'field' => 'hpp',
			'label' => 'HPP',
			'rules' => "required|numeric",
		), 
		"judul_nego" => array(
			'field' => 'judul_nego',
			'label' => 'Judul Nego',
			'rules' => "required|max_length[2000]",
		), "ba_nego" => array(
			'field' => 'ba_nego',
			'label' => 'Ba Nego',
			'rules' => "max_length[2000]",
		), "deskripsi" => array(
			'field' => 'deskripsi',
			'label' => 'Deskripsi',
			'rules' => "max_length[4000]",
		), "status" => array(
			'field' => 'status',
			'label' => 'Status',
			'rules' => "numeric",
		),);
	}

	protected function _afterDetail($id)
	{
		

		if(!$this->data['row']['file']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from t_files
				where nama_ref = 'negosiasi' and id_ref = ".$this->conn->escape($id));

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
		$this->Global_model->insert_log('HIS_NEGOSIASI',$id,'Update', $this->Global_model->STATUS_NEGOSIASI,'USERS','',json_encode($data_doc));

		return $ret;
	}

	private function _delsertFiles($id = null){
		$ret = true;

		if(count($this->post['file'])){
			$ret = $this->_updateFiles(array('id_ref'=>$id,'nama_ref'=>'negosiasi'), $this->post['file']['id']);
		}
		
		return $ret;
	}

}