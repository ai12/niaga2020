<?php
defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . "core/_adminController.php";
class T_kontrak extends _adminController
{

	public function __construct()
	{
		parent::__construct();
	}

	protected function init()
	{
		parent::init();
		$this->viewlist = "panelbackend/t_kontraklist";
		$this->viewdetail = "panelbackend/t_kontrakdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Kontrak';
			$this->data['edited'] = true;
		} elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Kontrak';
			$this->data['edited'] = true;
		} elseif ($this->mode == 'detail') {
			$this->layout = "panelbackend/layout_kontrak";
			$this->data['page_title'] = 'Detail Kontrak';
			$this->data['edited'] = false;
		} else {
			$this->data['page_title'] = 'Daftar Kontrak';
		}

		$this->data['width'] = "100%";

		$this->load->model("T_kontrakModel", "model");
		$this->load->model("CustomerModel", "customermodel");
		$this->data['customerarr'] = $this->customermodel->GetCombo();
		$this->data['jenisarr'] = [null => '', '0' => 'Penugasan', '1' => 'Normal'];
		$this->data['jenisrkaparr'] = [null => '', '0' => 'Non-RKAP', '1' => 'RKAP'];
		$this->data['statusarr'] = [null => '', '0' => 'On-Going', '1' => 'Selesai'];

		// untuk upload
		$this->load->model("T_filesModel","modelfile");
		$this->plugin_arr = array(
			'upload','datepicker'
		);
		$this->data['configfile'] = $this->config->item('file_upload_config');
		$this->data['configfile']['allowed_types'] = 'pdf|jpg|png|jpeg';
		$this->config->set_item('file_upload_config',$this->data['configfile']);
		//------

		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		
	}

	
	protected function Header()
	{
		return array(
			array(
				'name' => 'nama',
				'label' => 'Nama',
				'width' => "auto",
				'type' => "varchar2",
			), 
			array(
				'name' => 'id_customer',
				'label' => 'Pelanggan',
				'width' => "auto",
				'type' => "list",
				'value' => $this->data['customerarr'],
			), 
			array(
				'name' => 'jangka_waktu',
				'label' => 'Jangka Waktu',
				'type' => "number",
			), 
			array(
				'name' => 'file_kontrak',
				'label' => 'File Kontrak',
				'type' => "varchar2",
			), 
			array(
				'name' => 'prk_inti',
				'label' => 'PRK INTI',
				'type' => "varchar2",
			), 
			// array(
			// 	'name' => 'jenis',
			// 	'label' => 'Jenis',
			// 	'type' => "list",
			// 	'value' => $this->data['jenisarr'],
			// ), 
			// array(
			// 	'name' => 'deskripsi',
			// 	'label' => 'Catatan',
			// 	'width' => "auto",
			// 	'type' => "varchar2",
			// ), 
			array(
				'name' => 'status',
				'label' => 'Status',
				'width' => "auto",
				'type' => "list",
				'value' => $this->data['statusarr'],
			),
		);
	}

	protected function Record($id = null)
	{
		return array(
			'id_customer' => $this->post['id_customer'], 'nama' => $this->post['nama'],
			'jenis' => $this->post['jenis'],
			'no_kontrak' => $this->post['no_kontrak'],
			'tgl_awal' => $this->post['tgl_awal'],
			'tgl_akhir' => $this->post['tgl_akhir'],
			'lingkup' => $this->post['lingkup'],
			'jangka_waktu' => $this->post['jangka_waktu'],
			'file_kontrak' => $this->post['file_kontrak'],
			'jenis_rkap' => $this->post['jenis_rkap'],
			'prk_inti' => $this->post['prk_inti'],
			'deskripsi' => $this->post['deskripsi'], 'status' => $this->post['status'], 'jenis_niaga' => 2,
		);
	}

	protected function Rules()
	{
		return array("id_customer" => array(
			'field' => 'id_customer',
			'label' => 'Pelanggan',
			'rules' => "required|numeric",
		), "nama" => array(
			'field' => 'nama',
			'label' => 'Nama',
			'rules' => "required|max_length[2000]",
		), "jenis" => array(
			'field' => 'jenis',
			'label' => 'Jenis',
			'rules' => "numeric",
		), "jenis_rkap" => array(
			'field' => 'jenis',
			'label' => 'Jenis',
			'rules' => "numeric",
		), "deskripsi" => array(
			'field' => 'deskripsi',
			'label' => 'Deskripsi',
			'rules' => "max_length[4000]",
		), "prk_inti" => array(
			'field' => 'prk_inti',
			'label' => 'PRK Inti',
			'rules' => "max_length[100]",
		), "status" => array(
			'field' => 'status',
			'label' => 'Status',
			'rules' => "numeric",
		),"jangka_waktu" => array(
			'field' => 'jangka_waktu',
			'label' => 'Jangka Waktu',
			'rules' => "required|numeric",
		), "file_kontrak" => array(
			'field' => 'file_kontrak',
			'label' => 'File Kontrak',
			'rules' => "max_length[500]",
		),
	);
	}

	

	protected function _afterDetail($id)
	{
		$this->data['rowheader'] = $this->data['row'];

		if(!$this->data['row']['file1']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from t_files
				where jenis_file = 'file1' and  nama_ref = 'kontrak_detail' and id_ref = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file1']['id'] = $r[$this->modelfile->pk];
				$this->data['row']['file1']['name'] = $r['client_name'];
			}
		}
		if(!$this->data['row']['file2']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from t_files
				where jenis_file = 'file2' and  nama_ref = 'kontrak_detail' and id_ref = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file2']['id'] = $r[$this->modelfile->pk];
				$this->data['row']['file2']['name'] = $r['client_name'];
			}
		}
		if(!$this->data['row']['file3']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from t_files
				where jenis_file = 'file3' and nama_ref = 'kontrak_detail' and id_ref = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file3']['id'] = $r[$this->modelfile->pk];
				$this->data['row']['file3']['name'] = $r['client_name'];
			}
		}
		if(!$this->data['row']['file4']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from t_files
				where jenis_file = 'file4' and  nama_ref = 'kontrak_detail' and id_ref = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file4']['id'] = $r[$this->modelfile->pk];
				$this->data['row']['file4']['name'] = $r['client_name'];
			}
		}
		if(!$this->data['row']['file5']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from t_files
				where jenis_file = 'file5' and  nama_ref = 'kontrak_detail' and id_ref = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file5']['id'] = $r[$this->modelfile->pk];
				$this->data['row']['file5']['name'] = $r['client_name'];
			}
		}
	}

	protected function _afterUpdate($id){
		return $this->_afterInsert($id);
	}

	protected function _afterInsert($id){
		$ret = true;
		
		if($ret)
			$ret = $this->_delsertFiles($id);

		return $ret;
	}

	private function _delsertFiles($id = null){
		$ret = true;

		if(count($this->post['file1'])){
			$ret = $this->_updateFiles(array('jenis_file'=>'file1','id_ref'=>$id,'nama_ref'=>'kontrak_detail'), $this->post['file1']['id']);
		}
		if(count($this->post['file2'])){
			$ret = $this->_updateFiles(array('jenis_file'=>'file2','id_ref'=>$id,'nama_ref'=>'kontrak_detail'), $this->post['file2']['id']);
		}
		if(count($this->post['file3'])){
			$ret = $this->_updateFiles(array('jenis_file'=>'file3','id_ref'=>$id,'nama_ref'=>'kontrak_detail'), $this->post['file3']['id']);
		}
		if(count($this->post['file4'])){
			$ret = $this->_updateFiles(array('jenis_file'=>'file4','id_ref'=>$id,'nama_ref'=>'kontrak_detail'), $this->post['file4']['id']);
		}
		if(count($this->post['file5'])){
			$ret = $this->_updateFiles(array('jenis_file'=>'file5','id_ref'=>$id,'nama_ref'=>'kontrak_detail'), $this->post['file5']['id']);
		}
		
		return $ret;
	}
}
