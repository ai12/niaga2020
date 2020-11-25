<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Mt_template_doc extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/mt_template_doclist";
		$this->viewdetail = "panelbackend/mt_template_docdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Template DOC';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Template DOC';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Template DOC';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Template DOC';
		}

		$this->data['width'] = "1100px";

		$this->load->model("Mt_template_docModel","model");
		$this->load->model("Mt_template_doc_filesModel","modelfile");
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'upload'
		);
		$this->data['configfile'] = $this->config->item('file_upload_config');
		$this->data['configfile']['allowed_types'] = 'docx';

		$this->config->set_item("file_upload_config",$this->data['configfile']);
	}

	protected function Header(){
		return array(
			array(
				'name'=>'nama', 
				'label'=>'Nama', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
		);
	}

	protected function Record($id=null){
		return array(
			'nama'=>$this->data['row']['nama'],
		);
	}

	protected function Rules(){
		return array(
			/*"nama"=>array(
				'field'=>'nama', 
				'label'=>'Nama', 
				'rules'=>"required|max_length[200]",
			),*/
		);
	}
	protected function _afterDetail($id=null){
		if(!$this->data['row']['file']['id'] && $id){
			$rows = $this->conn->GetArray("select id_template_doc_files as id, client_name as name
				from mt_template_doc_files
				where id_template_doc = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file']['id'] = $r['id'];
				$this->data['row']['file']['name'] = $r['name'];
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

		return $ret;
	}

	private function _delsertFiles($id_template_doc = null){
		$ret = true;

		if(count($this->post['file'])){
			$ret = $this->_updateFiles(array('id_template_doc'=>$id_template_doc), $this->post['file']['id']);
		}
		return $ret;
	}

}