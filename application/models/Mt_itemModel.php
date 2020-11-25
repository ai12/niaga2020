<?php class Mt_itemModel extends _Model{
	public $table = "mt_item";
	public $pk = "id_item";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}
}