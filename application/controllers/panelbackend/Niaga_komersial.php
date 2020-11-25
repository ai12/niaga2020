<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Niaga_komersial extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/niaga_komersiallist";
		$this->viewdetail = "panelbackend/niaga_komersialdetail";
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

		$this->load->model("Niaga_komersialModel","model");
		$this->load->model("RabModel","rabrab");		
		$this->load->model("Proyek_pekerjaanModel","rabpekerjaan");
		$this->load->model("ProyekModel","proyek");

		$this->data['sumbersatuanarr'] = array('1'=>'Manual','4'=>'RAB','2'=>'Mandays','3'=>'Unit Day');
		$this->data['sumbernilaiarr'] = array('4'=>'Manual', '1'=>'Hitung di sub','2'=>'SPPD','3'=>'RAB','5'=>'Kompensasi Manpower');
		$this->data['jenismandaysarr'] = array(''=>'','1'=>'Max','2'=>'Total');

		$this->load->model("Mt_sumber_pegawaiModel","mtsumberpegawai");
		$this->data['mtsumberpegawaiarr'] = $this->mtsumberpegawai->GetCombo();
		unset($this->data['mtsumberpegawaiarr']['']);

		$this->load->model("Mt_jabatan_proyekModel","mtjabatanproyek");
		$this->data['jabatanarr'] = $this->mtjabatanproyek->GetCombo();
		unset($this->data['jabatanarr']['']);

		$this->load->model("Mt_jenis_ttpModel","mtjenisttp");
		$this->data['ttparr'] = $this->mtjenisttp->GetCombo();

		$this->load->model("Mt_wilayah_proyekModel","mtwilayah");
		$this->data['wilayaharr'] = $this->mtwilayah->GetCombo();

		$this->load->model("Mt_zona_sppdModel","mtzonasppd");
		$this->data['zonaarr'] = $this->mtzonasppd->GetCombo();

		$this->load->model("Mt_harga_sppdModel","mthargappd");
		$this->data['hargaarr'] = $this->mthargappd->GetCombo();
		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			''
		);
	}
	public function Index($id_rab=0, $page=0){
		$this->_beforeDetail($id_rab);

		if($this->post['act']=='save_proyek'){
			$record = array();
			$record['id_wilayah_proyek'] = $this->post['id_wilayah_proyek'];
			$record['id_zona_sppd'] = $this->post['id_zona_sppd'];
			$record['id_jenis_ttp'] = $this->post['id_jenis_ttp'];
			$this->conn->goUpdate("rab_proyek",$record, "id_proyek = ".$this->conn->escape($this->data['id_proyek']));

			if($record['id_zona_sppd']<>$this->data['rowheader']['id_zona_sppd']){
				$rows = $this->conn->GetArray("select id_niaga_komersial, id_harga_sppd from niaga_komersial where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek)." and sumber_nilai = '2'");
				foreach($rows as $r){
					$record = array();
					$record['nilai_satuan'] = $this->conn->GetOne("select nilai_komersial from mt_harga_sppd_detail where id_zona_sppd = ".$this->conn->escape($this->post['id_zona_sppd'])." and id_harga_sppd = ".$this->conn->escape($r['id_harga_sppd']));
					$this->conn->goUpdate("niaga_komersial", $record, "id_niaga_komersial = ".$this->conn->escape($r['id_niaga_komersial']));
				}
			}

			redirect(current_url());
		}

		$this->generate_komersial();
		$this->niaga_komersial();
		$this->hpp();

		$this->View($this->viewlist);
	}

	private function generate_komersial(){
		$cek = $this->conn->GetOne("select id_niaga_komersial from niaga_komersial where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek));

		if(!$cek){
			$id_niaga_proyek_max = $this->conn->GetOne("select max(id_niaga_proyek) from niaga_biaya_produksi where id_niaga_proyek<>".$this->conn->escape($this->id_niaga_proyek));

			$rows = $this->conn->GetArray("select * from niaga_komersial where id_niaga_proyek = ".$this->conn->escape($id_niaga_proyek_max)." order by id_niaga_komersial");

			$idarr = array();
			$idparentarr = array();
			$idrarr = array();
			foreach($rows as $r){
				$id_old = $r['id_niaga_komersial'];
				$id_parent_old = $r['id_niaga_komersial_parent'];
				unset($r['id_niaga_komersial']);
				unset($r['id_niaga_komersial_parent']);
				$r['id_niaga_proyek'] = $this->id_niaga_proyek;
				$this->conn->goInsert("niaga_komersial", $r);

				$id_niaga_komersial = $this->conn->GetOne("select max(id_niaga_komersial) from niaga_komersial where id_niaga_proyek = ".$this->conn->escape($r['id_niaga_proyek']));

				$idarr[$id_old] = $id_niaga_komersial;
				$idrarr[$id_old] = $r;

				if($id_parent_old)
					$idparentarr[$id_parent_old][] = $id_old;
			}

			foreach($idparentarr as $id_niaga_komersial_parent=>$rs){
				$id_niaga_komersial_parent = $idarr[$id_niaga_komersial_parent];
				foreach($rs as $id_niaga_komersial){
					$id_niaga_komersial = $idarr[$id_niaga_komersial];
					$this->conn->goUpdate("niaga_komersial",array("id_niaga_komersial_parent"=>$id_niaga_komersial_parent),"id_niaga_komersial = ".$this->conn->escape($id_niaga_komersial));
				}
			}

			$rows = $this->conn->GetArray("select c.kode_biaya, c.jasa_material, c.id_pos_anggaran, c.uraian, c.sumber_nilai, c.sumber_satuan, a.*
				from niaga_rab a 
				join rab_detail c on a.id_rab_detail = c.id_rab_detail 
				where exists (select 1 from niaga_komersial b where a.id_niaga_komersial = b.id_niaga_komersial and b.id_niaga_proyek = ".$this->conn->escape($id_niaga_proyek_max).")");

			foreach($rows as $r){
				$r['id_rab_detail'] = $this->conn->GetOne("select id_rab_detail 
					from rab_detail
					where ".$this->conn->createwhere(
						array(
							'kode_biaya'=>$r['kode_biaya'],
							'jasa_material'=>$r['jasa_material'],
							'id_pos_anggaran'=>$r['id_pos_anggaran'],
							'sumber_nilai'=>$r['sumber_nilai'],
							'sumber_satuan'=>$r['sumber_satuan'],
						)
					)
				);

				if(!$r['id_rab_detail'])
					continue;

				$r['id_niaga_komersial'] = $idarr[$r['id_niaga_komersial']];
				$this->conn->goInsert("niaga_rab",$r);
			}

			#sumber pegawai
			$rows = $this->conn->GetArray("select * from niaga_sumber_pegawai a where exists (select 1 from niaga_komersial b where a.id_niaga_komersial = b.id_niaga_komersial and b.id_niaga_proyek = ".$this->conn->escape($id_niaga_proyek_max).")");

			foreach($rows as $r){
				$r['id_niaga_komersial'] = $idarr[$r['id_niaga_komersial']];
				$this->conn->goInsert("niaga_sumber_pegawai",$r);
			}

			#jabatan proyek
			$rows = $this->conn->GetArray("select * from niaga_jabatan_proyek a where exists (select 1 from niaga_komersial b where a.id_niaga_komersial = b.id_niaga_komersial and b.id_niaga_proyek = ".$this->conn->escape($id_niaga_proyek_max).")");

			foreach($rows as $r){
				$r['id_niaga_komersial'] = $idarr[$r['id_niaga_komersial']];

				$this->conn->goInsert("niaga_jabatan_proyek",$r);
			}

			$this->_hitungMdKomersialParent();
		}
	}

	private function hpp(){
		$id_niaga_proyek_max = $this->conn->GetOne("select max(id_niaga_proyek) from niaga_biaya_produksi where id_niaga_proyek<>".$this->conn->escape($this->id_niaga_proyek));
		
		$id_niaga_komersial_kompensasi = $this->data['id_niaga_komersial_kompensasi'];
		#biaya produksi
		$rows = $this->conn->GetArray("select * from niaga_biaya_produksi where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek));

		$this->data['biayaproduksi'] = array();
		foreach($rows as $r){
			if($r['sumber_nilai']==2){
				$this->data['biayaproduksi'][$r['id_niaga_komersial']] = $r;
				if(!$this->data['id_niaga_biaya_produksi_parent'])
					$this->data['id_niaga_biaya_produksi_parent'] = $r['id_niaga_biaya_produksi_parent'];
			}

			if(!$this->data['id_niaga_biaya_produksi_parent'] && $r['uraian']=='RAB KOMERSIAL')
				$this->data['id_niaga_biaya_produksi_parent'] = $r['id_niaga_biaya_produksi'];

			if(!$r['id_niaga_biaya_produksi_parent'])
				$this->data['header'][$r['uraian']] = $r;
		}

		if(!$this->data['header']['RAB KOMERSIAL']){
			$record = array();
			$record['uraian'] = 'RAB KOMERSIAL';
			$record['sumber_nilai'] = 1;
			$record['id_niaga_proyek'] = $this->data['id_niaga_proyek'];
			$this->conn->goInsert("niaga_biaya_produksi",$record);
			$this->data['id_niaga_biaya_produksi_parent'] = $this->conn->GetOne("select max(id_niaga_biaya_produksi) from niaga_biaya_produksi where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek)." and sumber_nilai = 1");
			
			$record = array();
			$record['uraian'] = 'Biaya kontigensi';
			$record['sumber_nilai'] = 4;
			$record['nilai'] = 0.005;
			$record['id_niaga_biaya_produksi_parent'] = $this->data['id_niaga_biaya_produksi_parent'];
			$record['id_niaga_proyek'] = $this->data['id_niaga_proyek'];
			$this->conn->goInsert("niaga_biaya_produksi",$record);
		}

		if(!$this->data['header']['SALARY PERSONIL PJBS']){
			$record = array();
			$record['uraian'] = 'SALARY PERSONIL PJBS';
			$record['sumber_nilai'] = 3;
			$record['id_niaga_komersial'] = $id_niaga_komersial_kompensasi;
			$record['id_niaga_proyek'] = $this->data['id_niaga_proyek'];
			$this->conn->goInsert("niaga_biaya_produksi",$record);
		}

		if(!$this->data['header']['OTHER COST']){
			$record = array();
			$record['uraian'] = 'OTHER COST';
			$record['sumber_nilai'] = 1;
			$record['id_niaga_proyek'] = $this->data['id_niaga_proyek'];
			$this->conn->goInsert("niaga_biaya_produksi",$record);
			
			$rows = $this->conn->GetArray("select * from niaga_biaya_produksi where id_niaga_proyek = ".$this->conn->escape($id_niaga_proyek_max));

			$header = array();
			$child = array();
			foreach($rows as $r){
				if(!$r['id_niaga_biaya_produksi_parent'])
					$header[$r['uraian']] = $r;
				else
					$child[$r['id_niaga_biaya_produksi_parent']][] = $r;
			}

			$record = $header['OTHER COST'];
			if($record)
				$this->insertProduksiOther($child, array($record), null);
		}

		$cek = $this->conn->GetOne("select 1 from niaga_analisa where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek));

		if(!$cek){
			$rows = $this->conn->GetArray("select * from niaga_analisa where id_niaga_proyek = ".$this->conn->escape($id_niaga_proyek_max));

			foreach($rows as $record){
				$id_analisa_old = $record['id_analisa'];
				unset($record['id_analisa']);
				$record['id_niaga_proyek'] = $this->id_niaga_proyek;
				$this->conn->goInsert("niaga_analisa", $record);

				$id_analisa = $this->conn->GetOne("select max(id_analisa) from niaga_analisa where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek));

				$rows = $this->conn->GetArray("select * from niaga_beban_usaha where id_analisa = ".$this->conn->escape($id_analisa_old));
				foreach($rows as $record){
					unset($record['id_beban_usaha']);
					$record['id_niaga_proyek'] = $this->id_niaga_proyek;
					$record['id_analisa'] = $id_analisa;
					$this->conn->goInsert("niaga_beban_usaha", $record);
				}
			}
		}
	}

	private function insertProduksiOther($arr, $rows, $id_niaga_biaya_produksi_parent){
		foreach($rows as $record){
			$record['id_niaga_biaya_produksi_parent'] = $id_niaga_biaya_produksi_parent;
			$record['id_niaga_proyek'] = $this->data['id_niaga_proyek'];
			$id_niaga_biaya_produksi_parent_old1 = $record['id_niaga_biaya_produksi'];
			unset($record['id_niaga_biaya_produksi']);
			$this->conn->goInsert("niaga_biaya_produksi",$record);

			$id_niaga_biaya_produksi_parent1 = $this->conn->GetOne("select max(id_niaga_biaya_produksi) from niaga_biaya_produksi where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek)." and sumber_nilai = ".$this->conn->escape($record['sumber_nilai']));

			if($arr[$id_niaga_biaya_produksi_parent_old1]){
				$this->insertProduksiOther($arr, $arr[$id_niaga_biaya_produksi_parent_old1], $id_niaga_biaya_produksi_parent1);
			}
		}
	}

	public function Add($id_rab=0, $id_niaga_komersial_parent=null){
		$this->Edit($id_rab, 0, $id_niaga_komersial_parent);
	}


	public function Edit($id_rab=0,$id=null, $id_niaga_komersial_parent=null){

		if($this->post['act']=='reset'){
			redirect(current_url());
		}

		$this->_beforeDetail($id_rab,$id);

		$this->data['idpk'] = $id;

		$this->data['row'] = $this->model->GetByPk($id);
		if($id_niaga_komersial_parent)
			$this->data['row']['id_niaga_komersial_parent'] = $id_niaga_komersial_parent;

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
			$record['id_niaga_komersial_parent'] = $id_niaga_komersial_parent;

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

	protected function _beforeDelete($id){
		$ret =  $this->conn->Execute("delete from niaga_biaya_produksi where id_niaga_komersial = ".$this->conn->escape($id));

		if($ret)
			$ret = $this->conn->Execute("delete from niaga_rab where id_niaga_komersial = ".$this->conn->escape($id));

		if($ret)
			$ret = $this->conn->Execute("delete from niaga_jabatan_proyek where id_niaga_komersial = ".$this->conn->escape($id));

		if($ret)
			$ret = $this->conn->Execute("delete from niaga_sumber_pegawai where id_niaga_komersial = ".$this->conn->escape($id));
		
		return $ret;
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
		if(!$this->data['rowheader3']){
			$rec = array("id_rab"=>$id_rab);
			$this->_setLogRecord($rec);
			$this->conn->goInsert("niaga_proyek", $rec);
			$this->data['rowheader3'] = $this->conn->GetRow("select * from niaga_proyek where id_rab = ".$this->conn->escape($id_rab));

			$rows = $this->conn->GetArray("select b.* from rab_manpower a join rab_mandays b on a.id_manpower = b.id_manpower where a.id_rab = ".$this->conn->escape($id_rab));
			foreach($rows as $r){
				$this->conn->goInsert("niaga_mandays_komersial", $r);
			}
		}
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
				'name'=>'id_niaga_komersial_parent', 
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
			'is_add_ppn'=>(int)$this->post['is_add_ppn'],
			'id_harga_sppd'=>$this->post['id_harga_sppd'],
			'pembagi'=>($this->post['pembagi']),
			'pembulatan'=>($this->post['pembulatan']),
		);

		if($return['sumber_satuan']=='1'){
			$return['vol'] = $this->post['vol'];
			$return['satuan'] = $this->post['satuan'];
		}elseif($return['sumber_satuan']=='2'){
			$return['vol'] = $this->_hitungMdKomersial($return);
			$return['satuan'] = 'MD';
			if($return['jenis_mandays']==1){
				$return['day'] = $this->post['day'];
				$return['satuan'] = $this->post['satuan'];
			}

		}elseif($return['sumber_satuan']=='3'){
			$return['vol'] = $this->_hitungMdKomersial($return);
			$return['satuan'] = 'Unit Day';
		}elseif($this->post['act']=='save' && $return['sumber_nilai']=='1'){
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
				$return['vol'] = $this->conn->GetOne("select sum(vol) from rab_detail where id_rab_detail in (".implode(", ",$this->conn->escape_string(array_keys($this->data['row']['id_rab_detail']))).") and id_rab = ".$this->conn->escape($this->data['id_rab']));
		}elseif($return['sumber_satuan']<>'4' and $return['sumber_nilai']=='3'){

			if($this->post['id_rab_detail']){
				if(!is_array($this->post['id_rab_detail']))
					$this->data['row']['id_rab_detail'] = array($this->post['id_rab_detail']=>$this->post['id_rab_detail']);
				else
					$this->data['row']['id_rab_detail'] = $this->post['id_rab_detail'];
			}

			if($this->data['row']['id_rab_detail'])
				$return['nilai_satuan'] = $this->conn->GetOne("select nilai_satuan from rab_detail where id_rab_detail = ".$this->conn->escape(key($this->data['row']['id_rab_detail']." and id_rab = ".$this->conn->escape($this->data['id_rab']))));

		}

		if($return['sumber_nilai']=='2'){
			$return['nilai_satuan'] = $this->conn->GetOne("select nilai_komersial from mt_harga_sppd_detail where id_zona_sppd = ".$this->conn->escape($this->data['rowheader']['id_zona_sppd'])." and id_harga_sppd = ".$this->conn->escape($return['id_harga_sppd']));
		}

		return $return;
	}

	protected function Rules(){
		return array(
			"id_niaga_komersial_parent"=>array(
				'field'=>'id_niaga_komersial_parent', 
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

		if($this->data['row']['id_niaga_komersial_parent'])
			$this->data['row']['uraian_parent'] = $this->conn->GetOne("select uraian from niaga_komersial where id_niaga_komersial = ".$this->conn->escape($this->data['row']['id_niaga_komersial_parent']));
		
		if($this->data['row']['sumber_satuan']==2 or $this->data['row']['sumber_satuan']==3 or $this->data['row']['sumber_nilai']==5){
			if($this->data['row']['sumber_nilai']<>5){
				if($this->post['act']!='set_value' && empty($this->post['id_jabatan_proyek'])){
					$this->data['row']['id_jabatan_proyek'] = $this->conn->GetList("select id_jabatan_proyek as key, id_jabatan_proyek as val 
						from niaga_jabatan_proyek 
						where id_niaga_komersial = ".$this->conn->escape($id));
				}
			}

			if($this->post['act']!='set_value' && empty($this->post['id_sumber_pegawai'])){
				$this->data['row']['id_sumber_pegawai'] = $this->conn->GetList("select id_sumber_pegawai as key, id_sumber_pegawai as val 
					from niaga_sumber_pegawai 
					where id_niaga_komersial = ".$this->conn->escape($id));
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
				$this->data['row']['id_rab_detail'] = $this->conn->GetList("select id_rab_detail as key, id_rab_detail as val from niaga_rab where id_niaga_komersial = ".$this->conn->escape($id));


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

	private function _delsertJabatanProyek($id_niaga_komersial = null){
		$ret = $this->conn->Execute("delete from niaga_jabatan_proyek where id_niaga_komersial = ".$this->conn->escape($id_niaga_komersial));

		if(is_array($this->post['id_jabatan_proyek']) && count($this->post['id_jabatan_proyek'])){
			foreach($this->post['id_jabatan_proyek'] as $k=>$v){
				if(!$ret)
					break;

				$record = array();
				$record['id_niaga_komersial'] = $id_niaga_komersial;
				$record['id_jabatan_proyek'] = $k;

				$ret = $this->conn->goInsert("niaga_jabatan_proyek", $record);
			}
		}
		return $ret;
	}

	private function _delsertSumberPegawai($id_niaga_komersial = null){
		$ret = $this->conn->Execute("delete from niaga_sumber_pegawai where id_niaga_komersial = ".$this->conn->escape($id_niaga_komersial));

		if(is_array($this->post['id_sumber_pegawai']) && count($this->post['id_sumber_pegawai'])){
			foreach($this->post['id_sumber_pegawai'] as $k=>$v){
				if(!$ret)
					break;

				$record = array();
				$record['id_niaga_komersial'] = $id_niaga_komersial;
				$record['id_sumber_pegawai'] = $k;

				$ret = $this->conn->goInsert("niaga_sumber_pegawai", $record);
			}
		}
		return $ret;
	}

	private function _delsertRab($id_niaga_komersial = null){
		$ret = $this->conn->Execute("delete from niaga_rab where id_niaga_komersial = ".$this->conn->escape($id_niaga_komersial));

		if(!is_array($this->post['id_rab_detail']) && $this->post['id_rab_detail'])
			$this->post['id_rab_detail'] = array($this->post['id_rab_detail']=>$this->post['id_rab_detail']);

		if($this->post['id_rab_detail']){
			foreach($this->post['id_rab_detail'] as $k=>$v){
				if(!$ret)
					break;

				$record = array();
				$record['id_niaga_komersial'] = $id_niaga_komersial;
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

	protected function niaga_komersial(){
		$this->data['rows'] = array();

		#niaga komersial
		$rows = $this->conn->GetArray("select * from niaga_komersial where id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek)." order by id_niaga_komersial");

		foreach($rows as $r){
			$this->data['rows'][(int)$r['id_niaga_komersial_parent']][$r['id_niaga_komersial']] = $r;
		}

		#kompensasi manpower
		$rows = $this->conn->GetArray("
		select a.*, b.nama, d.nilai from(
			select a.id_niaga_komersial, c.id_jabatan_proyek, sum(d.jumlah) as mandays
			from niaga_komersial a
			join niaga_sumber_pegawai b on a.id_niaga_komersial = b.id_niaga_komersial
			join rab_manpower c on b.id_sumber_pegawai = c.id_sumber_pegawai and c.id_rab = ".$this->conn->escape($this->data['id_rab'])."
			join niaga_mandays_komersial d on c.id_manpower = d.id_manpower
			where a.sumber_nilai = 5
			and a.id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek)."
			group by a.id_niaga_komersial, c.id_jabatan_proyek
		) a
		join mt_jabatan_proyek b on a.id_jabatan_proyek = b.id_jabatan_proyek
		join mt_kompensasi_manpower c on a.id_jabatan_proyek = c.id_jabatan_proyek
		join mt_kompensasi_manpower_detail d on c.id_kompensasi_manpower = d.id_kompensasi_manpower and d.id_jenis_ttp = ".$this->conn->escape($this->data['rowheader']['id_jenis_ttp'])."
		order by c.id_level_jabatan, b.id_jabatan_proyek");

		$this->data['id_niaga_komersial_kompensasi'] = null;
		foreach($rows as $r){
			$this->data['rowskompensasi'][(int)$r['id_niaga_komersial']][$r['id_jabatan_proyek']] = $r;

			if(!$this->data['id_niaga_komersial_kompensasi'])
				$this->data['id_niaga_komersial_kompensasi'] = $r['id_niaga_komersial'];
		}	

		#rab
		$rows = $this->conn->GetArray("select a.*, b.id_niaga_komersial
			from rab_detail a
			join niaga_rab b on a.id_rab_detail = b.id_rab_detail
			join niaga_komersial c on b.id_niaga_komersial = c.id_niaga_komersial
			where c.sumber_nilai = 3 and c.sumber_satuan = 4 
			and c.id_niaga_proyek = ".$this->conn->escape($this->id_niaga_proyek)." and id_rab = ".$this->conn->escape($this->data['id_rab'])."
			order by a.kode_biaya, a.id_rab_detail");

		$this->data['rowsrab'] = array();
		$rowsgroup = array();
		foreach($rows as $k=>$r){
			if($r['id_rab_detail_parent'] && $r['sumber_nilai']<>3){
				$rowsgroup[$r['id_niaga_komersial']][$r['id_rab_detail_parent']][] = $r;
			}else{
				$this->data['rowsrab'][$r['id_niaga_komersial']][$r['id_rab_detail']] = $r;
			}
			unset($rows[$k]);
		}

		foreach($rowsgroup as $id_niaga_komersial=>$rs1){
			foreach($rs1 as $id_rab_detail_parent=>$rs){
				if(count($rs)>1){
					$r = $this->conn->GetRow("select * from rab_detail where id_rab_detail = ".$this->conn->escape($id_rab_detail_parent)." and id_rab = ".$this->conn->escape($this->data['id_rab']));
					$r['sub'] = $rs;
					$this->data['rowsrab'][(int)$id_niaga_komersial][$rs['id_rab_detail']] = $r;
				}else{
					$this->data['rowsrab'][(int)$id_niaga_komersial][$rs['id_rab_detail']] = $rs[0];
				}
			}
		}
/*
		foreach($rows as $r){
			$this->data['rowsrab'][(int)$r['id_niaga_komersial']][$r['id_rab_detail']] = $r;
		}	*/	
			
		#jasa & material
		$rows = $this->conn->GetArray("select a.*, nvl(vol,1)*nvl(harga_satuan,0) as nilai from rab_jasa_material a where id_rab = ".$this->conn->escape($this->data['id_rab']));

		$this->data['jasa_materialarr'] = array();
		foreach($rows as $r){
			$this->data['jasa_materialarr'][$r['id_pos_anggaran']][$r['jasa_material']][$r['kode_biaya']][] = $r;
		}
	}
}