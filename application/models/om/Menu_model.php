<?php

require APPPATH.'/models/om/_omModel.php';
class Menu_model extends _omModel
{

	//put your code here
	function __construct()
	{
		parent::__construct();
	}


	var $table  = 'public_sys_menu';
	var $pk 	= 'menu_id';
	var $column = ['menu_id'=>'#','parent_id'=>'Parent','label'=>'Label','iconcls'=>'Icon','url'=>'URL','visible'=>'Visible','state'=>'State','sort'=>'Sort']; //set column field database for datatable orderable
	var $order  = ['menu_id' => 'asc']; // default order 

	public function _setting()
	{
		$set = parent::_setting();

		//custom
		$set['parent_id']['label'] 	= 'Induk Menu';

		$set['parent_id']['type'] 	= 'number';
		$set['visible']['type'] 	= 'number';
		$set['sort']['type'] 	= 'number';
		
		$set['menu_id']['hidden'] 	= true;
		
		$set['menu_id']['width'] 	= '10px';
		$set['parent_id']['width'] 	= '200px';	
		$set['label']['width'] 		= '300px';	
		$set['visible']['width'] 	= '100px';
		$set['state']['width'] 		= '70px';
		$set['sort']['width'] 		= '50px';
		$set['url']['width'] 		= '300px';
		
		$set['iconcls']['required'] 	= false;
		$set['label']['url'] 		= 'detail';
		
		$set['menu_id']['form_width'] 	= '200px';
	
		
		$set['sort']['align'] 		= 'right';
		$set['parent_id']['value'] 	= $this->menuarr;
		$set['visible']['value'] 	= $this->visiblearr;

		return $set;
	}
	
	
}//END