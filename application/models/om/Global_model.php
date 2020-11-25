<?php
class Global_model extends CI_Model
{

	var $STATUS_PELUANG  = 10;
	var $STATUS_WO  	 = 20;
	var $STATUS_PROPOSAL  = 30;
	var $STATUS_NEGOSIASI  = 40;
	var $STATUS_KONTRAK  = 50;
	var $STATUS_SETTLEMENT  = 60;
	var $STATUS_CLOSED  = 70;
	var $STATUS_BATAL  = 90;


	//put your code here
	function __construct()
	{
		parent::__construct();
	}

	public function GetArray($sql){
		return $this->conn->GetArray($sql);
	}
	public function GetStatusArr($status = null){
		$arr[''] = '--- Pilih Status ---';
		$arr[$this->STATUS_PELUANG]   = 'Peluang';
		$arr[$this->STATUS_WO] 		  = 'Work Order';
		$arr[$this->STATUS_PROPOSAL]  = 'Proposal';
		$arr[$this->STATUS_NEGOSIASI] = 'Negosiasi';
		$arr[$this->STATUS_KONTRAK]   = 'Kontrak';
		$arr[$this->STATUS_SETTLEMENT]  = 'Settlement';
		$arr[$this->STATUS_CLOSED] 		= 'Closed';
		$arr[$this->STATUS_BATAL] 		= 'Batal';

		if(!is_null($status))
		{
			unset($arr[$status]);
		}
		return $arr;
	}
	public function GetJenisArr($key=null){
		$arr[null] 	= [];
		$arr['jenis_wo'] 	= [null => '', '0' => 'Penugasan', '1' => 'Non_Penugasan'];
		$arr['jenis_rkap'] 	= [null => '', '1' => 'Non-RKAP', '2' => 'RKAP'];
		return $arr[$key];
	}

	public function arrBulan()
	{
		$bln['01']= 'Januari';
		$bln['02']= 'Februari';
		$bln['03']= 'Maret';
		$bln['04']= 'April';
		$bln['05']= 'Mei';
		$bln['06']= 'Juni';
		$bln['07']= 'Juli';
		$bln['08']= 'Agustus';
		$bln['09']= 'September';
		$bln['10']= 'Oktober';
		$bln['11']= 'Nopember';
		$bln['12']= 'Desember';
		
		return $bln;
	}
	
