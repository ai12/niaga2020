<?php class Rab_e_jasa_materialModel extends _Model{
	public $table = "rab_e_jasa_material";
	public $pk = "id_jasa_material";
	public $label = "nama";
	public $order_default = "id_jasa_material asc";
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

		$table = "(select 
		a.*, 
		a.vol-nvl(a.vol_pengadaan,0) as sisa, 
		a.vol * a.harga_satuan as total_harga, 
		nilai_realisasi/(a.vol * a.harga_satuan)*100 progress_realisasi 
		from ".$this->table." a) a";

		if($arr_params['limit']===-1){
			$arr_return['rows'] = $this->conn->GetArray("
				select
				{$str_field}
				from
				".$table."
				{$str_condition}
				{$str_order} ");
		}else{
			$arr_return['rows'] = $this->conn->PageArray("
				select
				{$str_field}
				from
				".$table."
				{$str_condition}
				{$str_order} ",$arr_params['limit'],$arr_params['page']
			);
		}

		$arr_return['total'] = static::GetOne("
			select
			count(*) as total
			from
			".$table."
			{$str_condition}
		");

		return $arr_return;
	}

	public function SelectGridPrint($arr_param=array(), $str_field="*")
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

		$table = "(select 
		a.*, 
		a.vol-nvl(a.vol_pengadaan,0) as sisa, 
		a.vol * a.harga_satuan as total_harga, 
		nilai_realisasi/(a.vol * a.harga_satuan)*100 progress_realisasi 
		from ".$this->table." a) a";

		$arr_return['rows'] = $this->conn->GetArray("
			select
			{$str_field}
			from
			".$table."
			{$str_condition}
			{$str_order} ");

		$arr_return['total'] = static::GetOne("
			select
			count(*) as total
			from
			".$table."
			{$str_condition}
		");

		return $arr_return;
	}
}