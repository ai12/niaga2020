<?php
class _omModel extends CI_Model{
	
	
	public function _setting()
	{
		$datas = $this->column;
		$set = [];
		foreach ($datas as $k => $val) {
			$set[$k]['name']  = $k;
			$set[$k]['label'] = $val;
			$set[$k]['width'] = 'auto';
			$set[$k]['type']  = 'varchar2';
			$set[$k]['value'] = null;
			$set[$k]['required'] = true;
		}

		
		return $set;
	}

	function _get_datatables_query()
	{

		$list_setting = $this->_setting();
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

	
	public function dt_get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get(); 
		return $query->result();
	}

	public function dt_count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function dt_count_all()
	{
		$this->db->from(strtoupper($this->table));
		return $this->db->count_all_results();
	}

	function get_detail($kode = '0')
	{

		$result = array();
		// $this->db->_protect_identifiers = false;
		$this->db->select('*');
		$this->db->from(up($this->table));
		$this->db->where(up($this->pk), $kode, false);
		$query  = $this->db->get();
		// debug($kode);exit;
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
		} else {
			$fields = $this->db->list_fields(up($this->table));
			foreach ($fields as $field) {
				$result[$field] = '';
			}
		}

		return $result;
	}


	function save($kode = '0', $data)
	{
		$this->db->trans_start();

		// $this->db->save_queries = TRUE;
		$this->db->protect_identifiers = false;
		if ($kode == '' || $kode == '0') {
			$this->db->insert(up($this->table), $data);
			
		} else {
			$this->db->where(up($this->pk), $kode, false);
			$this->db->update(up($this->table), $data);
		}
		
		// print_r ($this->db->last_query());exit;
		$this->db->trans_complete();
		if ($this->db->trans_status() == 1) {
			// $this->load->model('logdata_model');
			// $this->logdata_model->log_data($this->modul_kode, $kode, $log_desk);

			// $this->load->model('approval_model');
			// $appr['appr_desk'] = 'KPI TAHUN ' . $data['kpi_tahun'];
			// $appr['perusahaan_id'] = $data['kpi_perusahaan_id'];
			// $appr['ref_tabel'] = $this->modul_kode;
			// $appr['ref_id'] = $kode;
			// $this->approval_model->approval_data($appr);
		}
		return $this->db->trans_status();
	}

	function delete($kode)
	{
		$this->db->trans_start();
		// $this->db->_protect_identifiers = false;
		$this->db->where(up($this->pk), $kode, false);
		$this->db->delete(up($this->table));

		$this->db->trans_complete();

		if ($this->db->trans_status()) {
			return 1;
		}
		return 0;
	}

	
}
