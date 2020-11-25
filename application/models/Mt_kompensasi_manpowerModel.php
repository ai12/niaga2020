<?php class Mt_kompensasi_manpowerModel extends _Model{
	public $table = "mt_kompensasi_manpower";
	public $pk = "id_kompensasi_manpower";
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

		$rows = $this->conn->GetArray("select * from mt_jenis_ttp");

		$arr = array();

		$i=1;
		foreach($rows as $r){
			$id = $r['id_jenis_ttp'];
			$arr[] = "max(case when id_jenis_ttp = $id then nilai else null end) nilai$i";
			$i++;
		}

		$imp = implode(",", $arr);

		$sql = "(select a.id_kompensasi_manpower, a.id_jabatan_proyek, a.id_level_jabatan,
		$imp
		from mt_kompensasi_manpower a 
		left join mt_kompensasi_manpower_detail b on a.id_kompensasi_manpower = b.id_kompensasi_manpower
		group by a.id_kompensasi_manpower, a.id_jabatan_proyek, a.id_level_jabatan) a";

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