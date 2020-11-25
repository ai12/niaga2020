<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Mt_kompensasi_manpower extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/mt_kompensasi_manpowerlist";
		$this->viewdetail = "panelbackend/mt_kompensasi_manpowerdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Kompensasi Manpower';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Kompensasi Manpower';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Kompensasi Manpower';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Kompensasi Manpower';
		}

		$this->data['width'] = "1000px";

		$this->load->model("Mt_kompensasi_manpowerModel","model");
		$this->load->model("Mt_kompensasi_manpower_detailModel","modeldetail");

		$this->load->model("Mt_jenis_ttpModel","mtjenisttp");
		$this->data['mtjenisttparr'] = $this->mtjenisttp->GetCombo();
		unset($this->data['mtjenisttparr']['']);
		ksort($this->data['mtjenisttparr']);

		$this->load->model("Mt_jabatan_proyekModel","mtjabatanproyek");
		$this->data['mtjabatanproyekarr'] = $this->mtjabatanproyek->GetCombo();

		
		$this->load->model("Mt_level_jabatanModel","mtleveljabatan");
		$this->data['mtleveljabatanarr'] = $this->mtleveljabatan->GetCombo();

		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			''
		);
	}

	protected function Header(){
		$return = array(
			array(
				'name'=>'id_jabatan_proyek', 
				'label'=>'Jabatan Proyek', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['mtjabatanproyekarr'],
			),
			array(
				'name'=>'id_level_jabatan', 
				'label'=>'Level Jabatan', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['mtleveljabatanarr'],
			),
		);

		$i=1;
		foreach($this->data['mtjenisttparr'] as $key=>$val){
			$return[] = array(
				'name'=>"nilai".$i,
				'label'=>$val,
				'type'=>"number"
			);

			$i++;
		}

		return $return;
	}

	protected function Record($id=null){
		return array(
			'id_jabatan_proyek'=>Rupiah2Number($this->post['id_jabatan_proyek']),
			'id_level_jabatan'=>Rupiah2Number($this->post['id_level_jabatan']),
		);
	}

	protected function _afterInsert($id=null){
		return $this->_afterUpdate($id);
	}

	protected function _afterUpdate($id=null){
		$ret = $this->conn->Execute("delete from mt_kompensasi_manpower_detail where id_kompensasi_manpower = ".$this->conn->escape($id));

		foreach($this->data['mtjenisttparr'] as $key=>$val){
			if(!$ret)
				break;

			$record = array();
			$record['id_kompensasi_manpower'] = $id;
			$record['id_jenis_ttp'] = $key;
			$record['nilai'] = Rupiah2Number($this->post['nilai'][$key]);

			$ret = $this->modeldetail->Insert($record);
		}

		return $ret;
	}

	protected function _afterDetail($id=null){
		if(!$this->data['row']['nilai'])
			$this->data['row']['nilai'] = $this->conn->GetList("select id_jenis_ttp as key, nilai val from mt_kompensasi_manpower_detail where id_kompensasi_manpower = ".$this->conn->escape($id));
	}

	protected function Rules(){
		$return = array(
			"id_jabatan_proyek"=>array(
				'field'=>'id_jabatan_proyek', 
				'label'=>'Jabatan Proyek', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['mtjabatanproyekarr']))."]|max_length[10]",
			),
			"id_level_jabatan"=>array(
				'field'=>'id_level_jabatan', 
				'label'=>'Level Jabatan', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['mtleveljabatanarr']))."]|max_length[10]",
			),
		);

		/*$i=1;

		foreach($this->data['mtjenisttparr'] as $key=>$val){
			$return["nilai[$key]"] = array(
				'field'=>"nilai[$key]", 
				'label'=>$val, 
				'rules'=>"required",
			);

			$i++;
		}*/

		return $return;
	}

}