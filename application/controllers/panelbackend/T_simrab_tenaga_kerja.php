<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class T_simrab_tenaga_kerja extends _adminController{

	private $tJabatan = 't_simrab_jabatan';
	private $tTenagaKerja = 't_simrabtenagakerja';

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/t_simrab_tenaga_kerja_list";
		$this->viewdetail = "panelbackend/t_simrab_tenaga_kerja_detail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";
		
		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Tenaga Kerja';
			$this->data['edited'] = true;
			$this->data['add_param'] = $_SESSION['simrab_id'];
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Tenaga Kerja';
			$this->data['edited'] = true;
			$this->data['add_param'] = $_SESSION['simrab_id'];
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Tenaga Kerja';
			$this->data['edited'] = false;
			$this->data['add_param'] = $_SESSION['simrab_id'];
		}elseif ($this->mode == 'delete'){
			$this->page_ctrl = 'panelbackend/t_simrab_tenaga_kerja/index/'.$_SESSION['simrab_id'];
		}else{
			$this->layout = "panelbackend/layout_simrab";
			$this->data['page_title'] = 'Daftar Tenaga Kerja';
		}

		$this->data['width'] = "100%";

		$this->load->model("T_simrab_tenaga_kerjaModel","model");

		/*$this->load->model("Mt_jenis_opportunitiesModel","mtjenisopportunities");
		$this->data['mtjenisopportunitiesarr'] = $this->mtjenisopportunities->GetCombo();*/
		
		$this->data['dataSelect'] = $this->jabatan();

		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			''
		);
	}

	protected function Header(){
		return array(
			array(
				'name'=>'jabatan_proyek', 
				'label'=>'Jabatan Proyek', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'fungsi', 
				'label'=>'Fungsi', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'jml_orang', 
				'label'=>'Jumlah Orang', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'jml_hari', 
				'label'=>'Jumlah Hari', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'biaya', 
				'label'=>'Biaya', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
		);
	}

	protected function Record($id=null){
		$sql = "select * from $this->tJabatan where nama = '".$this->post['jabatan_proyek']."'";
		$rs = $this->conn->GetArray($sql);

		return array(
			'id'=>$this->post['id'],
			'simrab_id'=>$_SESSION['simrab_id'],
			'jabatan_proyek'=>$this->post['jabatan_proyek'],
			'fungsi'=>$this->post['fungsi'],
			'jml_orang'=>$this->post['jml_orang'],
			'jml_hari'=>$this->post['jml_hari'],
			'biaya'=>$rs[0]['biaya']
		);
	}

	protected function Rules(){
		return array(
			"jabatan_proyek"=>array(
				'field'=>'jabatan_proyek', 
				'label'=>'Jabatan', 
				'rules'=>"required|max_length[100]",
			),
		);
	}
	public function Index($id='')
	{
		$_SESSION['simrab_id'] = $id;
		// $this->_beforeDetail($id);
		$sql = "select * from $this->tTenagaKerja where simrab_id = '$id' order by id asc";
		$this->data['results'] = $this->conn->GetArray($sql);

		$this->View($this->viewlist);

	}

	public function jabatan()
	{
		$sql = "select * from $this->tJabatan order by id asc";
		$rs = $this->conn->GetArray($sql);
		foreach ($rs as $key => $value) {
			$rt[$value['nama']] = $value['nama'];
		}
		return $rt;
	}
}