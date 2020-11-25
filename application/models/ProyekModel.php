<?php class ProyekModel extends _Model{
	public $table = "proyek";
	public $pk = "id_proyek";
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
		$sql = "(select a.*, nilai_hpp-nilai_realisasi as nilai_sisa from proyek a where is_deleted <> 1) a";
		if($arr_params['limit']===-1){
			$arr_return['rows'] = $this->conn->GetArray("
				select
				{$str_field}
				from
				{$sql}
				{$str_condition}
				{$str_order} ");
		}else{
			$arr_return['rows'] = $this->conn->PageArray("
				select
				{$str_field}
				from
				{$sql}
				{$str_condition}
				{$str_order} ",$arr_params['limit'],$arr_params['page']
			);
		}

		$arr_return['total'] = static::GetOne("
			select
			count(*) as total
			from
			{$sql}
			{$str_condition}
		");

		return $arr_return;
	}

	public function GetByPk($id){
		if(!$id){
			return array();
		}
		$sql = "select * 
		from ".$this->table." 
		where {$this->pk} = ".$this->conn->qstr($id);
		$ret = $this->conn->GetRow($sql);

		if(!$ret)
			$ret = array();

		$ret['pemberi_pekerjaan'] = $this->conn->GetOne("select nama from customer where id_customer = ".$this->conn->escape($ret['id_customer']));

		return $ret;
	}

	public function total($tahun=null){
		return $this->conn->GetRow("select sum(nvl(nilai_rab,0)) as total_rab, sum(nvl(nilai_realisasi,0)) as total_realisasi from proyek_pekerjaan where is_deleted = '0' and to_char(tgl_mulai_pelaksanaan,'YYYY') = ".$this->conn->escape($tahun));
	}

	public function total_proyek($tahun=null){
		return $this->conn->GetArray("select count(a.id_proyek) as total, a.id_status_proyek, b.nama, b.warna
			from mt_status_proyek b
			left join proyek a on a.is_deleted = '0' and a.id_status_proyek = b.id_status_proyek and to_char(tgl_rencana_mulai,'YYYY') = ".$this->conn->escape($tahun)."
			group by a.id_status_proyek, b.nama, b.warna");
	}

	public function pengumuman(){
		return $this->conn->GetArray("select 
			p.nama_proyek, pk.nama_pekerjaan, p.tgl_rencana_mulai, p.id_proyek
			from proyek p
			left join proyek_pekerjaan pk on pk.is_deleted = '0' and p.id_proyek = pk.id_proyek
			where not exists (
				select 1 
				from rab r
				where pk.id_proyek_pekerjaan = r.id_proyek_pekerjaan
			) and p.id_status_proyek = 4
			and p.is_deleted = '0' and sysdate-p.tgl_rencana_mulai <= 90
			");
	}

	public function total_harian($tahun=null){
		$sql = "select sum(nvl(nilai_rab,0)) nilai_rab, sum(nvl(nilai_realisasi,0)) nilai_realisasi, ab 
		from (select  
			nilai_rab, nilai_realisasi,
			to_char(tgl_mulai_pelaksanaan,'Month') ab 
			from proyek_pekerjaan a 
			where a.is_deleted = '0' and to_char(tgl_mulai_pelaksanaan,'YYYY') = ".$this->conn->escape($tahun).") a 
		group by ab order by ab";
		$rows = $this->conn->GetArray($sql);

		$ret = array();
		$nilai_rab=0;
		$nilai_realisasi=0;
		foreach($rows as $r){
			$nilai_rab+=$r['nilai_rab'];
			$ret['nilai_rab'][] = $nilai_rab;

			$nilai_realisasi+=$r['nilai_realisasi'];
			$ret['nilai_realisasi'][] = $nilai_realisasi;

			$ret['tgl'][] = $r['ab'];
		}
		return $ret;
	}

	public function total_realisasi_proyek($tahun=null){
		$sql = "select 
			sum(nvl(nilai_rab,0)) nilai_rab, 
			sum(nvl(nilai_realisasi,0)) nilai_realisasi, 
			bulan,
			id_proyek, 
			nama_proyek
		from (select  
			nilai_rab, nilai_realisasi, b.id_proyek, b.nama_proyek,
			to_char(tgl_mulai_pelaksanaan,'MM') bulan 
			from proyek_pekerjaan a 
			join proyek b on b.is_deleted = '0' and a.id_proyek = b.id_proyek
			where a.is_deleted = '0' and to_char(tgl_mulai_pelaksanaan,'YYYY') = ".$this->conn->escape($tahun)."
			and b.id_status_proyek in (1,2)
		) a 
		group by bulan, id_proyek, nama_proyek order by bulan";
		$rows = $this->conn->GetArray($sql);

		$temp = array();
		$maksimal = 0;
		foreach($rows as $r){
			if($r['nilai_rab']>$maksimal)
				$maksimal = $r['nilai_rab'];

			if($r['nilai_realisasi']>$maksimal)
				$maksimal = $r['nilai_realisasi'];

			$temp[$r['bulan']][] = $r;
		}

		return array("rows"=>$temp,"maksimal"=>$maksimal/1000000000,'total_data'=>count($rows));
	}

	public function status_proyek(){
		return $this->conn->GetArray("select * from mt_status_proyek");
	}

	public function total_rencana_proyek($tahun=null){
		$sql = "select 
			sum(nvl(nilai_rab,0)) nilai_rab,
			bulan,
			id_proyek, 
			nama_proyek, 
			id_status_proyek,
			warna
		from (select  
			nilai_rab, nilai_realisasi, b.id_proyek, b.nama_proyek,b.id_status_proyek,
			to_char(tgl_rencana_mulai,'MM') bulan, c.warna
			from proyek b
			left join proyek_pekerjaan a on a.is_deleted = '0' and a.id_proyek = b.id_proyek
			left join mt_status_proyek c on b.id_status_proyek = c.id_status_proyek
			where b.is_deleted = '0' and to_char(tgl_rencana_mulai,'YYYY') = ".$this->conn->escape($tahun)."
			order by tgl_rencana_mulai
		) a 
		group by bulan, id_proyek, nama_proyek, id_status_proyek, warna 
		order by bulan";
		$rows = $this->conn->GetArray($sql);

		$temp = array();
		$maksimal = 0;
		foreach($rows as $r){
			if($r['nilai_rab']>$maksimal)
				$maksimal = $r['nilai_rab'];

			$temp[$r['bulan']][] = $r;
		}

		return array("rows"=>$temp,"maksimal"=>$maksimal/1000000000,'total_data'=>count($rows));
	}
}