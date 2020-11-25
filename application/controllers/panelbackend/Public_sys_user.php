<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Public_sys_user extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/public_sys_userlist";
		$this->viewdetail = "panelbackend/public_sys_userdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah User';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit User';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail User';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar User';
		}

		$this->load->model("Public_sys_userModel","model");

		$this->load->model("Public_sys_groupModel","publicsysgroup");
		$publicsysgroup = $this->publicsysgroup;
		$rspublicsysgroup = $publicsysgroup->GArray();

		$publicsysgrouparr = array(''=>'');
		foreach($rspublicsysgroup as $row){
			$publicsysgrouparr[$row['group_id']] = $row['name'];
		}

		$this->data['publicsysgrouparr'] = $publicsysgrouparr;

		

		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'select2'
		);
	}

	protected function _afterDetail($id=null){

		$nid = $this->data['row']['nid'];
		$this->load->model("Mt_pegawaiModel","mtpegawai");
		$this->data['nidarr'][$nid] = $this->mtpegawai->GOne("nama","where nid = ".$this->conn->qstr($nid));

	}

	protected function Header(){
		return array(
			array(
				'name'=>'username', 
				'label'=>'Username', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'group_id', 
				'label'=>'Group ID', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['publicsysgrouparr'],
			),
			array(
				'name'=>'name', 
				'label'=>'Name', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'last_ip', 
				'label'=>'Last IP', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'last_login', 
				'label'=>'Last Login', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'is_active', 
				'label'=>'Active', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>array(''=>'-pilih-','0'=>'Tidak','1'=>'Iya'),
			),
		);
	}

	protected function Record($id=null){
		$return = array(
			'nid'=>$this->post['nid'],
			'username'=>$this->post['username'],
			'group_id'=>$this->post['group_id'],
			'name'=>$this->post['name'],
			'last_ip'=>$this->post['last_ip'],
			'last_login'=>$this->post['last_login'],
			'is_active'=>(int)$this->post['is_active']
		);

		if(!$id or ($id && $this->post['password'])){
			$return['password']=sha1(md5($this->post['password']));
		}

		return $return;
	}

	protected function Rules(){
		$return = array(
			"username"=>array(
				'field'=>'username', 
				'label'=>'Username', 
				'rules'=>"required|max_length[100]",
			),
			"group_id"=>array(
				'field'=>'group_id', 
				'label'=>'Group ID', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['publicsysgrouparr']))."]|max_length[10]",
			),
			"name"=>array(
				'field'=>'name', 
				'label'=>'Name', 
				'rules'=>"required|max_length[200]",
			),
			"confirmpassword"=>array(
				'field'=>'confirmpassword', 
				'label'=>'Confirm Password', 
				'rules'=>"max_length[100]|matches[password]",
			),
		);

		if($this->data['row'][$this->pk]){
			$return["password"]= array(
				'field'=>'password', 
				'label'=>'Password', 
				'rules'=>"max_length[100]",
			);
		}else{
			$return["password"]= array(
				'field'=>'password', 
				'label'=>'Password', 
				'rules'=>"required|max_length[100]",
			);
		}

		return $return;
	}

}