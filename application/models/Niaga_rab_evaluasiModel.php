<?php class Niaga_rab_evaluasiModel extends _Model{
	public $table = "niaga_rab_evaluasi";
	public $pk = "id_rab_detail";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}

	public function GetComboParent($id_child=null){
		$row = $this->conn->GetRow("select id_rab_detail, id_rab_detail_parent, uraian from niaga_rab_evaluasi where id_rab_detail = ".$this->conn->escape($id_child));
		if(!$row)
			return array();
		
		$ret = array();
		if($row['id_rab_detail_parent']){
			$ret = $this->GetComboParent($row['id_rab_detail_parent']);
		}

		$ret[$id_child] = $row['uraian'];

		return $ret;
	}

	public function GetComboChild($id_parent=null){
		$id_rab_detailarr = $this->GetChild($id_parent);
		if(!count($id_rab_detailarr))
			return array();

		$rows = $this->conn->GetArray("select 
			uraian, 
			id_rab_detail as id,
			id_rab_detail_parent as id_parent
			from niaga_rab_evaluasi where id_rab_detail in (".implode(",", $id_rab_detailarr).")");

		if(!count($rows))
			return array();

		$ret = array();
		$this->GenerateTree($rows, "id_parent", "id", "uraian", $ret, $id_parent);

		$data = array(''=>'-pilih-');
		foreach ($ret as $r) {
			$data[$r['id']] = $r['uraian'];
		}
		unset($data[$id_parent]);

		if(count($data)==1)
			return array();
		
		return $data;
	}

	public function GetChild($id_parent=null){

		$rows = $this->conn->GetArray("select id_rab_detail 
		from niaga_rab_evaluasi 
		where id_rab_detail_parent = ".$this->conn->escape($id_parent));
		$ret = array();
		$ret[] = $id_parent;
		if(count($rows))
			foreach($rows as $r){
			$ret1 = $this->GetChild($r['id_rab_detail']);
			$ret = array_merge($ret, $ret1);
		}

		return $ret;
	}
}