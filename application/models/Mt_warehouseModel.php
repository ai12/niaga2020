<?php class Mt_warehouseModel extends _Model{
	public $table = "mt_warehouse";
	public $pk = "table_code";
	public $label = "table_desc";
	function __construct(){
		parent::__construct();
	}
}