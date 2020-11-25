
		<?php
		defined('BASEPATH') or exit('No direct script access allowed');

		include APPPATH . "core/_omController.php";
		class T_proyekwo_prospek extends _omController
		{

			public function __construct()
			{
				parent::__construct();
				$this->load->library("UI");
				
				$_SESSION['menu_id'] = 1096;
				$this->modul = 't_proyekwo_prospek';
				$this->load->model('om/t_proyekwo_prospek_model', 'mod');

				$this->menuarr = $this->Global_model->GetComboMenu();
				$this->load->model("CustomerModel","customermodel");
				$this->load->model("Mt_pegawaiModel","pegawaimodel");
				$this->load->model("Mt_jenis_opportunitiesModel","niagamodel");
				$this->customerarr = $this->customermodel->GetCombo();
				$this->pegawaiarr = $this->pegawaimodel->GetCombo();
				$this->niagaarr = $this->niagamodel->GetCombo(" where ID_JENIS_OPPORTUNITIES = 1 ");
				unset($this->niagaarr['']);
				$this->jenisarr = $this->Global_model->GetJenisArr('jenis_wo');
				$this->jenisrkaparr = $this->Global_model->GetJenisArr('jenis_rkap');
				$this->statusarr = $this->Global_model->GetStatusArr();
				$this->load->model("M_wocatModel","wocat");
				$this->load->model("M_wocreate","wocreate");
				$this->data['userStatus'] = $this->wocat->GetCombo("where CATEGORY = 'USER_STATUS'");
				$this->data['woType'] = $this->wocat->GetCombo("where CATEGORY = 'WO_TYPE'");
				$this->data['mType'] = $this->wocat->GetCombo("where CATEGORY = 'M_TYPE'");
				/*$this->data['s1'] = $this->macan('acc_code1');
				$this->data['s2'] = $this->macan("acc_code2");
				$this->data['s3'] = $this->macan("acc_code3");
				$this->data['s4'] = $this->macan("acc_code4");
				$this->data['s5'] = $this->macan("acc_code5");
				$this->data['s6'] = $this->macan("acc_code6");
				$this->data['s7'] = $this->macan("acc_code7");*/
			
			}

			function other_setting()
			{
				$set[1]['name']  = 'user_status';
				$set[1]['label'] = 'User Status';
				$set[1]['width'] = 'auto';
				$set[1]['type']  = 'varchar2';
				$set[1]['value'] = [null=>'Pilih Status'];
				$set[1]['required'] = false;
				
				$set[2]['name']  = 'work_order_type';
				$set[2]['label'] = 'WO Type';
				$set[2]['width'] = 'auto';
				$set[2]['type']  = 'varchar2';
				$set[2]['value'] = [null=>'Pilih type'];
				$set[2]['required'] = false;
				
				$set[3]['name']  = 'maintenance_type';
				$set[3]['label'] = 'Maintenance Type';
				$set[3]['width'] = 'auto';
				$set[3]['type']  = 'varchar2';
				$set[3]['value'] = [null=>'Pilih Maintenance'];
				$set[3]['required'] = false;
			
				$set[4]['name']  = 'work_group';
				$set[4]['label'] = 'Workgroup';
				$set[4]['width'] = 'auto';
				$set[4]['type']  = 'varchar2';
				// $set[4]['value'] = '';
				$set[4]['required'] = false;
			
				$set[5]['name']  = 'account_code';
				$set[5]['label'] = 'Account Code';
				$set[5]['width'] = 'auto';
				$set[5]['type']  = 'varchar2';
				// $set[5]['value'] = '';
				$set[5]['required'] = false;
				
				$set[6]['name']  = 's1';
				$set[6]['label'] = 'Segment 1';
				$set[6]['width'] = 'auto';
				$set[6]['type']  = 'varchar2';
				$set[6]['value'] = [null=>'Pilih Segment'];
				$set[6]['required'] = false;
				
				$set[7]['name']  = 's2';
				$set[7]['label'] = 'Segment 2';
				$set[7]['width'] = 'auto';
				$set[7]['type']  = 'varchar2';
				$set[7]['value'] = [null=>'Pilih Segment'];
				$set[7]['required'] = false;

				$set[8]['name']  = 's3';
				$set[8]['label'] = 'Segment 3';
				$set[8]['width'] = 'auto';
				$set[8]['type']  = 'varchar2';
				$set[8]['value'] = [null=>'Pilih Segment'];
				$set[8]['required'] = false;

				$set[9]['name']  = 's4';
				$set[9]['label'] = 'Segment 4';
				$set[9]['width'] = 'auto';
				$set[9]['type']  = 'varchar2';
				$set[9]['value'] = [null=>'Pilih Segment'];
				$set[9]['required'] = false;

				$set[10]['name']  = 's5';
				$set[10]['label'] = 'Segment 5';
				$set[10]['width'] = 'auto';
				$set[10]['type']  = 'varchar2';
				$set[10]['value'] = [null=>'Pilih Segment'];
				$set[10]['required'] = false;

				$set[11]['name']  = 's6';
				$set[11]['label'] = 'Segment 6';
				$set[11]['width'] = 'auto';
				$set[11]['type']  = 'varchar2';
				$set[11]['value'] = [null=>'Pilih Segment'];
				$set[11]['required'] = false;

				$set[12]['name']  = 's7';
				$set[12]['label'] = 'Segment 7';
				$set[12]['width'] = 'auto';
				$set[12]['type']  = 'varchar2';
				$set[12]['value'] = [null=>'Pilih Segment'];
				$set[12]['required'] = false;

				return $set;
			}

			public function index()
			{
				$this->data['title'] 		= 'Daftar WO Prospek';		
				$this->data['subtitle'] 	= 'isi WO Prospek';	
				parent::index();
			}

			public function form($kode = 0)
			{
                // $this->data['s1'] = $this->wocat->GetCombo("where CATEGORY = 'S1'");
				// $this->data['s2'] = $this->wocat->GetCombo("where CATEGORY = 'S2'");
				// $this->data['s3'] = $this->wocat->GetCombo("where CATEGORY = 'S3'");
				// $this->data['s4'] = $this->wocat->GetCombo("where CATEGORY = 'S4'");
				// $this->data['s5'] = $this->wocat->GetCombo("where CATEGORY = 'S5'");
				// $this->data['s6'] = $this->wocat->GetCombo("where CATEGORY = 'S6'");
				// $this->data['s7'] = $this->wocat->GetCombo("where CATEGORY = 'S7'");
				// $this->data['ee'] = $this->wocat->GetCombo("where CATEGORY = 'EE'");
				// $this->data['session_wo'] = $this->session_wo();
			
				$this->data['title'] 		= 'Form WO Prospek';		
				$this->data['subtitle'] 	= 'isi WO Prospek';	
				$this->data['label_setting2'] 		= $this->other_setting();
				$this->data['xEdit'] = 1;
				$this->data['xDetail'] = 1;
				if($kode > 0)
				{
					$this->data['xDetail'] = 1;
					$this->data['xEdit'] = 0;
				}
				parent::form($kode);
				
			}
			public function detail($kode = 0)
			{
			
				$this->data['title'] 		= 'Detail WO Prospek';		
				$this->data['subtitle'] 	= 'isi WO Prospek';	
				$this->data['label_setting2'] 		= $this->other_setting();
				$this->data['readonly'] 	= true;	
				$this->data['xDetail'] = 1;
				if($kode > 0)
				{
					$this->data['xDetail'] = 0;
				}
				$this->data['label_setting2'] 		= $this->other_setting();
				parent::form($kode);
				
			}
			

			public function ajax_list()
			{
				echo parent::ajax_list();
				
			}

			public function session_wo($value='sess_wo')
			{
				// return [ 0 => ['A'=>1]];
                $rows = json_decode(@file_get_contents($this->config->item($value)), true);
				$data = [];
				if(count($rows) > 0)
				{
					foreach ($rows as $r) {
						$data[$r['WORK_ORDER']] = $r['WO_DESC'];
					}
                }
                
				return $data;
			}
			public function form_action(){
				/*print_r($this->input->post());
			exit();*/
				$result = 0;
				$this->load->library('form_validation');
				//$setting = $this->setting();
				/*$list_setting = $this->_list_setting();
				
				$this->form_validation->set_message('integer', '%s Hanya Boleh diisi Angka');
				$this->form_validation->set_message('numeric', '%s Hanya Boleh diisi Angka');
				$this->form_validation->set_message('matches', '%s Tidak sama dengan %s');
				$this->form_validation->set_message('required', '%s Wajib diisi');*/
				
				$kode	  = $this->input->post('row_id');
				
				/*foreach($list_setting as $k=>$rw){
					$required = ($rw['required']&&!$rw['hidden'])?'|required':'';
					$this->form_validation->set_rules($k,$rw['label'],'trim'.$required);
				}*/
				
				
				
				/*if ($this->form_validation->run() == FALSE) 
				{
					echo validation_errors('- ', ' ');exit;
				}*/
				
				
				/*foreach($list_setting as $k=>$rw){
					if($rw['hidden'])continue;
					if($rw['type']=='date')
					{
						$data_doc[up($k)] = date_format(date_create($this->input->post($k)),'d-M-Y');
					}else{
						if($rw['class']=='rupiah'){

							$data_doc[up($k)] = Rupiah2Number($this->input->post($k));
						}else{

							$data_doc[up($k)] = $this->input->post($k);
						}
					}
				}*/

				$post = $this->input->post();
				$ellipse = false;
				if($kode)
				{
					$ellipse =$this->update_ellipse($post);
				}
				else
				{
					$ellipse =$this->store_ellipse($post);		
				}

				if($ellipse)
				{
					if($kode)
					{
						$data_doc = [
							'ID_CUSTOMER' => $post['id_customer'],
							'JENIS' => $post['jenis'],
							'JENIS_RKAP' => $post['jenis_rkap'],
							'JENIS_NIAGA' => $post['jenis_niaga'],
							'NILAI' => Rupiah2Number($post['nilai']),
							'USER_STATUS' => $post['user_status'],
							'NO_PRK' => $post['no_prk'],
						];
					}
					else
					{
						$data_doc = [
							'KODE_WO' => $post['work_order'],
							'DESKRIPSI' => $post['deskripsi'],
							'ID_CUSTOMER' => $post['id_customer'],
							'NAMA' => $post['nama'],
							'JENIS' => $post['jenis'],
							'JENIS_RKAP' => $post['jenis_rkap'],
							'JENIS_NIAGA' => $post['jenis_niaga'],
							'TANGGAL' => date_format(date_create($post['tanggal']),'d-M-Y'),
							'NILAI' => Rupiah2Number($post['nilai']),
							'PIC_ID' => $post['pic_id'],
							/*'WOPREFIX' => $post['WORK_ORDER_PREFIX'],
							'PROJECTNUMBER' => $post['PROJECT_NUMBER'],
							'WORK_GROUP' => $post['work_group'],
							'ACCOUNT_CODE' => $post['account_code'],
							'MAINTENANCE_TYPE' => $post['maintenance_type'],
							'WORK_ORDER_TYPE' => $post['work_order_type'],
							'USER_STATUS' => $post['user_status'],*/
							'ORIGINATOR' => $post['originator'],
							'NO_PRK' => $post['no_prk'],
						];
					}
					
					$result = $this->mod->save($kode,$data_doc);
					
					echo $result;
				}
				else
				{
					echo 'Gagal kirim ke ellipse';
				}
			}

			function _list_setting()
			{
				$set = $this->mod->_setting();
				//unset($set['status'],$set['deskripsi'],$set['jenis'],$set['jenis_rkap'],$set['jenis_niaga']);
				return $set;
			}

			public function store_ellipse($post='')
			{
				return true;
				exit();
				/*[{"WORK_GROUP":"GENERAL","WORK_ORDER_TYPE":"PP","WORK_ORDER":"DN3020","WORK_ORDER_PREFIX":"20","RAISED_DATE":"06/11/2020","ORIGINATOR":"9216348KP","PROJECT_NUMBER":"20DN3M91","MAINTENANCE_TYPE":"JE","WORK_ORDER_DESCRIPTION":"WO_roy","ACCOUNT_CODE":"DPS340000000025I491","USER_STATUS":"IP"}]*/
				/*uncomment ini kalo mode test*/
				/*$post = $this->input->raw_input_stream;
				$post = json_decode($post,true);*/

				$url = "http://niaga-api.test/api/workorder/store";
				$arrData = [
					'WORK_GROUP' => $post['work_group'],
					'WORK_ORDER_TYPE' => $post['work_order_type'],
					'WORK_ORDER' => $post['work_order'],
					'WORK_ORDER_PREFIX' => $post['WORK_ORDER_PREFIX'],
					'RAISED_DATE' => date_format(date_create($post['tanggal']),'d/m/Y'),
					'ORIGINATOR' => $post['originator'],
					'PROJECT_NUMBER' => $post['PROJECT_NUMBER'],
					'MAINTENANCE_TYPE' => $post['maintenance_type'],
					'WORK_ORDER_DESCRIPTION' => $post['deskripsi'],
					'ACCOUNT_CODE' => $post['account_code'],
					'USER_STATUS' => $post['user_status'],
				];

				$param_str = json_encode([$arrData]);
				/*print_r($param_str);
				exit();*/
				$ch = curl_init();
				
				curl_setopt($ch,CURLOPT_URL, $url);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 2000);
				curl_setopt($ch,CURLOPT_TIMEOUT, 2000);
				curl_setopt($ch,CURLOPT_POST, 1);
				curl_setopt($ch,CURLOPT_POSTFIELDS, $param_str);
				curl_setopt($ch,CURLOPT_VERBOSE, true);
				curl_setopt($ch,CURLOPT_COOKIEJAR, '-'); 
				// curl_setopt($ch,CURLOPT_COOKIEFILE, 'cookie.txt'); 
				curl_setopt($ch,CURLOPT_COOKIESESSION, true);

				$rs = curl_exec($ch);

				$info = curl_getinfo($ch);
				$err = curl_errno($ch);
				$msg = curl_error($ch);

				/*diganti sesuai methode yang ada di ellipse*/
				if($info['http_code'] == 200)
					return true;

				return false;
			}

			public function update_ellipse($post='')
			{
				return true;
				exit();
				/*uncomment ini kalo mode test*/
				/*$post = $this->input->raw_input_stream;
				$post = json_decode($post,true);*/

				$url = "http://niaga-api.test/api/workorder/update";
				$arrData = [
					'WORK_ORDER' => $post['work_order'],
					'USER_STATUS' => $post['user_status'],
				];

				$param_str = json_encode([$arrData]);
				/*print_r($param_str);
				exit();*/
				$ch = curl_init();
				
				curl_setopt($ch,CURLOPT_URL, $url);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 2000);
				curl_setopt($ch,CURLOPT_TIMEOUT, 2000);
				curl_setopt($ch,CURLOPT_POST, 1);
				curl_setopt($ch,CURLOPT_POSTFIELDS, $param_str);
				curl_setopt($ch,CURLOPT_VERBOSE, true);
				curl_setopt($ch,CURLOPT_COOKIEJAR, '-'); 
				// curl_setopt($ch,CURLOPT_COOKIEFILE, 'cookie.txt'); 
				curl_setopt($ch,CURLOPT_COOKIESESSION, true);

				$rs = curl_exec($ch);

				$info = curl_getinfo($ch);
				$err = curl_errno($ch);
				$msg = curl_error($ch);

				/*diganti sesuai methode yang ada di ellipse*/
				if($info['http_code'] == 200)
					return true;

				return false;
			}
			public function store_ellipse_manual($workOrder='')
			{
				$post = $this->wocreate->GetByPk($workOrder);

				$url = "http://172.16.33.157:9091/wo_prospek";
				$arrData = [
					'WORK_GROUP' => $post['work_group'],
					'WORK_ORDER_TYPE' => $post['work_order_type'],
					'WORK_ORDER' => $post['work_order'],
					'WORK_ORDER_PREFIX' => $post['work_order_prefix'],
					'RAISED_DATE' => date_format(date_create($post['raised_date']),'d/m/Y'),
					'ORIGINATOR' => $post['originator'],
					'PROJECT_NUMBER' => $post['project_number'],
					'MAINTENANCE_TYPE' => $post['maintenance_type'],
					'WORK_ORDER_DESCRIPTION' => $post['work_order_description'],
					'ACCOUNT_CODE' => $post['account_code'],
					'USER_STATUS' => $post['user_status'],
				];

				$param_str = json_encode([$arrData]);
				$ch = curl_init();
				
				curl_setopt($ch,CURLOPT_URL, $url);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 2000);
				curl_setopt($ch,CURLOPT_TIMEOUT, 2000);
				curl_setopt($ch,CURLOPT_POST, 1);
				curl_setopt($ch,CURLOPT_POSTFIELDS, $param_str);
				curl_setopt($ch,CURLOPT_VERBOSE, true);
				curl_setopt($ch,CURLOPT_COOKIEJAR, '-'); 
				// curl_setopt($ch,CURLOPT_COOKIEFILE, 'cookie.txt'); 
				curl_setopt($ch,CURLOPT_COOKIESESSION, true);

				$rs = curl_exec($ch);

				$info = curl_getinfo($ch);
				$err = curl_errno($ch);
				$msg = curl_error($ch);

				/*diganti sesuai methode yang ada di ellipse*/
				// print_r($info);
				/*if($info['http_code'] == 200)
					return true;

				return false;*/
			}			
			
			
		}
		
