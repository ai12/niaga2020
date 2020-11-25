<?php
defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . "core/_adminController.php";
class T_negosiasi_proyek extends _adminController
{

	public function __construct()
	{
		parent::__construct();
	}

	protected function init()
	{
		parent::init();
		$this->viewlist = "panelbackend/t_negosiasi_proyeklist";
		$this->viewdetail = "panelbackend/t_negosiasi_proyekdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Negosiasi';
			$this->data['edited'] = true;
		} elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Negosiasi';
			$this->data['edited'] = true;
		} elseif ($this->mode == 'detail') {
			$this->data['page_title'] = 'Detail Negosiasi';
			$this->data['edited'] = false;
		} else {
			$this->data['page_title'] = 'Daftar Negosiasi Proyek';
		}

		$this->data['width'] = "100%";

		$this->load->model("T_negosiasi_proyekModel", "model");
		$this->load->model("T_proposalModel", "proposalModel");
		$this->data['proposalarr'] = $this->proposalModel->GetCombo();
		$this->data['statusarr'] = array('' => '', '0' => 'Not Finishied', '1' => 'Finished');
		$this->data['configfile'] = $this->config->item('file_upload_config');

		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'upload'
		);
	}

	protected function Header()
	{
		return array(array(
			'name' => 'id_proposal',
			'label' => 'Proposal',
			'width' => "auto",
			'type' => "list",
			'value' => $this->data['proposalarr'],
		), array(
			'name' => 'judul_nego',
			'label' => 'Judul Nego',
			'width' => "auto",
			'type' => "varchar2",
		), array(
			'name' => 'ba_nego',
			'label' => 'Ba Nego',
			'width' => "auto",
			'type' => "varchar2",
		), array(
			'name' => 'deskripsi',
			'label' => 'Deskripsi',
			'width' => "auto",
			'type' => "varchar2",
		), array(
			'name' => 'status',
			'label' => 'Status',
			'width' => "auto",
			'type' => "list",
			'value' => $this->data['statusarr'],
		),);
	}

	protected function Record($id=null){
		return array('jenis_niaga'=>1,'id_proposal'=>$this->post['id_proposal'],'judul_nego'=>$this->post['judul_nego'],'ba_nego'=>$this->post['ba_nego'],'deskripsi'=>$this->post['deskripsi'],'status'=>$this->post['status'],);
	}

	protected function Rules()
	{
		return array("id_proposal" => array(
			'field' => 'id_proposal',
			'label' => 'Id_proposal',
			'rules' => "required|numeric",
		), "judul_nego" => array(
			'field' => 'judul_nego',
			'label' => 'Judul_nego',
			'rules' => "required|max_length[2000]",
		), "ba_nego" => array(
			'field' => 'ba_nego',
			'label' => 'Ba_nego',
			'rules' => "max_length[2000]",
		), "deskripsi" => array(
			'field' => 'deskripsi',
			'label' => 'Deskripsi',
			'rules' => "max_length[4000]",
		), "status" => array(
			'field' => 'status',
			'label' => 'Status',
			'rules' => "required|numeric",
		),);
	}
}