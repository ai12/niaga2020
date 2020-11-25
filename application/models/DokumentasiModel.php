<?php class DokumentasiModel extends _Model
{
	public $table = "r_dokumentasi";
	public $pk = "id_dokumen";
	public $label = "path";
	function __construct()
	{
		parent::__construct();
	}
}
