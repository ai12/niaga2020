<?php class ProyekselesaiModel extends _Model{
	public $table = "proyek";
	public $pk = "id_proyek";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}

	public function list_dokumen($id=null){
		$sql = "select * from t_finishing_proyek where proyek_id = ".$id;
		$rows = $this->conn->GetArray($sql);
		return $rows;
	}
	public function list_history($id=null){
		$sql = "select * from t_finishing_log where proyek_id = ".$id." order by id asc";
		$rows = $this->conn->GetArray($sql);
		return $rows;
	}
}