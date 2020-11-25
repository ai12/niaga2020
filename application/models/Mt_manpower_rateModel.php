<?php class Mt_manpower_rateModel extends _Model{
	public $table = "mt_manpower_rate";
	public $pk = "id_manpower_rate";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}

	public function SelectGrid($arr_param=array(), $str_field="*")
	{
		$arr_return = array();
		$arr_params = array(
			'page' => 0,
			'limit' => 50,
			'order' => '',
			'filter' => ''
		);
		foreach($arr_param as $key=>$val){
			$arr_params[$key]=$val;
		}

		$arr_params['page'] = ($arr_params['page']/$arr_params['limit'])+1;

		$str_condition = "";
		$str_order = "";
		if(!empty($arr_params['filter']))
		{
			$str_condition = "where ".$arr_params['filter'];
		}
		if(!empty($arr_params['order']))
		{
			$str_order = "order by ".$arr_params['order'];
		}elseif($this->order_default){
			$str_order = "order by ".$this->order_default;
		}

		$rows = $this->conn->GetArray("select * from mt_wilayah_proyek");

		$arr = array();

		$i=1;
		foreach($rows as $r){
			$id = $r['id_wilayah_proyek'];
			$arr[] = "max(case when id_wilayah_proyek = $id then nilai else null end) nilai$i";
			$i++;
		}

		$imp = implode(",", $arr);

		$sql = "(select a.id_manpower_rate, a.id_jabatan_proyek, a.id_level_jabatan, a.hpp,
		$imp
		from mt_manpower_rate a 
		join mt_manpower_rate_detail b on a.id_manpower_rate = b.id_manpower_rate
		group by a.id_manpower_rate, a.id_jabatan_proyek, a.id_level_jabatan, a.hpp) a";

		if($arr_params['limit']===-1){
			$arr_return['rows'] = $this->conn->GetArray("
				select
				{$str_field}
				from
				$sql
				{$str_condition}
				{$str_order} ");
		}else{
			$arr_return['rows'] = $this->conn->PageArray("
				select
				{$str_field}
				from
				$sql
				{$str_condition}
				{$str_order} ",$arr_params['limit'],$arr_params['page']
			);
		}

		$arr_return['total'] = static::GetOne("
			select
			count(*) as total
			from
			$sql
			{$str_condition}
		");

		return $arr_return;
	}
}