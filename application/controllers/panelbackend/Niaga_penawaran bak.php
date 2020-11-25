<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Niaga_penawaran extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/niaga_penawaranlist";
		$this->viewdetail = "panelbackend/niaga_penawarandetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout_rab";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah RAB Komersial';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit RAB Komersial';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail RAB Komersial';
			$this->data['edited'] = false;	
		}else{
			$this->data['no_menu'] = true;
			$this->data['page_title'] = 'Daftar RAB Komersial';
		}

		$this->load->model("Niaga_penawaranModel","model");
		$this->load->model("RabModel","rabrab");		
		$this->load->model("Proyek_pekerjaanModel","rabpekerjaan");
		$this->load->model("ProyekModel","proyek");

		$this->data['sumbersatuanarr'] = array('1'=>'Manual','4'=>'RAB','2'=>'Mandays','3'=>'Unit Day');
		$this->data['sumbernilaiarr'] = array('4'=>'Manual', '1'=>'Hitung di sub'/*,'2'=>'Master Harga'*/,'3'=>'RAB');
		$this->data['jenismandaysarr'] = array(''=>'','1'=>'Max','2'=>'Total');

		$this->load->model("Mt_sumber_pegawaiModel","mtsumberpegawai");
		$this->data['mtsumberpegawaiarr'] = $this->mtsumberpegawai->GetCombo();
		unset($this->data['mtsumberpegawaiarr']['']);

		$this->load->model("Mt_jabatan_proyekModel","mtjabatanproyek");
		$this->data['jabatanarr'] = $this->mtjabatanproyek->GetCombo();
		unset($this->data['jabatanarr']['']);

		$this->data['aturan'] = $this->conn->GetRow("select * from mt_kelayakan_penawaran");
		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			''
		);
	}

	private function generatePenawaran(){

			$ret = $this->conn->Execute("delete from niaga_penawaran where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek));

			$this->niaga_komersial();

			$rows = $this->data['rows'];
			$rowskompensasi = $this->data['rowskompensasi'];
			$rowsrab = $this->data['rowsrab'];
			$jasa_materialarr = $this->data['jasa_materialarr'];

			if($rows[0])
			foreach($rows[0] as $r){ 
				$is_add_ppn = $r['is_add_ppn'];

				if($rowskompensasi[$r['id_niaga_komersial']]){
					if(!$id_niaga_penawaran_parent_kompensasi){
						$record = array();
						$record['uraian'] = 'MANPOWER SALARY';
						$record['sumber_nilai'] = 1;
						$record['id_niaga_proyek'] = $this->id_niaga_proyek;
						$this->conn->goInsert("niaga_penawaran", $record);

						$id_niaga_penawaran_parent = $this->conn->GetOne("select max(id_niaga_penawaran) 
							from niaga_penawaran 
							where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek));

						$id_niaga_penawaran_parent_kompensasi = $id_niaga_penawaran_parent;
					}
				}elseif($rows[$r['id_niaga_komersial']] or $rowskompensasi[$r['id_niaga_komersial']] or $rowsrab[$r['id_niaga_komersial']]){
					$record = array();
					$record['uraian'] = $r['uraian'];
					$record['sumber_nilai'] = 1;
					$record['id_niaga_proyek'] = $this->id_niaga_proyek;
					$this->conn->goInsert("niaga_penawaran", $record);

					$id_niaga_penawaran_parent = $this->conn->GetOne("select max(id_niaga_penawaran) 
						from niaga_penawaran 
						where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek));
				}

				#niaga komersial
				$total = 0;
				if($rows[$r['id_niaga_komersial']])
				foreach($rows[$r['id_niaga_komersial']] as $r1){ 
					$is_add_ppn = $r1['is_add_ppn'];
					if(!$r1['vol'])
						continue;

					if($is_add_ppn)
						$r1['nilai_satuan'] = (float)$r1['nilai_satuan']*1.1;

					$record = array();
					$record['id_niaga_penawaran_parent'] = $id_niaga_penawaran_parent;
					$record['uraian'] = $r1['uraian'];
					$record['nilai_satuan'] = $r1['nilai_satuan'];
					$record['vol'] = $r1['vol'];
					$record['satuan'] = $r1['satuan'];
					$record['id_niaga_proyek'] = $this->id_niaga_proyek;
					$this->conn->goInsert("niaga_penawaran", $record);
				}

				#kompensasi
				if($rowskompensasi[$r['id_niaga_komersial']])
				foreach($rowskompensasi[$r['id_niaga_komersial']] as $r1){ 
					if(!$r1['mandays'])
						continue; 

					$id_jabatan_proyek = $r1['id_jabatan_proyek'];

					$nilai = $this->conn->GetOne("select 
						nilai
						from mt_manpower_rate a
						join mt_manpower_rate_detail b on a.id_manpower_rate = b.id_manpower_rate
						where id_jabatan_proyek = ".$this->conn->escape($id_jabatan_proyek)."
						and id_wilayah_proyek = ".$this->conn->escape($this->data['rowheader']['id_wilayah_proyek']));

					$record = array();
					$record['id_niaga_penawaran_parent'] = $id_niaga_penawaran_parent_kompensasi;
					$record['uraian'] = $r1['nama'];
					$record['nilai_satuan'] = $nilai;
					$record['vol'] = $r1['mandays'];
					$record['satuan'] = 'MD';
					$record['id_niaga_proyek'] = $this->id_niaga_proyek;
					$this->conn->goInsert("niaga_penawaran", $record);
				}

				#rab
				if($rowsrab[$r['id_niaga_komersial']])
				foreach ($rowsrab[$r['id_niaga_komersial']] as $r2) { 
					if($is_add_ppn)
						$r2['nilai_satuan'] = $r2['nilai_satuan']*1.1;

					$record = array();
					$record['id_niaga_penawaran_parent'] = $id_niaga_penawaran_parent;
					$record['uraian'] = $r2['uraian'];
					if($r2['sumber_nilai']!='3'){
						$record['nilai_satuan'] = $r2['nilai_satuan'];
						$record['vol'] = $r2['vol'];
						$record['satuan'] = $r2['satuan'];
					}
					$record['id_niaga_proyek'] = $this->id_niaga_proyek;
					$this->conn->goInsert("niaga_penawaran", $record);

					$id_niaga_penawaran_parent1 = $this->conn->GetOne("select max(id_niaga_penawaran) 
						from niaga_penawaran 
						where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek));

					if($r2['sumber_nilai']=='3'){
						#jasa material
						$jm = $jasa_materialarr[$r2['id_pos_anggaran']][$r2['jasa_material']][$r2['kode_biaya']];
						if($jm)
						foreach($jm as $r3){
							if(!$r3['vol'])
								continue;
							
							if($is_add_ppn)
								$r3['harga_satuan'] = $r3['harga_satuan']*1.1;

							$record = array();
							$record['id_niaga_penawaran_parent'] = $id_niaga_penawaran_parent1;
							$record['uraian'] = $r3['nama'];
							$record['nilai_satuan'] = $r3['harga_satuan'];
							$record['vol'] = $r3['vol'];
							$record['satuan'] = $r3['satuan'];
							$record['id_niaga_proyek'] = $this->id_niaga_proyek;
							$this->conn->goInsert("niaga_penawaran", $record);
						}
					}
				}
			}

			redirect(current_url());
	}
	
	public function Index($id_rab=0, $page=0){
		$this->_beforeDetail($id_rab);

		if($this->post['act']=='generate_penawaran'){
			$this->generatePenawaran();
		}

		$this->data['rows'] = array();

		$rows = $this->conn->GetArray("select * from niaga_penawaran where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek)." order by id_niaga_penawaran");

		foreach($rows as $r){
			$this->data['rows'][(int)$r['id_niaga_penawaran_parent']][$r['id_niaga_penawaran']] = $r;
		}

		$rows = $this->conn->GetArray("select * from niaga_analisa where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek));

		$analisa = array();
		foreach($rows as $r){
			$analisa[$r['jenis']][] = $r;
		}

		$this->data['analisa'] = $analisa;

		$rows = $this->conn->GetArray("select * from niaga_beban_usaha where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek));

		$bebanusaha = array();
		foreach($rows as $r){
			$bebanusaha[$r['id_analisa']][] = $r;
		}

		$this->data['bebanusaha'] = $bebanusaha;

		$this->data['hpp'] = $this->data['rowheader3']['hpp'];

		$this->View($this->viewlist);
	}

	public function Add($id_rab=0, $id_niaga_penawaran_parent=null){
		$this->Edit($id_rab, 0, $id_niaga_penawaran_parent);
	}


	public function Edit($id_rab=0,$id=null, $id_niaga_penawaran_parent=null){

		if($this->post['act']=='reset'){
			redirect(current_url());
		}

		$this->_beforeDetail($id_rab,$id);

		$this->data['idpk'] = $id;

		$this->data['row'] = $this->model->GetByPk($id);
		if($id_niaga_penawaran_parent)
			$this->data['row']['id_niaga_penawaran_parent'] = $id_niaga_penawaran_parent;

		if (!$this->data['rowheader1'] && !$this->data['row'] && $id)
			$this->NoData();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters("","");

		if(count($this->post) && $this->post['act']<>'change'){
			if(!$this->data['row'])
				$this->data['row'] = array();

			$record = $this->Record($id);

			$this->data['row'] = array_merge($this->data['row'],$this->post);
			$this->data['row'] = array_merge($this->data['row'],$record);
		}

		$this->_onDetail($id);

		$this->data['rules'] = $this->Rules();

		## EDIT HERE ##
		if ($this->post['act'] === 'save') {

			$record['id_niaga_proyek'] = $this->id_niaga_proyek;
			$record['id_niaga_penawaran_parent'] = $id_niaga_penawaran_parent;

			$this->_isValid($record,false);

            $this->_beforeEdit($record,$id);

            $this->_setLogRecord($record,$id);

            $this->model->conn->StartTrans();
			if (trim($this->data['row'][$this->pk])==trim($id) && trim($id)) {

				$return = $this->_beforeUpdate($record, $id);

				if($return){
					$return = $this->model->Update($record, "$this->pk = ".$this->conn->qstr($id));
				}

				if ($return['success']) {

					$this->log("mengubah ".$record['nama']);

					$return1 = $this->_afterUpdate($id);

					if(!$return1){
						$return = false;
					}
				}
			}else {

				$return = $this->_beforeInsert($record);

				if($return){
					$return = $this->model->Insert($record);
					$id = $return['data'][$this->pk];
				}

				if ($return['success']) {

					$this->log("menambah ".$record['nama']);

					$return1 = $this->_afterInsert($id);

					if(!$return1){
						$return = false;
					}
				}
			}

            $this->conn->CompleteTrans();

			if ($return['success']) {

				$this->_afterEditSucceed($id);

				SetFlash('suc_msg', $return['success']);
				redirect("$this->page_ctrl/index/$id_rab");

			} else {
				$this->data['row'] = array_merge($this->data['row'],$record);
				$this->data['row'] = array_merge($this->data['row'],$this->post);

				$this->_afterEditFailed($id);

				$this->data['err_msg'] = "Data gagal disimpan";
			}
		}

		$this->_afterDetail($id);

		$this->View($this->viewdetail);
	}

	public function Detail($id_rab=null, $id=null){

		$this->_beforeDetail($id_rab, $id);

		$this->data['row'] = $this->model->GetByPk($id);

		$this->_onDetail($id);

		if (!$this->data['row'] && !$this->data['rowheader1'])
			$this->NoData();

		$this->_afterDetail($id);

		$this->View($this->viewdetail);
	}

	public function Delete($id_rab=null, $id=null){

        $this->model->conn->StartTrans();

        $this->_beforeDetail($id_rab,$id);

		$this->data['row'] = $this->model->GetByPk($id);
		
		$this->_onDetail($id);

		if (!$this->data['row'])
			$this->NoData();

		$return = $this->_beforeDelete($id);

		if($return){
			$return = $this->model->delete("$this->pk = ".$this->conn->qstr($id));
		}

		if($return){
			$return1 = $this->_afterDelete($id);
			if(!$return1)
				$return = false;
		}

        $this->model->conn->CompleteTrans();

		if ($return) {

			$this->log("menghapus $id");

			SetFlash('suc_msg', $return['success']);
			redirect("$this->page_ctrl/index/$id_rab");
		}
		else {
			SetFlash('err_msg',"Data gagal didelete");
			redirect("$this->page_ctrl/detail/$id_rab/$id");
		}

	}

	protected function _beforeDetail($id_rab=null, $id=null){
		$this->data['rowheader3'] = $this->conn->GetRow("select * from niaga_proyek where id_rab = ".$this->conn->escape($id_rab));
		$this->data['id_niaga_proyek'] = $this->id_niaga_proyek = $this->data['rowheader3']['id_niaga_proyek'];
		$this->data['id_rab'] = $id_rab;
		$this->data['rowheader2'] = $this->rabrab->GetByPk($id_rab);
		$this->data['id_proyek_pekerjaan'] = $id_proyek_pekerjaan = $this->data['rowheader2']['id_proyek_pekerjaan'];
		$this->data['rowheader1'] = $this->rabpekerjaan->GetByPk($id_proyek_pekerjaan);
		$this->data['id_proyek'] = $id_proyek = $this->data['rowheader1']['id_proyek'];
		$this->data['rowheader'] = $this->proyek->GetByPk($id_proyek);
		$this->data['editedheader'] = false;
		$this->data['modeheader'] = 'detail';
		$this->data['add_param'] .= $id_rab;
		$this->data['versiarr'] = $this->conn->GetArray("select * from rab where jenis='1' and id_proyek_pekerjaan = ".$this->conn->escape($id_proyek_pekerjaan));
		$this->data['last_versi'] = $this->conn->GetOne("select max(id_rab) from rab where jenis = '1' and id_proyek_pekerjaan = ".$this->conn->escape($id_proyek_pekerjaan));
	}

	protected function Header(){
		return array(
			array(
				'name'=>'id_niaga_penawaran_parent', 
				'label'=>'Niaga Komersial Parent', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'uraian', 
				'label'=>'Uraian', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'nilai_satuan', 
				'label'=>'Nilai Satuan', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'vol', 
				'label'=>'VOL', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'satuan', 
				'label'=>'Satuan', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'sumber_nilai', 
				'label'=>'Sumber Nilai', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'sumber_satuan', 
				'label'=>'Sumber Satuan', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'id_niaga_proyek', 
				'label'=>'Niaga Proyek', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['niagaproyekarr'],
			),
			array(
				'name'=>'jenis_mandays', 
				'label'=>'Jenmandays', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>array(''=>'-pilih-','0'=>'Tidak','1'=>'Iya'),
			),
			array(
				'name'=>'day', 
				'label'=>'DAY', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'pembagi', 
				'label'=>'Pembagi', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'created_by_desc', 
				'label'=>'Created BY Desc', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'modified_by_desc', 
				'label'=>'Modified BY Desc', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
		);
	}

	protected function Record($id=null){
		$return = array(
			'uraian'=>$this->post['uraian'],
			'nilai_satuan'=>($this->post['nilai_satuan']),
			'vol'=>($this->post['vol']),
			'satuan'=>$this->post['satuan'],
			'sumber_nilai'=>($this->post['sumber_nilai']),
			'sumber_satuan'=>($this->post['sumber_satuan']),
			'jenis_mandays'=>($this->post['jenis_mandays']),
			'day'=>($this->post['day']),
			'pembagi'=>($this->post['pembagi']),
		);

		if($return['sumber_satuan']=='1'){
			$return['vol'] = $this->post['vol'];
			$return['satuan'] = $this->post['satuan'];
		}elseif($return['sumber_satuan']=='2'){
			$return['vol'] = $this->_hitungMd($return);
			$return['satuan'] = 'MD';
			if($return['jenis_mandays']==1){
				$return['day'] = $this->post['day'];
				$return['satuan'] = $this->post['satuan'];
			}

		}elseif($return['sumber_satuan']=='3'){
			$return['vol'] = $this->_hitungMd($return);
			$return['satuan'] = 'Unit Day';
		}elseif($this->post['act']=='save'){
			$return['vol'] = "{{null}}";
			$return['satuan'] = "{{null}}";
		}

		if($return['sumber_satuan']=='4' and $return['sumber_nilai']<>'3'){

			if($this->post['id_rab_detail']){
				if(!is_array($this->post['id_rab_detail']))
					$this->data['row']['id_rab_detail'] = array($this->post['id_rab_detail']=>$this->post['id_rab_detail']);
				else
					$this->data['row']['id_rab_detail'] = $this->post['id_rab_detail'];
			}

			if($this->data['row']['id_rab_detail'])
				$return['vol'] = $this->conn->GetOne("select sum(vol) from rab_detail where id_rab_detail in (".implode(", ",$this->conn->escape_string(array_keys($this->data['row']['id_rab_detail']))).")");
		}elseif($return['sumber_satuan']<>'4' and $return['sumber_nilai']=='3'){

			if($this->post['id_rab_detail']){
				if(!is_array($this->post['id_rab_detail']))
					$this->data['row']['id_rab_detail'] = array($this->post['id_rab_detail']=>$this->post['id_rab_detail']);
				else
					$this->data['row']['id_rab_detail'] = $this->post['id_rab_detail'];
			}

			if($this->data['row']['id_rab_detail'])
				$return['nilai_satuan'] = $this->conn->GetOne("select nilai_satuan from rab_detail where id_rab_detail = ".$this->conn->escape(key($this->data['row']['id_rab_detail'])));

		}

		return $return;
	}

	protected function Rules(){
		return array(
			"id_niaga_penawaran_parent"=>array(
				'field'=>'id_niaga_penawaran_parent', 
				'label'=>'Niaga Komersial Parent', 
				'rules'=>"numeric|max_length[10]",
			),
			"uraian"=>array(
				'field'=>'uraian', 
				'label'=>'Uraian', 
				'rules'=>"required|max_length[200]",
			),
			"nilai_satuan"=>array(
				'field'=>'nilai_satuan', 
				'label'=>'Nilai Satuan', 
				'rules'=>"numeric|max_length[10]",
			),
			"vol"=>array(
				'field'=>'vol', 
				'label'=>'VOL', 
				'rules'=>"numeric|max_length[10]",
			),
			"satuan"=>array(
				'field'=>'satuan', 
				'label'=>'Satuan', 
				'rules'=>"max_length[20]",
			),
			"sumber_nilai"=>array(
				'field'=>'sumber_nilai', 
				'label'=>'Sumber Nilai', 
				'rules'=>"numeric|max_length[10]",
			),
			"sumber_satuan"=>array(
				'field'=>'sumber_satuan', 
				'label'=>'Sumber Satuan', 
				'rules'=>"numeric|max_length[10]",
			),
			"jenis_mandays"=>array(
				'field'=>'jenis_mandays', 
				'label'=>'Jenis Mandays', 
				'rules'=>"numeric|max_length[10]",
			),
			"day"=>array(
				'field'=>'day', 
				'label'=>'DAY', 
				'rules'=>"numeric|max_length[10]",
			),
			"pembagi"=>array(
				'field'=>'pembagi', 
				'label'=>'Pembagi', 
				'rules'=>"numeric|max_length[10]",
			),
		);
	}

	protected function _afterDetail($id){

		if($this->data['row']['id_niaga_penawaran_parent'])
			$this->data['row']['uraian_parent'] = $this->conn->GetOne("select uraian from niaga_penawaran where id_niaga_penawaran = ".$this->conn->escape($this->data['row']['id_niaga_penawaran_parent']));
		
		if($this->data['row']['sumber_satuan']==2 or $this->data['row']['sumber_satuan']==3){
			if($this->post['act']!='set_value' && empty($this->post['id_jabatan_proyek'])){
				$this->data['row']['id_jabatan_proyek'] = $this->conn->GetList("select id_jabatan_proyek as key, id_jabatan_proyek as val 
					from niaga_jabatan_proyek 
					where id_niaga_penawaran = ".$this->conn->escape($id));
			}
			if($this->post['act']!='set_value' && empty($this->post['id_sumber_pegawai'])){
				$this->data['row']['id_sumber_pegawai'] = $this->conn->GetList("select id_sumber_pegawai as key, id_sumber_pegawai as val 
					from niaga_sumber_pegawai 
					where id_niaga_penawaran = ".$this->conn->escape($id));

			}
		}

		if(!$this->data['row']['sumber_satuan'])
			$this->data['row']['sumber_satuan'] = 1;

		if($this->data['row']['sumber_nilai']=='3' or $this->data['row']['sumber_satuan']=='4'){
			$rows = $this->conn->GetArray("select a.*, nvl(nilai_satuan,0)*nvl(vol,1)*nvl(day,1) as nilai from rab_detail a where id_rab = ".$this->conn->escape($this->data['id_rab'])."
				order by nvl(id_rab_detail_parent, id_rab_detail), id_rab_detail, kode_biaya");

			$this->data['rowsrab'] = array();
			$i = 0;
			$this->GenerateTree($rows, "id_rab_detail_parent", "id_rab_detail", "uraian", $this->data['rowsrab'], null, $i, 0, "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");

			if(!$this->data['row']['id_rab_detail'] && $id)
				$this->data['row']['id_rab_detail'] = $this->conn->GetList("select id_rab_detail as key, id_rab_detail as val from niaga_rab where id_niaga_penawaran = ".$this->conn->escape($id));


			$rows = $this->conn->GetArray("select a.*, nvl(vol,1)*nvl(harga_satuan,0) as nilai from rab_jasa_material a where id_rab = ".$this->conn->escape($this->data['id_rab']));

			$this->data['jasa_materialarr'] = array();
			foreach($rows as $r){
				$this->data['jasa_materialarr'][$r['id_pos_anggaran']][$r['jasa_material']][$r['kode_biaya']][] = $r;
			}
		}
	}

	function GenerateTree(&$row, $colparent, $colid, $collabel, &$return=array(), $valparent=null, &$i=0, $level=0, $spacea = "&nbsp;➥&nbsp;", $max_level=100){

		$level++;
		foreach ($row as $key => $value) {
			# code...
			if(trim($value[$colparent])==trim($valparent)){
			
				$space = '';
				/*for($k=1; $k<$level; $k++){
					$space .= $spacea;
				}*/

				$value[$collabel] = $space.$value[$collabel];
				$value['level'] = $level;

				if($value['sumber_nilai']==1)
					$value[$collabel] = "<b>".$value[$collabel]."</b>";


				if($level<=$max_level){
					$return[$i]=$value;
				}

				$i++;

				$temp = $row;
				unset($temp[$key]);

				$this->GenerateTree($temp, $colparent, $colid, $collabel, $return, $value[$colid], $i, $level,$spacea, $max_level);

				$row = $temp;
			}
		}

		if($row && $level==1)
			$return = array_merge($return, $row);
	}

	protected function _afterDelete($id){
		return $this->_afterInsert($id);
	}

	protected function _afterUpdate($id){
		return $this->_afterInsert($id);
	}

	protected function _afterInsert($id){
		$ret = true;

		if($ret)
			$ret = $this->_delsertJabatanProyek($id);

		if($ret)
			$ret = $this->_delsertSumberPegawai($id);

		if($ret)
			$ret = $this->_delsertRab($id);

		return $ret;
	}

	private function _delsertJabatanProyek($id_niaga_penawaran = null){
		$ret = $this->conn->Execute("delete from niaga_jabatan_proyek where id_niaga_penawaran = ".$this->conn->escape($id_niaga_penawaran));

		if(is_array($this->post['id_jabatan_proyek']) && count($this->post['id_jabatan_proyek'])){
			foreach($this->post['id_jabatan_proyek'] as $k=>$v){
				if(!$ret)
					break;

				$record = array();
				$record['id_niaga_penawaran'] = $id_niaga_penawaran;
				$record['id_jabatan_proyek'] = $k;

				$ret = $this->conn->goInsert("niaga_jabatan_proyek", $record);
			}
		}
		return $ret;
	}

	private function _delsertSumberPegawai($id_niaga_penawaran = null){
		$ret = $this->conn->Execute("delete from niaga_sumber_pegawai where id_niaga_penawaran = ".$this->conn->escape($id_niaga_penawaran));

		if(is_array($this->post['id_sumber_pegawai']) && count($this->post['id_sumber_pegawai'])){
			foreach($this->post['id_sumber_pegawai'] as $k=>$v){
				if(!$ret)
					break;

				$record = array();
				$record['id_niaga_penawaran'] = $id_niaga_penawaran;
				$record['id_sumber_pegawai'] = $k;

				$ret = $this->conn->goInsert("niaga_sumber_pegawai", $record);
			}
		}
		return $ret;
	}

	private function _delsertRab($id_niaga_penawaran = null){
		$ret = $this->conn->Execute("delete from niaga_rab where id_niaga_penawaran = ".$this->conn->escape($id_niaga_penawaran));

		if(!is_array($this->post['id_rab_detail']) && $this->post['id_rab_detail'])
			$this->post['id_rab_detail'] = array($this->post['id_rab_detail']=>$this->post['id_rab_detail']);

		if($this->post['id_rab_detail']){
			foreach($this->post['id_rab_detail'] as $k=>$v){
				if(!$ret)
					break;

				$record = array();
				$record['id_niaga_penawaran'] = $id_niaga_penawaran;
				$record['id_rab_detail'] = $k;

				if($this->post['sumber_nilai']==3)
					$record['is_nilai'] = 1;

				if($this->post['sumber_satuan']==4)
					$record['is_satuan'] = 1;

				$ret = $this->conn->goInsert("niaga_rab", $record);
			}
		}
		return $ret;
	}
}