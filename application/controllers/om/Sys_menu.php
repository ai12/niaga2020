<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sys_menu extends _Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('om_helper');
		$this->load->model("om/Global_model");
		$this->template = "om/main";
		$this->layout = "om/layout1";

		$this->load->helper('om_helper');
		$this->load->model("om/Global_model");
		$this->load->model('AuthModel', 'auth');
		$this->sso = $this->config->item('sso');

		$this->helper("a");
		$this->helper("s");

		// $this->conn->debug = 1;

		if ($_GET['debug'] == '1') {
			$this->conn->debug = 1;
		}

		$this->load->helper('url');
		$this->load->helper('form');
		$this->modul = 'settlement';
	}

	public function get_group_menu()
	{
		$menu_id = $this->input->post('menu_id');
		$sys_group_id = $this->input->post('sys_group_id');
		$result = [];
		#get action
		$sql_get_action = "select * from PUBLIC_SYS_ACTION WHERE MENU_ID = $menu_id";
		$rs = $this->db->query($sql_get_action);
		if($rs->num_rows() > 0)
		{
			$result['action'] = $rs->result_array();
		}
		else
		{
			$lists = ['add','edit','delete','index'];
			foreach ($lists as $value) {
				$this->db->insert('PUBLIC_SYS_ACTION', ['MENU_ID'=>$menu_id, 'NAME'=>$value, 'VISIBLE'=>1]);
			}
			$rs = $this->db->query($sql_get_action);
			$result['action'] = $rs->result_array();
		}
		
		#get group reg or no
		$sql = "select GROUP_MENU_ID from PUBLIC_SYS_GROUP_MENU WHERE MENU_ID = $menu_id and GROUP_ID = $sys_group_id"; 
		$rs = $this->db->query($sql);
		
		if($rs->num_rows() > 0)
		{
			$result['group'] = 'Terdaftar';
		}
		else
		{
			$result['group'] = 'Belum Terdaftar';	
		}

		#get group action
		$rs = $this->db->query("select ACTION_ID from PUBLIC_SYS_GROUP_ACTION WHERE GROUP_MENU_ID in ($sql)");
		$result['group_action'] = $rs->result_array();

		$select = "<select name='action_group[]' id='action_group' class='form-control' multiple='true' style='height:100px'>";
		foreach ($result['action'] as $a) {
			$selected = '';
			foreach ($result['group_action'] as $ga) {
				if($ga['action_id'] == $a['action_id']){
					$selected = "selected=''";
				}
			}
			$select .= "<option value='$a[action_id]' $selected>$a[name]</option>";
		}
		$select .= "</select>";
		$result['select'] = $select;

		echo json_encode($result);
	}
	public function store_group_menu()
	{
		// $post = $this->input->post();
		$menu_id = $this->input->post('menu_id');
		$sys_group_id = $this->input->post('sys_group_id');
		$action_group_ids = $this->input->post('action_group_id');

		$this->db->trans_begin();
		
		//$this->db->where(['GROUP_ID'=>$post['sys_group_id'], 'MENU_ID'=>$post['menu_id']])->delete("PUBLIC_SYS_GROUP_MENU");
		$sql = "select GROUP_MENU_ID from PUBLIC_SYS_GROUP_MENU WHERE MENU_ID = $menu_id and GROUP_ID = $sys_group_id";

		#delete group action
		$this->db->query("delete PUBLIC_SYS_GROUP_ACTION WHERE GROUP_MENU_ID in ($sql)");
		#delete group menu
		$this->db->query("delete PUBLIC_SYS_GROUP_MENU WHERE MENU_ID = $menu_id and GROUP_ID = $sys_group_id");

		#insert group menu
		$insert_group = $this->db->insert('PUBLIC_SYS_GROUP_MENU',['GROUP_ID'=>$sys_group_id, 'MENU_ID'=>$menu_id]);

		#get grop menu id
		$insert_group_id = $this->db->query("select GROUP_MENU_ID from PUBLIC_SYS_GROUP_MENU order by GROUP_MENU_ID desc")->row_array();
		$group_menu_id = $insert_group_id['group_menu_id'];
		// exit();

		// insert into PUBLIC_SYS_GROUP_ACTION (GROUP_ID,MENU_ID) VALUES ('')
		foreach ($action_group_ids as $act_id) {
			$this->db->insert('PUBLIC_SYS_GROUP_ACTION',['GROUP_MENU_ID'=>$group_menu_id, 'ACTION_ID'=>$act_id]);
		}

		if($this->db->trans_status() === true)
		{
			$this->db->trans_commit();
		}
		else
		{
			$this->db->trans_rollback();
		}
		// $this->get_group_menu();
		// print_r($post);
	}
}