	public function arrSla($jenis=2)
	{
		
		if($jenis==2){
			$sla ['0'] = '0 - Kendala Kontrak';
			$sla ['1'] = '1 - Proses Pembuatan Laporan';
			$sla ['2'] = '2 - Approval Laporan oleh Tim Pemeriksa Owner (PLN/PJB/IPP) di Site';
			$sla ['3'] = '3 - BAPP PLN/IPP di TTD oleh Wakil Direksi Pekerjaan Owner-Manajer Unit di site';
			$sla ['4'] = '4 - Laporan dan BAPP PLN diterima di PJBS Kantor Pusat';
			$sla ['5'] = '5 - Laporan realisasi biaya ABOP final';
			$sla ['6'] = '6 - Laporan, BAPP dan realisasi biaya diterima & direview Niaga O&M';
			$sla ['7'] = '7 - Proses penerbitan BAPP dengan UJLJ / Customer ';
			$sla ['8'] = '8 - Review nilai tagihan, proses BASTP ttd DirOM PJBS';
			$sla ['9'] = '9 - Penerbitan form Permohonan Pembuatan Tagihan/Invoice untuk diserahkan ke Div Keuangan (disertai kelengkapan syarat penagihan)';
			$sla ['10'] = '10 - Proses verifikasi kelengkapan berkas tagihan di Keuangan';
			$sla ['11'] = '11 - Proses pembuatan dan approval dokumen tagihan';
			$sla ['12'] = '12 - Proses penyampaian/ pengiriman dokumen tagihan';
			$sla ['13'] = '13 - Proses verifikasi dokumen tagihan oleh pelanggan';
			$sla ['14'] = '14 - Terbayar';
		}else{
			$sla ['0'] = '0 - Proses Kontrak';
			$sla ['1'] = '1 - Proyek Adendum / Amandemen';
			$sla ['2'] = '2 - Laporan';
			$sla ['3'] = '3 - Dokumen kelengkapan serah terima pekerjaan (BAPP, BA STO, BA RR, BA Material, BA Jasa)';
			$sla ['4'] = '4 - Review kelengkapan dan nilai tagihan untuk penerbitan BASTP dengan Customer';
			$sla ['5'] = '5 - Proses BASTP (oleh customer dan BOD PJBS)';
			$sla ['6'] = '6 - Pembuatan tagihan /invoice disertai dilengkapi syarat penagihan untuk diserahkan ke Div Keu';		
			$sla ['7'] = '7 - Proses verifikasi kelengkapan berkas tagihan di Keuangan';
			$sla ['8'] = '8 - Proses pembuatan dan approval dokumen tagihan';
			$sla ['9'] = '9 - Proses penyampaian/ pengiriman dokumen tagihan';
			$sla ['10'] = '10 - Proses verifikasi dokumen tagihan oleh pelanggan';
			$sla ['11'] = '11 - Terbayar';
		}
		
		return $sla;
	}
	public function arrSlaColor()
	{
		$sla ['0'] = '#626567';
		$sla ['1'] = '#ff5a4e';
		$sla ['2'] = '#ff5a4e';
		$sla ['3'] = '#ff5a4e';
		$sla ['4'] = '#ff5a4e';
		$sla ['5'] = 'pink';
		$sla ['6'] = '#fff650';
		$sla ['7'] = '#fff650';
		$sla ['8'] = '#fff650';
		$sla ['9'] = '#fff650';
		$sla ['10'] = '#72e483';
		$sla ['11'] = '#72e483';
		$sla ['12'] = '#72e483';
		$sla ['13'] = '#72e483';
		$sla ['14'] = '#76c9ff';
		
		return $sla;
	}
	public function arrSlaPic()
	{
		$sla ['0'] = 'Niaga';
		$sla ['1'] = 'Unit';
		$sla ['2'] = 'Unit';
		$sla ['3'] = 'O/M';
		$sla ['4'] = 'O/M';
		$sla ['5'] = 'Ni,Ak,O&M';
		$sla ['6'] = 'Niaga';
		$sla ['7'] = 'Niaga';
		$sla ['8'] = 'Niaga';
		$sla ['9'] = 'Keuangan';
		$sla ['10'] = 'Keuangan';
		$sla ['11'] = 'Keuangan';
		$sla ['12'] = 'Keuangan';
		$sla ['13'] = 'Keuangan';
		$sla ['14'] = 'Keuangan';
		
		return $sla;
	}

	
	public function GetNextStatus($status = null){
		$label = $this->GetStatusArr();
		$arr[$this->STATUS_PELUANG][$this->STATUS_WO]  = $label[$this->STATUS_WO];
		
		$arr[$this->STATUS_WO][$this->STATUS_PROPOSAL]  = $label[$this->STATUS_PROPOSAL];
		
		$arr[$this->STATUS_PROPOSAL][$this->STATUS_NEGOSIASI]  = $label[$this->STATUS_NEGOSIASI];

		$arr[$this->STATUS_NEGOSIASI][$this->STATUS_KONTRAK]  = $label[$this->STATUS_KONTRAK];
		$arr[$this->STATUS_NEGOSIASI][$this->STATUS_BATAL]  = $label[$this->STATUS_BATAL];
		
		$arr[$this->STATUS_KONTRAK][$this->STATUS_SETTLEMENT]  = $label[$this->STATUS_SETTLEMENT];
		$arr[$this->STATUS_KONTRAK][$this->STATUS_CLOSED]  = $label[$this->STATUS_CLOSED];
		
		$arr[$this->STATUS_SETTLEMENT][$this->STATUS_CLOSED]  = $label[$this->STATUS_CLOSED];
		// debug ($arr);
		
		$rs = ['' => '-- Pilih Status -- ']+$arr[$status]; 
		return $rs;
	}
	private function GetMenuArr($parent_id = null)
	{
		$ret = '';
		$group_id = $_SESSION[SESSION_APP]['group_id'];
		$user_id = $_SESSION[SESSION_APP]['user_id'];
		$filter = ($parent_id == null) ? 'b.parent_id is null' : 'b.parent_id = ' . $parent_id;
		if ($user_id == 1) {
			$strSQL = " SELECT b.*
						FROM public_sys_menu b
						WHERE $filter
						ORDER BY b.sort";
		} else {
			$filter .= " and a.group_id =" . $group_id;
			$strSQL = "	SELECT b.*
						FROM public_sys_group_menu a
						LEFT JOIN public_sys_menu b ON a.menu_id = b.menu_id
						WHERE $filter
						ORDER BY b.sort";
		}

		$data = $this->GetArray($strSQL);

		$ret = array();
		if ($data) {
			foreach ($data as $row) {

				$_SESSION[SESSION_APP]['access_menu'][$row['url']] = 1;

				//if($row['label']=='Setting')
				//	$ret=array_merge($ret,$this->GetMenuCmsArr());

				$url = '#';
				if ($row['url'] != '') {
					$url = base_url($row['url']);
				}

				$icon = 'folder';
				if ($row['iconcls']) {
					$icon = $row['iconcls'];
				}

				$sub = $this->GetMenuArr($row['menu_id']);

				if ($row['visible']) {
					$ret[] = array(
						"menu_id" => $row["menu_id"],
						"label" => $row["label"],
						"icon" => $icon,
						"url" => $url,
						"sub" => $sub,
					);
				}
			}
		}
		return $ret;
	}

