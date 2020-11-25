<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class T_simulasi_rab extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/t_simulasi_rab_list";
		$this->viewdetail = "panelbackend/t_simulasi_rab_detail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Simulasi';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Simulasi';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Simulasi';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Simulasi RAB';
		}

		$this->data['width'] = "100%";

		$this->load->model("T_simulasi_rabModel","model");

		/*$this->load->model("Mt_jenis_opportunitiesModel","mtjenisopportunities");
		$this->data['mtjenisopportunitiesarr'] = $this->mtjenisopportunities->GetCombo();*/

		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			''
		);
	}

	protected function Header(){
		return array(
			array(
				'name'=>'nama_pekerjaan', 
				'label'=>'Nama RAB', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'tahun', 
				'label'=>'Tahun', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'tanggal', 
				'label'=>'Tanggal', 
				'width'=>"auto",
				'type'=>"number",
			),
		);
	}

	protected function Record($id=null){
		return array(
			'nama_pekerjaan'=>$this->post['nama_pekerjaan'],
			'id'=>$this->post['id'],
			'tahun'=>$this->post['tahun'],
			'tanggal'=>$this->post['tanggal'],
			'keterangan'=>$this->post['keterangan'],
		);
	}

	protected function Rules(){
		return array(
			"nama_pekerjaan"=>array(
				'field'=>'nama_pekerjaan', 
				'label'=>'Nama', 
				'rules'=>"required|max_length[1000]",
			),
		);
	}

}