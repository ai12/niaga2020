<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Mt_team_proyek extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/mt_team_proyeklist";
		$this->viewdetail = "panelbackend/mt_team_proyekdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";
		$this->data['width'] = "800px";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Team Proyek';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Team Proyek';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Team Proyek';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Team Proyek';
		}

		$this->load->model("Mt_team_proyekModel","model");
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
				'rules'=>"required|max_length[200]",
			),
		);
	}

}