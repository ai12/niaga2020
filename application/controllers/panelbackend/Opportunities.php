<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Opportunities extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/opportunitieslist";
		$this->viewdetail = "panelbackend/opportunitiesdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Opportunities';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Opportunities';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Opportunities';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Opportunities';
		}

		$this->data['width'] = "1800px";

		$this->load->model("OpportunitiesModel","model");
		$this->load->model("Mt_type_opportunitiesModel","mttypeopportunities");
		$this->data['mttypeopportunitiesarr'] = $this->mttypeopportunities->GetCombo();

		
		$this->load->model("Mt_jenis_opportunitiesModel","mtjenisopportunities");
		$this->data['mtjenisopportunitiesarr'] = $this->mtjenisopportunities->GetCombo();

		$this->data['statusarr'] = array(''=>'','0'=>'Belum ditindak lanjuti','1'=>'Sudah ditindak lanjuti');

		$this->data['picarr'] = $this->conn->GetList("select nid as key, nama as val from mt_pegawai 
			where nid in (select nid from public_sys_user)");
		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'datepicker','select2'
		);
	}

	protected function Header(){
		return array(
			array(
				'name'=>'nama', 
				'label'=>'Nama', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'nama_customer', 
				'label'=>'Customer', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'id_jenis_opportunities', 
				'label'=>'Jenis', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['mtjenisopportunitiesarr'],
			),
			array(
				'name'=>'id_tipe_opportunities', 
				'label'=>'Tipe', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['mttypeopportunitiesarr'],
			),
			array(
				'name'=>'tahun_rencana', 
				'label'=>'Tahun Rencana', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'tanggal', 
				'label'=>'Tanggal', 
				'width'=>"auto",
				'type'=>"date",
			),
			array(
				'name'=>'nama_pic', 
				'label'=>'PIC', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'perkiraan_nilai_kontrak', 
				'label'=>'Perkiraan Nilai Kontrak', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'status', 
				'label'=>'Status', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['statusarr'],
			),
			/*array(
				'name'=>'keterangan', 
				'label'=>'Keterangan', 
				'width'=>"auto",
				'type'=>"varchar2",
			),*/
		);
	}

	protected function Record($id=null){
		$return = array(
			'nama'=>$this->post['nama'],
			'id_customer'=>($this->post['id_customer']),
			'id_jenis_opportunities'=>($this->post['id_jenis_opportunities']),
			'id_tipe_opportunities'=>($this->post['id_tipe_opportunities']),
			'tahun_rencana'=>($this->post['tahun_rencana']),
			'tanggal'=>$this->post['tanggal'],
			'id_pic'=>$this->post['id_pic'],
			'perkiraan_nilai_kontrak'=>Rupiah2Number($this->post['perkiraan_nilai_kontrak']),
			'status'=>($this->post['status']),
			'keterangan'=>$this->post['keterangan'],
		);

		$return['nama_customer'] = $this->conn->GetOne("select nama from customer where id_customer = ".$this->conn->escape($return['id_customer']));
		$return['nama_pic'] = $this->conn->GetOne("select nama from mt_pegawai where nid = ".$this->conn->escape($return['id_pic']));

		return $return;
	}

	protected function Rules(){
		return array(
			"nama"=>array(
				'field'=>'nama', 
				'label'=>'Nama', 
				'rules'=>"required|max_length[1000]",
			),
			"id_jenis_opportunities"=>array(
				'field'=>'id_jenis_opportunities', 
				'label'=>'Jenis Opportunities', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['mtjenisopportunitiesarr']))."]|max_length[10]",
			),
			"id_tipe_opportunities"=>array(
				'field'=>'id_tipe_opportunities', 
				'label'=>'Tipe Opportunities', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['mttypeopportunitiesarr']))."]|max_length[10]",
			),
			"tahun_rencana"=>array(
				'field'=>'tahun_rencana', 
				'label'=>'Tahun Rencana', 
				'rules'=>"required|numeric|max_length[10]",
			),
			"tanggal"=>array(
				'field'=>'tanggal', 
				'label'=>'Tanggal', 
				'rules'=>"required",
			),
			"id_pic"=>array(
				'field'=>'id_pic', 
				'label'=>'PIC', 
				'rules'=>"required|max_length[18]",
			),
			"id_customer"=>array(
				'field'=>'id_customer', 
				'label'=>'Customer', 
				'rules'=>"required|max_length[18]",
			),/*
			"perkiraan_nilai_kontrak"=>array(
				'field'=>'perkiraan_nilai_kontrak', 
				'label'=>'Perkiraan Nilai Kontrak', 
				'rules'=>"numeric",
			),*/
			"status"=>array(
				'field'=>'status', 
				'label'=>'Status', 
				'rules'=>"numeric|max_length[10]",
			),
			"keterangan"=>array(
				'field'=>'keterangan', 
				'label'=>'Keterangan', 
				'rules'=>"max_length[2000]",
			),
		);
	}

	protected function _afterDetail($id=null){
		$this->data['picarr'][$this->data['row']['id_pic']] = $this->data['row']['nama_pic'];
		$this->data['customerarr'][$this->data['row']['id_customer']] = $this->data['row']['nama_customer'];
	}
}