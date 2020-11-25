<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Mt_unit extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/mt_unitlist";
		$this->viewdetail = "panelbackend/mt_unitdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Unit';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Unit';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Unit';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Unit';
		}

		$this->data['width'] = "800px";

		$this->load->model("Mt_unitModel","model");
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->load->model("Mt_brutoModel", "brutomodel");
		$this->data['jenisarr'] = $this->brutomodel->GetCombo();
		// $this->data['jenisarr'] = [null => '', '1' => 'PJB Group', '2' => 'FULL O&M (PLN GROUP)','3'=>'IPP'];
		$this->plugin_arr = array(
			''
		);
	}

	protected function Header(){
		return array(
			array(
				'name'=>'table_code', 
				'label'=>'Kode', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'table_desc', 
				'label'=>'Nama', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'table_type', 
				'label'=>'Jenis', 
				'width'=>"auto",
				'type' => "list",
				'value' => $this->data['jenisarr'],
			),
		);
	}

	protected function Record($id=null){
		return array(
			'table_code'=>$this->post['table_code'],
			'table_desc'=>$this->post['table_desc'],
			'table_type'=>$this->post['table_type'],
		);
	}

	protected function Rules(){
		return array(
			"table_code"=>array(
				'field'=>'table_code', 
				'label'=>'Kode', 
				'rules'=>"required|max_length[100]",
			),
			"table_desc"=>array(
				'field'=>'table_desc', 
				'label'=>'Nama', 
				'rules'=>"required|max_length[100]",
			),
		);
	}

}