	public function GetMenu($data = null, $ul = "<ul class=\"nav navbar-nav\">", &$child_active = '', $ischild = false, $level = 1)
	{

		$level++;

		if (!$data) {
			$start = true;
			// $data = $_SESSION[SESSION_APP]['menu'];
			$data = $this->GetMenuArr();
		}

		if ($data) {
			$fulluri = current_url();
			$ret .= "\n $ul \n ";
			foreach ($data as $row) {

				$url = $row['url'];
				if (!$ischild)
					$icon = $row['icon'];


				$active = "";
				

				if($_SESSION['menu_id']==$row['menu_id']){

					$child_active = $active = "active";
					
				}
				

				$child_active1 = '';
				$sub = '';
				if (count($row['sub'])) {
					$sub = $this->GetMenu($row['sub'], "<ul class=\"dropdown-menu\" role=\"menu\">", $child_active1, 1, $level);
				}


				if ($sub) {
					if ($level > 2) {
						if ($child_active1)
							$child_active = $child_active1;

						$ret .= "<li class=\"$child_active1 dropdown-submenu\">\n";
					} else {
						$ret .= "<li class=\"$child_active1\">\n";
					}
					$ret .= "<a href='" . $url . "' class=\"dropdown-toggle\" data-toggle=\"dropdown\">\n<span class='fa fa-{$icon} '></span> " . $row['label'] . "<span class=\"caret\"></span>\n</a>\n";
					$ret .= $sub;
				} else {
					$ret .= "<li class=\"$active\">\n";
					$ret .= "<a href='" . $url . "'><span class='fa fa-{$icon} '></span> " . $row['label'] . "</a>\n";
				}
				$ret .= "</li>\n";
			}

			$ret .= "</ul>";
		}
		
		return $ret;
	}
	function GetCombo()
	{
		$sql = "select {$this->pk} as key, {$this->label} as val from {$this->table} order by key";
		$rows = $this->conn->GetArray($sql);
		$data = array('' => '-pilih-');
		foreach ($rows as $r) {
			$data[trim($r['key'])] = $r['val'];
		}
		return $data;
	}

	function GetComboMenu()
	{
		$this->pk = 'menu_id';
		$this->label = 'label';
		$this->table = 'public_sys_menu';
		return $this->GetCombo();
	}

