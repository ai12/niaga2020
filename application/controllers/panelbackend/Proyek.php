<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Proyek extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/proyeklist";
		$this->viewdetail = "panelbackend/proyekdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->layout = "panelbackend/layout_proyek";
			$this->data['page_title'] = 'Tambah Proyek';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->layout = "panelbackend/layout_proyek";
			$this->data['page_title'] = 'Edit Proyek';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->layout = "panelbackend/layout_proyek";
			$this->data['page_title'] = 'Detail Proyek';
			$this->data['edited'] = false;	
		}else{
			$this->layout = "panelbackend/layout2";
			$this->data['page_title'] = 'Daftar Proyek';
		}

		$this->data['no_header'] = false;

		$this->load->model("ProyekModel","model");
		$this->load->model("Proyek_filesModel","modelfile");
		$this->load->model("Proyek_tglModel","proyektgl");
		$this->load->model("Mt_pegawaiModel","mtpegawai");
		$this->data['mtpegawaiarr'] = array();

		
		$this->load->model("Mt_warehouseModel","mtwarehouse");
		$this->data['mtmtwarehousearr'] = $this->mtwarehouse->GetCombo();
		
		$this->load->model("CustomerModel","mtcustomer");
		$this->data['mtcustomerarr'] = $this->mtcustomer->GetCombo();

		$this->load->model("Mt_zona_sppdModel","mtzonasppd");
		$this->data['zonasppdarr'] = $this->mtzonasppd->GetCombo();

		$this->load->model("Mt_wilayah_proyekModel","mtwilayah");
		$this->data['wilayaharr'] = $this->mtwilayah->GetCombo();
		
		$this->load->model("Mt_tipe_proyekModel","mttipeproyek");
		$this->data['mttipeproyekarr'] = $this->mttipeproyek->GetCombo();
		
		$this->load->model("Mt_status_proyekModel","mtstatusproyek");
		$this->data['mtstatusproyekarr'] = $this->mtstatusproyek->GetCombo();
		$this->data['configfile'] = $this->config->item('file_upload_config');

		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'datepicker','select2','upload'
		);
	}

	protected function Header(){
		return array(
			array(
				'name'=>'id_customer', 
				'label'=>'Customer', 
				'width'=>"200px",
				'type'=>"list",
				'value'=>$this->data['mtcustomerarr'],
			),
			array(
				'name'=>'nama_proyek', 
				'label'=>'Nama Proyek', 
				'width'=>"250px",
				'type'=>"varchar2",
			),
			/*array(
				'name'=>'id_tipe_proyek', 
				'label'=>'Tipe', 
				'width'=>"10px",
				'type'=>"list",
				'value'=>$this->data['mttipeproyekarr'],
			),*/
			array(
				'name'=>'tgl_rencana_mulai', 
				'label'=>'Rencana Mulai', 
				'width'=>"auto",
				'type'=>"date",
			),
			array(
				'name'=>'tgl_rencana_selesai', 
				'label'=>'Rencana Selesai', 
				'width'=>"auto",
				'type'=>"date",
			),
			/*array(
				'name'=>'tgl_realisasi_mulai', 
				'label'=>'Realisasi Mulai', 
				'width'=>"auto",
				'type'=>"date",
			),
			array(
				'name'=>'tgl_realisasi_selesai', 
				'label'=>'Realisasi Selesai', 
				'width'=>"auto",
				'type'=>"date",
			),*/
		/*	array(
				'name'=>'id_pic', 
				'label'=>'PIC', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['mtpegawaiarr'],
			),*/
			/*array(
				'name'=>'nama_pic', 
				'label'=>'Nama PIC', 
				'width'=>"auto",
				'type'=>"varchar2",
			),*/
			array(
				'name'=>'nilai_rab', 
				'label'=>'Nilai RAB', 
				'width'=>"100px",
				'type'=>"number",
			),
			array(
				'name'=>'nilai_hpp', 
				'label'=>'Nilai HPP', 
				'width'=>"100px",
				'type'=>"number",
			),
			array(
				'name'=>'nilai_realisasi', 
				'label'=>'Nilai Realisasi', 
				'width'=>"100px",
				'type'=>"number",
			),
			array(
				'name'=>'nilai_sisa', 
				'label'=>'Nilai Sisa', 
				'width'=>"100px",
				'type'=>"number",
			),
			/*array(
				'name'=>'nilai_terbayar', 
				'label'=>'Nilai Terbayar', 
				'width'=>"100px",
				'type'=>"number",
			),*/
			array(
				'name'=>'id_status_proyek', 
				'label'=>'Status Proyek', 
				'width'=>"90px",
				'type'=>"list",
				'value'=>$this->data['mtstatusproyekarr'],
			),
/*			array(
				'name'=>'jabatan_pic', 
				'label'=>'Jabatan PIC', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'id_proyek_old', 
				'label'=>'Proyek OLD', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['rabproyekarr'],
			),*/
		);
	}

	protected function Record($id=null){
		$return = array(
			/*'id_customer'=>$this->post['id_customer'],
			'nama_proyek'=>$this->post['nama_proyek'],
			'pic_customer'=>$this->post['pic_customer'],
			'pic_pln'=>$this->post['pic_pln'],
			'jabatan_pic_customer'=>$this->post['jabatan_pic_customer'],
			'jabatan_pic_pln'=>$this->post['jabatan_pic_pln'],
			'tgl_rencana_mulai'=>$this->post['tgl_rencana_mulai'],
			'tgl_rencana_selesai'=>$this->post['tgl_rencana_selesai'],
			'id_pic'=>$this->post['id_pic'],
			'id_rendal_proyek'=>$this->post['id_rendal_proyek'],
			'id_status_proyek'=>$this->post['id_status_proyek'],
			'id_warehouse'=>$this->post['id_warehouse'],
			'lokasi'=>$this->data['mtmtwarehousearr'][$this->post['id_warehouse']],
			'is_pln'=>(int)$this->post['is_pln'],*/
	/*		'nama_pic'=>$this->post['nama_pic'],
			'jabatan_pic'=>$this->post['jabatan_pic'],
			'id_proyek_old'=>$this->post['id_proyek_old'],
			'tgl_realisasi_mulai'=>$this->post['tgl_realisasi_mulai'],
			'tgl_realisasi_selesai'=>$this->post['tgl_realisasi_selesai'],*/
			'id_tipe_proyek'=>$this->post['id_tipe_proyek'],
			'id_wilayah_proyek'=>$this->post['id_wilayah_proyek'],
			'id_zona_sppd'=>$this->post['id_zona_sppd'],
			'is_close'=>(int)$this->post['is_close'],
		);

		if((int)$this->data['row']['is_close']<>(int)$return['is_close'] && $return['is_close'])
			$return['nilai_realisasi_close'] = $return['nilai_realisasi'];
/*
		$pic = $this->conn->GetRow("select nama, jabatan from mt_pegawai where trim(nid) = ".$this->conn->escape(trim($return['id_pic'])));

		$return['nama_pic'] = $pic['nama'];
		$return['jabatan_pic'] = $pic['jabatan'];

		$rendal = $this->conn->GetRow("select nama, jabatan from mt_pegawai where trim(nid) = ".$this->conn->escape(trim($return['id_rendal_proyek'])));

		$return['nama_rendal_proyek'] = $rendal['nama'];
		$return['jabatan_rendal_proyek'] = $rendal['jabatan'];*/

		return $return;
	}

	protected function Rules(){
		$return = array(
			/*"id_customer"=>array(
				'field'=>'id_customer', 
				'label'=>'Customer', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['mtcustomerarr']))."]",
			),
			"id_warehouse"=>array(
				'field'=>'id_warehouse', 
				'label'=>'Warehouse', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['mtmtwarehousearr']))."]",
			),
			"id_status_proyek"=>array(
				'field'=>'id_status_proyek', 
				'label'=>'Status Proyek', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['mtstatusproyekarr']))."]",
			),
			"nama_proyek"=>array(
				'field'=>'nama_proyek', 
				'label'=>'Nama Proyek', 
				'rules'=>"required|max_length[2000]",
			),
			"id_pic"=>array(
				'field'=>'id_pic', 
				'label'=>'PIC', 
				'rules'=>"required",
			),
			"id_tipe_proyek"=>array(
				'field'=>'id_tipe_proyek', 
				'label'=>'Tipe proyek', 
				'rules'=>"in_list[".implode(",", array_keys($this->data['mttipeproyekarr']))."]",
			),*/
			"id_wilayah_proyek"=>array(
				'field'=>'id_wilayah_proyek', 
				'label'=>'Wilayah proyek', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['wilayaharr']))."]",
			),
			"id_zona_sppd"=>array(
				'field'=>'id_zona_sppd', 
				'label'=>'Zona SPPD', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['zonasppdarr']))."]",
			),
		);

		return $return;
	}

	public function Detail( $id=null){

		if($this->post['act']=='reset')
			redirect(current_url());

		$this->_beforeDetail($id);

		$this->data['row'] = $this->model->GetByPk($id);

		if (!$this->data['row'])
			$this->NoData();

		if(($this->post['act']=='delete_tgl' or $this->post['act']=='save') && $this->access_role['edit']){
			if($this->post['act']=='delete_tgl')
				$return = $this->proyektgl->delete("id_proyek_tgl = ".$this->conn->escape($this->post['key']));
			elseif($this->post['act'] == 'save'){
				$record = array();
				$record['tgl_mulai'] = $this->post['tgl_mulai'];
				$record['tgl_selesai'] = $this->post['tgl_selesai'];
				$record['jenis'] = $this->post['jenis'];
				$record['id_proyek'] = $id;
				if($this->post['key']){
					$return = $this->proyektgl->Update($record,"id_proyek_tgl = ".$this->conn->escape($this->post['key']));
				}else{
					$return = $this->proyektgl->Insert($record);
				}
			}


			if($return['success']){
				$r = $this->proyektgl->GRow("tgl_mulai, tgl_selesai, jenis","where id_proyek = ".$this->conn->escape($id)." order by jenis desc, id_proyek_tgl desc");

				if($r['jenis']==2){
					$record = array(
						"tgl_realisasi_mulai"=>$r['tgl_mulai'],
						"tgl_realisasi_selesai"=>$r['tgl_selesai'],
					);
				}else{
					$record = array(
						"tgl_rencana_mulai"=>$r['tgl_mulai'],
						"tgl_rencana_selesai"=>$r['tgl_selesai'],
					);
				}
				$this->model->Update($record, "id_proyek = ".$this->conn->escape($id));
				SetFlash("suc_msg","Berhasil");
			}else{
				SetFlash("err_msg","Gagal");
			}

			redirect(current_url());
		}

		$this->_afterDetail($id);

		$this->View($this->viewdetail);
	}

	protected function _beforeDelete($id){
		$ret = $this->conn->Execute("delete from proyek_tgl where id_proyek = ".$this->conn->escape($id));

		$rows = $this->conn->GetArray("select * from proyek_files where id_proyek = ".$this->conn->escape($id));

		foreach($rows as $r){
			if(!$ret)
				break;
			
			@unlink($this->data['configfile']['upload_path'].$r['file_name']);
		}

		if($ret)
			$ret = $this->conn->Execute("delete from proyek_files where id_proyek = ".$this->conn->escape($id));

		return $ret;
	}

	protected function _afterInsert($id=null){
		$ret = true;
		if($ret)
			$ret = $this->_afterUpdate($id);

		return $ret;
	}

	protected function _afterUpdate($id){
		$ret = true;
		
		if($ret)
			$ret = $this->_delsertFiles($id);
		
		return $ret;
	}

	private function penunjukan_pm(){
		$this->data['configfile'] = $this->config->item('file_upload_config');
		$this->load->library("word");
		$word = $this->word;

		$row = $this->conn->GetRow("select file_name from mt_template_doc_files where id_template_doc = 1");
		$temp = $this->data['configfile']['upload_path'].$row['file_name'];
		
		if(!file_exists($temp) or !$row)
			$this->Error404();

		if(!$this->data['row']['penunjukan_pm_tgl']){
			$penunjukan_pm_tgl = date('d-m-Y');

			$penunjukan_pm_no_urut=$this->conn->GetOne("select max(penunjukan_pm_no_urut) from proyek where is_deleted = '0' and to_char(penunjukan_pm_tgl,'yyyymmdd') = ".date('Ymd'));

			if(!$penunjukan_pm_no_urut){
				$penunjukan_pm_no_urut = $this->conn->GetOne("select max(penunjukan_pm_no_urut) from proyek where is_deleted = '0' and to_char(penunjukan_pm_tgl,'yyyy') = ".date('Y'));

				$penunjukan_pm_no_urut++;
			}

			$penunjukan_pm_abjad=$this->conn->GetOne("select max(penunjukan_pm_abjad) from proyek where to_char(penunjukan_pm_tgl,'yyyymmdd') = ".date('Ymd'));

			if(!$penunjukan_pm_abjad)
				$penunjukan_pm_abjad = 'A';
			else
				$penunjukan_pm_abjad++;

			$record = array(
				"penunjukan_pm_tgl"=>$penunjukan_pm_tgl,
				"penunjukan_pm_no_urut"=>$penunjukan_pm_no_urut,
				"penunjukan_pm_abjad"=>$penunjukan_pm_abjad,
			);

			$this->data['row']['penunjukan_pm_tgl'] = $record['penunjukan_pm_tgl'];
			$this->data['row']['penunjukan_pm_no_urut'] = $record['penunjukan_pm_no_urut'];
			$this->data['row']['penunjukan_pm_abjad'] = $record['penunjukan_pm_abjad'];

			$this->model->Update($record, "id_proyek = ".$this->conn->escape($this->data['row']['id_proyek']));
		}

		$word->template($temp);
		$template = $word->templateProcessor;
		$phpword = $word->phpword();

		list($tgl_penunjukan, $bln_penunjukan, $tahun_penunjukan) = explode("-",$this->data['row']['penunjukan_pm_tgl']);

		$template->setValue("tgl_penunjukan", $tgl_penunjukan);
		$template->setValue("bln_penunjukan", $bln_penunjukan);
		$template->setValue("no_urut", str_pad($this->data['row']['penunjukan_pm_no_urut'],2,'0',STR_PAD_LEFT));
		$template->setValue("abjad", $this->data['row']['penunjukan_pm_abjad']);
		$template->setValue("tahun_penunjukan", $tahun_penunjukan);
		$template->setValue("nama_pm", $this->data['row']['nama_pic']);
		$template->setValue("nid_pm", $this->data['row']['id_pic']);
		$template->setValue("jabatan_pm", $this->data['row']['jabatan_pic']);
		$template->setValue("nama_proyek", $this->data['row']['nama_proyek']);
		$template->setValue("nama_customer", $this->data['row']['pemberi_pekerjaan']);
		$template->setValue("lokasi", $this->data['row']['lokasi']);
		$template->setValue("tgl_mulai", Eng2Ind($this->data['row']['tgl_rencana_mulai']));
		$template->setValue("tgl_selesai", Eng2Ind($this->data['row']['tgl_rencana_selesai']));
		$template->setValue("tanggal", Eng2Ind($this->data['row']['penunjukan_pm_tgl']));

		$word->download('Penunjukan_PM'.str_replace(" ", "_", $this->data['row']['nama_proyek']).'.docx');
		exit();
	}

	protected function _afterDetail($id){
		$this->data['rowstgl'] = $this->proyektgl->GArray("*","where id_proyek = ".$this->conn->escape($id)." order by jenis asc, id_proyek_tgl asc");
		$this->data['mtpegawaiarr'][$this->data['row']['id_pic']] = $this->data['row']['nama_pic'];
		$this->data['mtpegawaiarr'][$this->data['row']['id_rendal_proyek']] = $this->data['row']['nama_rendal_proyek'];
		$this->data['rowheader'] = $this->data['row'];

		if(!$this->data['row']['file']['id'] && $id){
			$rows = $this->conn->GetArray("select id_proyek_files as id, client_name as name
				from proyek_files
				where jenis_file = 'file' and id_proyek = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file']['id'][] = $r['id'];
				$this->data['row']['file']['name'][] = $r['name'];
			}
		}

		if($this->post['act']=='penunjukan_pm')
			$this->penunjukan_pm();
	}


	private function _delsertFiles($id_proyek = null){
		$ret = true;

		if(count($this->post['file'])){
			foreach($this->post['file']['id'] as $k=>$v){
				if(!$ret)
					break;

				$this->_updateFiles(array('id_proyek'=>$id_proyek), $v);
			}
		}
		return $ret;
	}

	private function goSync(){
		$pos = array('data'=>array("tahun"=>$this->data['tahun']));
		$return = $this->reqpromis("get_proyek_full", $pos);
		$rows = $return['data'];

		$ret = $this->conn->goUpdate('proyek',array("is_deleted"=>1), "to_char(nvl(tgl_rencana_mulai,nvl(tgl_realisasi_mulai,created_date)), 'YYYY')=".$this->conn->escape($this->data['tahun']));

		foreach($rows as $r){
			if(!$ret)
				break;

			$cek = $this->conn->GetOne("select 1 from proyek where id_proyek = ".$this->conn->escape($r['id_proyek']));

			if($cek)
				$ret = $this->conn->goUpdate('proyek',$r, "id_proyek = ".$this->conn->escape($r['id_proyek']));
			else
				$ret = $this->conn->goInsert('proyek',$r);

			/*if($ret)
				$ret = $this->getPekerjaan($r['id_proyek']);*/
		}

		if($ret){
			SetFlash("suc_msg","Sinkronisasi berhasil");
		}else{
			SetFlash("err_msg","Sinkronisasi gagal");
		}

		redirect(current_url());
	}

	public function Index($page=0){
		$tahun = date("Y");

		if($this->post['tahun']){
			$_SESSION[SESSION_APP][$this->page_ctrl]['tahun'] = $this->post['tahun'];
		}

		if($_SESSION[SESSION_APP][$this->page_ctrl]['tahun'])
			$tahun = $_SESSION[SESSION_APP][$this->page_ctrl]['tahun'];

		$this->data['tahun'] = $tahun;

		if($this->post['act']=='go_sync'){
			$this->goSync();
		}

		$this->data['layout_header'] .= "Tahun ".UI::createTextNumber('tahun',$tahun,'','',true,'form-control',"style='text-align:left; width: 90px; display: inline; font-size: 24px;' step='any' onchange='goSubmit(\"set_tahun\")'");

		// $this->data['pengumuman'] = $this->model->pengumuman();
/*		$this->data['total_harian'] = $this->model->total_harian($tahun);
		$this->data['total'] = $this->model->total($tahun);
		$this->data['total_proyek'] = $this->model->total_proyek($tahun);*/
		/*$this->data['total_realisasi_proyek'] = $this->model->total_realisasi_proyek($tahun);
		$this->data['status_proyek'] = $this->model->status_proyek();
		$this->data['total_rencana_proyek'] = $this->model->total_rencana_proyek($tahun);*/
		
		$this->data['header']=$this->Header();
		
		$this->_setFilter("is_deleted='0' and to_char(nvl(tgl_rencana_mulai,nvl(tgl_realisasi_mulai,created_date)), 'YYYY')=".$this->conn->escape($tahun));

		$this->data['list']=$this->_getList($page);

		$this->data['page']=$page;
		$param_paging = array(
			'base_url'=>base_url("{$this->page_ctrl}/index"),
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

	function logo_customer($id){
		$row = $this->conn->GetRow("select * from mt_customer_files where id_customer = ".$this->conn->escape($id));
		
		$this->data['configfile'] = $this->config->item('file_upload_config');

		if($row ){
			$full_path = $this->data['configfile']['upload_path'].$row['file_name'];
			header("Content-Type: {$row['file_type']}");
			header("Content-Disposition: inline; filename='".str_replace(" ","_",basename($row['client_name']))."'");
			header("Content-Length:".filesize($full_path));
			echo file_get_contents($full_path);
			die();
		}else{
			$full_path = $this->data['configfile']['upload_path'].'wbs60.jpg';
			header("Content-Type: image/jpg");
			header("Content-Disposition: inline; filename='wbs60.jpg'");
			header("Content-Length:".filesize($full_path));
			echo file_get_contents($full_path);
		}
	}



	public function Delete( $id=null){

        $this->model->conn->StartTrans();

        $this->_beforeDetail($id);

		$this->data['row'] = $this->model->GetByPk($id);

		if (!$this->data['row'])
			$this->NoData();

		$return = $this->_beforeDelete($id);

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
			redirect("$this->page_ctrl");
		}
		else {
			SetFlash('err_msg',"Data gagal didelete");
			redirect("$this->page_ctrl/detail/$id");
		}

	}
}