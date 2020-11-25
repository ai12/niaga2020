<?php class M_wocreate extends _Model{
	public $table = "CREATE_WO";
	public $pk = "WORK_ORDER";
	public $label = "WORK_ORDER_DESCRIPTION";
	function __construct(){
		parent::__construct();
	}
}