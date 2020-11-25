<?php class Mt_customer_typeModel extends _Model{
	public $table = "mt_customer_type";
	public $pk = "id_type";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}
}