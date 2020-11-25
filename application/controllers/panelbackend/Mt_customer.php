<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Mt_customer extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/mt_customerlist";
		$this->viewdetail = "panelbackend/mt_customerdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Pelanggan';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Pelanggan';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Pelanggan';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Pelanggan';
		}

		$this->data['width'] = "8400px";

		$this->load->model("CustomerModel","model");
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			''
		);
	}

	protected function Header(){
		return array(
			array(
				'name'=>'nama', 
				'label'=>'Nama', 
				'width'=>"auto",
				'type'=>"char",
			),
			array(
				'name'=>'inv_addr_1', 
				'label'=>'Alamat', 
				'width'=>"auto",
				'type'=>"char",
			),
			array(
				'name'=>'inv_state', 
				'label'=>'Propinsi', 
				'width'=>"100px",
				'type'=>"char",
			),
			array(
				'name'=>'inv_phone', 
				'label'=>'Telephone', 
				'width'=>"100px",
				'type'=>"char",
			),
		);
	}

	protected function Record($id=null){
		return array(
			'cust_no'=>$this->post['cust_no'],
			'cust_status'=>$this->post['cust_status'],
			'nama'=>$this->post['nama'],
			'inv_addr_1'=>$this->post['inv_addr_1'],
			'inv_addr_2'=>$this->post['inv_addr_2'],
			'inv_addr_3'=>$this->post['inv_addr_3'],
			'inv_zip'=>$this->post['inv_zip'],
			'inv_phone'=>$this->post['inv_phone'],
			'inv_contact'=>$this->post['inv_contact'],
			'inv_state'=>$this->post['inv_state'],
			'inv_fax_no'=>$this->post['inv_fax_no'],
			'inv_tlx_name'=>$this->post['inv_tlx_name'],
			'inv_tlx_no'=>$this->post['inv_tlx_no'],
			'deliv_name'=>$this->post['deliv_name'],
			'deliv_addr_1'=>$this->post['deliv_addr_1'],
			'deliv_addr_2'=>$this->post['deliv_addr_2'],
			'deliv_addr_3'=>$this->post['deliv_addr_3'],
			'deliv_zip'=>$this->post['deliv_zip'],
			'deliv_phone'=>$this->post['deliv_phone'],
			'deliv_contact'=>$this->post['deliv_contact'],
			'deliv_state'=>$this->post['deliv_state'],
			'deliv_fax_no'=>$this->post['deliv_fax_no'],
			'deliv_tlx_name'=>$this->post['deliv_tlx_name'],
			'deliv_tlx_no'=>$this->post['deliv_tlx_no'],
			'cust_typex1'=>$this->post['cust_typex1'],
			'cust_typex2'=>$this->post['cust_typex2'],
			'cust_typex3'=>$this->post['cust_typex3'],
			'cust_typex4'=>$this->post['cust_typex4'],
			'cust_typex5'=>$this->post['cust_typex5'],
			'cust_typex6'=>$this->post['cust_typex6'],
			'currency_type'=>$this->post['currency_type'],
			'country_code'=>$this->post['country_code'],
			'linked_cust_no'=>$this->post['linked_cust_no'],
			'linked_supp_no'=>$this->post['linked_supp_no'],
			'cash_dstrct_code'=>$this->post['cash_dstrct_code'],
			'email_address'=>$this->post['email_address'],
			'last_mod_date'=>$this->post['last_mod_date'],
			'last_mod_time'=>$this->post['last_mod_time'],
			'last_mod_user'=>$this->post['last_mod_user'],
			'creation_date'=>$this->post['creation_date'],
			'rel_ent_code'=>$this->post['rel_ent_code'],
			'last_mod_emp'=>$this->post['last_mod_emp'],
		);
	}

	protected function Rules(){
		return array(
			"cust_no"=>array(
				'field'=>'cust_no', 
				'label'=>'Cust NO', 
				'rules'=>"required|max_length[24]",
			),
			"cust_status"=>array(
				'field'=>'cust_status', 
				'label'=>'Cust Status', 
				'rules'=>"required|max_length[4]",
			),
			"nama"=>array(
				'field'=>'nama', 
				'label'=>'Cust Name', 
				'rules'=>"required|max_length[128]",
			),
			"inv_addr_1"=>array(
				'field'=>'inv_addr_1', 
				'label'=>'INV Addr 1', 
				'rules'=>"required|max_length[128]",
			),
			"inv_addr_2"=>array(
				'field'=>'inv_addr_2', 
				'label'=>'INV Addr 2', 
				'rules'=>"required|max_length[128]",
			),
			"inv_addr_3"=>array(
				'field'=>'inv_addr_3', 
				'label'=>'INV Addr 3', 
				'rules'=>"required|max_length[128]",
			),
			"inv_zip"=>array(
				'field'=>'inv_zip', 
				'label'=>'INV ZIP', 
				'rules'=>"required|max_length[40]",
			),
			"inv_phone"=>array(
				'field'=>'inv_phone', 
				'label'=>'INV Phone', 
				'rules'=>"required|max_length[64]",
			),
			"inv_contact"=>array(
				'field'=>'inv_contact', 
				'label'=>'INV Contact', 
				'rules'=>"required|max_length[128]",
			),
			"inv_state"=>array(
				'field'=>'inv_state', 
				'label'=>'INV State', 
				'rules'=>"required|max_length[8]",
			),
			"inv_fax_no"=>array(
				'field'=>'inv_fax_no', 
				'label'=>'INV FAX NO', 
				'rules'=>"required|max_length[64]",
			),
			"inv_tlx_name"=>array(
				'field'=>'inv_tlx_name', 
				'label'=>'INV TLX Name', 
				'rules'=>"required|max_length[128]",
			),
			"inv_tlx_no"=>array(
				'field'=>'inv_tlx_no', 
				'label'=>'INV TLX NO', 
				'rules'=>"required|max_length[88]",
			),
			"deliv_name"=>array(
				'field'=>'deliv_name', 
				'label'=>'Deliv Name', 
				'rules'=>"required|max_length[128]",
			),
			"deliv_addr_1"=>array(
				'field'=>'deliv_addr_1', 
				'label'=>'Deliv Addr 1', 
				'rules'=>"required|max_length[128]",
			),
			"deliv_addr_2"=>array(
				'field'=>'deliv_addr_2', 
				'label'=>'Deliv Addr 2', 
				'rules'=>"required|max_length[128]",
			),
			"deliv_addr_3"=>array(
				'field'=>'deliv_addr_3', 
				'label'=>'Deliv Addr 3', 
				'rules'=>"required|max_length[128]",
			),
			"deliv_zip"=>array(
				'field'=>'deliv_zip', 
				'label'=>'Deliv ZIP', 
				'rules'=>"required|max_length[40]",
			),
			"deliv_phone"=>array(
				'field'=>'deliv_phone', 
				'label'=>'Deliv Phone', 
				'rules'=>"required|max_length[64]",
			),
			"deliv_contact"=>array(
				'field'=>'deliv_contact', 
				'label'=>'Deliv Contact', 
				'rules'=>"required|max_length[128]",
			),
			"deliv_state"=>array(
				'field'=>'deliv_state', 
				'label'=>'Deliv State', 
				'rules'=>"required|max_length[8]",
			),
			"deliv_fax_no"=>array(
				'field'=>'deliv_fax_no', 
				'label'=>'Deliv FAX NO', 
				'rules'=>"required|max_length[64]",
			),
			"deliv_tlx_name"=>array(
				'field'=>'deliv_tlx_name', 
				'label'=>'Deliv TLX Name', 
				'rules'=>"required|max_length[128]",
			),
			"deliv_tlx_no"=>array(
				'field'=>'deliv_tlx_no', 
				'label'=>'Deliv TLX NO', 
				'rules'=>"required|max_length[88]",
			),
			"cust_typex1"=>array(
				'field'=>'cust_typex1', 
				'label'=>'Cust Typex1', 
				'rules'=>"required|max_length[8]",
			),
			"cust_typex2"=>array(
				'field'=>'cust_typex2', 
				'label'=>'Cust Typex2', 
				'rules'=>"required|max_length[8]",
			),
			"cust_typex3"=>array(
				'field'=>'cust_typex3', 
				'label'=>'Cust Typex3', 
				'rules'=>"required|max_length[8]",
			),
			"cust_typex4"=>array(
				'field'=>'cust_typex4', 
				'label'=>'Cust Typex4', 
				'rules'=>"required|max_length[8]",
			),
			"cust_typex5"=>array(
				'field'=>'cust_typex5', 
				'label'=>'Cust Typex5', 
				'rules'=>"required|max_length[8]",
			),
			"cust_typex6"=>array(
				'field'=>'cust_typex6', 
				'label'=>'Cust Typex6', 
				'rules'=>"required|max_length[8]",
			),
			"currency_type"=>array(
				'field'=>'currency_type', 
				'label'=>'Currency Type', 
				'rules'=>"required|max_length[16]",
			),
			"country_code"=>array(
				'field'=>'country_code', 
				'label'=>'Country Code', 
				'rules'=>"required|max_length[12]",
			),
			"linked_cust_no"=>array(
				'field'=>'linked_cust_no', 
				'label'=>'Linked Cust NO', 
				'rules'=>"required|max_length[24]",
			),
			"linked_supp_no"=>array(
				'field'=>'linked_supp_no', 
				'label'=>'Linked Supp NO', 
				'rules'=>"required|max_length[24]",
			),
			"cash_dstrct_code"=>array(
				'field'=>'cash_dstrct_code', 
				'label'=>'Cash Dstrct Code', 
				'rules'=>"required|max_length[16]",
			),
			"email_address"=>array(
				'field'=>'email_address', 
				'label'=>'Email Address', 
				'rules'=>"required|email|max_length[1280]",
			),
			"last_mod_date"=>array(
				'field'=>'last_mod_date', 
				'label'=>'Last MOD Date', 
				'rules'=>"required|max_length[8]",
			),
			"last_mod_time"=>array(
				'field'=>'last_mod_time', 
				'label'=>'Last MOD Time', 
				'rules'=>"required|max_length[6]",
			),
			"last_mod_user"=>array(
				'field'=>'last_mod_user', 
				'label'=>'Last MOD User', 
				'rules'=>"required|max_length[40]",
			),
			"creation_date"=>array(
				'field'=>'creation_date', 
				'label'=>'Creation Date', 
				'rules'=>"required|max_length[8]",
			),
			"rel_ent_code"=>array(
				'field'=>'rel_ent_code', 
				'label'=>'REL ENT Code', 
				'rules'=>"required|max_length[72]",
			),
			"last_mod_emp"=>array(
				'field'=>'last_mod_emp', 
				'label'=>'Last MOD EMP', 
				'rules'=>"required|max_length[40]",
			),
		);
	}

}