<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Rab_penawaran extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/rab_penawaranlist";
		$this->viewdetail = "panelbackend/rab_penawarandetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout_pricing";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah RAB Penawaran';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit RAB Penawaran';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail RAB Penawaran';
			$this->data['edited'] = false;	
		}else{
			$this->data['no_menu'] = true;
			$this->data['page_title'] = 'Daftar RAB Penawaran';
		}

		$this->load->model("Rab_penawaranModel","model");
		$this->load->model("RabModel","rabrab");		
		$this->load->model("Proyek_pekerjaanModel","rabpekerjaan");
		$this->load->model("ProyekModel","proyek");

		$this->data['sumbersatuanarr'] = array('1'=>'Manual','4'=>'RAB','2'=>'Mandays','3'=>'Unit Day');
		$this->data['sumbernilaiarr'] = array('4'=>'Manual', '1'=>'Hitung di sub'/*,'2'=>'Master SPPD'*/,'3'=>'RAB'/*,'5'=>'Manpower Salary'*/);
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

		$this->data['aturan'] = $this->conn->GetRow("select * from mt_kelayakan_penawaran");

		$this->load->model("Mt_harga_sppdModel","mthargappd");
		$this->data['hargaarr'] = $this->mthargappd->GetCombo();
		$this->load->model("Proyek_pekerjaan_filesModel","modelfile");
		$this->data['configfile'] = $this->config->item('file_upload_config');
		$this->data['configfile']['max_size'] = 5000;
		$this->data['configfile']['allowed_types'] = "gif|jpg|jpeg|png|pdf";
		$this->config->set_item('file_upload_config',$this->data['configfile']);

		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'upload','select2'
		);
	}

	protected function _uploadFiles($jenis_file=null){
		list($jenis_file1, $id_proyek_pekerjaan) = explode("__",$jenis_file);
		$id_proyek_pekerjaan = str_replace("upload", "", $id_proyek_pekerjaan);

		$name = $_FILES[$jenis_file]['name'];

		$this->data['configfile']['file_name'] = $jenis_file.time().$name;

		$this->load->library('upload', $this->data['configfile']);

        if ( ! $this->upload->do_upload($jenis_file))
        {
            $return = array('error' => "File $name gagal upload, ".strtolower(str_replace(array("<p>","</p>"),"",$this->upload->display_errors())));
        }
        else
        {
    		$upload_data = $this->upload->data();

			$record = array();
			$record['client_name'] = $upload_data['client_name'];
			$record['file_name'] = $upload_data['file_name'];
			$record['file_type'] = $upload_data['file_type'];
			$record['file_size'] = $upload_data['file_size'];
			$record['id_proyek_pekerjaan'] = $id_proyek_pekerjaan;
			$record['jenis_file'] = str_replace("upload","",$jenis_file);
			$ret = $this->modelfile->Insert($record);
			if($ret['success'])
			{
				$return = array('file'=>array("id"=>$ret['data'][$this->modelfile->pk],"name"=>$upload_data['client_name']));
			}else{
				unlink($upload_data['full_path']);
				$return = array('errors'=>"File $name gagal upload");
			}

        }

        return $return;

	}

	public function go_print($id_rab=null, $is_detail=false){
		$this->template = "panelbackend/main3";
		$this->layout = "panelbackend/layout2";
		$this->viewprint = "panelbackend/rab_penawaranprint";
		$this->data['is_detail'] = $is_detail;
		$this->_beforeDetail($id_rab);
		$this->rab_penawaran();

		$this->View($this->viewprint);
	}

	public function Index($id_rab=0, $page=0){
		$this->_beforeDetail($id_rab);

		if($this->post['act']=='set_recal' && $this->access_role['edit']){
			$this->_reCalculationPenawaran($this->id_rab_evaluasi);
			redirect(current_url());
		}

		$rowheader3 = $this->data['rowheader3'];
		if($this->post['act']=='edit_ttd'){
			if($rowheader3['prepair']<>$this->post['prepair'] && $this->post['prepair']){
				$rowheader3['prepair'] = $this->post['prepair'];
				$rp = $this->conn->GetRow("select nama, jabatan from mt_pegawai where trim(nid) = ".$this->conn->escape(trim($this->post['prepair'])));
				$rowheader3['prepair_nama'] = $rp['nama'];
				$rowheader3['prepair_jabatan'] = $rp['jabatan'];
			}
			if($rowheader3['cek']<>$this->post['cek'] && $this->post['cek']){
				$rowheader3['cek'] = $this->post['cek'];
				$rp = $this->conn->GetRow("select nama, jabatan from mt_pegawai where trim(nid) = ".$this->conn->escape(trim($this->post['cek'])));
				$rowheader3['cek_nama'] = $rp['nama'];
				$rowheader3['cek_jabatan'] = $rp['jabatan'];
			}
			if($rowheader3['approve']<>$this->post['approve'] && $this->post['approve']){
				$rowheader3['approve'] = $this->post['approve'];
				$rp = $this->conn->GetRow("select nama, jabatan from mt_pegawai where trim(nid) = ".$this->conn->escape(trim($this->post['approve'])));
				$rowheader3['approve_nama'] = $rp['nama'];
				$rowheader3['approve_jabatan'] = $rp['jabatan'];
			}
			$this->data['rowheader3'] = $rowheader3;
		}

		$this->data['prepairarr'][$rowheader3['prepair']] = $rowheader3['prepair_nama'];
		$this->data['cekarr'][$rowheader3['cek']] = $rowheader3['cek_nama'];
		$this->data['approvearr'][$rowheader3['approve']] = $rowheader3['approve_nama'];

		if($this->post['act']=='save_ttd'){
			$record = array();
			if($rowheader3['prepair']<>$this->post['prepair'] && $this->post['prepair']){
				$record['prepair'] = $this->post['prepair'];
				$rp = $this->conn->GetRow("select nama, jabatan from mt_pegawai where trim(nid) = ".$this->conn->escape(trim($this->post['prepair'])));
				$record['prepair_nama'] = $rp['nama'];
				$record['prepair_jabatan'] = $rp['jabatan'];
			}
			if($rowheader3['cek']<>$this->post['cek'] && $this->post['cek']){
				$record['cek'] = $this->post['cek'];
				$rp = $this->conn->GetRow("select nama, jabatan from mt_pegawai where trim(nid) = ".$this->conn->escape(trim($this->post['cek'])));
				$record['cek_nama'] = $rp['nama'];
				$record['cek_jabatan'] = $rp['jabatan'];
			}
			if($rowheader3['approve']<>$this->post['approve'] && $this->post['approve']){
				$record['approve'] = $this->post['approve'];
				$rp = $this->conn->GetRow("select nama, jabatan from mt_pegawai where trim(nid) = ".$this->conn->escape(trim($this->post['approve'])));
				$record['approve_nama'] = $rp['nama'];
				$record['approve_jabatan'] = $rp['jabatan'];
			}

			$this->conn->goUpdate('rab_evaluasi',$record, 'id_rab_evaluasi = '.$this->conn->escape($this->id_rab_evaluasi));

			redirect(current_url());
		}

		#edit
		$record = array();
		$record['uraian'] = $this->post['uraian'];
		$record['nilai_satuan'] = $this->post['nilai_satuan'];
		$record['addjustment'] = $this->post['addjustment'];
		$record['pembulatan'] = "{{null}}";
		$record['vol'] = $this->post['vol'];
		$record['satuan'] = $this->post['satuan'];
		if($this->post['act']=='save_edit'){
			$this->conn->goUpdate("rab_penawaran",$record, "id_rab_penawaran = ".$this->conn->escape($this->post['key']));
			redirect(current_url());
		}
		if($this->post['act']=='save_add'){
			$record['id_rab_penawaran_parent'] = $this->post['key'];
			$record['id_rab_evaluasi'] = $this->id_rab_evaluasi;
			$record['sumber_nilai'] = 4;
			$record['sumber_satuan'] = 1;
			$this->conn->goInsert("rab_penawaran",$record);
			redirect(current_url());
		}
		if($this->post['act']=='delete'){
			$this->conn->Execute("delete from rab_penawaran where id_rab_penawaran = ".$this->conn->escape($this->post['key']));
			redirect(current_url());
		}

		#beban usaha
		$record = array();
		$record['nilai'] = $this->post['nilai'];
		$record['nama'] = $this->post['nama'];
		if($this->post['act']=='save_edit_beban_usaha'){
			$this->conn->goUpdate("rab_analisa_beban_usaha",$record,"id_beban_usaha = ".$this->conn->escape($this->post['key']));
			redirect(current_url());
		}
		if($this->post['act']=='save_add_beban_usaha'){
			$record['id_analisa'] = $this->post['key'];
			$record['id_rab_evaluasi'] = $this->id_rab_evaluasi;
			$this->conn->goInsert("rab_analisa_beban_usaha",$record);
			redirect(current_url());
		}
		if($this->post['act']=='delete_beban_usaha'){
			$this->conn->Execute("delete from rab_analisa_beban_usaha where id_beban_usaha = ".$this->conn->escape($this->post['key']));
			redirect(current_url());
		}
		if($this->post['act']=='save_pph'){
			$record = array('pph'=>$this->post['pph']);
			$this->conn->goUpdate("rab_analisa",$record,"id_analisa = ".$this->conn->escape($this->post['key']));
			redirect(current_url());
		}

		if($this->post['act']=='generate_penawaran'){
			$this->conn->StartTrans();
			$ret = $this->generate_penawaran();

			if($ret)
				$ret = $this->_reCalculationPenawaran($this->id_rab_evaluasi);
			
			if($ret)
				$this->conn->trans_commit();
			else
				$this->conn->trans_rollback();

			redirect(current_url());
		}

		$this->rab_penawaran();
		$this->analisa();
		$this->file_upload();

		$this->View($this->viewlist);
	}

	private function file_upload(){
		$id_proyek_pekerjaan = $this->data['id_proyek_pekerjaan'];
		$rows = $this->conn->GetArray("select id_proyek_pekerjaan_files as id, client_name as name, jenis_file
			from proyek_pekerjaan_files
			where jenis_file = 'penawaran__$id_proyek_pekerjaan' and id_proyek_pekerjaan = ".$this->conn->escape($id_proyek_pekerjaan));

		foreach($rows as $r){
			$this->data['row'][$r['jenis_file']]['id'][] = $r['id'];
			$this->data['row'][$r['jenis_file']]['name'][] = $r['name'];
		}
	}

	private function analisa(){

		$rows = $this->conn->GetArray("select * from rab_analisa where id_rab_evaluasi = ".$this->conn->escape($this->id_rab_evaluasi));

		$analisa = array();
		foreach($rows as $r){
			$analisa[$r['jenis']][] = $r;
		}

		$this->data['analisa'] = $analisa;

		$rows = $this->conn->GetArray("select * from rab_analisa_beban_usaha where id_rab_evaluasi = ".$this->conn->escape($this->id_rab_evaluasi)." order by id_beban_usaha asc");

		$bebanusaha = array();
		foreach($rows as $r){
			$bebanusaha[$r['id_analisa']][] = $r;
		}

		$this->data['bebanusaha'] = $bebanusaha;

		$this->data['hpp'] = $this->data['rowheader3']['hpp'];
		$this->data['profit_margin'] = $this->data['rowheader3']['profit_margin'];
	}

	private function generate_penawaran(){
		$id_rab_evaluasi = $this->data['id_rab_evaluasi'];
		$id_rab = $this->data['id_rab'];


		#mandays
		$ret = $this->conn->Execute("delete from rab_penawaran_mandays a where exists (select 1 from rab_e_manpower b where a.id_manpower = b.id_manpower and b.id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi).")");

		if($ret)
			$ret = $this->conn->Execute("delete from rab_penawaran_sumber_pegawai a where exists (select 1 from rab_penawaran b where a.id_rab_penawaran = b.id_rab_penawaran and b.id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi).")");

		if($ret){
			$ret = $this->conn->Execute("delete from rab_analisa_beban_usaha a 
				where exists (select 1 from rab_analisa b where a.id_analisa = b.id_analisa and b.id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi).")");
		}

		if($ret)
			$ret = $this->conn->Execute("delete from rab_analisa a where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

		if($ret){
			$id_max_analisa = $this->conn->GetOne("select max(id_analisa) from rab_analisa");

			$record = $this->conn->GetRow("select * from rab_analisa where id_analisa = ".$this->conn->escape($id_max_analisa));
			unset($record['id_analisa']);
			$record['id_rab_evaluasi'] = $id_rab_evaluasi;
			$record['ppn'] = 10;
			$ret = $this->conn->goInsert("rab_analisa",$record);
			$id_analisa = $this->conn->GetOne("select max(id_analisa) from rab_analisa where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

			if($ret){
				$rows = $this->conn->GetArray("select * from rab_analisa_beban_usaha where id_analisa = ".$this->conn->escape($id_max_analisa));

				foreach($rows as $record){
					if(!$ret)
						break;

					unset($record['id_beban_usaha']);

					$record['id_analisa'] = $id_analisa;
					$ret = $this->conn->goInsert("rab_analisa_beban_usaha",$record);
				}
			}
		}



		if($ret)
			$ret = $this->conn->Execute("delete from rab_penawaran_jabatan_proyek a where exists (select 1 from rab_penawaran b where a.id_rab_penawaran = b.id_rab_penawaran and b.id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi).")");

		if($ret)
			$ret = $this->conn->Execute("delete from rab_penawaran_rab a where exists (select 1 from rab_penawaran b where a.id_rab_penawaran = b.id_rab_penawaran and b.id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi).")");

		$rows = $this->conn->GetArray("select b.* from rab_e_manpower a join rab_e_mandays b on a.id_manpower = b.id_manpower where a.id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

		foreach($rows as $r){
			if(!$ret)
				break;

			$ret = $this->conn->goInsert("rab_penawaran_mandays", $r);
		}

		if($ret)
			$ret = $this->conn->Execute("delete from rab_penawaran a where a.id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

		#manpower
		if($ret){
			$record = array();
			$record['uraian'] = "MANPOWER SALARY";
			$record['sumber_nilai'] = 1;
			$record['pembulatan'] = 2;
			$record['id_rab_evaluasi'] = $id_rab_evaluasi;
			$ret = $this->conn->goInsert("rab_penawaran", $record);

			if($ret){
				$id_rab_penawaran_salary = $this->conn->GetOne("select max(id_rab_penawaran) from rab_penawaran where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

				$id_wilayah_proyek = $this->data['rowheader']['id_wilayah_proyek'];

				$rowsj = $this->conn->GetArray("select a.*, d.nilai, b.id_sumber_pegawai
				from mt_jabatan_proyek a
				join rab_e_manpower b on a.id_jabatan_proyek = b.id_jabatan_proyek
				left join mt_manpower_rate c on a.id_jabatan_proyek = c.id_jabatan_proyek
				left join mt_manpower_rate_detail d on c.id_manpower_rate = d.id_manpower_rate and d.id_wilayah_proyek = ".$this->conn->escape($id_wilayah_proyek)."
				where b.id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

				$rowmp = array();
				$rowpegawai = array();
				$rowjabatan = array();
				$rowjabatannohp = array();
				foreach($rowsj as $r){
					$rowpegawai[$r['id_sumber_pegawai']] = $r['id_sumber_pegawai'];
					$rowjabatan[$r['id_jabatan_proyek']] = $r['id_jabatan_proyek'];

					if($r['id_jabatan_proyek']<>11)
						$rowjabatannohp[$r['id_jabatan_proyek']] = $r['id_jabatan_proyek'];

					if(in_array($r['id_jabatan_proyek'],array(9,10)))
						$i = 9;
					else
						$i = $r['id_jabatan_proyek'];

					$rowmp[$i]["id_jabatan_proyek"][] = $r['id_jabatan_proyek'];
					$rowmp[$i]["id_sumber_pegawai"][] = $r['id_sumber_pegawai'];
					$rowmp[$i]["nama"][] = $r['nama'];
					$rowmp[$i]['harga'] = $r['nilai'];
				}

				foreach($rowmp as $r){
					if(!$ret)
						break;

					$record = array();
					$record['id_rab_penawaran_parent'] = $id_rab_penawaran_salary;
					$record['uraian'] = implode(" dan ",array_unique($r['nama']));
					$record['nilai_satuan'] = $r['harga'];
					$record['satuan'] = "MD";
					$record['id_rab_evaluasi'] = $id_rab_evaluasi;
					$record['jenis_mandays'] = 2;
					$record['sumber_nilai'] = 4;
					$record['sumber_satuan'] = 2;
					$ret = $this->conn->goInsert("rab_penawaran", $record);

					if($ret){
						$id_rab_penawaran = $this->conn->GetOne("select max(id_rab_penawaran) from rab_penawaran where id_rab_penawaran_parent = ".$this->conn->escape($id_rab_penawaran_salary));

						$id_sumber_pegawaiarr = array_unique($r['id_sumber_pegawai']);
						foreach($id_sumber_pegawaiarr as $id_sumber_pegawai){
							if(!$ret)
								break;

							$ret = $this->conn->goInsert("rab_penawaran_sumber_pegawai", array("id_rab_penawaran"=>$id_rab_penawaran,"id_sumber_pegawai"=>$id_sumber_pegawai));
						}
						$id_jabatan_proyekarr = array_unique($r['id_jabatan_proyek']);
						foreach($id_jabatan_proyekarr as $id_jabatan_proyek){
							if(!$ret)
								break;

							$ret = $this->conn->goInsert("rab_penawaran_jabatan_proyek", array("id_rab_penawaran"=>$id_rab_penawaran,"id_jabatan_proyek"=>$id_jabatan_proyek));
						}
					}
				}
			}
		}


		if($ret){
			$record = array();
			$record['uraian'] = "TRANSPORTATION & ACCOMODATION";
			$record['sumber_nilai'] = 1;
			$record['pembulatan'] = 2;
			$record['id_rab_evaluasi'] = $id_rab_evaluasi;
			$ret = $this->conn->goInsert("rab_penawaran", $record);
			$id_rab_penawaran_transportation = $this->conn->GetOne("select max(id_rab_penawaran) from rab_penawaran where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

			if($ret){
				$id_zona_sppd = $this->data['rowheader']['id_zona_sppd'];

				$rowssppd = $this->conn->GetArray("select a.*, b.nilai 
					from mt_harga_sppd a
					join mt_harga_sppd_detail b on a.id_harga_sppd = b.id_harga_sppd
					where b.id_zona_sppd = ".$this->conn->escape($id_zona_sppd));

				foreach($rowssppd as $r){
					$record = array();
					$record['id_rab_penawaran_parent'] = $id_rab_penawaran_transportation;
					$record['uraian'] = trim(str_replace("per hr","",$r['nama']));
					$record['nilai_satuan'] = $r['nilai'];
					$record['id_rab_evaluasi'] = $id_rab_evaluasi;
					$record['jenis_mandays'] = 2;
					$record['sumber_nilai'] = 4;

					$id_sumber_pegawaiarr = array();
					$id_jabatan_proyekarr = array();
					if($r['id_harga_sppd']==1){
						#penginapan
						$record['sumber_satuan'] = 3;
						$record['satuan'] = "Org Hr";
						$record['pembagi'] = 2;
						$id_sumber_pegawaiarr = $rowpegawai;
						$id_jabatan_proyekarr = $rowjabatannohp;
					}elseif($r['id_harga_sppd']==2){
						#sewa kendaraan
						$record['sumber_satuan'] = 3;
						$record['satuan'] = "Kend Hr";
						$record['pembagi'] = 6;
						$id_sumber_pegawaiarr = $rowpegawai;
						$id_jabatan_proyekarr = $rowjabatannohp;
					}elseif($r['id_harga_sppd']==3){
						#konsumsi
						$record['sumber_satuan'] = 2;
						$record['satuan'] = "Org Hr";
						$id_sumber_pegawaiarr = $rowpegawai;
						$id_jabatan_proyekarr = $rowjabatan;
					}elseif($r['id_harga_sppd']==4){
						#traveling pp
						$record['sumber_satuan'] = 4;
						$record['satuan'] = "Org Hr";
					}

					$ret = $this->conn->goInsert("rab_penawaran", $record);

					if($ret){
						$id_rab_penawaran = $this->conn->GetOne("select max(id_rab_penawaran) from rab_penawaran where id_rab_penawaran_parent = ".$this->conn->escape($id_rab_penawaran_transportation));

						#mandays
						if(in_array($record['sumber_satuan'],array(2,3))){

							foreach($id_sumber_pegawaiarr as $id_sumber_pegawai){
								if(!$ret)
									break;

								$ret = $this->conn->goInsert("rab_penawaran_sumber_pegawai", array("id_rab_penawaran"=>$id_rab_penawaran,"id_sumber_pegawai"=>$id_sumber_pegawai));
							}
							foreach($id_jabatan_proyekarr as $id_jabatan_proyek){
								if(!$ret)
									break;

								$ret = $this->conn->goInsert("rab_penawaran_jabatan_proyek", array("id_rab_penawaran"=>$id_rab_penawaran,"id_jabatan_proyek"=>$id_jabatan_proyek));
							}
						}

						#rab
						if(in_array($record['sumber_satuan'],array(4))){
							$rowsrab = $this->conn->GetArray("select id_rab_detail 
							from rab_e_detail 
							where (trim(lower(uraian)) like '%sppd%' or trim(lower(uraian)) like '%angkutan udara%')
							and nilai_satuan is not null and nilai_satuan <> 0
							and id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

							foreach($rowsrab as $r1){
								if(!$ret)
									break;

								$ret = $this->conn->goInsert("rab_penawaran_rab", array("id_rab_penawaran"=>$id_rab_penawaran, "id_rab_detail"=>$r1['id_rab_detail'], "is_satuan"=>1));
							}
						}
					}
				}

				if($ret){
					$record = array();
					$record['id_rab_penawaran_parent'] = $id_rab_penawaran_transportation;
					$record['uraian'] = "Tools Mobilization";
					$record['vol'] = 1;
					$record['satuan'] = "LS";
					$record['id_rab_evaluasi'] = $id_rab_evaluasi;
					$record['sumber_nilai'] = 3;
					$record['sumber_satuan'] = 1;
					$ret = $this->conn->goInsert("rab_penawaran", $record);

					if($ret){
						$id_rab_penawaran = $this->conn->GetOne("select max(id_rab_penawaran) from rab_penawaran where id_rab_penawaran_parent = ".$this->conn->escape($id_rab_penawaran_transportation));

						$ret = $this->conn->goInsert("rab_penawaran_rab", array("id_rab_penawaran"=>$id_rab_penawaran, "id_rab_detail"=>$this->conn->GetOne("select id_rab_detail from rab_e_detail where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi)." and kode_biaya = 'I210'"), "is_nilai"=>1));
					}
				}

				if($ret){
					$record = array();
					$record['id_rab_penawaran_parent'] = $id_rab_penawaran_transportation;
					$record['uraian'] = "Pos dan Komunikasi";
					$record['nilai_satuan'] = 6000000;
					$record['vol'] = 1;
					$record['satuan'] = "LS";
					$record['id_rab_evaluasi'] = $id_rab_evaluasi;
					$record['sumber_nilai'] = 4;
					$record['sumber_satuan'] = 1;
					$ret = $this->conn->goInsert("rab_penawaran", $record);
				}
			}
		}


		if($ret){
			$record = array();
			$record['uraian'] = "TOOLS RENTAL COST";
			$record['sumber_nilai'] = 1;
			$record['pembulatan'] = 2;
			$record['id_rab_evaluasi'] = $id_rab_evaluasi;
			$ret = $this->conn->goInsert("rab_penawaran", $record);
			if($ret){
				$id_rab_penawaran_rental_cost = $this->conn->GetOne("select max(id_rab_penawaran) from rab_penawaran where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

				$rowssewa = $this->conn->GetArray("select * from rab_e_jasa_material where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi). " and kode_biaya = 'F215'");

				foreach($rowssewa as $r){
					if(!$ret)
						break;

					$record = array();
					$record['id_rab_penawaran_parent'] = $id_rab_penawaran_rental_cost;
					$record['uraian'] = $r['nama'];
					$record['nilai_satuan'] = $r['harga_satuan'];
					$record['vol'] = $r['vol'];
					$record['satuan'] = $r['satuan'];
					$record['id_rab_evaluasi'] = $id_rab_evaluasi;
					$record['sumber_nilai'] = 4;
					$record['sumber_satuan'] = 1;
					$ret = $this->conn->goInsert("rab_penawaran", $record);
				}
			}
		}


		#material
		if($ret){
			$arr = $this->conn->GetList("select kode_biaya as key, uraian as val 
				from rab_e_detail a
				where jasa_material = 2
				and exists (select 1 from rab_e_jasa_material b where a.kode_biaya = b.kode_biaya and a.jasa_material = b.jasa_material)");

			foreach ($arr as $key => $value) {
				$arr[$key] = trim(str_replace("MATERIAL","",$value));
			}
			$arrm = $arr;
			$keyarr = array_keys($arr);
			$key = $keyarr[count($keyarr)-1];
			$last = $arr[$key];
			unset($arr[$key]);

			$record = array();
			$record['uraian'] = implode(", ", $arr)." dan ".$last;
			$record['sumber_nilai'] = 1;
			$record['pembulatan'] = 2;
			$record['id_rab_evaluasi'] = $id_rab_evaluasi;
			$ret = $this->conn->goInsert("rab_penawaran", $record);
			if($ret){
				$id_rab_penawaran_material = $this->conn->GetOne("select max(id_rab_penawaran) from rab_penawaran where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

				foreach($arrm as $k=>$v){
					if(!$ret)
						break;

					$record = array();
					$record['uraian'] = $v;
					$record['sumber_nilai'] = 1;
					$record['id_rab_penawaran_parent'] = $id_rab_penawaran_material;
					$record['id_rab_evaluasi'] = $id_rab_evaluasi;
					$ret = $this->conn->goInsert("rab_penawaran", $record);

					if($ret){
						$id_rab_penawaran = $this->conn->GetOne("select max(id_rab_penawaran) from rab_penawaran where id_rab_penawaran_parent = ".$this->conn->escape($id_rab_penawaran_material));

						$rowsmaterial = $this->conn->GetArray("select * from rab_e_jasa_material where jasa_material = 2 and kode_biaya = '$k'");

						foreach($rowsmaterial as $r){
							if(!$ret)
								break;

							$record = array();
							$record['id_rab_penawaran_parent'] = $id_rab_penawaran;
							$record['uraian'] = $r['nama'];
							$record['nilai_satuan'] = $r['harga_satuan'];
							$record['vol'] = $r['vol'];
							$record['satuan'] = $r['satuan'];
							$record['id_rab_evaluasi'] = $id_rab_evaluasi;
							$record['sumber_nilai'] = 4;
							$record['sumber_satuan'] = 1;
							$ret = $this->conn->goInsert("rab_penawaran", $record);
						}
					}
				}
			}
		}


		if($ret){

			$record = array();
			$record['uraian'] = "JASA LAINNYA";
			$record['sumber_nilai'] = 1;
			$record['pembulatan'] = 2;
			$record['id_rab_evaluasi'] = $id_rab_evaluasi;
			$ret = $this->conn->goInsert("rab_penawaran", $record);
			if($ret){
				$id_rab_penawaran_jasa = $this->conn->GetOne("select max(id_rab_penawaran) from rab_penawaran where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

				$rowsjasa = $this->conn->GetArray("select * from rab_e_jasa_material where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi). " and kode_biaya <> 'F215' and jasa_material = 1");

				foreach($rowsjasa as $r){
					if(!$ret)
						break;

					$record = array();
					$record['id_rab_penawaran_parent'] = $id_rab_penawaran_jasa;
					$record['uraian'] = $r['nama'];
					$record['nilai_satuan'] = $r['harga_satuan'];
					$record['vol'] = $r['vol'];
					$record['satuan'] = $r['satuan'];
					$record['id_rab_evaluasi'] = $id_rab_evaluasi;
					$record['sumber_nilai'] = 4;
					$record['sumber_satuan'] = 1;
					$ret = $this->conn->goInsert("rab_penawaran", $record);
				}
			}
		}


		if($ret){
			$record = array();
			$record['uraian'] = "ADMINISTRASI/ LAPORAN";
			$record['sumber_nilai'] = 1;
			$record['id_rab_evaluasi'] = $id_rab_evaluasi;
			$ret = $this->conn->goInsert("rab_penawaran", $record);
			if($ret){
				$id_rab_penawaran_laporan = $this->conn->GetOne("select max(id_rab_penawaran) from rab_penawaran where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

				$record = array();
				$record['id_rab_penawaran_parent'] = $id_rab_penawaran_laporan;
				$record['uraian'] = "Pembuatan Laporan";
				$record['nilai_satuan'] = 20000000;
				$record['vol'] = 1;
				$record['satuan'] = "Lot";
				$record['id_rab_evaluasi'] = $id_rab_evaluasi;
				$record['sumber_nilai'] = 4;
				$record['sumber_satuan'] = 1;
				$ret = $this->conn->goInsert("rab_penawaran", $record);
			}
		}

		return $ret;
	}

	public function Add($id_rab=0, $id_rab_penawaran_parent=null){
		$this->Edit($id_rab, 0, $id_rab_penawaran_parent);
	}


	public function Edit($id_rab=0,$id=null, $id_rab_penawaran_parent=null){

		if($this->post['act']=='reset'){
			redirect(current_url());
		}

		$this->_beforeDetail($id_rab,$id);

		$this->data['idpk'] = $id;

		$this->data['row'] = $this->model->GetByPk($id);
		if($id_rab_penawaran_parent)
			$this->data['row']['id_rab_penawaran_parent'] = $id_rab_penawaran_parent;

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

			$record['id_rab_evaluasi'] = $this->id_rab_evaluasi;
			$record['id_rab_penawaran_parent'] = $id_rab_penawaran_parent;

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

			$this->log("menghapus ".json_encode($this->data['row']));

			SetFlash('suc_msg', $return['success']);
			redirect("$this->page_ctrl/index/$id_rab");
		}
		else {
			SetFlash('err_msg',"Data gagal didelete");
			redirect("$this->page_ctrl/detail/$id_rab/$id");
		}

	}

	protected function _beforeDelete($id){
		$ret =  true;

		if($ret)
			$ret = $this->conn->Execute("delete from rab_penawaran_rab where id_rab_penawaran = ".$this->conn->escape($id));

		if($ret)
			$ret = $this->conn->Execute("delete from rab_penawaran_jabatan_proyek where id_rab_penawaran = ".$this->conn->escape($id));

		if($ret)
			$ret = $this->conn->Execute("delete from rab_penawaran_sumber_pegawai where id_rab_penawaran = ".$this->conn->escape($id));
		
		return $ret;
	}

	protected function _beforeDetail($id_rab=null, $id=null){
		$this->data['rowheader3'] = $this->conn->GetRow("select * from rab_evaluasi where id_rab = ".$this->conn->escape($id_rab));
		$this->data['id_rab_evaluasi'] = $this->id_rab_evaluasi = $this->data['rowheader3']['id_rab_evaluasi'];
		$this->data['id_rab'] = $id_rab;
		$this->data['rowheader2'] = $this->rabrab->GetByPk($id_rab);
		$this->data['id_proyek_pekerjaan'] = $id_proyek_pekerjaan = $this->data['rowheader2']['id_proyek_pekerjaan'];
		$this->data['rowheader1'] = $this->rabpekerjaan->GetByPk($id_proyek_pekerjaan);
		$this->data['id_proyek'] = $id_proyek = $this->data['rowheader1']['id_proyek'];
		$this->data['rowheader'] = $this->proyek->GetByPk($id_proyek);
		$this->data['editedheader'] = false;
		$this->data['modeheader'] = 'detail';
		$this->data['add_param'] .= $id_rab;
	}

	protected function Header(){
		return array(
			array(
				'name'=>'id_rab_penawaran_parent', 
				'label'=>'Niaga Penawaran Parent', 
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
				'name'=>'id_rab_evaluasi', 
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
			'addjustment'=>$this->post['addjustment'],
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
			$return['vol'] = $this->_hitungMdPenawaran($return);
			$return['satuan'] = 'MD';
			if($return['jenis_mandays']==1){
				$return['day'] = $this->post['day'];
				$return['satuan'] = $this->post['satuan'];
			}

		}elseif($return['sumber_satuan']=='3'){
			$return['vol'] = $this->_hitungMdPenawaran($return);
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
				$return['vol'] = $this->conn->GetOne("select sum(vol) from rab_e_detail where id_rab_detail in (".implode(", ",$this->conn->escape_string(array_keys($this->data['row']['id_rab_detail']))).") and id_rab_evaluasi = ".$this->conn->escape($this->data['id_rab_evaluasi']));
		}elseif($return['sumber_satuan']<>'4' and $return['sumber_nilai']=='3'){

			if($this->post['id_rab_detail']){
				if(!is_array($this->post['id_rab_detail']))
					$this->data['row']['id_rab_detail'] = array($this->post['id_rab_detail']=>$this->post['id_rab_detail']);
				else
					$this->data['row']['id_rab_detail'] = $this->post['id_rab_detail'];
			}

			if($this->data['row']['id_rab_detail'])
				$return['nilai_satuan'] = $this->conn->GetOne("select nilai_satuan from rab_e_detail where id_rab_detail = ".$this->conn->escape(key($this->data['row']['id_rab_detail']))." and id_rab_evaluasi = ".$this->conn->escape($this->data['id_rab_evaluasi']));

		}

		if($return['sumber_nilai']=='2'){
			$return['nilai_satuan'] = $this->conn->GetOne("select nilai from mt_harga_sppd_detail where id_zona_sppd = ".$this->conn->escape($this->data['rowheader']['id_zona_sppd'])." and id_harga_sppd = ".$this->conn->escape($return['id_harga_sppd']));
		}

		return $return;
	}

	protected function Rules(){
		return array(
			"id_rab_penawaran_parent"=>array(
				'field'=>'id_rab_penawaran_parent', 
				'label'=>'Niaga Penawaran Parent', 
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

		if($this->data['row']['id_rab_penawaran_parent'])
			$this->data['row']['uraian_parent'] = $this->conn->GetOne("select uraian from rab_penawaran where id_rab_penawaran = ".$this->conn->escape($this->data['row']['id_rab_penawaran_parent']));
		
		if($this->data['row']['sumber_satuan']==2 or $this->data['row']['sumber_satuan']==3 or $this->data['row']['sumber_nilai']==5){
			if($this->data['row']['sumber_nilai']<>5){
				if($this->post['act']!='set_value' && empty($this->post['id_jabatan_proyek'])){
					$this->data['row']['id_jabatan_proyek'] = $this->conn->GetList("select id_jabatan_proyek as key, id_jabatan_proyek as val 
						from rab_penawaran_jabatan_proyek 
						where id_rab_penawaran = ".$this->conn->escape($id));
				}
			}

			if($this->post['act']!='set_value' && empty($this->post['id_sumber_pegawai'])){
				$this->data['row']['id_sumber_pegawai'] = $this->conn->GetList("select id_sumber_pegawai as key, id_sumber_pegawai as val 
					from rab_penawaran_sumber_pegawai 
					where id_rab_penawaran = ".$this->conn->escape($id));
			}
		}

		if(!$this->data['row']['sumber_satuan'])
			$this->data['row']['sumber_satuan'] = 1;

		if($this->data['row']['sumber_nilai']=='3' or $this->data['row']['sumber_satuan']=='4'){
			$rows = $this->conn->GetArray("select a.*, nvl(nilai_satuan,0)*nvl(vol,1)*nvl(day,1) as nilai from rab_e_detail a where id_rab_evaluasi = ".$this->conn->escape($this->data['id_rab_evaluasi'])."
				order by nvl(id_rab_detail_parent, id_rab_detail), id_rab_detail, kode_biaya");

			$this->data['rowsrab'] = array();
			$i = 0;
			$this->GenerateTree($rows, "id_rab_detail_parent", "id_rab_detail", "uraian", $this->data['rowsrab'], null, $i, 0, "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");

			if(!$this->data['row']['id_rab_detail'] && $id)
				$this->data['row']['id_rab_detail'] = $this->conn->GetList("select id_rab_detail as key, id_rab_detail as val from rab_penawaran_rab where id_rab_penawaran = ".$this->conn->escape($id));


			$rows = $this->conn->GetArray("select a.*, nvl(vol,1)*nvl(harga_satuan,0) as nilai from rab_e_jasa_material a where id_rab_evaluasi = ".$this->conn->escape($this->data['id_rab_evaluasi']));

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

	private function _delsertJabatanProyek($id_rab_penawaran = null){
		$ret = $this->conn->Execute("delete from rab_penawaran_jabatan_proyek where id_rab_penawaran = ".$this->conn->escape($id_rab_penawaran));

		if(is_array($this->post['id_jabatan_proyek']) && count($this->post['id_jabatan_proyek'])){
			foreach($this->post['id_jabatan_proyek'] as $k=>$v){
				if(!$ret)
					break;

				$record = array();
				$record['id_rab_penawaran'] = $id_rab_penawaran;
				$record['id_jabatan_proyek'] = $k;

				$ret = $this->conn->goInsert("rab_penawaran_jabatan_proyek", $record);
			}
		}

		return $ret;
	}

	private function _delsertSumberPegawai($id_rab_penawaran = null){
		$ret = $this->conn->Execute("delete from rab_penawaran_sumber_pegawai where id_rab_penawaran = ".$this->conn->escape($id_rab_penawaran));

		if(is_array($this->post['id_sumber_pegawai']) && count($this->post['id_sumber_pegawai'])){
			foreach($this->post['id_sumber_pegawai'] as $k=>$v){
				if(!$ret)
					break;

				$record = array();
				$record['id_rab_penawaran'] = $id_rab_penawaran;
				$record['id_sumber_pegawai'] = $k;

				$ret = $this->conn->goInsert("rab_penawaran_sumber_pegawai", $record);
			}
		}
		return $ret;
	}

	private function _delsertRab($id_rab_penawaran = null){
		$ret = $this->conn->Execute("delete from rab_penawaran_rab where id_rab_penawaran = ".$this->conn->escape($id_rab_penawaran));

		if(!is_array($this->post['id_rab_detail']) && $this->post['id_rab_detail'])
			$this->post['id_rab_detail'] = array($this->post['id_rab_detail']=>$this->post['id_rab_detail']);

		if($this->post['id_rab_detail']){
			foreach($this->post['id_rab_detail'] as $k=>$v){
				if(!$ret)
					break;

				$record = array();
				$record['id_rab_penawaran'] = $id_rab_penawaran;
				$record['id_rab_detail'] = $k;

				if($this->post['sumber_nilai']==3)
					$record['is_nilai'] = 1;

				if($this->post['sumber_satuan']==4)
					$record['is_satuan'] = 1;

				$ret = $this->conn->goInsert("rab_penawaran_rab", $record);
			}
		}
		return $ret;
	}

	protected function rab_penawaran(){
		$this->data['rows'] = array();

		#niaga penawaran
		$rows = $this->conn->GetArray("select * from rab_penawaran where id_rab_evaluasi = ".$this->conn->escape($this->id_rab_evaluasi)." order by id_rab_penawaran");

		foreach($rows as $r){
			$this->data['rows'][(int)$r['id_rab_penawaran_parent']][$r['id_rab_penawaran']] = $r;
		}
	}
}