<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class T_simrab_detail extends _adminController{


	private $table = 't_simrabdetail';

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/t_simrab_detail_list";
		$this->viewdetail = "panelbackend/t_simrab_detail_detail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Komponen Biaya';
			$this->data['edited'] = true;
			$this->data['add_param'] = $_SESSION['simrab_id'];
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Komponen Biaya';
			$this->data['edited'] = true;
			$this->data['add_param'] = $_SESSION['simrab_id'];
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Komponen Biaya';
			$this->data['edited'] = false;	
		}else{
			$this->layout = "panelbackend/layout_simrab";
			$this->data['page_title'] = 'Komponen Biaya';
		}

		$this->data['width'] = "100%";

		$this->load->model("T_simrab_detailModel","model");

		/*$this->load->model("Mt_jenis_opportunitiesModel","mtjenisopportunities");
		$this->data['mtjenisopportunitiesarr'] = $this->mtjenisopportunities->GetCombo();*/

		$this->data['dataSelect'] = $this->parentLv1();

		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			''
		);
	}

	protected function Record($id=null){
		return array(
			'nama'=>$this->post['nama'], //uraian
			'id'=>$this->post['id'],
			'parent_id'=>$this->post['parent_id'],
			'simrab_id'=>$_SESSION['simrab_id'],
			'hrg_satuan'=>$this->post['hrg_satuan'], //nilai satuan
			'kode'=>$this->post['kode'], //kode biaya
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
		$this->data['versiarr'] = $this->conn->GetArray("select * from t_simrabdetail where simrab_id=".$this->conn->escape($id)." order by kode asc");
		$this->data['rowheader'] = ['komponen_biaya'=>$id];
		$this->View($this->viewlist);

	}

	public function parentLv1()
	{
		$sql = "select * from $this->table where parent_id = 'first-data'";
		$rs = $this->conn->GetArray($sql);
		$rt = ['first-data' => 'First Data'];
		foreach ($rs as $key => $value) {
			$rt[$value['id']] = $value['nama'];
		}
		return $rt;
	}
}