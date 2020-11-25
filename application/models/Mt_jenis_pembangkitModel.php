<?php class Mt_jenis_pembangkitModel extends _Model{
	public $table = "mt_jenis_pembangkit";
	public $pk = "id_jenis_pembangkit";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}
}