	function Get_combo($tabel = 'T_WO_PROSPEK', $key = 'ID_WO', $label = 'NAMA')
	{
		$sql = "select {$key} as key, {$label} as val from {$tabel} order by key";
		$rows = $this->conn->GetArray($sql);
		$data = array('' => '-pilih-');
		foreach ($rows as $r) {
			$data[trim($r['key'])] = $r['val'];
		}
		return $data;
	}

	function get_next_exist($kode,$status)
	{
		if($kode=='')return false;
		$arr_status = $this->GetNextStatus($status);
		unset($arr_status['']);

		$this->db->select('*');
		$this->db->from('R_HISTORY');
		$this->db->where('REF','WO');
		$this->db->where('REF_ID', $kode, false);
		$this->db->where_in('STATUS', array_keys($arr_status), false);
		$query  = $this->db->get();
		// print_r($arr_status);exit;
		if ($query->num_rows() > 0) {
			return true;
		}

		return false;
	}
	function get_history($kode,$ref='WO')
	{
		if($kode=='')return false;
		$sql = "select * from R_HISTORY where REF = '$ref' AND REF_ID = $kode order by TGL asc";
		// print_r($sql);exit;
		$rows = $this->conn->GetArray($sql);
		return $rows;
	}

	function get_detail($kode = '0',$tabel = 'T_WO_PROSPEK', $key = 'ID_WO')
	{

		$result = array();
		// $this->db->_protect_identifiers = false;
		$this->db->select('*');
		$this->db->from(strtoupper($tabel));
		$this->db->where(strtoupper($key), $kode, false);
		$query  = $this->db->get();
		// debug($kode);exit;
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
		} else {
			$fields = $this->db->list_fields(strtoupper($tabel));
			foreach ($fields as $field) {
				$result[$field] = '';
			}
		}

