<?php class CustomerModel extends _Model{
	public $table = "customer";
	public $pk = "id_customer";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}
}