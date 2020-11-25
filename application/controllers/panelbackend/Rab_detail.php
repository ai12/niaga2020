<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Rab_detail extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/rab_detaillist";
		$this->viewdetail = "panelbackend/rab_detaildetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout_rab";
		// $this->data['width'] = "1200px";

		if ($this->mode == 'add') {
			$this->viewdetail = "panelbackend/rab_detailedit";
			$this->data['page_title'] = 'Tambah RAB RAB Detail';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->viewdetail = "panelbackend/rab_detailedit";
			$this->data['page_title'] = 'Edit RAB RAB Detail';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->viewdetail = "panelbackend/rab_detaildetail";
			$this->data['page_title'] = 'Detail RAB RAB Detail';
			$this->data['edited'] = false;	
		}else{

			$this->data['no_menu'] = true;
			$this->data['page_title'] = 'Daftar RAB RAB Detail';
		}

		$this->load->model("Rab_detailModel","model");
		$this->load->model("proyek_pekerjaanModel","rabpekerjaan");
		$this->load->model("RabModel","rabrab");
		$this->load->model("proyekModel","proyek");
		$this->load->model("Mt_uomModel","mtuom");
		$this->data['mtuomarr'] = $this->mtuom->GetCombo();

		$this->load->model("Mt_jabatan_proyekModel","mtjabatanproyek");
		$this->data['jabatanarr'] = $this->mtjabatanproyek->GetCombo();
		unset($this->data['jabatanarr']['']);

		$this->data['jasamaterialarr'] = array('1'=>'Jasa','2'=>'Material');
		$this->data['sumbersatuanarr'] = array('0'=>'Tanpa Satuan','1'=>'Manual','2'=>'Mandays','3'=>'Unit Day');
		$this->data['sumbernilaiarr'] = array('1'=>'Hitung di sub','2'=>'Master Harga','3'=>'Jasa/Material','5'=>'Kontigensi','6'=>'JKK','7'=>'JKM','8'=>'Asuransi Konstruksi','4'=>'Manual');
		$this->data['jenismandaysarr'] = array(''=>'','1'=>'Max','2'=>'Total');

		$this->load->model("Mt_sumber_pegawaiModel","mtsumberpegawai");
		$this->data['mtsumberpegawaiarr'] = $this->mtsumberpegawai->GetCombo();
		unset($this->data['mtsumberpegawaiarr']['']);
		$this->load->model("Mt_pos_anggaranModel","mtposanggaran");
		$this->data['mtposanggaranarr'] = $this->mtposanggaran->GetCombo();

		$this->data['configfile'] = $this->config->item('file_upload_config');
		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'upload','select2'
		);
	}

	private function setAjukan($id_rab=null){
		$this->rabrab->Update(array('status'=>1,'ket_rendal'=>$this->post['keterangan']),"id_rab = ".$this->conn->escape($id_rab));

		redirect(current_url());
	}

	private function setAjukanManager($id_rab=null){
		$this->rabrab->Update(array('status'=>1,'asman_ok'=>1,'ket_asman'=>$this->post['keterangan']),"id_rab = ".$this->conn->escape($id_rab));

		redirect(current_url());
	}

	private function setSetujui($id_rab=null){
		$this->conn->StartTrans();

		$ret = $this->rabrab->Update(array('status'=>2,'manager_ok'=>1,'is_final'=>1,'ket_manager'=>$this->post['keterangan']),"id_rab = ".$this->conn->escape($id_rab));


		/*if($ret['success']){
			$id_rab_parent = $id_rab;

			$record = array(
				'id_proyek_pekerjaan'=>$this->data['id_proyek_pekerjaan'],
				'versi'=>1,
				'jenis'=>2,
				'id_rab_parent'=>$id_rab_parent,
				'is_final'=>0,
			);
			$ret = $this->rabrab->Insert($record);
			$r = $id_rab = $id = $ret['data']["id_rab"];

			if($id_rab){
				$rows = $this->conn->GetArray("select *
				from rab_detail where id_rab = ".$this->conn->escape($id_rab_parent));

				foreach($rows as $rc){
					$rc['id_rab'] = $id_rab;
					$rc['id_rab_detail_old'] = $rc['id_rab_detail'];
					unset($rc['id_rab_detail']);
					if(!$r)
						break;

					$r = $this->conn->goInsert("rab_detail",$rc);
				}
			}

			if($id_rab && $r){
				$r = $this->conn->execute("update rab_detail a 
				set id_rab_detail_parent = (select id_rab_detail from rab_detail b 
				where b.id_rab = ".$this->conn->escape($id_rab)." and a.id_rab_detail_parent = b.id_rab_detail_old) 
				where id_rab = ".$this->conn->escape($id_rab));
			}

			if($r){
				$rows = $this->conn->GetArray("select b.id_rab_detail, a.id_jabatan_proyek 
				from rab_detail_jabatan_proyek a
				join rab_detail b on a.id_rab_detail = b.id_rab_detail_old 
				where b.id_rab = ".$this->conn->escape($id_rab));

				foreach($rows as $rc){
					if(!$r)
						break;

					$r = $this->conn->goInsert("rab_detail_jabatan_proyek",$rc);
				}
			}

			if($r){
				$rows = $this->conn->GetArray("select b.id_rab_detail, a.id_sumber_pegawai 
				from rab_detail_sumber_pegawai a
				join rab_detail b on a.id_rab_detail = b.id_rab_detail_old 
				where b.id_rab = ".$this->conn->escape($id_rab));

				foreach($rows as $rc){
					if(!$r)
						break;

					$r = $this->conn->goInsert("rab_detail_sumber_pegawai",$rc);
				}
			}

			if($r){
				$ret['success'] = true;
			}else{
				$ret['success'] = false;
			}
		}*/

		if($ret['success']){
			SetFlash("suc_msg","Berhasil");
			$this->conn->trans_commit();
		}
		else{
			SetFlash("err_msg","Gagal");
			$this->conn->trans_rollback();
		}

		redirect(current_url());
	}

	private function setKembalikan($id_rab=null){
		$this->rabrab->Update(array('status'=>3,'manager_ok'=>0,'asman_ok'=>0,'ket_asman'=>$this->post['keterangan']),"id_rab = ".$this->conn->escape($id_rab));

		redirect(current_url());
	}

	private function setRevisi($id_rab=null){
		$this->_revisi($id_rab, null, $this->post['keterangan']);

		redirect(current_url());
	}

	public function Index($id_rab=0, $id_rab_detail=null){

		if($this->post['act']=='set_recal' && $this->access_role['edit']){
			$this->_reCalculation($id_rab);
			redirect(current_url());
		}

		if($this->post['act']=='set_ajukan' && $this->access_role['ajukan'])
			$this->setAjukan($id_rab);

		if($this->post['act']=='set_kembalikan' && ($this->access_role['ajukan_manager'] or $this->access_role['setujui']))
			$this->setKembalikan($id_rab);

		if($this->post['act']=='set_ajukan_manager' && $this->access_role['ajukan_manager'])
			$this->setAjukanManager($id_rab);

		if($this->post['act']=='set_revisi' && $this->access_role['add'])
			$this->setRevisi($id_rab);

		if($this->post['act']=='set_pekerjaan_baru' && $this->access_role['add'])
			$this->jadikanRAB($id_rab);

		if($this->post['act']=='set_salin_proyek' && $this->access_role['add'])
			$this->jadikanProyek($id_rab);

		$this->_beforeDetail($id_rab);

		if($this->post['act']=='set_setujui' && $this->access_role['setujui'])
			$this->setSetujui($id_rab);

		$this->data['row']['id_rab_detail'] = $id_rab_detail;
		$this->_afterDetail($id_rab_detail);

		$this->View($this->viewlist);
	}

	public function Add($id_rab=0, $id_rab_detail_parent=null){
		$this->data['id_rab_detail_parent'] = $id_rab_detail_parent;
		$this->Edit($id_rab);
	}

	public function Edit($id_rab=0,$id=null,$id_rab_detail_parent=null){

		if($id_rab_detail_parent)
			$this->data['id_rab_detail_parent'] = $id_rab_detail_parent;

		if($this->post['act']=='reset'){
			redirect(current_url());
		}

		$this->_beforeDetail($id_rab,$id);

		$this->data['idpk'] = $id;

		$this->data['row'] = $this->model->GetByPk($id);

		if($this->data['row']['id_rab_detail_parent'])
			$this->data['id_rab_detail_parent'] = $this->data['row']['id_rab_detail_parent'];

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

			$record['id_rab'] = $id_rab;
			if($this->data['id_rab_detail_parent'])
				$record['id_rab_detail_parent'] = $this->data['id_rab_detail_parent'];

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
					
					$this->log("mengubah ".json_encode($record));

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

					$this->data['row'] = $return;

					$this->log("menambah ".json_encode($record));

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
				if($this->data['id_rab_detail_parent']){
					redirect("$this->page_ctrl/detail/$id_rab/".$this->data['id_rab_detail_parent']);
				}else{
					redirect("$this->page_ctrl/detail/$id_rab/".$id);
				}

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

	public function Delete($id_rab=null, $id=null, $id_rab_detail_parent=null){

        $this->model->conn->StartTrans();

		$this->_beforeDetail($id_rab, $id);

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

			$this->log("menghapus ".json_encode($this->data['row']));

			SetFlash('suc_msg', $return['success']);

			if($id_rab_detail_parent)
				redirect("$this->page_ctrl/detail/$id_rab/$id_rab_detail_parent");
			else
				redirect("$this->page_ctrl/index/$id_rab");
		}
		else {
			SetFlash('err_msg',"Data gagal didelete");
			redirect("$this->page_ctrl/detail/$id_rab/$id");
		}

	}

	public function go_print_detail($id_rab=null, $id_rab_detail=null){
		$this->template = "panelbackend/main3";
		$this->layout = "panelbackend/layout3";
		$this->data['width'] = "900px";
		$this->data['no_header'] =true;

		$this->_beforeDetail($id_rab);
		$this->data['row'] = $this->model->GetByPk($id_rab_detail);
		$this->_afterDetail($id_rab_detail);
		$this->View("panelbackend/rab_detaildetailprint");
	}

	public function Detail($id_rab=null, $id=null){

		$this->_beforeDetail($id_rab, $id);

		$this->data['row'] = $this->model->GetByPk($id);

		$this->_onDetail($id);

		if (!$this->data['row'] && !$this->data['rowheader1'])
			$this->NoData();

		$this->_afterDetail($id);

		if($this->data['row']['sumber_nilai']<>1 and $this->data['row']['sumber_nilai']<>3){
			$this->viewdetail = "panelbackend/rab_detailedit";
		}

		$this->View($this->viewdetail);
	}

	protected function _afterDetail($id=null){
		if($this->data['row']['id_rab_detail_parent'])
			$this->data['id_rab_detail_parent'] = $this->data['row']['id_rab_detail_parent'];

		$this->data['breadcrumb'] = $this->model->GetComboParent($this->data['id_rab_detail_parent']);

		if($this->data['row']['id_item'])
			$this->viewdetail = "panelbackend/rab_detailedit";

		if($this->viewdetail<>"panelbackend/rab_detailedit"){
			if(!$this->data['row']['id_rab_detail']){
				$max_level = 3;
				$rows = $this->conn->GetArray("select * from rab_detail where id_rab = ".$this->conn->escape($this->data['id_rab'])." and id_item is null order by nvl(urutan, nvl(id_rab_detail_parent, id_rab_detail)), kode_biaya");
			}else{
				$max_level = 2;
				$id_rab_detailarr = $this->model->GetChild($this->data['row']['id_rab_detail']);
				if(!count($id_rab_detailarr))
					return array();

				$rows = $this->conn->GetArray("select * from rab_detail where id_rab = ".$this->conn->escape($this->data['id_rab'])." and id_rab_detail in (".implode(",", $id_rab_detailarr).") and id_rab_detail <> ".$this->conn->escape($this->data['row']['id_rab_detail'])." order by kode_biaya, id_rab_detail");
			}

			$this->data['rows'] = array();
			$i = 0;
			$this->GenerateTree($rows, "id_rab_detail_parent", "id_rab_detail", "uraian", $this->data['rows'], $this->data['row']['id_rab_detail'], $i, 0, "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $max_level);

			$this->data['parentarr'] = array();

			foreach($this->data['rows'] as $r){
				$this->data['parentarr'][$r['id_rab_detail_parent']][] = $r['id_rab_detail'];
			}

			$this->data['is_satuan'] = false;
			$this->data['is_kode_biaya'] = false;
			foreach($this->data['rows'] as $r){
				if($r['vol'] or $r['satuan'])
					$this->data['is_satuan'] = true;

				if($r['kode_biaya'])
					$this->data['is_kode_biaya'] = true;
			}
		}

		if($this->data['row']['sumber_satuan']==2 or $this->data['row']['sumber_satuan']==3){
			if($this->post['act']!='set_value' && empty($this->post['id_jabatan_proyek'])){
				$this->data['row']['id_jabatan_proyek'] = $this->conn->GetList("select id_jabatan_proyek as key, id_jabatan_proyek as val 
					from rab_detail_jabatan_proyek 
					where id_rab_detail = ".$this->conn->escape($id));
			}
			if($this->post['act']!='set_value' && empty($this->post['id_sumber_pegawai'])){
				$this->data['row']['id_sumber_pegawai'] = $this->conn->GetList("select id_sumber_pegawai as key, id_sumber_pegawai as val 
					from rab_detail_sumber_pegawai 
					where id_rab_detail = ".$this->conn->escape($id));

			}
		}

		if($this->data['row']['sumber_nilai']==3){
			$this->data['rowsjasa_material'] = $this->conn->GetArray("select 
			nvl(vol,1)*nvl(harga_satuan,0) as total,
			a.*
			from rab_jasa_material a
			where id_rab = ".$this->conn->escape($this->data['id_rab'])."
			and kode_biaya = ".$this->conn->escape($this->data['row']['kode_biaya'])."
			and id_pos_anggaran = ".$this->conn->escape($this->data['row']['id_pos_anggaran'])."
			and jasa_material = ".$this->conn->escape($this->data['row']['jasa_material']));
		}
	}

	public function go_print($id_rab=null){

		$this->template = "panelbackend/main3";
		$this->layout = "panelbackend/layout3";
		$this->data['width'] = "900px";
		$this->data['no_header'] =true;

		$this->_beforeDetail($id_rab);
		$this->_afterDetail();
		$this->View("panelbackend/rab_detailprint");
	}


	function GenerateTree(&$row, $colparent, $colid, $collabel, &$return=array(), $valparent=null, &$i=0, $level=0, $spacea = "&nbsp;➥&nbsp;", $max_level=100){

		$level++;
		foreach ($row as $key => $value) {
			# code...
			if(trim($value[$colparent])==trim($valparent)){
			
				$space = '';
				for($k=1; $k<$level; $k++){
					$space .= $spacea;
				}

				$value[$collabel] = $space.$value[$collabel];
				$value['level'] = $level;

				if($level<=1 or (!$value['kode_biaya'] && $level<=2))
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

	protected function _beforeDetail($id_rab=null, $id=null){
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

		$this->data['ttdarr'] = $this->conn->GetArray("select * from proyek_pekerjaan_ttd where id_proyek_pekerjaan = ".$this->conn->escape($id_proyek_pekerjaan)." order by id_proyek_pekerjaan_ttd");

		if($this->data['last_versi']<>$this->data['rowheader2']['id_rab']){
			$this->access_role['add']=0;
			$this->access_role['edit']=0;
			$this->access_role['delete']=0;
			$this->access_role['delete_file']=0;
			$this->access_role['upload_file']=0;
			$this->access_role['delete_file']=0;
			$this->access_role['save']=0;
		}
	}

	protected function _afterDelete($id){
		return $this->_afterInsert($id);
	}

	protected function _afterUpdate($id){
		return $this->_afterInsert($id);
	}

	protected function _afterInsert($id){
		$ret = true;

		// $this->conn->debug=1;
		// dpr($ret,1);

		if($ret)
			$ret = $this->_delsertFiles($id);

		if($ret)
			$ret = $this->_delsertJabatanProyek($id);

		if($ret)
			$ret = $this->_delsertSumberPegawai($id);
		
		if($ret)
			$ret = $this->_hitungSubParent($this->data['id_rab_detail_parent'], $this->data['row']['sumber_nilai']=='5');

		if($ret)
			$ret = $this->_hitungTotalRabParent();

		return $ret;
	}

	private function _delsertFiles($id_rab_detail = null){
		$ret = true;

		if(is_array($this->post['files']) && count($this->post['files'])){
			foreach($this->post['files']['id'] as $k=>$v){
				if(!$ret)
					break;

				$this->_updateFiles(array('id_rab_detail'=>$id_rab_detail), $v);
			}
		}
		return $ret;
	}

	private function _delsertJabatanProyek($id_rab_detail = null){
		$ret = $this->conn->Execute("delete from rab_detail_jabatan_proyek where id_rab_detail = ".$this->conn->escape($id_rab_detail));

		if(is_array($this->post['id_jabatan_proyek']) && count($this->post['id_jabatan_proyek'])){
			foreach($this->post['id_jabatan_proyek'] as $k=>$v){
				if(!$ret)
					break;

				$record = array();
				$record['id_rab_detail'] = $id_rab_detail;
				$record['id_jabatan_proyek'] = $k;

				$this->conn->goInsert("rab_detail_jabatan_proyek", $record);
			}
		}
		return $ret;
	}

	private function _delsertSumberPegawai($id_rab_detail = null){
		$ret = $this->conn->Execute("delete from rab_detail_sumber_pegawai where id_rab_detail = ".$this->conn->escape($id_rab_detail));

		if(is_array($this->post['id_sumber_pegawai']) && count($this->post['id_sumber_pegawai'])){
			foreach($this->post['id_sumber_pegawai'] as $k=>$v){
				if(!$ret)
					break;

				$record = array();
				$record['id_rab_detail'] = $id_rab_detail;
				$record['id_sumber_pegawai'] = $k;

				$this->conn->goInsert("rab_detail_sumber_pegawai", $record);
			}
		}
		return $ret;
	}

	protected function Record($id=null){
		$return = array(
			'id_item'=>$this->post['id_item'],
			'uraian'=>$this->post['uraian'],
			'kode_biaya'=>$this->post['kode_biaya'],
			'no_prk'=>$this->post['no_prk'],
			'id_pos_anggaran'=>$this->post['id_pos_anggaran'],
			'keterangan'=>$this->post['keterangan'],
			'vol'=>$this->post['vol'],
			'satuan'=>$this->post['satuan'],
			'sumber_satuan'=>$this->post['sumber_satuan'],
			'pembagi'=>$this->post['pembagi'],
			'sumber_nilai'=>$this->post['sumber_nilai'],
			'nilai_satuan'=>$this->post['nilai_satuan'],
			'is_ppn'=>(int)$this->post['is_ppn'],
			'jasa_material'=>$this->post['jasa_material'],
			'jenis_mandays'=>$this->post['jenis_mandays'],
			'day'=>"{{null}}",
			'jenis'=>"1",
		);
		
		if($return['sumber_satuan']=='1'){
			$return['vol'] = $this->post['vol'];
			$return['satuan'] = $this->post['satuan'];
		}elseif($return['sumber_satuan']=='2'){
			// $this->conn->debug = 1;
			$return['vol'] = $this->_hitungMd($return);
			$return['satuan'] = 'MD';
			if($return['jenis_mandays']==1){
				$return['day'] = $this->post['day'];
				$return['satuan'] = $this->post['satuan'];
			}

			// dpr($return,1);
		}elseif($return['sumber_satuan']=='3'){
			// $this->conn->debug = 1;
			$return['vol'] = $this->_hitungMd($return);
			$return['satuan'] = 'Unit Day';
		}else{
			$return['vol'] = "{{null}}";
			$return['satuan'] = "{{null}}";
		}

		if($return['sumber_nilai']=='1'){
			$return['nilai_satuan'] = $this->_hitungSub($this->data['row']['id_rab_detail']);

			if($return['is_ppn'])
				$return['nilai_satuan'] = (float)$return['nilai_satuan']*1.1;
		}elseif($return['sumber_nilai']=='2'){
			$return['nilai_satuan'] = $this->conn->GetOne("select nilai from mt_item_detail where id_item = ".$this->conn->escape($return['id_item']));
			$return['is_ppn'] = "{{null}}";
		}elseif($return['sumber_nilai']=='3'){
			$return['nilai_satuan'] = $this->_hitungSow($return);

			if($return['is_ppn'])
				$return['nilai_satuan'] = (float)$return['nilai_satuan']*1.1;
		}elseif($return['sumber_nilai']=='5'){
			$id_rab_detail = $this->data['row']['id_rab_detail'];
			if(!$id_rab_detail)
				$id_rab_detail = $this->data['id_rab_detail_parent'];
/*
			$this->conn->debug = 1;*/
			$return['nilai_satuan'] = $this->_hitungTotalRab($id_rab_detail, $this->data['id_rab_detail_parent']);/*

			dpr($return,1);*/

			if($return['is_ppn'])
				$return['nilai_satuan'] = $return['nilai_satuan']*1.1;
		}elseif($return['sumber_nilai']=='6'){
			$return['vol'] = calJKK($return['nilai_satuan'])/$return['nilai_satuan'];
		}elseif($return['sumber_nilai']=='7'){
			$return['vol'] = calJKM($return['nilai_satuan'])/$return['nilai_satuan'];
		}elseif($return['sumber_nilai']=='8'){
			$return['vol'] = calCAR($return['nilai_satuan'])/$return['nilai_satuan'];
		}else{
			$return['nilai_satuan'] = $this->post['nilai_satuan'];
		}

		return $return;
	}

	protected function Rules(){
		$return = array(
			"uraian"=>array(
				'field'=>'uraian', 
				'label'=>'Uraian', 
				'rules'=>"required|max_length[200]",
			),
			"nilai_satuan"=>array(
				'field'=>'nilai_satuan', 
				'label'=>'Nilai Satuan', 
				'rules'=>"numeric",
			),
			"kode_biaya"=>array(
				'field'=>'kode_biaya', 
				'label'=>'Kode Biaya', 
				'rules'=>"max_length[20]",
			),
			"sumber_nilai"=>array(
				'field'=>'sumber_nilai', 
				'label'=>'Sumber Nilai', 
				'rules'=>"in_list[".implode(",", array_keys($this->data['sumbernilaiarr']))."]",
			),
			"sumber_satuan"=>array(
				'field'=>'sumber_satuan', 
				'label'=>'Sumber Satuan', 
				'rules'=>"in_list[".implode(",", array_keys($this->data['sumbersatuanarr']))."]",
			),
			"keterangan"=>array(
				'field'=>'keterangan', 
				'label'=>'Keterangan', 
				'rules'=>"max_length[4000]",
			),
			"is_ppn"=>array(
				'field'=>'is_ppn', 
				'label'=>'IS PPN', 
				'rules'=>"max_length[1]",
			),
		);

		if($this->data['row']['sumber_nilai']==3){
			$return['kode_biaya'] = array(
				'field'=>'kode_biaya', 
				'label'=>'Kode Biaya', 
				'rules'=>"required|max_length[20]",
			);
			$return['jasa_material'] = array(
				'field'=>'jasa_material', 
				'label'=>'Jasa/Material', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['jasamaterialarr']))."]",
			);
		}

		/*elseif($this->data['row']['sumber_nilai']==4){

			$return['nilai_satuan'] = array(
				'field'=>'nilai_satuan', 
				'label'=>'Nilai Satuan', 
				'rules'=>"required|numeric",
			);
		}*/

		if($this->data['row']['sumber_satuan']==1){
			$return['vol'] = array(
				'field'=>'vol', 
				'label'=>'VOL', 
				'rules'=>"required|integer",
			);
			$return['satuan'] = array(
				'field'=>'satuan', 
				'label'=>'Satuan', 
				'rules'=>"required|max_length[100]|in_list[".implode(",", array_keys($this->data['mtuomarr']))."]",
			);
		}elseif($this->data['row']['sumber_satuan']==2){
			$return['id_sumber_pegawai'] = array(
				'field'=>'id_sumber_pegawai', 
				'label'=>'Sumber Pegawai', 
				'rules'=>"in_list[".implode(",", array_keys($this->data['mtsumberpegawaiarr']))."]",
			);
			$return['jenis_mandays'] = array(
				'field'=>'jenis_mandays', 
				'label'=>'Jenis Mandays', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['jenismandaysarr']))."]",
			);
		}


		return $return;
	}

	public function download_pdf($id_rab=null){
		$this->_beforeDetail($id_rab);
		$this->load->library("PHPPdf");

		$pdf = new PHPPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$pdf->SetMargins(3, 3, 3);
		$pdf->SetHeaderMargin(1);
		$pdf->SetFooterMargin(1);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->SetFontSize(7);

		$pdf->AddPage();
		$html = $this->curlwait(site_url("panelbackend/rab_detail/go_print/$id_rab"),array(date('Ymd')=>base64_encode(base64_encode(json_encode($_SESSION[SESSION_APP]['menu'])).md5(date('Ymdhi')).base64_encode(json_encode($_SESSION[SESSION_APP]['group_id'])))));
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->lastPage();

		$rows = $this->conn->GetArray("select id_rab_detail from rab_detail where id_rab_detail_parent is null and id_rab = ".$this->conn->escape($id_rab));

		foreach($rows as $r){
			$pdf->AddPage();
			$html = $this->curlwait(site_url("panelbackend/rab_detail/go_print_detail/$id_rab/$r[id_rab_detail]"),array(date('Ymd')=>base64_encode(base64_encode(json_encode($_SESSION[SESSION_APP]['menu'])).md5(date('Ymdhi')).base64_encode(json_encode($_SESSION[SESSION_APP]['group_id'])))));
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->lastPage();
		}

		$pdf->Output('rab '.$this->data['rowheader']['nama_proyek'].' '.$this->data['rowheader1']['nama_pekerjaan'].date('Ymdhis').'.pdf', 'I');
	}

}