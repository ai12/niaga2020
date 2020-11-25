<?php class Proyek_pekerjaanModel extends _Model{
	public $table = "proyek_pekerjaan";
	public $pk = "id_proyek_pekerjaan";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}

	public function GetByPk($id){
		if(!$id)
			return array();

		$sql = "select a.*, 
		case when tgl_selesai_pelaksanaan_real <= sysdate and tgl_selesai_pelaksanaan_real is not null
		then tgl_selesai_pelaksanaan_real 
		else sysdate end as sysdate1
		from ".$this->table."  a
		where {$this->pk} = ".$this->conn->qstr($id);
		$ret = $this->conn->GetRow($sql);

		if(!$ret)
			$ret = array();

		return $ret;
	}
}