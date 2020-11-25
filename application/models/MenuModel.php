<?php class MenuModel extends _Model{
			public $table = "public_sys_menu";
			public $pk = "menu_id";
			public $label = "label";
			function __construct(){
				parent::__construct();
			}
		}
		
