<?php class Mt_tipe_pekerjaanModel extends _Model{
	public $table = "mt_tipe_pekerjaan";
	public $pk = "id_tipe_pekerjaan";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}
}