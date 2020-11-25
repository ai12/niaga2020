<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Rab_e_manpower extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/rab_e_manpowerlist";
		$this->viewdetail = "panelbackend/rab_e_manpowerdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout_rab_analisa";

		$this->data['no_header'] = false;

		if ($this->mode == 'add') {
			$this->data['width'] = "1200px";
			$this->data['page_title'] = 'Tambah Manpower';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['width'] = "1200px";
			$this->data['page_title'] = 'Edit Manpower';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['width'] = "1200px";
			$this->data['page_title'] = 'Detail Manpower';
			$this->data['edited'] = false;	
		}else{
			$this->data['no_menu'] = true;
			$this->data['page_title'] = 'Daftar Manpower';
			$this->data['no_header'] = false;
		}

		$this->load->model("Rab_e_manpowerModel","model");
		$this->load->model("proyek_pekerjaanModel","rabpekerjaan");
		$this->load->model("RabModel","rabrab");
		$this->load->model("ProyekModel","proyek");
		
		$this->load->model("Mt_jabatan_proyekModel","mtjabatanproyek");
		$this->data['mtjabatanproyekarr'] = $this->mtjabatanproyek->GetCombo();

		
		$this->load->model("Mt_team_proyekModel","mtteamproyek");
		$this->data['mtteamproyekarr'] = $this->mtteamproyek->GetCombo();

		$this->load->model("Mt_sumber_pegawaiModel","mtsumberpegawai");
		$this->data['mtsumberpegawaiarr'] = $this->mtsumberpegawai->GetCombo();
		$this->data['configfile'] = $this->config->item('file_upload_config');

		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'select2','upload'
		);
	}

	protected function Record($id=null){

		return array(
			'id_rab_evaluasi'=>$this->data['id_rab_evaluasi'],
			'id_team_proyek'=>$this->post['id_team_proyek'],
			'id_jabatan_proyek'=>$this->post['id_jabatan_proyek'],
			'id_sumber_pegawai'=>$this->post['id_sumber_pegawai'],
			'jumlah'=>$this->post['jumlah'],
		);
	}

	public function HeaderExport(){
		$return = array(
			array(
				'name'=>'nama_team_proyek', 
				'name_ori'=>'id_team_proyek', 
				'label'=>'Team Proyek', 
				'required'=>true,
				'type'=>"listinverst",
				'value'=>$this->data['mtteamproyekarr'],
			),
			array(
				'name'=>'nama_jabatan_proyek', 
				'name_ori'=>'id_jabatan_proyek', 
				'label'=>'Jabatan Proyek', 
				'required'=>true,
				'type'=>"listinverst",
				'value'=>$this->data['mtjabatanproyekarr'],
			),/*
			array(
				'name'=>'id_team_proyek', 
				'label'=>'Team Proyek', 
				'required'=>true,
				'type'=>"list",
				'value'=>$this->data['mtteamproyekarr'],
			),
			array(
				'name'=>'id_jabatan_proyek', 
				'label'=>'Jabatan Proyek', 
				'required'=>true,
				'type'=>"list",
				'value'=>$this->data['mtjabatanproyekarr'],
			),*/
			array(
				'name'=>'nama_sumber_pegawai', 
				'name_ori'=>'id_sumber_pegawai', 
				'label'=>'Sumber Pegawai', 
				'required'=>true,
				'type'=>"listinverst",
				'value'=>$this->data['mtsumberpegawaiarr'],
			),
			array(
				'name'=>'jumlah', 
				'label'=>'Jumlah', 
				'width'=>"auto",
			),
		);

        for($i=$this->data['rowheader1']['hmin']; $i>0; $i--){
            $return[] = array(
				'name'=>'h-'.$i, 
				'label'=>'H-'.$i, 
				'width'=>"auto",
            );
        }

        for($i=1; $i<=$this->data['rowheader1']['h']; $i++){
            $return[] = array(
				'name'=>'h'.$i, 
				'label'=>'H'.$i, 
				'width'=>"auto",
            );
        }

        for($i=1; $i<=$this->data['rowheader1']['hplus']; $i++){
            $return[] = array(
				'name'=>'h+'.$i, 
				'label'=>'H+'.$i, 
				'width'=>"auto",
            );
        }

		return $return;
	}

	protected function Rules(){
		return array(
			"id_team_proyek"=>array(
				'field'=>'id_team_proyek', 
				'label'=>'Team Proyek', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['mtteamproyekarr']))."]",
			),
			"id_jabatan_proyek"=>array(
				'field'=>'id_jabatan_proyek', 
				'label'=>'Jabatan Proyek', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['mtjabatanproyekarr']))."]",
			),
			"id_sumber_pegawai"=>array(
				'field'=>'id_sumber_pegawai', 
				'label'=>'Sumber Pegawai', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['mtsumberpegawaiarr']))."]",
			),
			"jumlah"=>array(
				'field'=>'jumlah', 
				'label'=>'Jumlah', 
				'rules'=>"required",
			),
		);
	}

	public function Index($id_rab=0){

		$this->_beforeDetail($id_rab);

		$this->data['rows'] = $this->conn->GetArray("select * from rab_e_manpower where id_rab_evaluasi = ".$this->conn->escape($this->id_rab_evaluasi)."order by id_team_proyek, id_jabatan_proyek");

		$this->data['rowdays'] = array();
		$rows = $this->conn->GetArray("select b.* from rab_e_manpower a join rab_e_mandays b on a.id_manpower = b.id_manpower where a.id_rab_evaluasi = ".$this->conn->escape($this->id_rab_evaluasi));

		foreach($rows as $r){
			$this->data['rowdays'][$r['id_manpower']][$r['day']] = $r['jumlah'];
		}

		$this->data['edited'] = ($this->post['act']=='edit_all');

		if($this->post['act']=='save_all'){
			$this->conn->StartTrans();
			$ret = true;
			$post = $this->post;
			$this->post=array();
			foreach($post['day'] as $id_manpower=>$jumlah){
				if(!$ret)
					break;

				/*$ret = $this->conn->goUpdate("rab_e_manpower",array("jumlah"=>$jumlah),"id_manpower = ".$this->conn->escape($id_manpower));

				if($ret){*/
					$this->post['day'] = $jumlah;
					$ret = $this->_delsertMandays($id_manpower);
				// }
			}

			if($ret)
				$ret = $this->_updateCollective();

			if($ret){
				$this->conn->trans_commit();
				SetFlash("suc_msg","Berhasil");
			}else{
				$this->conn->trans_rollback();
				SetFlash("err_msg","Berhasil");
			}

			redirect(current_url());
		}

		$this->View($this->viewlist);
	}

	public function Add($id_rab=0){
		$this->Edit($id_rab);
	}

	public function Edit($id_rab=0,$id=null){

		if($this->post['act']=='reset'){
			redirect(current_url());
		}

		$this->_beforeDetail($id_rab,$id);

		$this->data['idpk'] = $id;

		$this->data['row'] = $this->model->GetByPk($id);

		if (!$this->data['rowheader1'] && !$this->data['row'] && $id)
			$this->NoData();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters("","");

		if(!empty($this->post) && $this->post['act']<>'change'){
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

			$record['id_rab_evaluasi'] = $this->id_rab_evaluasi;

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
					$this->data['row'] = $return['data'];

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
				redirect("$this->page_ctrl/detail/$id_rab/$id");

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

		if (!$return['error'] && $return['success']){
			$ret = $this->_updateCollective();

			if(!$ret){
				$return['success'] = false;
				$return['error'] = "Proses update RAB gagal !";
			}
		}

        $this->model->conn->CompleteTrans();

		if ($return['success']) {

			$this->log("menghapus ".json_encode($this->data['row']));

			SetFlash('suc_msg', $return['success']);
			redirect("$this->page_ctrl/index/$id_rab");
		}
		else {
			SetFlash('err_msg',"Data gagal didelete");
			redirect("$this->page_ctrl/detail/$id_rab/$id");
		}

	}

	public function Delete_all($id_rab=null){

	    $this->_beforeDetail($id_rab);

		$return = array('success'=>true);

        $this->model->conn->StartTrans();

        $rows = $this->model->GArray("*", " where id_rab_evaluasi = ".$this->conn->escape($this->id_rab_evaluasi));

        if($rows)
        foreach($rows as $r){
        	if(!$return)
        		break;

        	$id = $r[$this->pk];

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

			if($return)
				$this->log("menghapus ".json_encode($this->data['row']));
        }else
	        $this->_beforeDetail($id_rab);

		if (!$return['error'] && $return['success']){
			$ret = $this->_updateCollective();

			if(!$ret){
				$return['success'] = false;
				$return['error'] = "Proses update RAB gagal !";
			}
		}

        $this->model->conn->CompleteTrans();

		if ($return['success']) {
			SetFlash('suc_msg', $return['success']);
			redirect("$this->page_ctrl/index/$id_rab");
		}
		else {
			SetFlash('err_msg',"Data gagal didelete");
			redirect("$this->page_ctrl/index/$id_rab");
		}
	}


	protected function _beforeDetail($id_rab=null, $id=null){
		$this->data['id_rab'] = $id_rab;
		$this->data['rowheader3'] = $this->conn->GetRow("select * from rab_evaluasi where id_rab = ".$this->conn->escape($id_rab));
		
		$this->data['id_rab_evaluasi'] = $this->id_rab_evaluasi = $this->data['rowheader3']['id_rab_evaluasi'];

		$this->data['rowheader2'] = $this->rabrab->GetByPk($id_rab);
		$this->data['id_proyek_pekerjaan'] = $id_proyek_pekerjaan = $this->data['rowheader2']['id_proyek_pekerjaan'];
		$this->data['rowheader1'] = $this->rabpekerjaan->GetByPk($id_proyek_pekerjaan);
		$this->data['id_proyek'] = $id_proyek = $this->data['rowheader1']['id_proyek'];
		$this->data['rowheader'] = $this->proyek->GetByPk($id_proyek);
		$this->data['editedheader'] = false;
		$this->data['modeheader'] = 'detail';
		$this->data['add_param'] .= $id_rab;
	}

	protected function _afterDetail($id=null){
		if(empty($this->data['row']['day'])){
			$this->data['row']['day'] = array();
			$rows = $this->conn->GetArray("select * from rab_e_mandays where id_manpower = ".$this->conn->escape($id));
			foreach($rows as $r){
				$this->data['row']['day'][$r['day']] = $r['jumlah'];
			}
		}
	}

	protected function _afterInsert($id=null){
		$ret = true;
		if($ret)
			$ret = $this->_afterUpdate($id);

		return $ret;
	}

	protected function _afterDelete($id=null){
		$ret = true;
		if($ret)
			$ret = $this->_afterUpdate($id);

		return $ret;
	}

	protected function _afterUpdate($id=null){
		$ret = true;
		
		if($ret)
			$ret = $this->_delsertMandays($id);

		return $ret;
	}

	protected function _updateCollective(){

		$ret = $this->_hitungMdParent();

		$id_rab_evaluasi = $this->data['id_rab_evaluasi'];

		if($ret)
			$ret = $this->_hitungTotalAll($id_rab_evaluasi);

		return $ret;
	}

	private function _delsertMandays($id_manpower = null){
		$ret = $this->conn->Execute("delete from rab_e_mandays where id_manpower = ".$this->conn->escape($id_manpower));

		$MainSpecarr = array();

		if(!empty($this->post['day'])){
			foreach ($this->post['day'] as $key => $v) {
				if(!$v)
					continue;

				if(!$ret)
					break;

				$record = array();
				$record['id_manpower'] = $id_manpower;
				$record['jumlah'] = $v;
				$record['day'] = $key;

				$ret = $this->conn->goInsert('rab_e_mandays', $record);
			}
		}

		return $ret;
	}

	public function import_list($id_rab=null){

		$file_arr = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel','application/wps-office.xls','application/wps-office.xlsx');

		if(in_array($_FILES['importupload']['type'], $file_arr)){

			$this->_beforeDetail($id_rab);

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters("<br/>","");

			$this->load->library('Factory');
			$inputFileType = Factory::identify($_FILES['importupload']['tmp_name']);
			$objReader = Factory::createReader($inputFileType);
			$excel = $objReader->load($_FILES['importupload']['tmp_name']);
			$sheet = $excel->getSheet(0); 
			$highestRow = $sheet->getHighestRow(); 
            $this->model->conn->StartTrans();

			#header export
			$header=array(
				array(
					'name'=>$this->model->pk
				)
			);
			$header=array_merge($header,$this->HeaderExport());

			for ($row = 2; $row <= $highestRow; $row++){ 

		    	$col = 'A';
		    	$record = array();
		    	$record['id_rab_evaluasi'] = $this->id_rab_evaluasi;
		    	foreach($header as $r1){
		    		if($r1['type']=='list')
		           		$record[$r1['name']] = (string)$sheet->getCell($col.$row)->getValue();
		           	elseif($r1['type']=='listinverst'){
		           		$rk = strtolower(trim((string)$sheet->getCell($col.$row)->getValue()));

		           		$arr = array();
		           		foreach ($r1['value'] as $key => $value) {
		           			$arr[strtolower(trim($value))] = $key;
		           		}

		           		if(!$arr[$rk])
		           			$arr[$rk] = $rk;

		           		$record[$r1['name_ori']] = (string)$arr[$rk];
		           	}
		           	else
		           		$record[$r1['name']] = $sheet->getCell($col.$row)->getValue();

	           		$col++;
		    	}

		    	$this->data['row'] = $record;

		        for($i=$this->data['rowheader1']['hmin']; $i>0; $i--){
		        	$this->post['day']['hmin'.$i] = $record['h-'.$i];
		        }

		        for($i=1; $i<=$this->data['rowheader1']['h']; $i++){
		        	$this->post['day']['h'.$i] = $record['h'.$i];
		        }

		        for($i=1; $i<=$this->data['rowheader1']['hplus']; $i++){
		        	$this->post['day']['hplus'.$i] = $record['h+'.$i];
		        }

		    	$error = $this->_isValidImport($record);

		    	if($error){
	    			$return['success'] = false;
		    		$return['error'] = $error;
		    	}else{
			    	if($record[$this->model->pk]){
			    		$return = $this->model->Update($record, $this->model->pk."=".$record[$this->model->pk]);
			    		$id = $record[$this->model->pk];

				    	if($return['success']){
				    		$ret = $this->_afterUpdate($id);

				    		if(!$ret){
				    			$return['success'] = false;
				    			$return['error'] = "Gagal update";
				    		}
				    	}
			    	}else{
			    		$return = $this->model->Insert($record);
			    		$id = $return['data'][$this->model->pk];

				    	if($return['success']){
				    		$ret = $this->_afterInsert($id);

				    		if(!$ret){
				    			$return['success'] = false;
				    			$return['error'] = "Gagal insert";
				    		}
				    	}
			    	}
			    }

				if(!$return['success'])
					break;				
			}

			if (!$return['error'] && $return['success']){
				$ret = $this->_updateCollective();

				if(!$ret){
					$return['success'] = false;
					$return['error'] = "Proses update RAB gagal !";
				}
			}

			if (!$return['error'] && $return['success']) {
            	$this->model->conn->trans_commit();
				SetFlash('suc_msg', $return['success']);
			}else{
            	$this->model->conn->trans_rollback();
				$return['error'] = "Gagal import. ".$return['error'];
				$return['success'] = false;
			}
		}else{
			$return['error'] = "Format file tidak sesuai";
		}

		echo json_encode($return);
	}

	public function export_list($id_rab=null){

		$this->_beforeDetail($id_rab);

		$this->load->library('PHPExcel');
		$this->load->library('Factory');
		$excel = new PHPExcel();
		$excel->setActiveSheetIndex(0);	
		$excelactive = $excel->getActiveSheet();


		#header export
		$header=array(
			array(
				'name'=>$this->model->pk
			)
		);
		$header=array_merge($header,$this->HeaderExport());

		$row = 1;

	    foreach($header as $r){
	    	if(!$col)
	    		$col = 'A';
	    	else
	        	$col++;    

	        $excelactive->setCellValue($col.$row,$r['name']);
	    }


		$excelactive->getStyle('A1:'.$col.$row)->getFont()->setBold(true);
        $excelactive
		    ->getStyle('A1:'.$col.$row)
		    ->getFill()
		    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
		    ->getStartColor()
		    ->setARGB('6666ff');

	    #data
	    $this->_setFilter("id_rab_evaluasi = ".$this->conn->escape($this->id_rab_evaluasi));
		$respon = $this->model->SelectGrid(
			array(
			'limit' => -1,
			'order' => "id_team_proyek, id_jabatan_proyek",
			'filter' => $this->_getFilter()
			)
		);
		$rows = $respon['rows'];

		$row = 2;
        foreach($rows as $r){
	    	$col = 'A';


			$rows1 = $this->conn->GetArray("select * from rab_e_mandays where id_manpower = ".$this->conn->escape($r['id_manpower']));

			foreach($rows1 as $r1){
				$r[str_replace("min","-",$r1['day'])] = $r1['jumlah'];
				$r[str_replace("plus","+",$r1['day'])] = $r1['jumlah'];
			}

	    	foreach($header as $r1){
	    		if($r1['type']=='listinverst'){
	    			$r[$r1['name']] = $r1['value'][$r[$r1['name_ori']]];
	    		}
           		$excelactive->setCellValue($col.$row,$r[$r1['name']]);
           		$col++;
	    	}

            $row++;
        }





	    $objWriter = Factory::createWriter($excel,'Excel2007');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$this->ctrl.date('Ymd').'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
		exit();
	}

}