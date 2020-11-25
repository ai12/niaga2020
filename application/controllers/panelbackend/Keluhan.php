<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Keluhan extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/keluhanlist";
		$this->viewdetail = "panelbackend/keluhandetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Keluhan';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Keluhan';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Keluhan';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Keluhan';
		}

		$this->data['width'] = "1400px";

		$this->load->model("KeluhanModel","model");
		$this->load->model("proyekModel","proyek");
		$this->load->model("CustomerModel","mtcustomer");

		
		$this->load->model("Mt_urgensiModel","mturgensi");
		$this->data['mturgensiarr'] = $this->mturgensi->GetCombo();
		
		$this->load->model("Mt_kepuasanModel","mtkepuasan");
		$this->data['mtkepuasanarr'] = $this->mtkepuasan->GetCombo();
		$this->load->model("Mt_kategori_keluhanModel","mtkategorikeluhan");
		$this->data['mtkategoriarr'] = $this->mtkategorikeluhan->GetCombo();
		$this->data['statusarr'] = array(''=>'','1'=>'Belum ditindak lanjuti','2'=>'Distribusi', '3'=>'Action', '4'=>'Close');

		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'datepicker','select2'
		);
	}

	public function Add(){
		$this->Edit();
	}

	public function Edit($id=null){

		if($this->post['act']=='reset'){
			redirect(current_url());
		}

		$this->_beforeDetail($id);

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
				redirect("$this->page_ctrl/detail/$id");

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

	public function Detail($id=null){

		$this->_beforeDetail($id);

		$this->data['row'] = $this->model->GetByPk($id);

		$this->_onDetail($id);

		if (!$this->data['row'] && !$this->data['rowheader'])
			$this->NoData();

		$this->_afterDetail($id);

		$this->View($this->viewdetail);
	}

	protected function _afterDetail($id){
		$this->data['picarr'][$this->data['row']['pic']] = $this->data['row']['pic_nama'];
		$this->data['proyekarr'][$this->data['row']['id_proyek']] = $this->conn->GetOne("select nama_proyek from proyek where id_proyek = ".$this->conn->escape($this->data['row']['id_proyek']));
	}

	public function Delete($id=null){

        $this->model->conn->StartTrans();

        $this->_beforeDetail($id);

		$this->data['row'] = $this->model->GetByPk($id);
		
		$this->_onDetail($id);

		if (!$this->data['row'])
			$this->NoData();

		// $return = $this->_beforeDelete($id);
		$return = true;

		if($return){

			$record = array('is_deleted'=>1);
			
            $this->_setLogRecord($record,$id);

			$return = $this->model->Update($record,"$this->pk = ".$this->conn->qstr($id));
		}

		if($return){
			$return1 = $this->_afterDelete($id);
			if(!$return1)
				$return = false;
		}

        $this->model->conn->CompleteTrans();

		if ($return) {

			$this->log("menghapus ".json_encode($this->data['row']));

			SetFlash('suc_msg', $return['success']);
			redirect("$this->page_ctrl/index");
		}
		else {
			SetFlash('err_msg',"Data gagal didelete");
			redirect("$this->page_ctrl/detail/$id");
		}

	}

	protected function Header(){
		return array(
			array(
				'name'=>'nama_proyek', 
				'label'=>'Proyek', 
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
				'name'=>'tanggal', 
				'label'=>'Tanggal', 
				'width'=>"auto",
				'type'=>"date",
			),
			/*array(
				'name'=>'nama_orang', 
				'label'=>'Nama Orang', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'jabatan', 
				'label'=>'Jabatan', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'email', 
				'label'=>'Email', 
				'width'=>"auto",
				'type'=>"varchar2",
			),*/
			array(
				'name'=>'isi', 
				'label'=>'ISI', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'id_urgensi', 
				'label'=>'Urgensi', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['mturgensiarr'],
			),
			array(
				'name'=>'id_kategori_keluhan', 
				'label'=>'Kategori Keluhan', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['mtkategoriarr'],
			),
			array(
				'name'=>'status', 
				'label'=>'Status', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['statusarr'],
			),
		);
	}

	protected function Record($id=null){
		$ret = array(
			'id_proyek'=>$this->post['id_proyek'],
			'tanggal'=>$this->post['tanggal'],
			'nama_orang'=>$this->post['nama_orang'],
			'jabatan'=>$this->post['jabatan'],
			'email'=>$this->post['email'],
			'target'=>$this->post['target'],
			'isi'=>$this->post['isi'],
			'id_urgensi'=>($this->post['id_urgensi']),
			'id_kepuasan'=>($this->post['id_kepuasan']),
			'id_kategori_keluhan'=>($this->post['id_kategori_keluhan']),
			'catatan'=>($this->post['catatan']),
			'pic'=>($this->post['pic']),
			'tgl_distribusi'=>($this->post['tgl_distribusi']),
			'tgl_close'=>($this->post['tgl_close']),
			'tgl_action_plan'=>($this->post['tgl_action_plan']),
			'action_plan'=>($this->post['action_plan']),
			'tgl_action_plan_report'=>($this->post['tgl_action_plan_report']),
			'action_plan_report'=>($this->post['action_plan_report']),
		);

		$ret['id_customer'] = $this->conn->GetOne("select id_customer from proyek where id_proyek = ".$this->conn->escape($ret['id_proyek']));

		$ret['pic_nama'] = $this->conn->GetOne("select nama from mt_pegawai where nid = ".$this->conn->escape($ret['pic']));

		$ret['status'] = 1;
		if($ret['tgl_distribusi'])
			$ret['status'] = 2;
		if($ret['tgl_action_plan'])
			$ret['status'] = 3;
		if($ret['tgl_close'])
			$ret['status'] = 4;

		return $ret;
	}

	protected function Rules(){
		return array(
			/*"id_customer"=>array(
				'field'=>'id_customer', 
				'label'=>'Customer', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['mtcustomerarr']))."]|max_length[10]",
			),*/
			/*"id_proyek"=>array(
				'field'=>'id_proyek', 
				'label'=>'Proyek', 
				'rules'=>"required",
			),*/
			"tanggal"=>array(
				'field'=>'tanggal', 
				'label'=>'Tanggal', 
				'rules'=>"required",
			),
			"nama_orang"=>array(
				'field'=>'nama_orang', 
				'label'=>'Nama Orang', 
				'rules'=>"required|max_length[200]",
			),
			"jabatan"=>array(
				'field'=>'jabatan', 
				'label'=>'Jabatan', 
				'rules'=>"required|max_length[200]",
			),
			"email"=>array(
				'field'=>'email', 
				'label'=>'Email', 
				'rules'=>"required|valid_email|max_length[200]",
			),
			"isi"=>array(
				'field'=>'isi', 
				'label'=>'ISI', 
				'rules'=>"required|max_length[4000]",
			),
			"id_urgensi"=>array(
				'field'=>'id_urgensi', 
				'label'=>'Status Keluhan', 
				'rules'=>"in_list[".implode(",", array_keys($this->data['mturgensiarr']))."]|max_length[10]",
			),
		);
	}

}