		return $result;
	}

	function update_wo($kode,$data)
	{

		$result = array();
		// $this->db->_protect_identifiers = false;
		$this->db->where('ID_WO',$kode);
		$this->db->update('T_WO_PROSPEK',$data);
		
	}
	function insert_log($ref,$ref_id,$desk,$status,$user='USERS',$lampiran='',$other_attr='')
	{

		$hist['REF'] = $ref;
		$hist['REF_ID'] = $ref_id;
		$hist['TGL'] = date('d-M-Y H:i:s');
		$hist['DESKRIPSI'] = $desk;
		$hist['STATUS'] = $status;
		$hist['USER'] = $user;
		$hist['LAMPIRAN'] = $lampiran;
		$hist['OTHER_ATTR'] = $other_attr;

		$this->db->insert('R_HISTORY', $hist);
		
	}

	function last_id($db,$key)
	{

		$result = array();
		// $this->db->_protect_identifiers = false;
		$this->db->select('*');
		$this->db->from(up($db));
		$this->db->order_by(up($key), 'DESC');
		$this->db->limit(1);
		$query  = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$result = $row[$key];
		} else {
			$result = 0;
		}

		return $result;
	}

	function formating_history($arr,$type)
	{
		$string = '';
        $dt = json_decode($arr,true);
        
		if($type == $this->STATUS_PROPOSAL)
		{
			$string .= (isset($dt['hpp']))?'<br>- HPP : Rp.'.$dt['hpp']:'';
			$string .= (isset($dt['proposal_penawaran']))?'<br>- Harga Penawaran : Rp.'.$dt['proposal_penawaran']:'';
			$string .= (isset($dt['standar_produksi']))?'<br>- L/R : Rp.'.$dt['standar_produksi']:'';
			$string .= (isset($dt['gpm']))?'<br>- GPM : '.$dt['gpm'].'%':'';
			$string .= (isset($dt['npm']))?'<br>- NPM : '.$dt['npm'].'%':'';
			if($dt['jenis_niaga']==2){
                $string .= (isset($dt['irr']))?'<br>- IRR : '.$dt['irr'].'%':'';
                $string .= (isset($dt['npv']))?'<br>- NPV : Rp. '.$dt['npv']:'';
            }
			$string .= (isset($dt['deskripsi']))?'<br>- deskripsi :'.$dt['deskripsi']:'';
		}elseif($type == $this->STATUS_NEGOSIASI)
		{
			$string .= (isset($dt['kesepakatan_harga']))?'<br>- Kesepakatan Harga : Rp.'.$dt['kesepakatan_harga']:'';
			$string .= (isset($dt['hpp']))?'<br>- HPP : Rp.'.$dt['hpp']:'';
			$string .= (isset($dt['deskripsi']))?'<br>- deskripsi : '.$dt['deskripsi']:'';

		}
		return $string;
	}

	function nilai_settlement($unit,$periode,$jenis=2)
	{
		
		$sql = "select * from t_settlement where unit_id = '$unit' and periode = '$periode' and jenis = $jenis";
		$ret = $this->conn->GetRow($sql);

		if(!$ret){

			$ret['id'] = 0;
			$ret['unit_id'] = $unit;
			$ret['periode'] = $periode;
			$ret['status'] = 0;
			$ret['nilai_kontrak'] = 0;
			$ret['nilai_tagihan'] = 0;
			$ret['nilai_terbayar'] = 0;
			$ret['nilai_biaya'] = 0;
			$ret['persen_sla'] = 0;
			$ret['jenis'] = 0;
		}

		return $ret;	
	}
	function nilai_sla($unit='',$periode)
	{
		$str_unit = '';
		if($unit!=''){
			$str_unit .= " and unit_id = '$unit' ";
		}
		$sql = "select sum(nilai_kontrak) as pendapatan,sum(nilai_terbayar) as pendapatan_real,sum(nilai_hpp) as nilai_hpp,avg(persen_sla) persen_sla,sum(nilai_biaya) as biaya_real  from t_settlement where periode = '$periode' and jenis = 2 $str_unit";
		// echo $sql.'<br>';
		$rs =  $this->conn->GetRow($sql);

		if(!$rs){

			$ret['pendapatan'] = 0;
			$ret['hpp'] = 0;
			$ret['laba_rencana'] = 0;
			$ret['gpm_rencana'] = 0;
			$ret['pendapatan_real'] = 0;
			$ret['laba_real'] = 0;
			$ret['biaya_real'] = 0;
			$ret['gpm_real'] = 0;
			$ret['persen_sla'] = 0;
			
		}else{
			$ret['pendapatan'] = ($rs['pendapatan']>0)?$rs['pendapatan']:0;
			$ret['hpp'] = ($rs['nilai_hpp']>0)?$rs['nilai_hpp']:0;
			$ret['laba_rencana'] = $ret['pendapatan']-$ret['hpp'];
			$ret['gpm_rencana'] = ($ret['pendapatan']>0)?($ret['laba_rencana']*100)/$ret['pendapatan']:0;
			$ret['pendapatan_real'] = ($rs['pendapatan_real'])?$rs['pendapatan_real']:0;
			$ret['biaya_real'] = ($rs['biaya_real']>0)?$rs['biaya_real']:0;
			$ret['laba_real'] = $ret['pendapatan_real']-$ret['biaya_real'];
			$ret['gpm_real'] = ($ret['pendapatan_real']>0)?($ret['laba_real']*100)/$ret['pendapatan_real']:0;
			$ret['persen_sla'] = $rs['persen_sla'];
		}

		return $ret;	
	}

	function save($table, $pk, $kode = '0', $data)
	{
		$this->db->trans_start();

		// $this->db->save_queries = TRUE;
		$this->db->protect_identifiers = false;
		if ($kode == '' || $kode == '0') {
			$this->db->insert(strtoupper($table), $data);
			
		} else {
			$this->db->where(strtoupper($pk), $kode, false);
			$this->db->update(strtoupper($table), $data);
		}
		
		$this->db->trans_complete();
		if ($this->db->trans_status() == 1) {
			
		}
		return $this->db->trans_status();
	}

	function uraian_settlement($unit,$jenis=1,$jenis_niaga=2,$periode=null)
	{
		// var_dump($periode);
		$arr_sla = $this->arrSla($jenis_niaga);
		end($arr_sla);
		$end = key($arr_sla);
		$str_periode = '';
		if(!is_null($periode))
		{
			$first = array_pop($periode);
			$str_periode = " and ( periode = '$first' ";
			foreach($periode as $k=>$row)
			{
				$str_periode .= " or periode = '$row'";
			}
			$str_periode .= ') ';
		}
		$sql = "select * from t_settlement where unit_id = '$unit' and jenis = $jenis_niaga and status < $end $str_periode order by periode asc";
		
		$ret =  $this->GetArray($sql);
		// echo $sql;
		$rs = '';
		foreach ($ret as $key => $value) {
			# code...
			$string = ($jenis==1)?$value['uraian']:$value['tindak_lanjut'];
			$rs .= ($string!='')?'- '.$value['periode'].' : '.$string.'<br>':'';
		}

		return $rs;	
	}

	function history_settlement($unit,$jenis=2)
	{
		
		$sql = "select * from t_settlement where unit_id = '$unit' and jenis = $jenis order by id asc";
		$ret =  $this->GetArray($sql);		
		return $ret;	
	}

	function nilai_settlement_by_status($status,$jenis=2,$unit='',$periode=null)
	{
		if(!is_null($periode))
		{
			$first = array_pop($periode);
			$str_periode = " and ( periode = '$first' ";
			foreach($periode as $k=>$row)
			{
				$str_periode .= " or periode = '$row'";
			}
			$str_periode .= ') ';
		}

		$type_unit = ($unit!='')?' and table_type = '.$unit:'';
		$sql = "select * from t_settlement a join mt_unit b on trim(a.unit_id) = trim(b.table_code) where status = $status  and jenis = $jenis $type_unit $str_periode";
		// echo $sql.'<br>';
		$ret =  $this->GetArray($sql);
		$data['jumlah'] = count($ret);

		foreach ($ret as $key => $value) {
			$data['tagihan'] += $value['nilai_tagihan'];		
			$data['total'] += $value['nilai_kontrak'];		
		}


		return $data;	
	}
	function nilai_settlement_by_unit($unit,$jenis=2,$periode=null)
	{
		if(!is_null($periode))
		{
			$first = array_pop($periode);
			$str_periode = " and ( periode = '$first' ";
			foreach($periode as $k=>$row)
			{
				$str_periode .= " or periode = '$row'";
			}
			$str_periode .= ') ';
		}
		$sql = "select * from t_settlement where unit_id = '$unit'  and jenis = $jenis $str_periode";
		// echo $sql;
		$ret =  $this->GetArray($sql);
		
		$data = [];
		$data['pekerjaan'] = 0;
		$data['pemberkasan_unit'] = 0;
		$data['verifikasi_om'] = 0;
		$data['proses_niaga'] = 0;
		$data['bast'] = 0;
		$data['masuk_keuangan'] = 0;
		$data['verifikasi']= 0;
		$data['terbayar']= 0;
		$data['dalam_proses'] = 0;
		$data['total'] = 0;
		foreach ($ret as $key => $value) {
			$data['pekerjaan'] += $value['nilai_tagihan'];
			if($value['status']==1||$value['status']==2){
				$data['pemberkasan_unit'] += $value['nilai_kontrak'];
			}
			if($value['status']==3||$value['status']==3){
				$data['verifikasi_om'] += $value['nilai_kontrak'];
			}
			if($value['status']==5||$value['status']==6||$value['status']==7){
				$data['proses_niaga'] += $value['nilai_kontrak'];
			}
			if($value['status']==8){
				$data['bast'] += $value['nilai_kontrak'];
			}
			if($value['status']==9){
				$data['masuk_keuangan'] += $value['nilai_kontrak'];
			}
			if($value['status']==10||$value['status']==11||$value['status']==12||$value['status']==13){
				$data['verifikasi'] += $value['nilai_kontrak'];
			}
			if($value['status']==14){
				$data['terbayar'] += $value['nilai_kontrak'];
			}
			$data['dalam_proses'] += $value['nilai_terbayar'];
			$data['total'] += $value['nilai_kontrak'];
		}


		return $data;	
	}

}//END