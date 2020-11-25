<?php class Mt_customer_statusModel extends _Model{
	public $table = "mt_customer_status";
	public $pk = "id_status";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}
}