<?php class Mt_customer_kategoriModel extends _Model{
	public $table = "mt_customer_kategori";
	public $pk = "id_kategori";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}
}