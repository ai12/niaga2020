<?php
defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . "core/_adminController.php";
class T_kontrak_hist extends _adminController
{

	public function __construct()
	{
		parent::__construct();
	}

	protected function init()
	{
		parent::init();
		$this->viewlist = "panelbackend/t_kontrak_histlist";
		$this->viewdetail = "panelbackend/t_kontrak_histdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout_kontrak";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah History Kontrak';
			$this->data['edited'] = true;
		} elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit  History Kontrak';
			$this->data['edited'] = true;
		} elseif ($this->mode == 'detail') {
			$this->data['page_title'] = 'Detail  History Kontrak';
			$this->data['edited'] = false;
		} else {
			$this->data['page_title'] = 'Daftar  History Kontrak';
		}

		$this->data['width'] = "100%";

		$this->load->model("T_kontrak_histModel", "model");
		$this->load->model("t_kontrakModel","kontrak");

		$this->data['statusarr'] = [null => '', '0' => 'OnGoing', '1' => 'Finished'];


		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'upload','datepicker','select2'
		);

		// untuk upload
		$this->load->model("T_filesModel","modelfile");
		// $this->plugin_arr = array(
		// 	'upload'
		// );
		$this->data['configfile'] = $this->config->item('file_upload_config');
		$this->data['configfile']['allowed_types'] = 'pdf|jpg|jpeg';
		$this->config->set_item('file_upload_config',$this->data['configfile']);
		//------
	}

	protected function Header()
	{
		return array(
		// array(
		// 	'name' => 'id_kontrak',
		// 	'label' => 'Id_kontrak',
		// 	'width' => "auto",
		// 	'type' => "number",
		// ), 
		array(
			'name' => 'nama',
			'label' => 'Nama',
			'width' => "auto",
			'type' => "varchar2",
		), array(
			'name' => 'no_pihak1',
			'label' => 'No Pihak 1',
			'width' => "auto",
			'type' => "varchar2",
		), array(
			'name' => 'no_pihak2',
			'label' => 'No Pihak 2',
			'width' => "auto",
			'type' => "varchar2",
		), array(
			'name' => 'tgl_kontrak',
			'label' => 'Tgl Kontrak',
			'width' => "auto",
			'type' => "date",
		), array(
			'name' => 'tgl_mulai',
			'label' => 'Tgl Mulai',
			'width' => "auto",
			'type' => "date",
		), array(
			'name' => 'tgl_selesai',
			'label' => 'Tgl Selesai',
			'width' => "auto",
			'type' => "date",
		), array(
			'name' => 'deskripsi',
			'label' => 'Catatan',
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
		return array('id_kontrak' => $this->post['id_kontrak'], 
		'nama' => $this->post['nama'], 'no_pihak1' => $this->post['no_pihak1'], 'no_pihak2' => $this->post['no_pihak2'], 'tgl_kontrak' => $this->post['tgl_kontrak'], 'tgl_mulai' => $this->post['tgl_mulai'], 'tgl_selesai' => $this->post['tgl_selesai'], 'deskripsi' => $this->post['deskripsi'], 'status' => $this->post['status'],);
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

	protected function Rules()
	{
		return array(
		// "id_kontrak" => array(
		// 	'field' => 'id_kontrak',
		// 	'label' => 'Id_kontrak',
		// 	'rules' => "required|numeric",
		// ),
		 "nama" => array(
			'field' => 'nama',
			'label' => 'Nama',
			'rules' => "required|max_length[2000]",
		), "no_pihak1" => array(
			'field' => 'no_pihak1',
			'label' => 'No_pihak1',
			'rules' => "required|max_length[2000]",
		), "no_pihak2" => array(
			'field' => 'no_pihak2',
			'label' => 'No_pihak2',
			'rules' => "required|max_length[2000]",
		), "tgl_kontrak" => array(
			'field' => 'tgl_kontrak',
			'label' => 'Tgl_kontrak',
			'rules' => "required",
		), "tgl_mulai" => array(
			'field' => 'tgl_mulai',
			'label' => 'Tgl_mulai',
			'rules' => "required",
		), "tgl_selesai" => array(
			'field' => 'tgl_selesai',
			'label' => 'Tgl_selesai',
			'rules' => "required",
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

	public function Index($id_kontrak=0, $page=0){
		
		$this->_beforeDetail($id_kontrak);
		$this->data['header']=$this->Header();
		$this->_setFilter("id_kontrak = ".$this->conn->escape($id_kontrak));
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
		$this->data['rowheader'] = $this->kontrak->GetByPk($id_kontrak);
		$this->data['rowheader1'] = $this->data['row'];
		$this->data['add_param'] .= $id_kontrak;
	}

	// protected function _afterDetail($id=null){
	// 	//if(!$this->data['row'] && $id){
	// 		$rows = $this->conn->GetArray("select *
	// 			from t_kontrak_hist
	// 			where id_kontrak_hist = ".$this->conn->escape($id));

	// 		$ba_nego = [];
	// 		foreach($rows as $r){
	// 			$surat_permohonan['id'] = $r['id_kontrak_hist'];
	// 			$surat_permohonan['name'] = $r['surat_permohonan'];
				
	// 			$notulen_rapat['id'] = $r['id_kontrak_hist'];
	// 			$notulen_rapat['name'] = $r['notulen_rapat'];
				
	// 			$penawaran_harga['id'] = $r['id_kontrak_hist'];
	// 			$penawaran_harga['name'] = $r['penawaran_harga'];
				
	// 			$hpp_lampiran['id'] = $r['id_kontrak_hist'];
	// 			$hpp_lampiran['name'] = $r['hpp_lampiran'];
					
	// 			$amandemen['id'] = $r['id_kontrak_hist'];
	// 			$amandemen['name'] = $r['amandemen'];
				
				
	// 			$ba_nego['id'] = $r['id_kontrak_hist'];
	// 			$ba_nego['name'] = $r['ba_nego'];
	// 		}
	// 		$this->data['row']['surat_permohonan'] = $surat_permohonan;
	// 		$this->data['row']['notulen_rapat'] = $notulen_rapat;
	// 		$this->data['row']['penawaran_harga'] = $penawaran_harga;
	// 		$this->data['row']['ba_nego'] = $ba_nego;
	// 		$this->data['row']['hpp_lampiran'] = $hpp_lampiran;
	// 		$this->data['row']['amandemen'] = $amandemen;
	// 	//}
	// 	//echo '<pre>';print_r($this->data['row']);exit;
	// }

	protected function _afterDetail($id)
	{
		

		if(!$this->data['row']['file1']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from t_files
				where jenis_file = 'file1' and  nama_ref = 'kontrak_hist' and id_ref = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file1']['id'] = $r[$this->modelfile->pk];
				$this->data['row']['file1']['name'] = $r['client_name'];
			}
		}
		if(!$this->data['row']['file2']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from t_files
				where jenis_file = 'file2' and  nama_ref = 'kontrak_hist' and id_ref = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file2']['id'] = $r[$this->modelfile->pk];
				$this->data['row']['file2']['name'] = $r['client_name'];
			}
		}
		if(!$this->data['row']['file3']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from t_files
				where jenis_file = 'file3' and nama_ref = 'kontrak_hist' and id_ref = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file3']['id'] = $r[$this->modelfile->pk];
				$this->data['row']['file3']['name'] = $r['client_name'];
			}
		}
		if(!$this->data['row']['file4']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from t_files
				where jenis_file = 'file4' and  nama_ref = 'kontrak_hist' and id_ref = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file4']['id'] = $r[$this->modelfile->pk];
				$this->data['row']['file4']['name'] = $r['client_name'];
			}
		}
		if(!$this->data['row']['file5']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from t_files
				where jenis_file = 'file5' and  nama_ref = 'kontrak_hist' and id_ref = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file5']['id'] = $r[$this->modelfile->pk];
				$this->data['row']['file5']['name'] = $r['client_name'];
			}
		}
		if(!$this->data['row']['file6']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from t_files
				where jenis_file = 'file6' and  nama_ref = 'kontrak_hist' and id_ref = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file6']['id'] = $r[$this->modelfile->pk];
				$this->data['row']['file6']['name'] = $r['client_name'];
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
			$ret = $this->_updateFiles(array('jenis_file'=>'file1','id_ref'=>$id,'nama_ref'=>'kontrak_hist'), $this->post['file1']['id']);
		}
		if(count($this->post['file2'])){
			$ret = $this->_updateFiles(array('jenis_file'=>'file2','id_ref'=>$id,'nama_ref'=>'kontrak_hist'), $this->post['file2']['id']);
		}
		if(count($this->post['file3'])){
			$ret = $this->_updateFiles(array('jenis_file'=>'file3','id_ref'=>$id,'nama_ref'=>'kontrak_hist'), $this->post['file3']['id']);
		}
		if(count($this->post['file4'])){
			$ret = $this->_updateFiles(array('jenis_file'=>'file4','id_ref'=>$id,'nama_ref'=>'kontrak_hist'), $this->post['file4']['id']);
		}
		if(count($this->post['file5'])){
			$ret = $this->_updateFiles(array('jenis_file'=>'file5','id_ref'=>$id,'nama_ref'=>'kontrak_hist'), $this->post['file5']['id']);
		}
		if(count($this->post['file6'])){
			$ret = $this->_updateFiles(array('jenis_file'=>'file6','id_ref'=>$id,'nama_ref'=>'kontrak_hist'), $this->post['file6']['id']);
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
