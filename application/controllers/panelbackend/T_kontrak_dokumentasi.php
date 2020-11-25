<?php
defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . "core/_adminController.php";
class T_kontrak_dokumentasi extends _adminController
{

	public function __construct()
	{
		parent::__construct();
	}

	protected function init()
	{
		parent::init();
		$this->viewlist = "panelbackend/dokumentasilist";
		$this->viewdetail = "panelbackend/dokumentasidetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout_kontrak";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Dokumentasi';
			$this->data['edited'] = true;
		} elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Dokumentasi';
			$this->data['edited'] = true;
		} elseif ($this->mode == 'detail') {
			$this->data['page_title'] = 'Detail Dokumentasi';
			$this->data['edited'] = false;
		} else {
			$this->data['page_title'] = 'Daftar Dokumentasi';
		}

		$this->data['width'] = "100%";

		$this->load->model("DokumentasiModel", "model");
		$this->load->model("t_kontrakModel","kontrak");

		$this->data['jenisarr'] = [null => '','DRAFT'=>'Draft', 'UNDANGAN'=>'Surat undangan / Pendaftaran (atas penugasan)','SURAT_PENUGASAN' => 'Surat Penugasan', 'RKS'=>'RKS',  'PERMINTAAN'=>'Permintaan','BA_AANWIJZING'=> 'BA Aanwijzing', 'PENAWARAN_HARGA'=>'Penawaran Harga', 'BA_NEGO'=>'BA Nego','LAIN'=>'Lain-lain'];
		$this->data['statusarr'] = [null => '', '0' => 'Temp', '1' => 'Final'];

		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		
		// untuk upload
		$this->load->model("T_filesModel","modelfile");
		$this->plugin_arr = array(
			'upload'
		);
		$this->data['configfile'] = $this->config->item('file_upload_config');
		$this->data['configfile']['allowed_types'] = 'pdf';
		$this->config->set_item('file_upload_config',$this->data['configfile']);
		//------
	}
	protected function Header()
	{
		return array(
		// array(
		// 	'name' => 'ref_id',
		// 	'label' => 'Ref_id',
		// 	'width' => "auto",
		// 	'type' => "number",
		// ), 
		// array(
		// 	'name' => 'ref_nama',
		// 	'label' => 'Ref_nama',
		// 	'width' => "auto",
		// 	'type' => "varchar2",
		// ), 
		array(
			'name' => 'nomor',
			'label' => 'Nomor Dokumen',
			'width' => "auto",
			'type' => "varchar2",
		), 
		array(
			'name' => 'jenis',
			'label' => 'Jenis',
			'width' => "auto",
			'type' => "list",
			'value'=>$this->data['jenisarr'],
		), 
		array(
			'name' => 'path',
			'label' => 'Path',
			'width' => "auto",
			'type' => "varchar2",
		), array(
			'name' => 'status',
			'label' => 'Status',
			'width' => "auto",
			'type' => "list",
			'value'=>$this->data['statusarr'],
		),);
	}

	protected function Record($id = null)
	{
		return array('ref_id' => $this->post['ref_id'], 
		// 'ref_nama' => $this->post['ref_nama'],
		'ref_nama' => 't_kontrak',
		'nomor' => $this->post['nomor'],
		'jenis' => $this->post['jenis'],	
		'path' => $this->post['path'], 'status' => $this->post['status'],);
	}

	protected function Rules()
	{
		return array(
		// "ref_id" => array(
		// 	'field' => 'ref_id',
		// 	'label' => 'Ref_id',
		// 	'rules' => "required|numeric",
		// ), "ref_nama" => array(
		// 	'field' => 'ref_nama',
		// 	'label' => 'Ref_nama',
		// 	'rules' => "required|max_length[50]",
		// ), 
		"jenis" => array(
			'field' => 'jenis',
			'label' => 'Jenis',
			'rules' => "required|max_length[100]",
		), 
		"jenis" => array(
			'field' => 'nomor',
			'label' => 'Nomor Dokumen',
			'rules' => "required|max_length[1000]",
		), 
		"path" => array(
			'field' => 'path',
			'label' => 'Path',
			'rules' => "max_length[4000]",
		), "status" => array(
			'field' => 'status',
			'label' => 'Status',
			'rules' => "required|numeric",
		),);
	}

	public function Detail($id_kontrak=null, $id=null){

		$this->_beforeDetail($id_kontrak, $id);

		$this->data['row'] = $this->model->GetByPk($id);

		$this->_onDetail($id);

		if (!$this->data['row'] && !$this->data['rowheader'])
			$this->NoData();

		$this->_afterDetail($id);

		$this->View($this->viewdetail);
	}

	public function Index($id_kontrak=0, $page=0){
		
		$this->_beforeDetail($id_kontrak);
		$this->data['header']=$this->Header();
		$this->_setFilter("ref_id = ".$this->conn->escape($id_kontrak));
		$this->data['list']=$this->_getList($page);

		$this->data['page']=$page;

		$param_paging = array(
			'base_url'=>base_url("{$this->page_ctrl}/index/$id_kontrak"),
			'cur_page'=>$page,
			'total_rows'=>$this->data['list']['total'],
			'per_page'=>$this->limit,
			'first_tag_open'=>'<li>',
			'first_tag_close'=>'</li>',
			'last_tag_open'=>'<li>',
			'last_tag_close'=>'</li>',
			'cur_tag_open'=>'<li class="active"><a href="#">',
			'cur_tag_close'=>'</a></li>',
			'next_tag_open'=>'<li>',
			'next_tag_close'=>'</li>',
			'prev_tag_open'=>'<li>',
			'prev_tag_close'=>'</li>',
			'num_tag_open'=>'<li>',
			'num_tag_close'=>'</li>',
			'anchor_class'=>'pagination__page',

		);
		$this->load->library('pagination');

		$paging = $this->pagination;

		$paging->initialize($param_paging);

		$this->data['paging']=$paging->create_links();

		$this->data['limit']=$this->limit;

		$this->data['limit_arr']=$this->limit_arr;


		$this->View($this->viewlist);
	}

	public function Add($id_kontrak=0){
		$this->Edit($id_kontrak);
	}

	public function Edit($id_kontrak=0,$id=null){

		if($this->post['act']=='reset'){
			redirect(current_url());
		}

		$this->_beforeDetail($id_kontrak,$id);

		$this->data['idpk'] = $id;

		$this->data['row'] = $this->model->GetByPk($id);

		if (!$this->data['rowheader'] && !$this->data['row'] && $id)
			$this->NoData();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters("","");

		if(count($this->post) && $this->post['act']<>'change'){
			if(!$this->data['row'])
				$this->data['row'] = array();

			$record = $this->Record($id);

			$this->data['row'] = array_merge($this->data['row'],$record);
			$this->data['row'] = array_merge($this->data['row'],$this->post);
		}

		$this->_onDetail($id);

		$this->data['rules'] = $this->Rules();

		## EDIT HERE ##
		if ($this->post['act'] === 'save') {

			$this->_isValid($record,true);

            $this->_beforeEdit($record,$id);

            $this->_setLogRecord($record,$id);

            $this->model->conn->StartTrans();
			if (trim($this->data['row'][$this->pk])==trim($id) && trim($id)) {

				$return = $this->_beforeUpdate($record, $id);

				if($return){
					$return = $this->model->Update($record, "$this->pk = ".$this->conn->qstr($id));
				}

				if ($return['success']) {

					$this->log("mengubah ".json_encode($record));

					$return1 = $this->_afterUpdate($id);

					if(!$return1){
						$return = false;
					}
				}
			}else {

				$return = $this->_beforeInsert($record);

				if($return){
					$return = $this->model->Insert($record);
					$id = $return['data'][$this->pk];
				}

				if ($return['success']) {

					$this->log("menambah ".json_encode($record));

					$return1 = $this->_afterInsert($id);

					if(!$return1){
						$return = false;
					}
				}
			}

            $this->conn->CompleteTrans();

			if ($return['success']) {

				$this->_afterEditSucceed($id);

				SetFlash('suc_msg', $return['success']);
				redirect("$this->page_ctrl/detail/$id_kontrak/$id");

			} else {
				$this->data['row'] = array_merge($this->data['row'],$record);
				$this->data['row'] = array_merge($this->data['row'],$this->post);

				$this->_afterEditFailed($id);

				$this->data['err_msg'] = "Data gagal disimpan";
			}
		}

		$this->_afterDetail($id);

		$this->View($this->viewdetail);
	}

	protected function _beforeDetail($id_kontrak=null, $id=null){
		$this->data['id_kontrak'] = $id_kontrak;
		$this->data['ref_id'] = $id_kontrak;
		$this->data['rowheader'] = $this->kontrak->GetByPk($id_kontrak);
		$this->data['rowheader1'] = $this->data['row'];
		$this->data['add_param'] .= $id_kontrak;
	}

	protected function _afterDetail($id)
	{
		

		if(!$this->data['row']['file']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from t_files
				where nama_ref = 'kontrak_dok' and id_ref = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file']['id'] = $r[$this->modelfile->pk];
				$this->data['row']['file']['name'] = $r['client_name'];
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

		if(count($this->post['file'])){
			$ret = $this->_updateFiles(array('id_ref'=>$id,'nama_ref'=>'kontrak_dok'), $this->post['file']['id']);
		}
		
		return $ret;
	}

	public function delete( $parent = null, $id=null){

        $this->model->conn->StartTrans();

     

		$this->data['row'] = $this->model->GetByPk($id);

		if (!$this->data['row'])
			$this->NoData();

		$return = $this->model->delete("$this->pk = ".$this->conn->qstr($id));

		
        $this->model->conn->CompleteTrans();

		if ($return) {

			$this->log("menghapus ".json_encode($this->data['row']));

			SetFlash('suc_msg', $return['success']);
			redirect("$this->page_ctrl/index/$parent");
		}
		else {
			SetFlash('err_msg',"Data gagal didelete");
			redirect("$this->page_ctrl/index/$parent");
		}

	}

}
