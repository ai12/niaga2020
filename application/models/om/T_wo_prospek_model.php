<?php
require APPPATH . '/models/om/_omModel.php';
class T_wo_prospek_model extends _omModel
{

	//put your code here
	function __construct()
	{
		parent::__construct();
	}


	var $table  = 't_wo_prospek';
	var $pk 	= 'id_wo';
	var $column = [
		'kode_wo' => 'Work Order', 'deskripsi' => 'WO Description', 'id_customer' => 'Customer', 'nama' => 'Nama Pekerjaan',
		'jenis' => 'Jenis', 'jenis_rkap' => 'Jenis RKAP', 'jenis_niaga' => 'Jenis niaga',
		'tanggal' => 'Tanggal Estimasi Pekerjaan', 'nilai' => 'Estimasi Nilai Pekerjaan', 'pic_id' => 'PIC', /*'user_status' => 'Status',*/
	];
	var $order  = ['id_wo' => 'asc']; // default order 

	public function _setting()
	{
		$set = parent::_setting();

		//custom
		// $set['id_wo']['hidden'] 	= true;	
		$set['nilai']['width'] 	= 'auto';
		$set['nama']['width'] 		= 'auto';
		$set['status']['hidden'] 	= true;
		$set['status']['required'] 	= false;
		$set['deskripsi']['required'] 	= false;
		$set['kode_wo']['required'] 	= false;

		$set['kode_wo']['url'] 	= 'detail';
		$set['id_customer']['value'] 	= $this->customerarr;
		$set['pic_id']['value'] 		= $this->pegawaiarr;
		$set['jenis_rkap']['value'] 	= $this->jenisrkaparr;
		$set['jenis']['value'] 			= $this->jenisarr;
		$set['status']['value'] 		= $this->statusarr;
		$set['jenis_niaga']['value'] 		= $this->niagaarr;

		// $set['nilai']['type'] 	= 'number';
		$set['tanggal']['type'] = 'date';
		$set['deskripsi']['type'] = 'text';

		$set['id_customer']['class'] = 'select2';
		$set['pic_id']['class'] = 'select2';
		$set['nilai']['class'] = 'rupiah';

		return $set;
	}
	public function dt_count_all()
	{
		$this->db->where('JENIS_NIAGA', 2);
		$this->db->from(strtoupper($this->table));
		return $this->db->count_all_results();
	}

	function _get_datatables_query()
	{

		$list_setting = $this->_setting();
		$this->db->where('JENIS_NIAGA', 2);
		foreach($list_setting as $k=>$val)
		{
			if ($this->input->post($k)) {
				if($val['type']=='number'){
					
					$this->db->where(strtoupper($k), $this->input->post($k));
				}else{

					$this->db->like(strtoupper($k), $this->input->post($k));
				}
			}
		}
		
		$this->db->from(strtoupper($this->table));
		$i = 0;

		$column = array_keys($this->column);
		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by(strtoupper($column[$_POST['order']['0']['column']]), $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(strtoupper(key($order)), $order[key($order)]);
		}
		
	}

	
}//END
