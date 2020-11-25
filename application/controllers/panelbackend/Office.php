<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Office extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/officelist";
		$this->viewdetail = "panelbackend/customer_officedetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";
		
		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Customer Office';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Customer Office';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Customer Office';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Office';
		}

		$this->data['width'] = "2600px";

		$this->load->model("Customer_officeModel","model");
		$this->load->model("Mt_customer_statusModel","mtcustomerstatus");
		$this->data['mtcustomerstatusarr'] = $this->mtcustomerstatus->GetCombo();

		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			''
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
				'name'=>'site', 
				'label'=>'Site', 
				'width'=>"auto",
				'type'=>"varchar2",
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
			array(
				'name'=>'telephone_2', 
				'label'=>'Telephone 2', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'fax', 
				'label'=>'FAX', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
		);
	}
}