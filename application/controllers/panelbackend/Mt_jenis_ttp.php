<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Mt_jenis_ttp extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/mt_jenis_ttplist";
		$this->viewdetail = "panelbackend/mt_jenis_ttpdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Jenis TTP';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Jenis TTP';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Jenis TTP';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Jenis TTP';
		}

		$this->data['width'] = "800px";

		$this->load->model("Mt_jenis_ttpModel","model");
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
		);
	}

	protected function Record($id=null){
		return array(
			'nama'=>$this->post['nama'],
		);
	}

	protected function Rules(){
		return array(
			"nama"=>array(
				'field'=>'nama', 
				'label'=>'Nama', 
				'rules'=>"max_length[200]",
			),
		);
	}

}