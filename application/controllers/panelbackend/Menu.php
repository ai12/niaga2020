<?php
defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . "core/_adminController.php";
class Menu extends _adminController
{

	public function __construct()
	{
		parent::__construct();
	}

	protected function init()
	{
		parent::init();
		$this->viewlist = "panelbackend/menulist";
		$this->viewdetail = "panelbackend/menudetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Menu';
			$this->data['edited'] = true;
			$this->data['mode'] = 'add';
		} elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Menu';
			$this->data['edited'] = true;
			$this->load->model("Public_sys_groupModel", "groupmodel");
			$this->data['groupcb'] = $this->groupmodel->GetArray($this->groupmodel->SqlCombo());	
			$this->data['mode'] = 'edit';
		} elseif ($this->mode == 'detail') {
			$this->data['page_title'] = 'Detail Menu';
			$this->data['edited'] = false;
			$this->data['mode'] = 'detail';
		} else {
			$this->data['page_title'] = 'Daftar Menu';
		}

		$this->data['width'] = "100%";

		$this->load->model("MenuModel", "model");
		$this->data['menuarr'] = $this->model->GetCombo();
		$this->data['visiblearr'] = array(''=>'','0'=>'not visible','1'=>'visible');

		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			''
		);
	}

	protected function Header()
	{
		return array(array(
			'name' => 'parent_id',
			'label' => 'Parent_id',
			'width' => "auto",
			'type' => "list",
			'value'=>$this->data['menuarr'],
		), array(
			'name' => 'label',
			'label' => 'Label',
			'width' => "auto",
			'type' => "varchar2",
		), array(
			'name' => 'iconcls',
			'label' => 'Iconcls',
			'width' => "auto",
			'type' => "varchar2",
		), array(
			'name' => 'url',
			'label' => 'Url',
			'width' => "auto",
			'type' => "varchar2",
		), array(
			'name' => 'visible',
			'label' => 'Visible',
			'width' => "auto",
			'type' => "list",
			'value'=>$this->data['visiblearr'],
		), array(
			'name' => 'state',
			'label' => 'State',
			'width' => "auto",
			'type' => "varchar2",
		), array(
			'name' => 'sort',
			'label' => 'Sort',
			'width' => "auto",
			'type' => "number",
		),);
	}

	protected function Record($id = null)
	{
		return array('parent_id' => $this->post['parent_id'], 
		'label' => $this->post['label'], 
		'iconcls' => $this->post['iconcls'], 
		'url' => $this->post['url'], 
		'visible' => $this->post['visible'], 
		'state' => $this->post['state'], 
		'sort' => $this->post['sort'],);
	}

	protected function Rules()
	{
		return array("parent_id" => array(
			'field' => 'parent_id',
			'label' => 'Parent_id',
			'rules' => "required|numeric",
		), "label" => array(
			'field' => 'label',
			'label' => 'Label',
			'rules' => "required|max_length[100]",
		), "iconcls" => array(
			'field' => 'iconcls',
			'label' => 'Iconcls',
			'rules' => "max_length[50]",
		), "url" => array(
			'field' => 'url',
			'label' => 'Url',
			'rules' => "required|max_length[100]",
		), "visible" => array(
			'field' => 'visible',
			'label' => 'Visible',
			'rules' => "required|max_length[1]",
		), "state" => array(
			'field' => 'state',
			'label' => 'State',
			'rules' => "required|max_length[10]",
		), "sort" => array(
			'field' => 'sort',
			'label' => 'Sort',
			'rules' => "numeric",
		),);
	}
}
