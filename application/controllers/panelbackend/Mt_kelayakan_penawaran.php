<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Mt_kelayakan_penawaran extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/mt_kelayakan_penawaranlist";
		$this->viewdetail = "panelbackend/mt_kelayakan_penawarandetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Kelayakan Penawaran';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Kelayakan Penawaran';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Kelayakan Penawaran';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Kelayakan Penawaran';
		}

		$this->data['width'] = "800px";

		$this->load->model("Mt_kelayakan_penawaranModel","model");
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			''
		);
	}

	protected function Header(){
		return array(
			array(
				'name'=>'max_nego', 
				'label'=>'MAX Nego', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'layak', 
				'label'=>'Layak', 
				'width'=>"auto",
				'type'=>"number",
			),
		);
	}

	protected function Record($id=null){
		return array(
			'max_nego'=>Rupiah2Number($this->post['max_nego']),
			'layak'=>Rupiah2Number($this->post['layak']),
		);
	}

	protected function Rules(){
		return array(
			"max_nego"=>array(
				'field'=>'max_nego', 
				'label'=>'MAX Nego', 
				'rules'=>"required|numeric|max_length[10]",
			),
			"layak"=>array(
				'field'=>'layak', 
				'label'=>'Layak', 
				'rules'=>"required|numeric|max_length[10]",
			),
		);
	}

}