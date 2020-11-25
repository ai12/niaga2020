<?php
defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . "core/_adminController.php";
class T_proyek_kontrak extends _adminController
{

	public function __construct()
	{
		parent::__construct();
	}

	protected function init()
	{
		parent::init();
		$this->viewlist = "panelbackend/t_kontrak_proyeklist";
		$this->viewdetail = "panelbackend/t_kontrak_proyekdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout-no-add";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Kontrak Proyek';
			$this->data['edited'] = true;
		} elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Kontrak Proyek';
			$this->data['edited'] = true;
		} elseif ($this->mode == 'detail') {
			$this->data['page_title'] = 'Detail Kontrak Proyek';
			// $this->layout = "panelbackend/layout_kontrak_proyek";
			$this->data['det_kontrak'] = $this->db->where('KONTRAKPROYEK_ID', $this->uri->segment(4))->get('T_KONTRAK_PROYEK_DETAIL')->row();
			$this->data['prep'] = $this->db->where('KONTRAKPROYEK_ID', $this->uri->segment(4))->get('T_KONTRAK_PROYEK_PREPARATION')->row();
			$this->data['exe'] = $this->db->where('KONTRAKPROYEK_ID', $this->uri->segment(4))->get('T_KONTRAK_PROYEK_EXE')->row();
			$this->data['finishing'] = $this->db->where('KONTRAKPROYEK_ID', $this->uri->segment(4))->get('T_KONTRAK_PROYEK_FINISHING2')->row();
			$this->data['finishing_detail'] = $this->db->where('KONTRAKPROYEK_ID', $this->uri->segment(4))->order_by('CREATED_AT','ASC')->get('T_KONTRAK_PROYEK_FINISHING1')->result();
			$this->data['dokumen_detail'] = $this->db->where('KONTRAKPROYEK_ID', $this->uri->segment(4))->order_by('CREATED_AT','ASC')->get('T_KONTRAK_PROYEK_DOKUMEN')->result();
			$this->data['pihak3'] = $this->db->where('KONTRAKPROYEK_ID', $this->uri->segment(4))->order_by('CREATED_AT','ASC')->get('T_KONTRAK_PROYEK_PIHAK3')->result();
			$this->data['edited'] = false;
		} else {
			$this->data['page_title'] = 'Daftar Kontrak Proyek';
		}

		$this->data['width'] = "100%";

		$this->load->model("T_kontrak_proyekModel", "model");

		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'datepicker'
		);
	}

	protected function Header()
	{
		return array(
			array(
				'name' => 'nama',
				'label' => 'Nama',
				'width' => "auto",
				'type' => "varchar2",
			), array(
				'name' => 'kontrak_no',
				'label' => 'No Kontrak',
				'width' => "auto",
				'type' => "number",
			), array(
				'name' => 'kontrak_tgl',
				'label' => 'Tgl. Kontrak',
				'width' => "auto",
				'type' => "date",
			), array(
				'name' => 'kontrak_nilai',
				'label' => 'Kontrak nilai',
				'width' => "auto",
				'type' => "number",
			), array(
				'name' => 'durasi',
				'label' => 'Durasi',
				'width' => "auto",
				'type' => "number",
			),
			// array(
			// 	'name' => 'rencana_tgl_mulai',
			// 	'label' => 'Rencana tgl mulai',
			// 	'width' => "auto",
			// 	'type' => "date",
			// ), array(
			// 	'name' => 'rencana_tgl_selesai',
			// 	'label' => 'Rencana tgl selesai',
			// 	'width' => "auto",
			// 	'type' => "date",
			// ), 
			array(
				'name' => 'tgl_mulai',
				'label' => 'Tgl mulai',
				'width' => "auto",
				'type' => "date",
			), array(
				'name' => 'tgl_selesai',
				'label' => 'Tgl selesai',
				'width' => "auto",
				'type' => "date",
			), array(
				'name' => 'no_prk',
				'label' => 'PRK',
				'width' => "auto",
				'type' => "varchar2",
			),
			// array(
			// 	'name' => 'manager',
			// 	'label' => 'Manager',
			// 	'width' => "auto",
			// 	'type' => "varchar2",
			// ), array(
			// 	'name' => 'jml_personil',
			// 	'label' => 'Jml personil',
			// 	'width' => "auto",
			// 	'type' => "number",
			// ), array(
			// 	'name' => 'no_prk',
			// 	'label' => 'No prk',
			// 	'width' => "auto",
			// 	'type' => "varchar2",
			// ), array(
			// 	'name' => 'tgl_prk',
			// 	'label' => 'Tgl prk',
			// 	'width' => "auto",
			// 	'type' => "date",
			// ), array(
			// 	'name' => 'progres_fisik',
			// 	'label' => 'Progres fisik',
			// 	'width' => "auto",
			// 	'type' => "number",
			// ), array(
			// 	'name' => 'progres_laporan',
			// 	'label' => 'Progres laporan',
			// 	'width' => "auto",
			// 	'type' => "number",
			// ), array(
			// 	'name' => 'kendala',
			// 	'label' => 'Kendala',
			// 	'width' => "auto",
			// 	'type' => "varchar2",
			// ), array(
			// 	'name' => 'deskripsi',
			// 	'label' => 'Deskripsi',
			// 	'width' => "auto",
			// 	'type' => "varchar2",
			// ), array(
			// 	'name' => 'status',
			// 	'label' => 'Status',
			// 	'width' => "auto",
			// 	'type' => "number",
			// ),
		);
	}

	protected function Record($id = null)
	{
		return array(
			'nama' => $this->post['nama'],
			'kontrak_no' => $this->post['kontrak_no'], 'kontrak_tgl' => $this->post['kontrak_tgl'],
			'kontrak_nilai' => Rupiah2Number($this->post['kontrak_nilai']), 'durasi' => $this->post['durasi'], 'rencana_tgl_mulai' => $this->post['rencana_tgl_mulai'], 'rencana_tgl_selesai' => $this->post['rencana_tgl_selesai'], 'tgl_mulai' => $this->post['tgl_mulai'], 'tgl_selesai' => $this->post['tgl_selesai'], 'tipe_pekerjaan' => $this->post['tipe_pekerjaan'], 'manager' => $this->post['manager'], 'jml_personil' => $this->post['jml_personil'], 'no_prk' => $this->post['no_prk'], 'tgl_prk' => $this->post['tgl_prk'], 'progres_fisik' => $this->post['progres_fisik'], 'progres_laporan' => $this->post['progres_laporan'], 'kendala' => $this->post['kendala'],
			// 'deskripsi' => $this->post['deskripsi'], 'status' => $this->post['status'],
		);
	}

	protected function Rules()
	{
		return array(
			"nama" => array(
				'field' => 'nama',
				'label' => 'Nama',
				'rules' => "required|max_length[2000]",
			), "kontrak_no" => array(
				'field' => 'kontrak_no',
				'label' => 'Kontrak no',
				'rules' => "required|max_length[2000]",
			), "kontrak_tgl" => array(
				'field' => 'kontrak_tgl',
				'label' => 'Kontrak tgl',
				'rules' => "required",
			), "kontrak_nilai" => array(
				'field' => 'kontrak_nilai',
				'label' => 'Kontrak nilai',
				'rules' => "required|numeric",
			), "durasi" => array(
				'field' => 'durasi',
				'label' => 'Durasi',
				'rules' => "required|numeric",
			), "rencana_tgl_mulai" => array(
				'field' => 'rencana_tgl_mulai',
				'label' => 'Rencana tgl mulai',
				'rules' => "required",
			), "rencana_tgl_selesai" => array(
				'field' => 'rencana_tgl_selesai',
				'label' => 'Rencana tgl selesai',
				'rules' => "required",
			), "tgl_mulai" => array(
				'field' => 'tgl_mulai',
				'label' => 'Tgl mulai',
				'rules' => "required",
			), "tgl_selesai" => array(
				'field' => 'tgl_selesai',
				'label' => 'Tgl selesai',
				'rules' => "required",
			), "tipe_pekerjaan" => array(
				'field' => 'tipe_pekerjaan',
				'label' => 'Tipe pekerjaan',
				'rules' => "required|max_length[100]",
			), "manager" => array(
				'field' => 'manager',
				'label' => 'Manager',
				'rules' => "required|max_length[100]",
			), "jml_personil" => array(
				'field' => 'jml_personil',
				'label' => 'Jml personil',
				'rules' => "required|numeric",
			), "no_prk" => array(
				'field' => 'no_prk',
				'label' => 'No prk',
				'rules' => "required|max_length[100]",
			), "tgl_prk" => array(
				'field' => 'tgl_prk',
				'label' => 'Tgl prk',
				'rules' => "required",
			), "progres_fisik" => array(
				'field' => 'progres_fisik',
				'label' => 'Progres fisik',
				'rules' => "numeric",
			), "progres_laporan" => array(
				'field' => 'progres_laporan',
				'label' => 'Progres laporan',
				'rules' => "numeric",
			), "kendala" => array(
				'field' => 'kendala',
				'label' => 'Kendala',
				'rules' => "max_length[4000]",
			),
			"deskripsi" => array(
				'field' => 'deskripsi',
				'label' => 'Deskripsi',
				'rules' => "max_length[4000]",
			), "status" => array(
				'field' => 'status',
				'label' => 'Status',
				'rules' => "numeric",
			),
		);
	}

	protected function _afterDetail($id){
		$this->data['rowheader'] = $this->data['row'];

	}
}
