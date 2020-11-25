<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Mt_manpower_rate extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/mt_manpower_ratelist";
		$this->viewdetail = "panelbackend/mt_manpower_ratedetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Manpower Rate';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Manpower Rate';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Manpower Rate';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Manpower Rate';
		}

		$this->data['width'] = "1000px";

		$this->load->model("Mt_manpower_rateModel","model");
		$this->load->model("Mt_manpower_rate_detailModel","modeldetail");

		$this->load->model("Mt_wilayah_proyekModel","mtwilayahproyek");
		$this->data['mtwilayahproyekarr'] = $this->mtwilayahproyek->GetCombo();
		unset($this->data['mtwilayahproyekarr']['']);
		ksort($this->data['mtwilayahproyekarr']);

		$this->load->model("Mt_jabatan_proyekModel","mtjabatanproyek");
		$this->data['mtjabatanproyekarr'] = $this->mtjabatanproyek->GetCombo();

		
		$this->load->model("Mt_level_jabatanModel","mtleveljabatan");
		$this->data['mtleveljabatanarr'] = $this->mtleveljabatan->GetCombo();

		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'select2'
		);
	}

	protected function _onDetail($id){
		$this->data['ratearr'] = $this->conn->GetList("select id_wilayah_proyek as key, koofisien_rate as val from mt_wilayah_proyek");
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
			array(
				'name'=>'hpp', 
				'label'=>'HPP', 
				'width'=>"auto",
				'type'=>"number",
			),
		);

		$i=1;
		foreach($this->data['mtwilayahproyekarr'] as $row){
			$return[] = array(
				'name'=>"nilai".$i,
				'label'=>"Daerah ".$i,
				'type'=>"number"
			);

			$i++;
		}

		return $return;
	}

	protected function Record($id=null){

		if($this->post['nilai']){
			foreach($this->data['mtwilayahproyekarr'] as $key=>$val){
				$this->post['nilai'][$key] = Rupiah2Number($this->post['nilai'][$key]);
			}
			$this->post['hpp'] = Rupiah2Number($this->post['hpp']);
		}

		return array(
			'id_jabatan_proyek'=>($this->post['id_jabatan_proyek']),
			'id_level_jabatan'=>($this->post['id_level_jabatan']),
			'hpp'=>($this->post['hpp']),
		);
	}

	protected function _afterInsert($id=null){
		return $this->_afterUpdate($id);
	}

	protected function _afterUpdate($id=null){
		$ret = $this->conn->Execute("delete from mt_manpower_rate_detail where id_manpower_rate = ".$this->conn->escape($id));

		foreach($this->data['mtwilayahproyekarr'] as $key=>$val){
			if(!$ret)
				break;

			$record = array();
			$record['id_manpower_rate'] = $id;
			$record['id_wilayah_proyek'] = $key;
			$record['nilai'] = ($this->post['nilai'][$key]);

			$ret = $this->modeldetail->Insert($record);
		}

		return $ret;
	}

	protected function _afterDetail($id=null){
		if(!$this->data['row']['nilai'])
			$this->data['row']['nilai'] = $this->conn->GetList("select id_wilayah_proyek as key, nilai val from mt_manpower_rate_detail where id_manpower_rate = ".$this->conn->escape($id));
	}

	protected function Rules(){
		$return = array(
			"id_jabatan_proyek"=>array(
				'field'=>'id_jabatan_proyek', 
				'label'=>'Jabatan Proyek', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['mtjabatanproyekarr']))."]",
			),
			"id_level_jabatan"=>array(
				'field'=>'id_level_jabatan', 
				'label'=>'Level Jabatan', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['mtleveljabatanarr']))."]",
			),
			"hpp"=>array(
				'field'=>'hpp', 
				'label'=>'HPP', 
				'rules'=>"required|numeric",
			),
		);

		$i=1;

		foreach($this->data['mtwilayahproyekarr'] as $key=>$val){
			$return["nilai[$key]"] = array(
				'field'=>"nilai[$key]", 
				'label'=>'Daerah '.$i, 
				'rules'=>"required",
			);

			$i++;
		}

		return $return;
	}

}