<?php class Proyek_filesModel extends _Model{
	public $table = "proyek_files";
	public $pk = "id_proyek_files";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}
}