<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Mon_proyekselesai extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "om/settlement/proyeklist";
		$this->viewdetail = "om/settlement/proyekdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->layout = "panelbackend/layout_proyek";
			$this->data['page_title'] = 'Tambah Proyek';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->layout = "panelbackend/layout_kontrak_proyekselesai";
			$this->data['page_title'] = 'Edit Proyek';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->layout = "panelbackend/layout_kontrak_proyekselesai";
			$this->data['page_title'] = 'Detail Kontrak';
			$this->data['edited'] = false;	
		}else{
			$this->layout = "panelbackend/layout2";
			$this->data['page_title'] = 'Daftar Kontrak';
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
				'label'=>'Nama Kontrak', 
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

	protected function _afterDetail($id){
		$this->data['rowstgl'] = $this->proyektgl->GArray("*","where id_proyek = ".$this->conn->escape($id)." order by jenis asc, id_proyek_tgl asc");
		$this->data['mtpegawaiarr'][$this->data['row']['id_pic']] = $this->data['row']['nama_pic'];
		$this->data['mtpegawaiarr'][$this->data['row']['id_rendal_proyek']] = $this->data['row']['nama_rendal_proyek'];
		$this->data['rowheader'] = $this->data['row'];

		$this->load->model("ProyekSelesaiModel","proyekSelesaiModel");
		$this->data['rowdetail'] = $this->proyekSelesaiModel->list_dokumen($id);
		$this->data['history'] = $this->proyekSelesaiModel->list_history($id);
		// print_r($this->data);exit;
		if(!$this->data['row']['file']['id'] && $id){
			$rows = $this->conn->GetArray("select id_proyek_files as id, client_name as name
				from proyek_files
				where jenis_file = 'file' and id_proyek = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file']['id'][] = $r['id'];
				$this->data['row']['file']['name'][] = $r['name'];
			}
		}

		
	}

	public function update_history($id=0)
	{
		$record['proyek_id'] = $id;
		$record['status_fisik'] = $this->input->post('status_fisik');
		$record['status_niaga'] = $this->input->post('status_niaga');
		$record['status_proyek'] = $this->input->post('status_proyek');
		$return =  $this->conn->goInsert("t_finishing_log", $record);
		echo 1;
	}

	
}