<?php
defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . "core/_adminController.php";
class T_kontrak_pekerjaan extends _adminController
{

	public function __construct()
	{
		parent::__construct();
	}

	protected function init()
	{
		parent::init();
		$this->viewlist = "panelbackend/t_kontrak_pekerjaanlist";
		$this->viewdetail = "panelbackend/t_kontrak_pekerjaandetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout_kontrak_proyek";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Pekerjaan Pihak ketiga';
			$this->data['edited'] = true;
		} elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Pekerjaan Pihak ketiga';
			$this->data['edited'] = true;
		} elseif ($this->mode == 'detail') {
			$this->data['page_title'] = 'Detail Pekerjaan Pihak ketiga';
			$this->data['edited'] = false;
		} else {
			$this->data['page_title'] = 'Daftar Pekerjaan Pihak ketiga';
		}

		$this->data['width'] = "100%";

		$this->load->model("T_kontrak_pekerjaanModel", "model");
		$this->load->model("t_kontrak_proyekModel","kontrak");
		$this->data['statusarr'] = [null => '', '0' => 'On-Going', '1' => 'Selesai'];


		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'datepicker'
		);
	}

	protected function Header()
	{
		return array(
		// array(
		// 	'name' => 'id_kontrak_proyek',
		// 	'label' => 'Id kontrak proyek',
		// 	'width' => "auto",
		// 	'type' => "number",
		// ), 
		array(
			'name' => 'nama',
			'label' => 'Nama',
			'width' => "auto",
			'type' => "varchar2",
		), array(
			'name' => 'perusahaan',
			'label' => 'Perusahaan',
			'width' => "auto",
			'type' => "varchar2",
		),
		 array(
			'name' => 'nilai',
			'label' => 'Nilai',
			'width' => "auto",
			'type' => "number",
		), 
		array(
			'name' => 'tgl',
			'label' => 'Tgl',
			'width' => "auto",
			'type' => "timestamp",
		), 
		// array(
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
		return array('id_kontrak_proyek' => $this->post['id_kontrak_proyek'], 
		'nama' => $this->post['nama'], 'perusahaan' => $this->post['perusahaan'], 
		'nilai' => Rupiah2Number($this->post['nilai']), 'tgl' => $this->post['tgl'], 'deskripsi' => $this->post['deskripsi'], 'status' => $this->post['status'],);
	}

	protected function Rules()
	{
		return array("id_kontrak_proyek" => array(
			'field' => 'id_kontrak_proyek',
			'label' => 'Id kontrak proyek',
			'rules' => "required|numeric",
		), "nama" => array(
			'field' => 'nama',
			'label' => 'Nama',
			'rules' => "required|max_length[2000]",
		), "perusahaan" => array(
			'field' => 'perusahaan',
			'label' => 'Perusahaan',
			'rules' => "required|max_length[2000]",
		), "nilai" => array(
			'field' => 'nilai',
			'label' => 'Nilai',
			'rules' => "required|numeric",
		), "tgl" => array(
			'field' => 'tgl',
			'label' => 'Tgl',
			'rules' => "max_length[11]",
		), "deskripsi" => array(
			'field' => 'deskripsi',
			'label' => 'Deskripsi',
			'rules' => "max_length[4000]",
		), "status" => array(
			'field' => 'status',
			'label' => 'Status',
			'rules' => "numeric",
		),);
	}

	public function Detail($id_kontrak_proyek = null, $id = null)
	{

		$this->_beforeDetail($id_kontrak_proyek, $id);

		$this->data['row'] = $this->model->GetByPk($id);

		$this->_onDetail($id);

		if (!$this->data['row'] && !$this->data['rowheader'])
			$this->NoData();

		$this->_afterDetail($id);

		$this->View($this->viewdetail);
	}

	public function Index($id_kontrak_proyek = 0, $page = 0)
	{

		$this->_beforeDetail($id_kontrak_proyek);
		$this->data['header'] = $this->Header();
		$this->_setFilter("id_kontrak_proyek = " . $this->conn->escape($id_kontrak_proyek));
		$this->data['list'] = $this->_getList($page);

		$this->data['page'] = $page;

		$param_paging = array(
			'base_url' => base_url("{$this->page_ctrl}/index/$id_kontrak_proyek"),
			'cur_page' => $page,
			'total_rows' => $this->data['list']['total'],
			'per_page' => $this->limit,
			'first_tag_open' => '<li>',
			'first_tag_close' => '</li>',
			'last_tag_open' => '<li>',
			'last_tag_close' => '</li>',
			'cur_tag_open' => '<li class="active"><a href="#">',
			'cur_tag_close' => '</a></li>',
			'next_tag_open' => '<li>',
			'next_tag_close' => '</li>',
			'prev_tag_open' => '<li>',
			'prev_tag_close' => '</li>',
			'num_tag_open' => '<li>',
			'num_tag_close' => '</li>',
			'anchor_class' => 'pagination__page',

		);
		$this->load->library('pagination');

		$paging = $this->pagination;

		$paging->initialize($param_paging);

		$this->data['paging'] = $paging->create_links();

		$this->data['limit'] = $this->limit;

		$this->data['limit_arr'] = $this->limit_arr;


		$this->View($this->viewlist);
	}

	public function Add($id_kontrak_proyek = 0)
	{
		$this->Edit($id_kontrak_proyek);
	}

	public function Edit($id_kontrak_proyek = 0, $id = null)
	{

		if ($this->post['act'] == 'reset') {
			redirect(current_url());
		}

		$this->_beforeDetail($id_kontrak_proyek, $id);

		$this->data['idpk'] = $id;

		$this->data['row'] = $this->model->GetByPk($id);

		if (!$this->data['rowheader'] && !$this->data['row'] && $id)
			$this->NoData();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters("", "");

		if (count($this->post) && $this->post['act'] <> 'change') {
			if (!$this->data['row'])
				$this->data['row'] = array();

			$record = $this->Record($id);

			$this->data['row'] = array_merge($this->data['row'], $record);
			$this->data['row'] = array_merge($this->data['row'], $this->post);
		}

		$this->_onDetail($id);

		$this->data['rules'] = $this->Rules();

		## EDIT HERE ##
		if ($this->post['act'] === 'save') {

			$this->_isValid($record, true);

			$this->_beforeEdit($record, $id);

			$this->_setLogRecord($record, $id);

			$this->model->conn->StartTrans();
			if (trim($this->data['row'][$this->pk]) == trim($id) && trim($id)) {

				$return = $this->_beforeUpdate($record, $id);

				if ($return) {
					$return = $this->model->Update($record, "$this->pk = " . $this->conn->qstr($id));
				}

				if ($return['success']) {

					$this->log("mengubah " . json_encode($record));

					$return1 = $this->_afterUpdate($id);

					if (!$return1) {
						$return = false;
					}
				}
			} else {

				$return = $this->_beforeInsert($record);

				if ($return) {
					$return = $this->model->Insert($record);
					$id = $return['data'][$this->pk];
				}

				if ($return['success']) {

					$this->log("menambah " . json_encode($record));

					$return1 = $this->_afterInsert($id);

					if (!$return1) {
						$return = false;
					}
				}
			}

			$this->conn->CompleteTrans();

			if ($return['success']) {

				$this->_afterEditSucceed($id);

				SetFlash('suc_msg', $return['success']);
				redirect("$this->page_ctrl/detail/$id_kontrak_proyek/$id");
			} else {
				$this->data['row'] = array_merge($this->data['row'], $record);
				$this->data['row'] = array_merge($this->data['row'], $this->post);

				$this->_afterEditFailed($id);

				$this->data['err_msg'] = "Data gagal disimpan";
			}
		}

		$this->_afterDetail($id);

		$this->View($this->viewdetail);
	}

	protected function _beforeDetail($id_kontrak_proyek = null, $id = null)
	{
		$this->data['id_kontrak_proyek'] = $id_kontrak_proyek;
		$this->data['rowheader'] = $this->kontrak->GetByPk($id_kontrak_proyek);
		$this->data['rowheader1'] = $this->data['row'];
		$this->data['add_param'] .= $id_kontrak_proyek;
	}
}
