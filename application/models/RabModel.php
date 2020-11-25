<?php class RabModel extends _Model{
	public $table = "rab";
	public $pk = "id_rab";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}
/*
	function realisasi_wbs($id_rab=null){
		$row = $this->conn->GetRow("select 
			to_char(max(a.selesai),'YYYYMMDD') as selesai,
			to_char(min(a.mulai),'YYYYMMDD') as mulai,
			to_char(max(a.last_update_realisasi),'YYYYMMDD') as selesai_real,
			to_char(min(a.last_update_realisasi),'YYYYMMDD') as mulai_real
			from wbs_plan_detail a
			join wbs_plan b on a.id_plan = b.id_plan
			where b.id_rab = ".$this->conn->escape($id_rab));

		$total = $row['total'];
		$selesai = $row['selesai'];
		$mulai = $row['mulai'];

		if($row){
			if($row['selesai_real']>$selesai)
				$selesai = $row['selesai_real'];

			if($row['mulai_real']<$mulai)
				$mulai = $row['mulai_real'];
		}

		$diff = abs(strtotime($selesai) - strtotime($mulai));
		$total_hari = round($diff / (60 * 60 * 24));

		$day = array();
		$mulai_int = strtotime($mulai);
		for ($i=0;$i<$total_hari;$i++) {
			# menghitung rencana
			$tanggal = strtotime("+$i day", $mulai_int);
			$day[date('Ymd', $tanggal)] = array();
		}

		$sql = "select sum(nvl(rencana,0)) abs, ab 
		from (select  
			rencana, 
			to_char(selesai,'YYYYMMDD') ab 
			from wbs_plan_detail a 
			join wbs_plan b on a.id_plan = b.id_plan
			where id_rab = ".$this->conn->escape($id_rab)."
			and is_leaf='1'
			) a 
		group by ab order by ab";
		$rows = $this->conn->GetArray($sql);
		$rencana = array();
		$temp = array();
		$tot=0;
		foreach($rows as $r){
			$tot+=$r['abs'];
			$temp[$r['ab']] = $tot;
		}

		foreach($day as $tgl=>$v){
			if($temp[$tgl])
				$t = $temp[$tgl];
			
			$rencana[$tgl] = $t;
		}

		$sql = "select sum(nvl(realisasi,0)) abs, ab 
		from (select  
			realisasi, 
			to_char(last_update_realisasi,'YYYYMMDD') ab 
			from wbs_plan_detail a 
			join wbs_plan b on a.id_plan = b.id_plan
			where id_rab = ".$this->conn->escape($id_rab)."
			and is_leaf='1'
			) a 
		group by ab order by ab";
		$rows = $this->conn->GetArray($sql);
		$realisasi = array();
		$temp = array();
		$tot=0;
		foreach($rows as $r){
			$tot+=$r['abs'];
			$temp[$r['ab']] = $tot;
		}

		foreach($day as $tgl=>$v){
			if($temp[$tgl])
				$t = $temp[$tgl];
			
			$realisasi[$tgl] = $t;
		}

		$ret = array(
			'realisasi'=>$realisasi,
			'day'=>$day,
			'rencana'=>$rencana
		);

		return $ret;
	}*/

	public function GetCountTask(){
		$addfilter = "and 1<>1";

		if(Access("ajukan","panelbackend/rab_detail"))
			$addfilter = "and asman_ok = '0' and manager_ok = '0' and (status = '0' or status = '3')";
		elseif(Access("ajukan_manager","panelbackend/rab_detail"))
			$addfilter = "and asman_ok = '0' and manager_ok = '0' and status = '1'";
		elseif(Access("setujui","panelbackend/rab_detail"))
			$addfilter = "and asman_ok = '1' and manager_ok = '0' and status = '1'";

		return $this->conn->GetOne("select count(1) from (select b.nama_pekerjaan, c.nama_proyek, a.*,
			case 
			when status = 0 then 'DRAFT'
			when status = 1 then 'DIAJUKAN'
			when status = 2 then 'DISETUJUI'
			when status = 3 then 'DIKEMBALIKAN'
			end as nama_status
			from rab a
			join proyek_pekerjaan b on b.is_deleted = '0' and a.id_proyek_pekerjaan = b.id_proyek_pekerjaan
			join proyek c on c.is_deleted = '0' and c.id_proyek = b.id_proyek
			where 1=1 $addfilter) a");
	}

	public function SelectGridTask($arr_param=array(), $str_field="*")
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

		$addfilter = "and 1<>1";

		if(Access("ajukan","panelbackend/rab_detail"))
			$addfilter = "and asman_ok = '0' and manager_ok = '0' and (status = '0' or status = '3')";
		elseif(Access("ajukan_manager","panelbackend/rab_detail"))
			$addfilter = "and asman_ok = '0' and manager_ok = '0' and status = '1'";
		elseif(Access("setujui","panelbackend/rab_detail"))
			$addfilter = "and asman_ok = '1' and manager_ok = '0' and status = '1'";

		$this->table = "(select b.nama_pekerjaan, c.nama_proyek, a.*,
			case 
			when status = 0 then 'DRAFT'
			when status = 1 then 'DIAJUKAN'
			when status = 2 then 'DISETUJUI'
			when status = 3 then 'DIKEMBALIKAN'
			end as nama_status
			from rab a
			join proyek_pekerjaan b on b.is_deleted = '0' and a.id_proyek_pekerjaan = b.id_proyek_pekerjaan
			join proyek c on c.id_proyek = b.id_proyek and c.is_deleted = '0'
			where 1=1 $addfilter) a";

		if($arr_params['limit']===-1){
			$arr_return['rows'] = $this->conn->GetArray("
				select
				{$str_field}
				from
				".$this->table."
				{$str_condition}
				{$str_order} ");
		}else{
			$arr_return['rows'] = $this->conn->PageArray("
				select
				{$str_field}
				from
				".$this->table."
				{$str_condition}
				{$str_order} ",$arr_params['limit'],$arr_params['page']
			);
		}

		$arr_return['total'] = static::GetOne("
			select
			count(*) as total
			from
			".$this->table."
			{$str_condition}
		");

		return $arr_return;
	}

	public function GetByPk($id){
		if(!$id){
			return array();
		}
		$sql = "select * from ".$this->table." where {$this->pk} = ".$this->conn->qstr($id);
		$ret = $this->conn->GetRow($sql);

		return $ret;
	}
}

//last_update_realisasi_rab