<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Proyek_pekerjaan extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/proyek_pekerjaanlist";
		$this->viewdetail = "panelbackend/proyek_pekerjaandetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout_proyek";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Pekerjaan';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Pekerjaan';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Pekerjaan';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Daftar Pekerjaan';
		}

		// $this->data['no_header'] = true;

		$this->load->model("proyek_pekerjaanModel","model");
		$this->load->model("proyekModel","proyek");
		$this->load->model("RabModel","rabrab");		
		$this->load->model("proyek_pekerjaan_filesModel","modelfile");
		
		$this->load->model("CustomerModel","mtcustomer");
		$this->data['mtcustomerarr'] = $this->mtcustomer->GetCombo();
		$this->data['configfile'] = $this->config->item('file_upload_config');

		
		$this->load->model("Mt_tipe_pekerjaanModel","mttipepekerjaan");
		$this->data['mttipepekerjaanarr'] = $this->mttipepekerjaan->GetCombo();

		unset($this->access_role['add']);
		unset($this->access_role['edit']);
		unset($this->access_role['delete']);
		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'datepicker','select2','upload'
		);
	}

	private function goSync($id_proyek=null){
		$pos = array();
		$pos['data'] = array(
			"params"=>array("id_proyek"=>$id_proyek)
		);
		$return = $this->reqpromis("get_pekerjaan_full", $pos);
		$rs = $return['data'];

		$ret = true;

		if($rs)
			$ret = $this->conn->goUpdate('proyek_pekerjaan',array("is_deleted"=>1), "id_proyek=".$this->conn->escape($this->data['id_proyek']));

		if($rs)
		foreach($rs as $r1){
			if(!$ret)
				break;

			$r1['id_proyek_pekerjaan'] = $r1['id_pekerjaan'];

			$cek = $this->conn->GetOne("select 1 from proyek_pekerjaan where id_proyek_pekerjaan = ".$this->conn->escape($r1['id_proyek_pekerjaan']));

			if($cek)
				$ret = $this->conn->goUpdate('proyek_pekerjaan',$r1, "id_proyek_pekerjaan = ".$this->conn->escape($r1['id_proyek_pekerjaan']));
			else
				$ret = $this->conn->goInsert('proyek_pekerjaan',$r1);

			if($ret){
				$pos = array();
				$pos['data'] = array("id_pekerjaan"=>$r1['id_proyek_pekerjaan']);
				$return = $this->reqpromis("get_rab", $pos);
				$row = $return['data']['rab'];

				if(!$row){
					$ret = false;
					continue;
				}

				$cek = $this->conn->GetOne("select 1 from rab where id_rab = ".$this->conn->escape($row['id_rab']));


				$row['id_proyek_pekerjaan'] = $row['id_pekerjaan'];


				if($cek)
					$ret = $this->conn->goUpdate("rab",$row,"id_rab = ".$this->conn->escape($row['id_rab']));
				else
					$ret = $this->conn->goInsert("rab",$row);


				$jasa_material = $return['data']['jasa_material'];

				if($jasa_material)
				foreach($jasa_material as $r2){
					if(!$ret)
						break;

					$cek = $this->conn->GetOne("select 1 from rab_jasa_material where id_jasa_material = ".$this->conn->escape($r2['id_jasa_material']));

					if($cek)
						$ret = $this->conn->goUpdate('rab_jasa_material',$r2, "id_jasa_material = ".$this->conn->escape($r2['id_jasa_material']));
					else
						$ret = $this->conn->goInsert('rab_jasa_material',$r2);
				}

				$manpower = $return['data']['manpower'];

				if($manpower)
				foreach($manpower as $r2){
					if(!$ret)
						break;

					$cek = $this->conn->GetOne("select 1 from rab_manpower where id_manpower = ".$this->conn->escape($r2['id_manpower']));

					if($cek)
						$ret = $this->conn->goUpdate('rab_manpower',$r2, "id_manpower = ".$this->conn->escape($r2['id_manpower']));
					else
						$ret = $this->conn->goInsert('rab_manpower',$r2);

					if($ret)
						$ret = $this->conn->Execute("delete from rab_mandays where id_manpower = ".$this->conn->escape($r2['id_manpower']));

					if($ret){
						if($r2['mandays'])
							foreach($r2['mandays'] as $r3){
							if(!$ret)
								break;

							$ret = $this->conn->goInsert("rab_mandays",$r3);
						}
					}
				}


				$rab_detail = $return['data']['rab_detail'];

				if($rab_detail)
				foreach($rab_detail as $r2){
					if(!$ret)
						break;

					$cek = $this->conn->GetOne("select 1 from rab_detail where id_rab_detail = ".$this->conn->escape($r2['id_rab_detail']));

					if($cek)
						$ret = $this->conn->goUpdate('rab_detail',$r2, "id_rab_detail = ".$this->conn->escape($r2['id_rab_detail']));
					else
						$ret = $this->conn->goInsert('rab_detail',$r2);

					if($ret)
						$ret = $this->conn->Execute("delete from rab_detail_jabatan_proyek where id_rab_detail = ".$this->conn->escape($r2['id_rab_detail']));

					if($ret){
						if($r2['jabatan_proyek'])
							foreach($r2['jabatan_proyek'] as $r3){
							if(!$ret)
								break;

							$ret = $this->conn->goInsert("rab_detail_jabatan_proyek",$r3);
						}
					}

					if($ret)
						$ret = $this->conn->Execute("delete from rab_detail_sumber_pegawai where id_rab_detail = ".$this->conn->escape($r2['id_rab_detail']));

					if($ret){
						if($r2['sumber_pegawai'])
							foreach($r2['sumber_pegawai'] as $r3){
							if(!$ret)
								break;

							$ret = $this->conn->goInsert("rab_detail_sumber_pegawai",$r3);
						}
					}
				}
			}
		}

		if($ret && $rs){
			$record = $this->conn->GetRow("select 
				sum(nilai_rab) as nilai_rab,
				sum(nilai_hpp) as nilai_hpp,
				sum(nilai_realisasi) as nilai_realisasi,
				sum(nilai_terbayar) as nilai_terbayar
				from proyek_pekerjaan 
				where is_deleted <> 1
				and id_proyek = ".$this->conn->escape($id_proyek)."
				group by id_proyek");

			$ret = $this->conn->goUpdate("proyek", $record, "id_proyek = ".$this->conn->escape($id_proyek));
		}

		if($ret){
			SetFlash("suc_msg","Sinkronisasi berhasil");
		}else{
			SetFlash("err_msg","Sinkronisasi gagal");
		}

		redirect(current_url());
	}

	public function Index($id_proyek=0, $page=0){
		if($this->post['act']=='go_sync')
			$this->goSync($id_proyek);

		$this->_beforeDetail($id_proyek);
		$this->data['header']=$this->Header();
		$this->_setFilter("is_deleted='0' and id_proyek = ".$this->conn->escape($id_proyek));
		$this->data['list']=$this->_getList($page);

		$this->data['add_menu'] = '<button type="button" class="btn btn-warning" onclick="if(confirm(\'Apakah Anda akan melakukan sinkronisasi ?\')){goSubmit(\'go_sync\')}">
            <i class="glyphicon glyphicon-refresh"></i>
            Update From Promis
            </button>';

		$this->data['page']=$page;

		$param_paging = array(
			'base_url'=>base_url("{$this->page_ctrl}/index/$id_proyek"),
			'cur_page'=>$page,
			'total_rows'=>$this->data['list']['total'],
			'per_page'=>$this->limit,
			'first_tag_open'=>'<li>',
			'first_tag_close'=>'</li>',
			'last_tag_open'=>'<li>',
			'last_tag_close'=>'</li>',
			'cur_tag_open'=>'<li class="active"><a href="#">',
			'cur_tag_close'=>'</a></li>',
			'next_tag_open'=>'<li>',
			'next_tag_close'=>'</li>',
			'prev_tag_open'=>'<li>',
			'prev_tag_close'=>'</li>',
			'num_tag_open'=>'<li>',
			'num_tag_close'=>'</li>',
			'anchor_class'=>'pagination__page',

		);
		$this->load->library('pagination');

		$paging = $this->pagination;

		$paging->initialize($param_paging);

		$this->data['paging']=$paging->create_links();

		$this->data['limit']=$this->limit;

		$this->data['limit_arr']=$this->limit_arr;


		$this->View($this->viewlist);
	}

	protected function Header(){
		return array(
			array(
				'name'=>'nama_pekerjaan', 
				'label'=>'Nama Pekerjaan', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'no_prk', 
				'label'=>'No. PRK', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'id_tipe_pekerjaan', 
				'label'=>'Tipe Pekerjaan', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['mttipepekerjaanarr'],
			),
			array(
				'name'=>'nilai_hpp', 
				'label'=>'Nilai HPP', 
				'width'=>"auto",
				'type'=>"number",
			),
			/*array(
				'name'=>'tgl_mulai_rab', 
				'label'=>'Pengerjaan RAB', 
				'width'=>"auto",
				'type'=>"date",
			),*/
			/*array(
				'name'=>'durasi', 
				'label'=>'Durasi', 
				'width'=>"auto",
				'type'=>"polos",
			),*/
		);
	}

	protected function Record($id=null){
		$return = array(
			'nama_pekerjaan'=>$this->post['nama_pekerjaan'],
			'no_pekerjaan'=>$this->post['no_pekerjaan'],
			'tgl_pekerjaan'=>$this->post['tgl_pekerjaan'],
			'no_kontrak'=>$this->post['no_kontrak'],
			'tgl_kontrak'=>$this->post['tgl_kontrak'],
			'nilai_hpp'=>$this->post['nilai_hpp'],
			'no_prk'=>$this->post['no_prk'],
			'tgl_mulai_pelaksanaan'=>$this->post['tgl_mulai_pelaksanaan'],
			'tgl_selesai_pelaksanaan'=>$this->post['tgl_selesai_pelaksanaan'],
			'tgl_mulai_rab'=>$this->post['tgl_mulai_rab'],
			'tgl_selesai_rab'=>$this->post['tgl_selesai_rab'],
			'hmin'=>$this->post['hmin'],
			'h'=>$this->post['h'],
			'hplus'=>$this->post['hplus'],
			'id_tipe_pekerjaan'=>$this->post['id_tipe_pekerjaan'],
			'tgl_hpp'=>$this->post['tgl_hpp'],
			'tgl_prk'=>$this->post['tgl_prk'],
		);

		$pic = $this->conn->GetRow("select nama, jabatan from mt_pegawai where trim(nid) = ".$this->conn->escape(trim($return['id_pic'])));

		$return['nama_pic'] = $pic['nama'];
		$return['jabatan_pic'] = $pic['jabatan'];

		return $return;
	}

	protected function Rules(){
		return array(
			"nama_pekerjaan"=>array(
				'field'=>'nama_pekerjaan', 
				'label'=>'Nama Pekerjaan', 
				'rules'=>"required",
			),
			"no_pekerjaan"=>array(
				'field'=>'no_pekerjaan', 
				'label'=>'No. SP3', 
				'rules'=>"max_length[200]",
			),
		/*	"tgl_pekerjaan"=>array(
				'field'=>'tgl_pekerjaan', 
				'label'=>'Tgl. SP3', 
				'rules'=>"required",
			),*/
			"hmin"=>array(
				'field'=>'hmin', 
				'label'=>'Jumlah Hari', 
				'rules'=>"required",
			),
			"h"=>array(
				'field'=>'h', 
				'label'=>'Jumlah Hari', 
				'rules'=>"required",
			),
			"hplus"=>array(
				'field'=>'hplus', 
				'label'=>'Jumlah Hari', 
				'rules'=>"required",
			),
			"no_kontrak"=>array(
				'field'=>'no_kontrak', 
				'label'=>'No. Kontrak', 
				'rules'=>"max_length[200]",
			),
			"nilai_hpp"=>array(
				'field'=>'nilai_hpp', 
				'label'=>'Nilai HPP', 
				'rules'=>"integer",
			),
			"no_prk"=>array(
				'field'=>'no_prk', 
				'label'=>'No. PRK', 
				'rules'=>"max_length[200]|callback_checkprk",
			),
			"tgl_mulai_pelaksanaan"=>array(
				'field'=>'tgl_mulai_pelaksanaan', 
				'label'=>'Tgl. Mulai Pelaksanaan', 
				'rules'=>"required",
			),
			"id_tipe_pekerjaan"=>array(
				'field'=>'id_tipe_pekerjaan', 
				'label'=>'Tipe Pekerjaan', 
				'rules'=>"in_list[".implode(",", array_keys($this->data['mttipepekerjaanarr']))."]",
			),
		);
	}

	function checkprk($str)
    {
    	if(!$str)
    		return true;

    	$ret = $this->conn->GetOne("select 1 from mt_prk where prk = ".$this->conn->escape($str));
        if (!$ret)
        {
                $this->form_validation->set_message('checkprk', 'PRK tidak terdaftar');
                return FALSE;
        }
        else
        {
                return TRUE;
        }
    }

	public function Add($id_proyek=0){
		$this->Edit($id_proyek);
	}

	public function Edit($id_proyek=0,$id=null){

		if($this->post['act']=='reset'){
			redirect(current_url());
		}

		$this->_beforeDetail($id_proyek,$id);

		$this->data['idpk'] = $id;

		$this->data['row'] = $this->model->GetByPk($id);

		if (!$this->data['rowheader'] && !$this->data['row'] && $id)
			$this->NoData();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters("","");

		if(count($this->post) && $this->post['act']<>'change'){
			if(!$this->data['row'])
				$this->data['row'] = array();

			$record = $this->Record($id);

			$this->data['row'] = array_merge($this->data['row'],$record);
			$this->data['row'] = array_merge($this->data['row'],$this->post);
		}

		$this->_onDetail($id);

		$this->data['rules'] = $this->Rules();

		## EDIT HERE ##
		if ($this->post['act'] === 'save') {

			$record['id_proyek'] = $id_proyek;

			$this->_isValid($record,true);

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
				redirect("$this->page_ctrl/detail/$id_proyek/$id");

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

	public function Detail($id_proyek=null, $id=null){

		$this->_beforeDetail($id_proyek, $id);

		$this->data['row'] = $this->model->GetByPk($id);

		$this->_onDetail($id);

		if (!$this->data['row'] && !$this->data['rowheader'])
			$this->NoData();

		$this->_afterDetail($id);

		$this->View($this->viewdetail);
	}

	protected function _beforeDelete($id=null){

		$rows = $this->conn->GetArray("select * from proyek_pekerjaan_files where id_proyek_pekerjaan = ".$this->conn->escape($id));

		$ret = true;

		foreach($rows as $r){
			if(!$ret)
				break;
			
			@unlink($this->data['configfile']['upload_path'].$r['file_name']);
		}

		if($ret)
			$ret = $this->conn->Execute("delete from proyek_pekerjaan_files where id_proyek_pekerjaan = ".$this->conn->escape($id));

		if($ret)
			$ret = $this->conn->Execute("delete from rab where id_proyek_pekerjaan = ".$this->conn->escape($id));

		if($ret)
			$ret = $this->conn->Execute("delete from proyek_pekerjaan_ttd where id_proyek_pekerjaan = ".$this->conn->escape($id));

		return $ret;
	}

	public function Delete($id_proyek=null, $id=null){

        $this->model->conn->StartTrans();

        $this->_beforeDetail($id);

		$this->data['row'] = $this->model->GetByPk($id);
		
		$this->_onDetail($id);

		if (!$this->data['row'])
			$this->NoData();

		// $return = $this->_beforeDelete($id);
		$return = true;

		if($return){

			$record = array('is_deleted'=>1);
			
            $this->_setLogRecord($record,$id);

			$return = $this->model->Update($record,"$this->pk = ".$this->conn->qstr($id));
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
			redirect("$this->page_ctrl/index/$id_proyek");
		}
		else {
			SetFlash('err_msg',"Data gagal didelete");
			redirect("$this->page_ctrl/detail/$id_proyek/$id");
		}

	}

	protected function _beforeDetail($id_proyek=null, $id=null){
		$this->data['id_proyek'] = $id_proyek;
		$this->data['rowheader'] = $this->proyek->GetByPk($id_proyek);
		$this->data['rowheader1'] = $this->data['row'];
		$this->data['add_param'] .= $id_proyek;
	}

	protected function _afterDetail($id){

		if(!$this->data['row']['ttd'] && $id){
			$this->data['row']['ttd'] = $this->conn->GetArray("select a.*
				from proyek_pekerjaan_ttd a
				where id_proyek_pekerjaan = ".$this->conn->escape($id)." 
				order by id_proyek_pekerjaan_ttd");
		}

		if(!$this->data['row']['ttd']){
			$max_id = $this->conn->GetOne("select max(id_proyek_pekerjaan) from proyek_pekerjaan_ttd a");
			$this->data['row']['ttd'] = $this->conn->GetArray("select a.*
				from proyek_pekerjaan_ttd a
				where id_proyek_pekerjaan = ".$this->conn->escape($max_id)." 
				order by id_proyek_pekerjaan_ttd");
		}

		if(count($this->data['row']['ttd'])){
			$this->data['ttdarr'] = $this->conn->GetList("select nid as key, nama as val from mt_pegawai where nid in (".$this->conn->GetKeysStr($this->data['row']['ttd'],'nid').")");
		}

		if(!$this->data['row']['sp3']['id'] && $id){
			$rows = $this->conn->GetArray("select id_proyek_pekerjaan_files as id, client_name as name
				from proyek_pekerjaan_files
				where jenis_file = 'sp3' and id_proyek_pekerjaan = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['sp3']['id'][] = $r['id'];
				$this->data['row']['sp3']['name'][] = $r['name'];
			}
		}

		if(!$this->data['row']['kontrak']['id'] && $id){
			$rows = $this->conn->GetArray("select id_proyek_pekerjaan_files as id, client_name as name
				from proyek_pekerjaan_files
				where jenis_file = 'kontrak' and id_proyek_pekerjaan = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['kontrak']['id'][] = $r['id'];
				$this->data['row']['kontrak']['name'][] = $r['name'];
			}
		}

		if(!$this->data['row']['file']['id'] && $id){
			$rows = $this->conn->GetArray("select id_proyek_pekerjaan_files as id, client_name as name
				from proyek_pekerjaan_files
				where jenis_file = 'file' and id_proyek_pekerjaan = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file']['id'][] = $r['id'];
				$this->data['row']['file']['name'][] = $r['name'];
			}
		}

		$this->data['mtpegawaiarr'][$this->data['row']['id_pic']] = $this->data['row']['nama_pic'];

		$this->data['rowheader1'] = $this->data['row'];

		$id_rab = $this->data['id_rab'] = $this->conn->GetOne("select max(id_rab) from rab where id_proyek_pekerjaan = ".$this->conn->escape($id)." and jenis = '1'");

		$this->data['rowheader2'] = $this->rabrab->GetByPk($id_rab);

		$id_proyek = $this->data['id_proyek'];

		$cek = $this->conn->GetOne("select 1 from proyek_pekerjaan where is_deleted = '0' and id_proyek = ".$this->conn->escape($id_proyek));

		if(!$cek && !$this->data['row']['tgl_mulai_pelaksanaan'] && !$this->data['row']['tgl_selesai_pelaksanaan']){
			$this->data['row']['tgl_mulai_pelaksanaan'] = $this->data['rowheader']['tgl_rencana_mulai'];
			$this->data['row']['tgl_selesai_pelaksanaan'] = $this->data['rowheader']['tgl_rencana_selesai'];
		}

		if(!$cek && !$this->data['row']['id_pic']){
			$this->data['row']['id_pic'] = $_SESSION[SESSION_APP]['nid'];
			$this->data['row']['nama_pic'] = $_SESSION[SESSION_APP]['name'];
		}

		$this->data['mtpegawaiarr'][$this->data['row']['id_pic']] = $this->data['row']['nama_pic'];

		
		if($this->post['act']=='pernyataan_emergency')
			$this->pernyataan_emergency();

		if($this->post['act']=='pengajuan_prk')
			$this->pengajuan_prk();
	}

	protected function _afterInsert($id=null){
		$ret = true;
		if($ret)
			$ret = $this->_afterUpdate($id);

		if($ret)
			$ret = $this->newRab($id);

		return $ret;
	}

	protected function _afterUpdate($id){
		$ret = true;
		
		if($ret)
			$ret = $this->_delsertFiles($id);
		
		if($ret)
			$ret = $this->_delsertTTD($id);
		
		return $ret;
	}

	private function _delsertFiles($id_proyek_pekerjaan = null){
		$ret = true;

		if(!empty($this->post['sp3'])){
			foreach($this->post['sp3']['id'] as $k=>$v){
				if(!$ret)
					break;

				$this->_updateFiles(array('id_proyek_pekerjaan'=>$id_proyek_pekerjaan), $v);
			}
		}

		if(!empty($this->post['kontrak'])){
			foreach($this->post['kontrak']['id'] as $k=>$v){
				if(!$ret)
					break;

				$this->_updateFiles(array('id_proyek_pekerjaan'=>$id_proyek_pekerjaan), $v);
			}
		}

		if(!empty($this->post['file'])){
			foreach($this->post['file']['id'] as $k=>$v){
				if(!$ret)
					break;

				$this->_updateFiles(array('id_proyek_pekerjaan'=>$id_proyek_pekerjaan), $v);
			}
		}
		return $ret;
	}

	private function _delsertTTD($id_proyek_pekerjaan = null){
		$ret = $this->conn->Execute("delete from proyek_pekerjaan_ttd where id_proyek_pekerjaan = ".$this->conn->escape($id_proyek_pekerjaan));

		$MainSpecarr = array();

		if(!empty($this->post['ttd'])){
			foreach ($this->post['ttd'] as $key => $v) {
				if(!$v['nid'])
					continue;

				if(!$ret)
					break;

				$record = array();
				$record['id_proyek_pekerjaan'] = $id_proyek_pekerjaan;
				$record['nid'] = $v['nid'];
				$row_pegawai = $this->conn->GetRow("select nama, jabatan from mt_pegawai where trim(nid) = ".$this->conn->escape($v['nid']));
				$record['nama'] = $row_pegawai['nama'];
				$record['jabatan'] = $row_pegawai['jabatan'];

				$ret = $this->conn->goInsert('proyek_pekerjaan_ttd', $record);
			}
		}

		return $ret;
	}

	private function pernyataan_emergency(){
		$this->data['configfile'] = $this->config->item('file_upload_config');
		$this->load->library("word");
		$word = $this->word;

		$row = $this->conn->GetRow("select file_name from mt_template_doc_files where id_template_doc = 2");
		$temp = $this->data['configfile']['upload_path'].$row['file_name'];
		
		if(!file_exists($temp) or !$row)
			$this->Error404();

		$word->template($temp);
		$template = $word->templateProcessor;
		$phpword = $word->phpword();

		$template->setValue("nama_proyek", $this->data['rowheader']['nama_proyek']);
		$template->setValue("nama_pekerjaan", $this->data['row']['nama_pekerjaan']);
		$template->setValue("nama_customer", $this->data['rowheader']['pemberi_pekerjaan']);
		$template->setValue("nama_pm", $this->data['rowheader']['nama_pic']);
		$template->setValue("nid_pm", $this->data['rowheader']['id_pic']);
		$template->setValue("jabatan_pm", $this->data['rowheader']['jabatan_pic']);
		$template->setValue("lokasi", $this->data['rowheader']['lokasi']);
		$template->setValue("tgl_pekerjaan", Eng2Ind($this->data['row']['tgl_mulai_pelaksanaan']));
		$template->setValue("no_prk", Eng2Ind($this->data['row']['no_prk']));

		$word->download('Pernyataan_Emergency '.str_replace(" ", "_", $this->data['row']['nama_proyek']).' '.str_replace(" ", "_", $this->data['row']['nama_pekerjaan']).'.docx');
		exit();
	}

	private function pengajuan_prk(){
		$this->data['configfile'] = $this->config->item('file_upload_config');
		$this->load->library("word");
		$word = $this->word;

		$row = $this->conn->GetRow("select file_name from mt_template_doc_files where id_template_doc = 3");
		$temp = $this->data['configfile']['upload_path'].$row['file_name'];
		
		if(!file_exists($temp) or !$row)
			$this->Error404();

		$word->template($temp);
		$template = $word->templateProcessor;
		$phpword = $word->phpword();

		$template->setValue("nama_proyek", $this->data['rowheader']['nama_proyek']);
		$template->setValue("nama_pekerjaan", $this->data['row']['nama_pekerjaan']);
		$template->setValue("nama_customer", $this->data['rowheader']['pemberi_pekerjaan']);
		$template->setValue("nama_pm", $this->data['rowheader']['nama_pic']);
		$template->setValue("nid_pm", $this->data['rowheader']['id_pic']);
		$template->setValue("jabatan_pm", $this->data['rowheader']['jabatan_pic']);
		$template->setValue("lokasi", $this->data['rowheader']['lokasi']);
		$template->setValue("tgl_mulai", Eng2Ind($this->data['rowheader']['tgl_rencana_mulai']));
		$template->setValue("tgl_selesai", Eng2Ind($this->data['rowheader']['tgl_rencana_selesai']));
		$template->setValue("tgl_pekerjaan", Eng2Ind($this->data['row']['tgl_mulai_pelaksanaan']));

		$word->download('Pengajuan_PRK '.str_replace(" ", "_", $this->data['row']['nama_proyek']).' '.str_replace(" ", "_", $this->data['row']['nama_pekerjaan']).'.docx');
		exit();
	}
}