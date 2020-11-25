<?php class Mt_brutoModel extends _Model{
	public $table = "mt_bruto";
	public $pk = "id";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}

	function GetCombo($where=''){
		$sql = $this->SqlCombo($where);
		$rows = $this->conn->GetArray($sql);
		$data = array(''=>'UN-CATEGORY');
		foreach ($rows as $r) {
			$data[trim($r['key'])] = $r['val'];
		}
		return $data;
	}
	
}