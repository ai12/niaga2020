<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Create_wo extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/create_wolist";
		$this->viewdetail = "panelbackend/create_wodetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Work Order';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Work Order';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Work Order';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Work Order';
		}

		$this->data['width'] = "800px";

		$this->load->model("Create_woModel","model");
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'datepicker'
		);
		$this->load->model("M_wocatModel","wocat");

		$this->data['userStatus'] = $this->wocat->GetCombo("where CATEGORY = 'USER_STATUS'");
		$this->data['woType'] = $this->wocat->GetCombo("where CATEGORY = 'WO_TYPE'");
		$this->data['mType'] = $this->wocat->GetCombo("where CATEGORY = 'M_TYPE'");
		/*$this->data['s1'] = $this->macan('acc_code1');
		$this->data['s2'] = $this->macan("acc_code2");
		$this->data['s3'] = $this->macan("acc_code3");
		$this->data['s4'] = $this->macan("acc_code4");
		$this->data['s5'] = $this->macan("acc_code5");
		$this->data['s6'] = $this->macan("acc_code6");
		$this->data['s7'] = $this->macan("acc_code7");*/
		$this->data['s1'] = $this->wocat->GetCombo("where CATEGORY = 'S1'");
		$this->data['s2'] = $this->wocat->GetCombo("where CATEGORY = 'S2'");
		$this->data['s3'] = $this->wocat->GetCombo("where CATEGORY = 'S3'");
		$this->data['s4'] = $this->wocat->GetCombo("where CATEGORY = 'S4'");
		$this->data['s5'] = $this->wocat->GetCombo("where CATEGORY = 'S5'");
		$this->data['s6'] = $this->wocat->GetCombo("where CATEGORY = 'S6'");
		$this->data['s7'] = $this->wocat->GetCombo("where CATEGORY = 'S7'");
		$this->data['ee'] = $this->wocat->GetCombo("where CATEGORY = 'EE'");
		$this->data['session_wo'] = $this->session_wo();
	}

	protected function Header(){
		return array(
			array(
				'name'=>'work_order', 
				'label'=>'Work Order', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'work_order_description', 
				'label'=>'WO Description', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'user_status', 
				'label'=>'User Status', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'work_order_type', 
				'label'=>'WO Type', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'maintenance_type', 
				'label'=>'Maintenance Type', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'account_code', 
				'label'=>'Acc Coode', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
		);
	}

	protected function Record($id=null){
		return array(
			'work_order'=>$this->post['work_order'],
			'work_order_description'=>$this->post['work_order_description'],
			'user_status'=>$this->post['user_status'],
			'work_order_type'=>$this->post['work_order_type'],
			'maintenance_type'=>$this->post['maintenance_type'],
			'work_group'=>$this->post['work_group'],
			'account_code'=>$this->post['account_code'],
			'originator'=>$this->post['originator'],
			'raised_date'=>$this->post['raised_date'],
		);
	}

	protected function Rules(){
		return array(
			"nama"=>array(
				'field'=>'work_order', 
				'label'=>'Work Order', 
				'rules'=>"required|max_length[10]",
			),
		);
	}

	public function Edit($value='')
	{
		if ($this->post['act'] === 'save') {
			/*
			WORK_ORDER_PREFIX = ?
			"PROJECT_NUMBER":"20DN3M91"
			*/
			/*[{"WORK_GROUP":"GENERAL","WORK_ORDER_TYPE":"PP","WORK_ORDER":"DN3010","WORK_ORDER_PREFIX":"20","RAISED_DATE":"06/11/2020","ORIGINATOR":"9216348KP","PROJECT_NUMBER":"20DN3M91","MAINTENANCE_TYPE":"JE","WORK_ORDER_DESCRIPTION":"WO_COBA","ACCOUNT_CODE":"DPS340000000025I491","USER_STATUS":"IP"}]*/
			$url = "http://coba.test/create_wo.php";
			$post = $this->post;
			unset(
				/*$post['s1'],
				$post['s2'],
				$post['s3'],
				$post['s4'],
				$post['s5'],
				$post['s6'],
				$post['s7'],
				$post['s8'],*/
				$post['act'],
				$post['go'],
				$post['key']
			);

			$param_str = json_encode([$post]);

			$ch = curl_init();
			
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 2000);
			curl_setopt($ch,CURLOPT_TIMEOUT, 2000);
			curl_setopt($ch,CURLOPT_POST, 1);
			curl_setopt($ch,CURLOPT_POSTFIELDS, $param_str);
			curl_setopt($ch,CURLOPT_VERBOSE, true);
			curl_setopt($ch,CURLOPT_COOKIEJAR, '-'); 
			curl_setopt($ch,CURLOPT_COOKIEFILE, 'cookie.txt'); 
			curl_setopt($ch,CURLOPT_COOKIESESSION, true);

			$result = curl_exec($ch);

			$info = curl_getinfo($ch);
			$err = curl_errno($ch);
			$msg = curl_error($ch);
			// print_r($result);
		}else{
			parent::Edit();
		}
		
	}

	public function macan($value='acc_code1')
	{
		$rows = json_decode(@file_get_contents($this->config->item($value)), true);
		$data = [];
		foreach ($rows as $r) {
			$data[$r['COST_CTRE_SEG']] = $r['CCTRE_SEG_DESC'];
		}
		return $data;
	}

	public function session_wo($value='sess_wo')
	{
		return [ 0 => ['A'=>1]];
		/*$rows = json_decode(@file_get_contents($this->config->item($value)), true);
		$data = [];
		foreach ($rows as $r) {
			$data[$r['WORK_ORDER']] = $r['WO_DESC'];
		}
		return $data;*/
	}
}