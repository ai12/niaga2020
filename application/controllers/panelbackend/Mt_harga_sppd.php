<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Mt_harga_sppd extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/mt_harga_sppdlist";
		$this->viewdetail = "panelbackend/mt_harga_sppddetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Harga Sppd';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Harga Sppd';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Harga Sppd';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Harga Sppd';
		}

		$this->data['width'] = "1300px";

		$this->load->model("Mt_harga_sppdModel","model");
		$this->load->model("Mt_harga_sppd_detailModel","modeldetail");

		$this->load->model("Mt_zona_sppdModel","mtzonasppd");
		$this->data['mtzonasppdarr'] = $this->mtzonasppd->GetCombo();
		unset($this->data['mtzonasppdarr']['']);
		ksort($this->data['mtzonasppdarr']);

		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			''
		);
	}

	protected function Header(){
		$return = array(
			array(
				'name'=>'nama', 
				'label'=>'Nama', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
		);

		$i=1;
		foreach($this->data['mtzonasppdarr'] as $row){
			$return[] = array(
				'name'=>"nilai_komersial".$i,
				'label'=>"Kom. ".$i,
				'type'=>"number"
			);
			$return[] = array(
				'name'=>"nilai".$i,
				'label'=>"PH. ".$i,
				'type'=>"number"
			);

			$i++;
		}

		return $return;
	}

	protected function Record($id=null){
		return array(
			'nama'=>$this->post['nama'],
		);
	}

	protected function _afterInsert($id=null){
		return $this->_afterUpdate($id);
	}

	protected function _afterUpdate($id=null){
		$ret = $this->conn->Execute("delete from mt_harga_sppd_detail where id_harga_sppd = ".$this->conn->escape($id));

		foreach($this->data['mtzonasppdarr'] as $key=>$val){
			if(!$ret)
				break;

			$record = array();
			$record['id_harga_sppd'] = $id;
			$record['id_zona_sppd'] = $key;
			$record['nilai'] = Rupiah2Number($this->post['nilai'][$key]);
			$record['nilai_komersial'] = Rupiah2Number($this->post['nilai_komersial'][$key]);

			$ret = $this->modeldetail->Insert($record);
		}

		return $ret;
	}

	protected function _afterDetail($id=null){
		$this->data['row']['nilai'] = $this->conn->GetList("select id_zona_sppd as key, nilai val from mt_harga_sppd_detail where id_harga_sppd = ".$this->conn->escape($id));
		$this->data['row']['nilai_komersial'] = $this->conn->GetList("select id_zona_sppd as key, nilai_komersial val from mt_harga_sppd_detail where id_harga_sppd = ".$this->conn->escape($id));
	}

	protected function Rules(){
		$return = array(
			"nama"=>array(
				'field'=>'nama', 
				'label'=>'Nama', 
				'rules'=>"required|max_length[200]",
			),
		);

		$i=1;

		foreach($this->data['mtzonasppdarr'] as $key=>$val){
			$return["nilai[$key]"] = array(
				'field'=>"nilai[$key]", 
				'label'=>'Zona '.$i, 
				'rules'=>"required",
			);
			$return["nilai_komersial[$key]"] = array(
				'field'=>"nilai_komersial[$key]", 
				'label'=>'Zona Komersial '.$i, 
				'rules'=>"required",
			);

			$i++;
		}

		return $return;
	}

}