<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class T_simrab_jasa_material extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/t_simrab_jasa_material_list";
		$this->viewdetail = "panelbackend/t_simrab_jasa_material_detail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Jasa Material';
			$this->data['edited'] = true;
			$this->data['add_param'] = $_SESSION['simrab_id'];
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Jasa Material';
			$this->data['edited'] = true;
			$this->data['add_param'] = $_SESSION['simrab_id'];
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Jasa Material';
			$this->data['edited'] = false;	
			$this->data['add_param'] = $_SESSION['simrab_id'];
		}elseif ($this->mode == 'delete'){
			$this->page_ctrl = 'panelbackend/t_simrab_jasa_material/index/'.$_SESSION['simrab_id'];
		}else{
			$this->layout = "panelbackend/layout_simrab";
			$this->data['page_title'] = 'Daftar Jasa Material';
		}

		$this->data['width'] = "100%";

		$this->load->model("T_simrab_jasa_materialModel","model");

		/*$this->load->model("Mt_jenis_opportunitiesModel","mtjenisopportunities");
		$this->data['mtjenisopportunitiesarr'] = $this->mtjenisopportunities->GetCombo();*/

		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->data['optParents'] = $this->optParents();
		$this->data['optDetails'] = $this->optDetails();
		$this->plugin_arr = array(
			''
		);
	}

	protected function Header(){
		return array(
			array(
				'name'=>'nama', 
				'label'=>'Uraian', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'vol', 
				'label'=>'Vol', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'satuan', 
				'label'=>'Satuan', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'hrg_satuan', 
				'label'=>'Harga Satuan', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'keterangan', 
				'label'=>'Keterangan', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
		);
	}

	protected function Record($id=null){
		return array(
			'nama'=>$this->post['nama'],
			'id'=>$this->post['id'],
			'simrab_id'=>$_SESSION['simrab_id'],
			// 'keterangan'=>$this->post['keterangan'],
			'vol'=>$this->post['vol'],
			'satuan'=>$this->post['satuan'],
			'hrg_satuan'=>$this->post['hrg_satuan'],
			'group_id'=>$this->post['group_id']
		);
	}

	protected function Rules(){
		return array(
			"nama"=>array(
				'field'=>'nama', 
				'label'=>'Uraian', 
				'rules'=>"required|max_length[100]",
			),
		);
	}
	public function Index($id='')
	{
		$_SESSION['simrab_id'] = $id;
		

		$this->data['optDetails'] = $this->optDetails(" and id in (select group_id from T_SIMRABJASAMATERIAL where simrab_id = '$_SESSION[simrab_id]') ");
		$this->data['dataResults'] = $this->dataResults();

		$this->View($this->viewlist);

	}

	public function optParents()
	{
		return $this->conn->GetArray("select * from T_SIMRABGROUP where parent_id = 0 order by id asc");
	}

	public function optDetails($where='')
	{
		return $this->conn->GetArray("select * from T_SIMRABGROUP where parent_id > 0 $where order by id asc");
	}

	public function dataResults()
	{
		return $this->conn->GetArray("select * from T_SIMRABJASAMATERIAL where simrab_id = '$_SESSION[simrab_id]' order by id asc");
	}
}