<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mon_settelment_proyek extends _Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('om_helper');
		$this->load->model("om/Global_model");
	}

	public function save_detail()
	{
		$this->db->trans_begin();
		$post = $this->input->post();
		$id = uuid();
		$rs = $this->db->where('KONTRAKPROYEK_ID',$post['KONTRAKPROYEK_ID'])->get('T_KONTRAK_PROYEK_DETAIL');
		
		$this->db->set('KONTRAKPROYEK_ID', $post['KONTRAKPROYEK_ID']);
		$this->db->set('UNIT_KERJA', $post['UNIT_KERJA']);
		$this->db->set('RKAP', $post['RKAP']);
		$this->db->set('STATUS_FISIK', $post['STATUS_FISIK']);
		$this->db->set('STATUS_NIAGA', $post['STATUS_NIAGA']);
		$this->db->set('STATUS_PROYEK', $post['STATUS_PROYEK']);
		$this->db->set('STATUS_SETTLEMENT', $post['STATUS_SETTLEMENT']);
		$this->db->set('TAHUN_PROYEK', $post['TAHUN_PROYEK']);
		$this->db->set('NO_PRK', $post['NO_PRK']);

		if($rs->num_rows())
		{
			$r = $rs->row();
			$this->db->where('ID',$r->id);
            
			$this->db->set('UPDATED_AT',"SYSDATE",false);
			$this->db->set('UPDATED_BY',$_SESSION['SESSION_APP_EBISNIS']['user_id']);
			$this->db->update('T_KONTRAK_PROYEK_DETAIL');
		}
		else
		{
			$this->db->set('ID', $id);
            
			$this->db->set('CREATED_AT',"SYSDATE",false);
			$this->db->set('CREATED_BY',$_SESSION['SESSION_APP_EBISNIS']['user_id']);
			$this->db->insert('T_KONTRAK_PROYEK_DETAIL');
		}
		if($this->db->trans_status() === true)
		{
			$this->db->trans_commit();
			echo 'Tersimpan';
		}
		else
		{
			$this->db->trans_rollback();
			echo 'Tidak Tersimpan, silahkan ulangi lagi';
		}
	}

	public function save_preparation()
	{
		$this->load->helper('s_helper');
		$this->db->trans_begin();
		$post = $this->input->post();
		$id = uuid();
		$rs = $this->db->where('KONTRAKPROYEK_ID',$post['KONTRAKPROYEK_ID'])->get('T_KONTRAK_PROYEK_PREPARATION');
		
		$ihTgl = $post['PERMINTAAN_IH_TGL'];
		$infoTgl = $post['INFORMASI_HARGA_TGL'];
		$kesepakatanTgl = $post['KESEPAKATAN_HARGA_TGL'];
		$rendalTgl = $post['RAB_RENDAL_TGL'];
		
		$this->db->set('KONTRAKPROYEK_ID', $post['KONTRAKPROYEK_ID']);
		$this->db->set('PRICING', Rupiah2Number($post['PRICING']));
		$this->db->set('RAB_KOMERSIAL', Rupiah2Number($post['RAB_KOMERSIAL']));
		$this->db->set('PERMINTAAN_IH_NOMOR', $post['PERMINTAAN_IH_NOMOR']);
		$this->db->set('INFORMASI_HARGA_NOMOR', $post['INFORMASI_HARGA_NOMOR']);
		$this->db->set('KESEPAKATAN_HARGA_NOMOR', $post['KESEPAKATAN_HARGA_NOMOR']);
		$this->db->set('KESEPAKATAN_HARGA_NILAI', Rupiah2Number($post['KESEPAKATAN_HARGA_NILAI']));
		$this->db->set('RAB_RENDAL_NILAI', Rupiah2Number($post['RAB_RENDAL_NILAI']));
		$this->db->set('ANALISA_LR_NPM', $post['ANALISA_LR_NPM']);
		$this->db->set('ANALISA_LR_GPM', $post['ANALISA_LR_GPM']);

		$this->db->set('PERMINTAAN_IH_TGL',"to_date('$ihTgl','dd-mm-yyyy')",false);
		$this->db->set('INFORMASI_HARGA_TGL',"to_date('$ihTgl','dd-mm-yyyy')",false);
		$this->db->set('KESEPAKATAN_HARGA_TGL',"to_date('$infoTgl','dd-mm-yyyy')",false);
		$this->db->set('RAB_RENDAL_TGL',"to_date('$kesepakatanTgl','dd-mm-yyyy')",false);

		if($rs->num_rows())
		{
			$r = $rs->row();
			$this->db->where('ID',$r->id);
            
			$this->db->set('UPDATED_AT',"SYSDATE",false);
			$this->db->set('UPDATED_BY',$_SESSION['SESSION_APP_EBISNIS']['user_id']);
			$this->db->update('T_KONTRAK_PROYEK_PREPARATION');
		}
		else
		{
			$this->db->set('ID', $id);
            
			$this->db->set('CREATED_AT',"SYSDATE",false);
			$this->db->set('CREATED_BY',$_SESSION['SESSION_APP_EBISNIS']['user_id']);
			$this->db->insert('T_KONTRAK_PROYEK_PREPARATION');
		}
		if($this->db->trans_status() === true)
		{
			$this->db->trans_commit();
			echo 'Tersimpan';
		}
		else
		{
			$this->db->trans_rollback();
			echo 'Tidak Tersimpan, silahkan ulangi lagi';
		}
	}

	public function get_preparation()
	{
		# code...
	}
	public function save_finishing()
	{
		$this->db->trans_begin();
		$post = $this->input->post();
		$id = uuid();
		$rs = $this->db->where('KONTRAKPROYEK_ID',$post['KONTRAKPROYEK_ID'])->get('T_KONTRAK_PROYEK_FINISHING2');
		$tglDibayar = $this->input->post('TANGGAL_DIBAYAR');
		if($rs->num_rows())
		{
			$r = $rs->row();
			$this->db->where('ID',$r->id);

            $this->db->set('EVALUASI_PEKERJAAN', $this->input->post('EVALUASI_PEKERJAAN'));
			$this->db->set('TANGGAL_DIBAYAR',"to_date('$tglDibayar','dd-mm-yyyy')",false);
			$this->db->set('UPDATED_AT',"SYSDATE",false);
			$this->db->set('UPDATED_BY',$_SESSION['SESSION_APP_EBISNIS']['user_id']);
			$this->db->update('T_KONTRAK_PROYEK_FINISHING2');
		}
		else
		{
			$this->db->set('ID', $id);
            $this->db->set('KONTRAKPROYEK_ID', $this->input->post('KONTRAKPROYEK_ID'));
            $this->db->set('EVALUASI_PEKERJAAN', $this->input->post('EVALUASI_PEKERJAAN'));
			$this->db->set('TANGGAL_DIBAYAR',"to_date('$tglDibayar','dd-mm-yyyy')",false);
			$this->db->set('CREATED_AT',"SYSDATE",false);
			$this->db->set('CREATED_BY',$_SESSION['SESSION_APP_EBISNIS']['user_id']);
			$this->db->insert('T_KONTRAK_PROYEK_FINISHING2');
		}
		if($this->db->trans_status() === true)
		{
			$this->db->trans_commit();
			echo 'Tersimpan';
		}
		else
		{
			$this->db->trans_rollback();
			echo 'Tidak Tersimpan, silahkan ulangi lagi';
		}
	}

	public function save_finishing_list()
	{
		$filename = $_FILES['LAMPIRAN_FINISHING']['name'];
		$this->db->trans_begin();
		$uuid = uuid();
		if($_FILES['LAMPIRAN_FINISHING']['name'])
		{
			$config['upload_path'] = './uploads/finishing/';
	        if (!is_dir($config['upload_path'])) {
	            mkdir($config['upload_path'], 0755, TRUE);
	        }
	        $config['allowed_types'] = '*';
	        ;
	        $this->load->library('upload', $config);
	        if (!$this->upload->do_upload('LAMPIRAN_FINISHING')) {
	            echo $this->upload->display_errors('', '');
	            exit;
	        } else {
	            $data = $this->upload->data();

	            $tglFinishing = $this->input->post('TANGGAL_FINISHING');

	            $this->db->set('ID', $uuid);
	            $this->db->set('KONTRAKPROYEK_ID', $this->input->post('KONTRAK_PROYEK_ID'));
	            $this->db->set('JENIS_FINISHING', $this->input->post('JENIS_FINISHING'));
				$this->db->set('NOMOR_FINISHING', $this->input->post('NOMOR_FINISHING'));
				$this->db->set('LAMPIRAN_FINISHING', $data['file_name']);
				$this->db->set('TANGGAL_FINISHING',"to_date('$tglFinishing','dd-mm-yyyy')",false);
				$this->db->set('CREATED_AT',"SYSDATE",false);
				$this->db->set('CREATED_BY',$_SESSION['SESSION_APP_EBISNIS']['user_id']);
				$this->db->insert('T_KONTRAK_PROYEK_FINISHING1');
	        }
		}
		if($this->db->trans_status() === true)
		{

			$this->db->trans_commit();
			$row = $this->db->where('ID',$uuid)->get('T_KONTRAK_PROYEK_FINISHING1')->row_array();
			$row['status'] = true;
			$row['msg'] = 'Tersimpan';
			echo json_encode($row);
		}
		else
		{
			$this->db->trans_rollback();
			echo json_encode(['msg'=>'Tidak Tersimpan, silahkan ulangi lagi']);
		}
	}

	public function save_dokumen_list()
	{
		$filename = $_FILES['LAMPIRAN_DOKUMEN']['name'];
		$this->db->trans_begin();
		$uuid = uuid();
		if($_FILES['LAMPIRAN_DOKUMEN']['name'])
		{
			$config['upload_path'] = './uploads/dokumen/';
	        if (!is_dir($config['upload_path'])) {
	            mkdir($config['upload_path'], 0755, TRUE);
	        }
	        $config['allowed_types'] = '*';
	        ;
	        $this->load->library('upload', $config);
	        if (!$this->upload->do_upload('LAMPIRAN_DOKUMEN')) {
	            echo $this->upload->display_errors('', '');
	            exit;
	        } else {
	            $data = $this->upload->data();

	            $this->db->set('ID', $uuid);
	            $this->db->set('KONTRAKPROYEK_ID', $this->input->post('KONTRAK_PROYEK_ID'));
	            $this->db->set('JENIS_DOKUMEN', $this->input->post('JENIS_DOKUMEN'));
				$this->db->set('LAMPIRAN_DOKUMEN', $data['file_name']);
				$this->db->set('CREATED_AT',"SYSDATE",false);
				$this->db->set('CREATED_BY',$_SESSION['SESSION_APP_EBISNIS']['user_id']);
				$this->db->insert('T_KONTRAK_PROYEK_DOKUMEN');
	        }
		}
		if($this->db->trans_status() === true)
		{

			$this->db->trans_commit();
			$row = $this->db->where('ID',$uuid)->get('T_KONTRAK_PROYEK_DOKUMEN')->row_array();
			$row['status'] = true;
			$row['msg'] = 'Tersimpan';
			echo json_encode($row);
		}
		else
		{
			$this->db->trans_rollback();
			echo json_encode(['msg'=>'Tidak Tersimpan, silahkan ulangi lagi']);
		}
	}

	public function save_pihak_ketiga()
	{
		$filename = $_FILES['LAMPIRAN_FINISHING']['name'];
		$this->db->trans_begin();
		$uuid = uuid();
		$this->db->set('ID', $uuid);
        $this->db->set('KONTRAKPROYEK_ID', $this->input->post('KONTRAKPROYEK_ID'));
        $this->db->set('NAMA_PERUSAHAAN', $this->input->post('NAMA_PERUSAHAAN'));
		$this->db->set('NAMA_PEKERJAAN', $this->input->post('NAMA_PEKERJAAN'));
		$this->db->set('NILAI_PEKERJAAN', $this->input->post('NILAI_PEKERJAAN'));
		$this->db->set('CREATED_AT',"SYSDATE",false);
		$this->db->set('CREATED_BY',$_SESSION['SESSION_APP_EBISNIS']['user_id']);
		$this->db->insert('T_KONTRAK_PROYEK_PIHAK3');

		if($this->db->trans_status() === true)
		{

			$this->db->trans_commit();
			$row = $this->db->where('ID',$uuid)->get('T_KONTRAK_PROYEK_PIHAK3')->row_array();
			$row['status'] = true;
			$row['msg'] = 'Tersimpan';
			echo json_encode($row);
		}
		else
		{
			$this->db->trans_rollback();
			echo json_encode(['msg'=>'Tidak Tersimpan, silahkan ulangi lagi']);
		}
	}
	public function delete_finishing_detail($id='')
	{
		$this->load->helper('file');

		$kontrak = $this->db->where('ID',$id)->get('T_KONTRAK_PROYEK_FINISHING1')->row();

		delete_files('./uploads/finishing/'.$kontrak->LAMPIRAN_FINISHING);

		$this->db->where('ID',$id)->delete('T_KONTRAK_PROYEK_FINISHING1');
		echo $id;
	}

	public function delete_dokumen_detail($id='')
	{
		$this->load->helper('file');

		$kontrak = $this->db->where('ID',$id)->get('T_KONTRAK_PROYEK_DOKUMEN')->row();

		delete_files('./uploads/dokumen/'.$kontrak->LAMPIRAN_DOKUMEN);

		$this->db->where('ID',$id)->delete('T_KONTRAK_PROYEK_DOKUMEN');
		echo $id;
	}

	public function delete_pihak_ketiga($id='')
	{
		$this->db->where('ID',$id)->delete('T_KONTRAK_PROYEK_PIHAK3');
		echo $id;
	}

	public function save_execution()
	{
		$uuid = uuid();
		$post = $this->input->post();
		$kontrakTgl = $post['KONTRAK_TGL'];
		$rencanaMulai = $post['RENCANA_MULAI'];
		$rencanaSelesai = $post['RENCANA_SELESAI'];
		$aktualMulai = $post['AKTUAL_MULAI'];
		$aktualSelesai = $post['AKTUAL_SELESAI'];
		$tglBukaPrk = $post['TGL_BUKA_PRK'];
		
		$rs = $this->db->where('KONTRAKPROYEK_ID',$post['KONTRAKPROYEK_ID'])->get('T_KONTRAK_PROYEK_EXE');

		$this->db->trans_begin();
		
        $this->db->set('KONTRAKPROYEK_ID', $post['KONTRAKPROYEK_ID']);
        $this->db->set('KONTRAK_NOMOR', $post['KONTRAK_NOMOR']);
		$this->db->set('KONTRAK_TGL',"to_date('$kontrakTgl','dd-mm-yyyy')",false);
        $this->db->set('KONTRAK_NILAI', $post['KONTRAK_NILAI']);
        $this->db->set('DURASI', $post['DURASI']);
        $this->db->set('PROGRESS_FISIK', $post['PROGRESS_FISIK']);

		$this->db->set('RENCANA_MULAI',"to_date('$rencanaMulai','dd-mm-yyyy')",false);
		$this->db->set('RENCANA_SELESAI',"to_date('$rencanaSelesai','dd-mm-yyyy')",false);
		$this->db->set('AKTUAL_MULAI',"to_date('$aktualMulai','dd-mm-yyyy')",false);
		$this->db->set('AKTUAL_SELESAI',"to_date('$aktualSelesai','dd-mm-yyyy')",false);
		$this->db->set('TGL_BUKA_PRK',"to_date('$tglBukaPrk','dd-mm-yyyy')",false);

        $this->db->set('TIPE_PEKERJAAN', $post['TIPE_PEKERJAAN']);
        $this->db->set('MANAJER_PROYEK', $post['MANAJER_PROYEK']);
        $this->db->set('JUMLAH_PERSONIL', $post['JUMLAH_PERSONIL']);
        $this->db->set('KENDALA_TINDAK_LANJUT', $post['KENDALA_TINDAK_LANJUT']);
        $this->db->set('LAPORAN', $post['LAPORAN']);
        $this->db->set('NO_PRK', $post['NO_PRK']);

		if($rs->num_rows() > 0)
		{
			$this->db->set('UPDATED_AT',"SYSDATE",false);
			$this->db->set('UPDATED_BY',$_SESSION['SESSION_APP_EBISNIS']['user_id']);
			$this->db->update('T_KONTRAK_PROYEK_EXE');
		}
		else
		{
			$this->db->set('ID', $uuid);
			$this->db->set('CREATED_AT',"SYSDATE",false);
			$this->db->set('CREATED_BY',$_SESSION['SESSION_APP_EBISNIS']['user_id']);
			$this->db->insert('T_KONTRAK_PROYEK_EXE');
		}

		// update kontrak proyek
		$proyek['KONTRAK_NO'] = $post['KONTRAK_NOMOR'];
		$proyek['KONTRAK_TGL'] = date_format(date_create($post['KONTRAK_TGL']),'d-M-Y');
		$proyek['KONTRAK_NILAI'] = $post['KONTRAK_NILAI'];
		$proyek['DURASI'] = $post['DURASI'];
		$proyek['RENCANA_TGL_MULAI'] = date_format(date_create($post['RENCANA_MULAI']),'d-M-Y');
		$proyek['RENCANA_TGL_SELESAI'] = date_format(date_create($post['RENCANA_SELESAI']),'d-M-Y');
		$proyek['TGL_MULAI'] = date_format(date_create($post['AKTUAL_MULAI']),'d-M-Y');
		$proyek['TGL_SELESAI'] = date_format(date_create($post['AKTUAL_SELESAI']),'d-M-Y');
		$proyek['NO_PRK'] = $post['NO_PRK'];
		$proyek['TGL_PRK'] = date_format(date_create($post['TGL_BUKA_PRK']),'d-M-Y');

		// var_dump($proyek);

		$this->db->where('ID_KONTRAK_PROYEK',$post['KONTRAKPROYEK_ID']);
		$this->db->update('T_KONTRAK_PROYEK',$proyek);

		if($this->db->trans_status() === true)
		{
			$this->db->trans_commit();
			echo 'Tersimpan';
		}
		else
		{
			$this->db->trans_rollback();
			echo 'Tidak Tersimpan, silahkan ulangi lagi';
		}
	}

}