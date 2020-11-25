<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Customer_contacts extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/customer_contactslist";
		$this->viewdetail = "panelbackend/customer_contactsdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout_customer";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Customer Contacts';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Customer Contacts';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Customer Contacts';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Customer Contacts';
		}

		$this->data['width'] = "2600px";

		$this->load->model("Customer_contactsModel","model");
		$this->load->model("Mt_customer_statusModel","mtcustomerstatus");
		$this->data['mtcustomerstatusarr'] = $this->mtcustomerstatus->GetCombo();

		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'datepicker'
		);
	}

	public function Index($id_customer=0, $page=0){
		$this->_beforeDetail($id_customer);
		$this->data['header']=$this->Header();
		$this->_setFilter("id_customer = ".$this->conn->escape($id_customer));
		$this->data['list']=$this->_getList($page);

		$this->data['page']=$page;

		$param_paging = array(
			'base_url'=>base_url("{$this->page_ctrl}/index/$id_customer"),
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

	public function Add($id_customer=null){
		$this->Edit($id_customer);
	}

	public function Edit($id_customer=null, $id=null){

		if($this->post['act']=='reset'){
			redirect(current_url());
		}

		$this->_beforeDetail($id_customer, $id);

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
			$record['id_customer'] = $id_customer;
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
				redirect("$this->page_ctrl/detail/$id_customer/$id");

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

	public function Detail($id_customer=null, $id=null){

		$this->_beforeDetail($id_customer, $id);

		$this->data['row'] = $this->model->GetByPk($id);

		if (!$this->data['row'])
			$this->NoData();

		$this->_afterDetail($id);

		$this->View($this->viewdetail);
	}

	public function Delete($id_customer=null, $id=null){

        $this->model->conn->StartTrans();

        $this->_beforeDetail($id_customer, $id);

		$this->data['row'] = $this->model->GetByPk($id);

		if (!$this->data['row'])
			$this->NoData();

		$return = $this->_beforeDelete($id);

		if($return){
			$return = $this->model->delete("$this->pk = ".$this->conn->qstr($id));
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
			redirect("$this->page_ctrl/index/$id_customer");
		}
		else {
			SetFlash('err_msg',"Data gagal didelete");
			redirect("$this->page_ctrl/detail/$id_customer/$id");
		}

	}

	protected function _beforeDetail($id_customer=null, $id=null){
		$this->data['rowheader'] = $this->conn->GetRow("select * from customer where id_customer = ".$this->conn->escape($id_customer));

		$this->data['add_param'] .= $id_customer;
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
				'name'=>'posisi', 
				'label'=>'Posisi', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'id_status', 
				'label'=>'Status', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['mtcustomerstatusarr'],
			),
			array(
				'name'=>'tgl_lahir', 
				'label'=>'Tgl. Lahir', 
				'width'=>"auto",
				'type'=>"date",
			),
			array(
				'name'=>'alamat', 
				'label'=>'Alamat', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'telephone_1', 
				'label'=>'Telephone 1', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
		);
	}

	protected function Record($id=null){
		return array(
			'nama'=>$this->post['nama'],
			'posisi'=>$this->post['posisi'],
			'id_status'=>Rupiah2Number($this->post['id_status']),
			'tgl_lahir'=>$this->post['tgl_lahir'],
			'alamat'=>$this->post['alamat'],
			'telephone_1'=>$this->post['telephone_1'],
			'telephone_2'=>$this->post['telephone_2'],
			'fax'=>$this->post['fax'],
			'email_1'=>$this->post['email_1'],
			'email_2'=>$this->post['email_2'],
			'instagram'=>$this->post['instagram'],
			'facebook'=>$this->post['facebook'],
			'twitter'=>$this->post['twitter'],
		);
	}

	protected function Rules(){
		return array(
			"nama"=>array(
				'field'=>'nama', 
				'label'=>'Nama', 
				'rules'=>"required|max_length[200]",
			),
			"posisi"=>array(
				'field'=>'posisi', 
				'label'=>'Posisi', 
				'rules'=>"max_length[200]",
			),
			"id_status"=>array(
				'field'=>'id_status', 
				'label'=>'Status', 
				'rules'=>"in_list[".implode(",", array_keys($this->data['mtcustomerstatusarr']))."]|max_length[10]",
			),
			"alamat"=>array(
				'field'=>'alamat', 
				'label'=>'Alamat', 
				'rules'=>"max_length[2000]",
			),
			"telephone_1"=>array(
				'field'=>'telephone_1', 
				'label'=>'Telephone 1', 
				'rules'=>"max_length[20]",
			),
			"telephone_2"=>array(
				'field'=>'telephone_2', 
				'label'=>'Telephone 2', 
				'rules'=>"max_length[20]",
			),
			"fax"=>array(
				'field'=>'fax', 
				'label'=>'FAX', 
				'rules'=>"max_length[20]",
			),
			"email_1"=>array(
				'field'=>'email_1', 
				'label'=>'Email 1', 
				'rules'=>"email|max_length[200]",
			),
			"email_2"=>array(
				'field'=>'email_2', 
				'label'=>'Email 2', 
				'rules'=>"email|max_length[200]",
			),
			"instagram"=>array(
				'field'=>'instagram', 
				'label'=>'Instagram', 
				'rules'=>"max_length[200]",
			),
			"facebook"=>array(
				'field'=>'facebook', 
				'label'=>'Facebook', 
				'rules'=>"max_length[200]",
			),
			"twitter"=>array(
				'field'=>'twitter', 
				'label'=>'Twitter', 
				'rules'=>"max_length[200]",
			),
		);
	}

}