<?php class Create_woModel extends _Model{
	public $table = "create_wo";
	public $pk = "work_order";
	public $label = "work_order_description";
	function __construct(){
		parent::__construct();
	}
}