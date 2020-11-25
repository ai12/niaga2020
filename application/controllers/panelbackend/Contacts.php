<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Contacts extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/contactslist";
		$this->viewdetail = "panelbackend/customer_contactsdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

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
			$this->data['page_title'] = 'Contacts';
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

	protected function Header(){
		return array(
			array(
				'name'=>'nama_customer', 
				'label'=>'Nama Customer', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
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

}