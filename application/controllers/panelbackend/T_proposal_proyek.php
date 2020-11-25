<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class T_proposal_proyek extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/t_proposal_proyeklist";
		$this->viewdetail = "panelbackend/t_proposal_proyekdetail";
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
			$this->data['page_title'] = 'Daftar Proposal Proyek';
		}

		$this->data['width'] = "100%";

		$this->load->model("T_proposal_proyekModel","model");

		$this->load->model("Mt_jenis_opportunitiesModel","mtjenisopportunities");
		$this->data['mtjenisopportunitiesarr'] = $this->mtjenisopportunities->GetCombo();

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
				'name'=>'hpp', 
				'label'=>'Nilai HPP', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'proposal_penawaran', 
				'label'=>'Propsal Penawaran', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'standar_produksi', 
				'label'=>'Standar Produksi', 
				'width'=>"auto",
				'type'=>"number",
			),
		);
	}

	protected function Record($id=null){
		return array(
			'nama'=>$this->post['nama'],
			'jenis_niaga'=> 1,
			'hpp'=>Rupiah2Number($this->post['hpp']),
			'proposal_penawaran'=>Rupiah2Number($this->post['proposal_penawaran']),
			'standar_produksi'=>Rupiah2Number($this->post['standar_produksi']),
		);
	}

	protected function Rules(){
		return array(
			"nama"=>array(
				'field'=>'nama', 
				'label'=>'Nama', 
				'rules'=>"required|max_length[1000]",
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
			"deskripsi"=>array(
				'field'=>'deskripsi', 
				'label'=>'Catatan', 
				'rules'=>"max_length[2000]",
			),
		);
	}

}