<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Rab extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/rablist";
		$this->viewdetail = "panelbackend/rabdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout_proyek";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah RAB';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit RAB';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail RAB';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar RAB';
		}

		$this->data['no_menu'] = true;

		$this->load->model("RabModel","model");
		$this->load->model("proyek_pekerjaanModel","rabpekerjaan");
		$this->load->model("proyekModel","proyek");

		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			''
		);
	}

	public function Index($id_proyek_pekerjaan=0, $id_rab=null){

		$this->_beforeDetail($id_proyek_pekerjaan);

		if($id_rab){
			redirect("panelbackend/rab_jasa_material/index/".$id_rab);
		}elseif($this->data['last_versi']){
			redirect("panelbackend/rab_jasa_material/index/".$this->data['last_versi']);
		}else{
			$this->newRab($id_proyek_pekerjaan);
			redirect("panelbackend/rab_jasa_material/index/".$id);
		}

	}

	protected function _beforeDetail($id_proyek_pekerjaan=null, $id=null){
		$this->data['id_proyek_pekerjaan'] = $id_proyek_pekerjaan;
		$this->data['rowheader1'] = $this->rabpekerjaan->GetByPk($id_proyek_pekerjaan);
		$this->data['id_proyek'] = $id_proyek = $this->data['rowheader1']['id_proyek'];
		$this->data['rowheader'] = $this->proyek->GetByPk($id_proyek);
		$this->data['editedheader'] = false;
		$this->data['modeheader'] = 'detail';
		$this->data['add_param'] .= $id_proyek_pekerjaan;
		$this->data['last_versi'] = $this->conn->GetOne("select max(id_rab) from rab where jenis = '1' and id_proyek_pekerjaan = ".$this->conn->escape($id_proyek_pekerjaan));
	}

	protected function Record($id=null){
		return array(
			'id_proyek_pekerjaan'=>$this->post['id_proyek_pekerjaan'],
			'versi'=>$this->post['versi'],
			'is_final'=>(int)$this->post['is_final'],
		);
	}

	protected function Rules(){
		return array(
			"id_proyek_pekerjaan"=>array(
				'field'=>'id_proyek_pekerjaan', 
				'label'=>'Pekerjaan', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['rabpekerjaanarr']))."]",
			),
			"versi"=>array(
				'field'=>'versi', 
				'label'=>'Versi', 
				'rules'=>"required|max_length[20]",
			),
			"is_final"=>array(
				'field'=>'is_final', 
				'label'=>'IS Final', 
				'rules'=>"max_length[1]",
			),
		);
	}

}