<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Task extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/tasklist";
		$this->viewdetail = "panelbackend/taskdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		$this->data['width'] = "1000px";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Task';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Task';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Task';
			$this->data['edited'] = false;	
		}else{
			$this->data['width'] = "2000px";
			$this->data['page_title'] = 'Daftar Task';
		}

		$this->load->model("TaskModel","model");
		$this->load->model("Task_filesModel","modelfile");
		$this->load->model("Mt_tipe_kegiatan_taskModel","mttipekegiatantask");
		$this->data['mttipekegiatantaskarr'] = $this->mttipekegiatantask->GetCombo();
		unset($this->data['mttipekegiatantaskarr'][6]);
		$this->data['configfile'] = $this->config->item('file_upload_config');
		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'select2','datepicker','upload'
		);
	}

	public function Detail( $id=null, $is_fu=false){
		$this->data['is_fu'] = $is_fu;
		$this->_beforeDetail($id);

		$this->data['row'] = $this->model->GetByPk($id);

		if (!$this->data['row'])
			$this->NoData();

		$this->_afterDetail($id);


		if($this->data['is_fu']){
			$this->data['page_title'] = 'Follow Up';
			$this->viewdetail = "panelbackend/taskdetailfollowup";
		}

		$this->View($this->viewdetail);
	}

	public function Edit($id=null, $is_fu=false){

		if($this->post['act']=='reset'){
			redirect(current_url());
		}

		$this->data['is_fu'] = $is_fu;

		$this->_beforeDetail($id);

		$this->data['idpk'] = $id;

		$this->data['row'] = $this->model->GetByPk($id);

		if (!$this->data['row'] && $id)
			$this->NoData();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters("","");

		if($this->post && $this->post['act']<>'change'){
			if(!$this->data['row'])
				$this->data['row'] = array();

			$record = $this->Record($id);

			$this->data['row'] = array_merge($this->data['row'],$record);
			$this->data['row'] = array_merge($this->data['row'],$this->post);
		}

		$this->data['rules'] = $this->Rules();

		$this->_onDetail($id);

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

            $this->model->conn->CompleteTrans();

			if ($return['success']) {

				$this->_afterEditSucceed($id);

				SetFlash('suc_msg', $return['success']);
				redirect("$this->page_ctrl/detail/$id/$is_fu");

			} else {
				$this->data['row'] = array_merge($this->data['row'],$record);
				$this->data['row'] = array_merge($this->data['row'],$this->post);

				$this->_afterEditFailed($id);

				$this->data['err_msg'] = "Data gagal disimpan";
			}
		}

		$this->_afterDetail($id);

		if($this->data['is_fu']){
			$this->data['page_title'] = 'Follow Up';
			$this->viewdetail = "panelbackend/taskdetailfollowup";
		}

		$this->View($this->viewdetail);
	}

	protected function Header(){
		$kegiatanarr = $this->data['mttipekegiatantaskarr'];
		unset($kegiatanarr[5]);
		return array(
			array(
				'name'=>'nama', 
				'label'=>'Kegiatan', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'id_tipe_kegiatan_task', 
				'label'=>'Tipe Kegiatan', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$kegiatanarr,
			),
			array(
				'name'=>'nama_customer', 
				'label'=>'Customer', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'lokasi', 
				'label'=>'Lokasi', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'pegawai_nama', 
				'label'=>'Pegawai', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'tgl_awal', 
				'label'=>'Tgl. Awal', 
				'width'=>"auto",
				'type'=>"datetime",
			),
			array(
				'name'=>'tgl_akhir', 
				'label'=>'Tgl. Akhir', 
				'width'=>"auto",
				'type'=>"datetime",
			),
			array(
				'name'=>'nama_follow_up', 
				'label'=>'Follow Up', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'id_tipe_follow_up', 
				'label'=>'Tipe FU', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['mttipekegiatantaskarr'],
			),
		);
	}

	protected function Record($id=null){
		$return = array(
			'nama'=>$this->post['nama'],
			'catatan'=>$this->post['catatan'],
			'id_tipe_kegiatan_task'=>($this->post['id_tipe_kegiatan_task']),
			'id_customer'=>($this->post['id_customer']),
			'lokasi'=>$this->post['lokasi'],
			'id_pegawai'=>$this->post['id_pegawai'],
			'tgl_awal'=>($this->post['tgl_awal']),
			'tgl_akhir'=>($this->post['tgl_akhir']),
		);

		$return['pegawai_nama'] = $this->conn->GetOne("select nama from mt_pegawai where nid = ".$this->conn->escape($this->post['id_pegawai']));

		if($this->data['is_fu']){
			$return = array(
				'nama'=>$this->post['nama'],
				'nama_follow_up'=>$this->post['nama_follow_up'],
				'catatan_follow_up'=>$this->post['catatan_follow_up'],
				'id_tipe_follow_up'=>($this->post['id_tipe_follow_up']),
				'lokasi_follow_up'=>$this->post['lokasi_follow_up'],
				'id_pegawai_follow_up'=>$this->post['id_pegawai_follow_up'],
				'tgl_awal_follow_up'=>($this->post['tgl_awal_follow_up']),
				'tgl_akhir_follow_up'=>($this->post['tgl_akhir_follow_up']),
			);

			$return['pegawai_follow_up_nama'] = $this->conn->GetOne("select nama from mt_pegawai where nid = ".$this->conn->escape($this->post['id_pegawai_follow_up']));
		}

		return $return;
	}

	protected function _afterDetail($id){
		$this->data['pegawaiarr'][$this->data['row']['id_pegawai']] = $this->data['row']['pegawai_nama'];
		$this->data['pegawaiarr'][$this->data['row']['id_pegawai_follow_up']] = $this->data['row']['pegawai_follow_up_nama'];

		$this->data['customerarr'][$this->data['row']['id_customer']] = $this->conn->GetOne("select nama from customer where id_customer = ".$this->conn->escape($this->data['row']['id_customer']));


		if(!$this->data['row']['file']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from task_files
				where jenis_file = 'file' and {$this->pk} = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row'][$r['jenis_file']]['id'] = $r[$this->modelfile->pk];
				$this->data['row'][$r['jenis_file']]['name'] = $r['client_name'];
			}
		}

		if(!$this->data['row']['ffu']['id'] && $id){
			$rows = $this->conn->GetArray("select *
				from task_files
				where jenis_file = 'ffu' and {$this->pk} = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row'][$r['jenis_file']]['id'] = $r[$this->modelfile->pk];
				$this->data['row'][$r['jenis_file']]['name'] = $r['client_name'];
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
			$ret = $this->_updateFiles(array($this->pk=>$id), $this->post['file']['id']);
		}
		
		if(count($this->post['ffu'])){
			$ret = $this->_updateFiles(array($this->pk=>$id), $this->post['ffu']['id']);
		}
		return $ret;
	}

	protected function Rules(){
		$return = array(
			"nama"=>array(
				'field'=>'nama', 
				'label'=>'Nama', 
				'rules'=>"required|max_length[1000]",
			),
			"catatan"=>array(
				'field'=>'catatan', 
				'label'=>'Catatan', 
				'rules'=>"max_length[1000]",
			),
			"id_tipe_kegiatan_task"=>array(
				'field'=>'id_tipe_kegiatan_task', 
				'label'=>'Tipe Kegiatan Task', 
				'rules'=>"required|numeric|max_length[10]",
			),
			"id_customer"=>array(
				'field'=>'id_customer', 
				'label'=>'Customer', 
				'rules'=>"required|numeric|max_length[10]",
			),
			"lokasi"=>array(
				'field'=>'lokasi', 
				'label'=>'Lokasi', 
				'rules'=>"required|max_length[200]",
			),
			"id_pegawai"=>array(
				'field'=>'id_pegawai', 
				'label'=>'Pegawai', 
				'rules'=>"required|max_length[20]",
			),
			"tgl_awal"=>array(
				'field'=>'tgl_awal', 
				'label'=>'Tgl. Awal', 
				'rules'=>"required",
			),
			"tgl_akhir"=>array(
				'field'=>'tgl_akhir', 
				'label'=>'Tgl. Akhir', 
				'rules'=>"required",
			),
		);

		if($this->data['is_fu']){
			$return = array(
				"nama"=>array(
					'field'=>'nama', 
					'label'=>'Nama', 
					'rules'=>"required|max_length[1000]",
				),
				"nama_follow_up"=>array(
					'field'=>'nama_follow_up', 
					'label'=>'Nama Follow UP', 
					'rules'=>"required|max_length[1000]",
				),
				"catatan_follow_up"=>array(
					'field'=>'catatan_follow_up', 
					'label'=>'Catatan Follow UP', 
					'rules'=>"max_length[1000]",
				),
				"id_tipe_follow_up"=>array(
					'field'=>'id_tipe_follow_up', 
					'label'=>'Tipe Follow UP', 
					'rules'=>"required|in_list[".implode(",", array_keys($this->data['mttipekegiatantaskarr']))."]|max_length[10]",
				),
				"lokasi_follow_up"=>array(
					'field'=>'lokasi_follow_up', 
					'label'=>'Lokasi Follow UP', 
					'rules'=>"max_length[200]",
				),
				"tgl_awal_follow_up"=>array(
					'field'=>'tgl_awal_follow_up', 
					'label'=>'Tgl. Awal Follow UP', 
					'rules'=>"",
				),
				"tgl_akhir_follow_up"=>array(
					'field'=>'tgl_akhir_follow_up', 
					'label'=>'Tgl. Akhir Follow UP', 
					'rules'=>"",
				),
			);
		}

		return $return;
	}

}