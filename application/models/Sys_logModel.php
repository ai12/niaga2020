<?php class Sys_logModel extends _Model{
	public $table = "public_sys_log";
	public $pk = "";
	public $order_default = "activity_time desc";
	function __construct(){
		parent::__construct();
	}
}