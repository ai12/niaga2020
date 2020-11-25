<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Mt_wilayah_proyek extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/mt_wilayah_proyeklist";
		$this->viewdetail = "panelbackend/mt_wilayah_proyekdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Wilayah Proyek';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Wilayah Proyek';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Wilayah Proyek';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Wilayah Proyek';
		}

		$this->data['width'] = "800px";

		$this->load->model("Mt_wilayah_proyekModel","model");
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			''
		);
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
				'name'=>'koofisien_rate', 
				'label'=>'Koofisien Rate', 
				'width'=>"auto",
				'type'=>"number",
			),
		);
	}

	protected function Record($id=null){
		return array(
			'nama'=>$this->post['nama'],
			'koofisien_rate'=>Rupiah2Number($this->post['koofisien_rate']),
		);
	}

	protected function Rules(){
		return array(
			"nama"=>array(
				'field'=>'nama', 
				'label'=>'Nama', 
				'rules'=>"required|max_length[200]",
			),
			"koofisien_rate"=>array(
				'field'=>'koofisien_rate', 
				'label'=>'Koofisien Rate', 
				'rules'=>"required|numeric|max_length[10]",
			),
		);
	}

}