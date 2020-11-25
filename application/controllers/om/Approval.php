<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Approval extends _Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('om_helper');
		$this->load->model("om/Global_model");
	}

	public function approval_action()
	{
		// exit;
		$result = 0;
		$this->load->library('form_validation');

		$this->form_validation->set_message('integer', '%s Hanya Boleh diisi Angka');
		$this->form_validation->set_message('numeric', '%s Hanya Boleh diisi Angka');
		$this->form_validation->set_message('matches', '%s Tidak sama dengan %s');
		$this->form_validation->set_message('required', '%s Wajib diisi');

		$kode	  = $this->input->post('id');

		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		$result = [];
		if ($this->form_validation->run() == FALSE) {
			$result['valid'] = 0;
			$result['msg']	 = validation_errors('- ', ' ');;
			$result['url']	 = '';

			echo json_encode($result);
			exit;
		}

		$data_doc['status'] = $this->input->post('status');
		$data_doc['id'] = $this->input->post('id');
		$data_doc['keterangan'] = $this->input->post('keterangan');
		$data_doc['lampiran'] = $this->input->post('lampiran', '');

		// echo '<pre>';print_r($data_doc);exit;
		//$rs = $this->mod->save($kode,$data_doc);
		// parent

		$detail = $this->Global_model->get_detail($data_doc['id']);
		$rs = 0;
		$url = '/';
		switch ($data_doc['status']) {
			case 10:
				# create peluang
				break;

			case 20:
				# create wo
				break;

			case 30:
				# create proposal
				$tabel 	= 't_proposal';
				$key 	= 'id_proposal';
				$data['REF_ID'] = $data_doc['id'];
				$data['NAMA'] 	= 'Proposal from WO :' . $detail['nama'];
				$data['JENIS_NIAGA'] 	= $detail['jenis_niaga'];
				// debug($data);exit;
				$this->db->insert(up($tabel), $data);
				$last_id = $this->Global_model->last_id($tabel, $key);
				$rs = 1;

				if ($detail['jenis_niaga'] == 2) {
					// om					
					$url = 'panelbackend/t_proposal/edit/' . $last_id;
				} else {
					$url = 'panelbackend/t_proyekproposal/edit/' . $last_id;
				}
				break;
			case 40:
				# create negosiasi

				$tabel 	= 't_negosiasi';
				$key 	= 'id_nego';
				$detail_proposal = $this->Global_model->get_detail($data_doc['id'], 't_proposal', 'ref_id');
				$data['REF_ID'] = $data_doc['id'];
				$data['ID_PROPOSAL'] = $detail_proposal['id_proposal'];
				$data['JUDUL_NEGO'] 	= 'NEGO :' . $detail['nama'];
				$data['JENIS_NIAGA'] 	= $detail['jenis_niaga'];
                $this->db->insert(up($tabel), $data);
                
                // insert into opportunities
				$detail_pegawai = $this->Global_model->get_detail("'".$detail['pic_id']."'", 'MT_PEGAWAI', 'NID');
				$detail_customer = $this->Global_model->get_detail($detail['id_customer'], 'CUSTOMER', 'ID_CUSTOMER');
				$data2['NAMA'] 	= $detail['nama'];
				$data2['ID_JENIS_OPPORTUNITIES'] = $detail['jenis_niaga'];
				$data2['ID_TIPE_OPPORTUNITIES'] = $detail['jenis_rkap'];
				$data2['TAHUN_RENCANA'] 	=date('Y');
				$data2['TANGGAL'] 	= $detail['tanggal'];
				$data2['ID_PIC'] 	= $detail['pic_id'];
				$data2['STATUS'] 	= 1;
				$data2['PERKIRAAN_NILAI_KONTRAK'] 	= $detail['nilai'];
				$data2['NAMA_PIC'] 	= (isset($detail_pegawai['nama']))?$detail_pegawai['nama']:'';
				$data2['ID_CUSTOMER'] 	= $detail['id_customer'];
                $data2['NAMA_CUSTOMER'] 	= (isset($detail_customer['nama']))?$detail_customer['nama']:'';
                
                $this->db->insert('OPPORTUNITIES', $data2);
                


				$last_id = $this->Global_model->last_id($tabel, $key);
				$rs = 1;
				if ($detail['jenis_niaga'] == 2) {

					// om
					$url = 'panelbackend/t_negosiasi/edit/' . $last_id;
				} else {
					$url = 'panelbackend/t_proyeknegosiasi/edit/' . $last_id;
				}
				break;
			case 50:
				# create kontrak
				$data['REF_ID'] = $data_doc['id'];
				if(!empty($_FILES['lampiran']['name']))
				{
					$data_doc['lampiran'] = $this->_uploadFile('kontrak_'.date('YmdHis').'_'.$data_doc['id']);
				}

				if ($detail['jenis_niaga'] == 2) {
					// om
					$tabel 	= 't_kontrak';
					$key 	= 'id_kontrak';
					// $data['REF_ID'] = $data_doc['id'];
					$data['ID_CUSTOMER'] = $detail['id_customer'];
					$data['NAMA'] 	= 'KONTRAK :' . $detail['nama'];
					$data['JENIS_NIAGA'] 	= $detail['jenis_niaga'];
					$data['FILE_KONTRAK'] 	= $data_doc['lampiran'];
					$this->db->insert(up($tabel), $data);
					$last_id = $this->Global_model->last_id($tabel, $key);

					// history
					$tabel 	= 't_kontrak_hist';
					$key 	= 'id_kontrak_hist';
					$data2['ID_KONTRAK'] = $last_id;
					$data2['NAMA'] 	= 'KONTRAK AWAL:' . $detail['nama'];
					$data2['NO_PIHAK1'] 	= $detail['no_kontrak'];
					$data2['TGL_SELESAI'] 	= $detail['tgl_akhir'];
					
					$this->db->insert(up($tabel), $data2);

					$rs = 1;
					$url = 'panelbackend/t_kontrak/edit/' . $last_id;
				} else {
					$tabel 	= 'proyek';
					$key 	= 'id_proyek';
					// $data['REF_ID'] = $data_doc['id'];
					$data['ID_CUSTOMER'] = $detail['id_customer'];
					$data['NAMA_PROYEK'] 	= 'Proposal from WO :' . $detail['nama'];
					$data['ID_PIC'] = trim($detail['pic_id']);
					$data['TGL_RENCANA_MULAI'] = date('d-M-Y');
					$data['TGL_REALISASI_MULAI'] = date('d-M-Y');
					$data['CREATED_DATE'] = date('d-M-Y H:i:s');
					
					
				
					// debug($data);
					// exit;
					$this->db->insert(up($tabel), $data);
					$last_id = $this->Global_model->last_id($tabel, $key);
					
					$data = [];
					$tabel 	= 't_kontrak_proyek';
					$key 	= 'id_kontrak_proyek';
					$data['REF_ID'] = $data_doc['id'];
					// $data['ID_CUSTOMER'] = $detail['id_customer'];
					$data['NAMA'] 	= 'KONTRAK :' . $detail['nama'];
					// $data['JENIS_NIAGA'] 	= $detail['jenis_niaga'];

					$this->db->insert(up($tabel), $data);
					$last_id = $this->Global_model->last_id($tabel, $key);
					
					
					$rs = 1;
					$url = 'panelbackend/mon_settlement_proyek/detail/' . $last_id;
				}
				//status harusnya closed
				$data_doc['status'] = $this->Global_model->STATUS_CLOSED;

				break;

			default:
				# code...
				break;
		}

		// $hist['REF'] = 'WO';
		// $hist['REF_ID'] = $data_doc['id'];
		// $hist['TGL'] = date('d-M-Y H:i:s');
		// $hist['DESKRIPSI'] = $data_doc['keterangan'];
		// $hist['STATUS'] = $data_doc['status'];
		// $hist['USER'] = 'USERS';
		// $hist['LAMPIRAN'] = $data_doc['lampiran'];
		// debug($data_doc);
		// exit;
		$this->Global_model->insert_log('WO',$data_doc['id'],$data_doc['keterangan'], $data_doc['status'],'USERS',$data_doc['lampiran']);
		// $this->db->insert('R_HISTORY', $hist);

		$this->Global_model->update_wo($data_doc['id'],array('STATUS'=>$data_doc['status']));

		$result['valid'] = ($rs == 1) ? true : false;
		$result['msg']	 = ($rs != 1) ? $rs : '';
		$result['url']	 = $url;

		echo json_encode($result);
	}

	private function _uploadFile($name)
	{
		$config['upload_path']          = './uploads/kontrak';
		$config['allowed_types']        = 'pdf';
		$config['file_name']            = $name;
		$config['overwrite']			= true;
		$config['max_size']             = 1024; // 1MB
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;
		if (!is_dir($config['upload_path'])) {
			mkdir($config['upload_path'],0755,TRUE);
		}


		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('lampiran'))
		{
			echo $this->upload->display_errors('', '');exit;
		}else
		{
			$data = $this->upload->data();
			return $data['file_name'];
		}	


		return null;
	}
}
