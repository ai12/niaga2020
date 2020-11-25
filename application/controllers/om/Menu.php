<?php
defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . "core/_omController.php";
class Menu extends _omController
{

	public function __construct()
	{
		parent::__construct();
		
		$this->modul = 'menu';
		$this->load->model('om/menu_model', 'mod');

		$this->menuarr = $this->Global_model->GetComboMenu();
		$this->visiblearr = array(''=>'','0'=>'not visible','1'=>'visible');
	}

	public function index()
	{
		$this->data['title'] 		= 'Daftar Menu';		
		$this->data['subtitle'] 	= 'isi Menu';	
		parent::index();
	}

	public function form($kode = 0)
	{
	
		$this->data['title'] 		= 'Form Menu';		
		$this->data['subtitle'] 	= 'isi Menu';	
		parent::form($kode);
		
	}
	public function detail($kode = 0)
	{
	
		$this->data['title'] 		= 'Detail Menu';		
		$this->data['subtitle'] 	= 'isi Menu';	
		$this->data['readonly'] 	= true;	
		parent::form($kode);
		
	}
	

	public function ajax_list()
	{
		echo parent::ajax_list();
		
	}

	
	
	
}
