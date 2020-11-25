<?php class Mt_unitModel extends _Model{
	public $table = "mt_unit";
	public $pk = "table_code";
	public $label = "table_desc";
	function __construct(){
		parent::__construct();
	}

	public function GArray($field="*",$addsql=""){

		if($this->is_pengadaan && !(trim($_SESSION[SESSION_APP]['subdit'])=='C1' or trim($_SESSION[SESSION_APP]['subdit'])=='C4' or trim($_SESSION[SESSION_APP]['subdit'])=='C5' or trim($_SESSION[SESSION_APP]['subdit'])=='AA2'))
			$str_condition = " and trim(table_code) = trim('{$_SESSION[SESSION_APP]['unit']}') ";

		$sql = "select {$field} from ".$this->table." {$addsql} where 1=1 $str_condition";
		return $this->conn->GetArray($sql);
	}
}