<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Rab_jasa_material extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/rab_jasa_materiallist";
		$this->viewdetail = "panelbackend/rab_jasa_materialdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout_rab";

		$this->data['no_header'] = false;

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Jasa/Material';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Jasa/Material';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Jasa/Material';
			$this->data['edited'] = false;	
		}else{
			$this->data['page_title'] = 'Jasa/Material';
			$this->data['no_header'] = false;
		}

		$this->load->model("Rab_jasa_materialModel","model");
		$this->load->model("Rab_jasa_material_filesModel","modelfile");
		$this->load->model("RabModel","rabrab");		
		$this->load->model("proyek_pekerjaanModel","rabpekerjaan");
		$this->load->model("proyekModel","proyek");
		$this->load->model("Mt_uomModel","mtuom");
		$this->data['mtuomarr'] = $this->mtuom->GetCombo();
		$this->load->model("Mt_pos_anggaranModel","mtposanggaran");
		$this->data['mtposanggaranarr'] = $this->mtposanggaran->GetCombo();
		$this->data['jasamaterialarr'] = array(''=>'','1'=>'Jasa','2'=>'Material','3'=>'Jasa dan Material');
		$this->data['jenisjasaarr'] = array(''=>'','1'=>'PJBS','2'=>'Pihak ke 3');
		$this->data['configfile'] = $this->config->item('file_upload_config');
		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'upload','select2'
		);
	}

	protected function _beforeDelete($id=null){

		$rows = $this->conn->GetArray("select * from rab_jasa_material_files where id_jasa_material = ".$this->conn->escape($id));

		$ret = true;

		foreach($rows as $r){
			if(!$ret)
				break;
			
			@unlink($this->data['configfile']['upload_path'].$r['file_name']);
		}

		if($ret)
			$ret = $this->conn->Execute("delete from rab_jasa_material_files where id_jasa_material = ".$this->conn->escape($id));

		return $ret;
	}

	protected function Header(){
		return array(
			array(
				'name'=>'nama', 
				'label'=>'Jasa/Material', 
				'width'=>"auto",
				'type'=>"varchar2",
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
				'name'=>'harga_satuan', 
				'label'=>'Harga Satuan', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'total_harga', 
				'label'=>'Total Harga', 
				'width'=>"auto",
				'type'=>"number",
			),
			array(
				'name'=>'jasa_material', 
				'label'=>'Jasa/Material', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['jasamaterialarr'],
			),
			array(
				'name'=>'id_pos_anggaran', 
				'label'=>'POS', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['mtposanggaranarr'],
			),
			array(
				'name'=>'kode_biaya', 
				'label'=>'Kode Biaya', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'keterangan', 
				'label'=>'Keterangan', 
				'type'=>"varchar2",
			),
		);
	}

	public function Delete_all($id_rab=null){

		$return = array('success'=>"Delete berhasil");

        $this->model->conn->StartTrans();

        $rows = $this->model->GArray("*", " where id_rab = ".$this->conn->escape($id_rab));

        if($rows)
        foreach($rows as $r){
        	if(!$return)
        		break;

        	$id = $r[$this->pk];

	        $this->_beforeDetail($id_rab, $id);

			$this->data['row'] = $r;
			
			$this->_onDetail($id);

			if (!$this->data['row'])
				$this->NoData();

			$return = $this->_beforeDelete($id);

			if($return){
				$return = $this->model->Delete("$this->pk = ".$this->conn->qstr($id));
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

	protected function _updateCollective(){

		$id_rab = $this->data['id_rab'];

		$ret = $this->_hitungSowAll($id_rab);
		
		if($ret)
			$ret = $this->_hitungTotalAll($id_rab);

		return $ret;
	}

	protected function Record($id=null){
		$return = array(
			'id_item'=>$this->post['id_item'],
			'nama'=>$this->post['nama'],
			'keterangan'=>$this->post['keterangan'],
			'vol'=>$this->post['vol'],
			'satuan'=>$this->post['satuan'],
			'harga_satuan'=>$this->post['harga_satuan'],
			'kode_biaya'=>$this->post['kode_biaya'],
			'durasi'=>$this->post['durasi'],
			'jasa_material'=>$this->post['jasa_material'],
			/*'jenis_jasa'=>$this->post['jenis_jasa'],*/
			'id_pos_anggaran'=>$this->post['id_pos_anggaran'],
		);

		return $return;
	}

	public function HeaderExport(){
		return array(
			array(
				'name'=>'nama', 
				'label'=>'Jasa/Material', 
			),
			array(
				'name'=>'jasa_material', 
				'label'=>'Jasa/Material', 
				'type'=>"list",
				'value'=>$this->data['jasamaterialarr'],
			),
	/*		array(
				'name'=>'jenis_jasa', 
				'label'=>'Jasa Material', 
				'type'=>"list",
				'value'=>$this->data['jenisjasaarr'],
			),*/
			array(
				'name'=>'vol', 
				'label'=>'VOL', 
			),
			array(
				'name'=>'satuan', 
				'label'=>'Satuan', 
				'type'=>'list',
				'value'=>$this->data['mtuomarr']
			),
			array(
				'name'=>'harga_satuan', 
				'label'=>'Harga Satuan', 
			),
			array(
				'name'=>'kode_biaya', 
				'label'=>'Kode Biaya', 
				'type'=>"varchar2",
			),
			array(
				'name'=>'keterangan', 
				'label'=>'Keterangan', 
				'type'=>"varchar2",
			),
			/*array(
				'name'=>'durasi', 
				'label'=>'Durasi', 
				'width'=>"auto",
				'type'=>"number",
			),*/
		);
	}

	protected function Rules(){
		$return = array(
			"nama"=>array(
				'field'=>'nama', 
				'label'=>'Jasa/Material', 
				'rules'=>"required|max_length[1000]",
			),
			"keterangan"=>array(
				'field'=>'keterangan', 
				'label'=>'Keterangan', 
				'rules'=>"max_length[4000]",
			),
			"jasa_material"=>array(
				'field'=>'jasa_material', 
				'label'=>'Jasa Material', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['jasamaterialarr']))."]",
			),
		);

/*		if($this->data['row']['jasa_material']=='1'){
			$return["jenis_jasa"]=array(
				'field'=>'jenis_jasa', 
				'label'=>'Jenis Jasa', 
				'rules'=>"required|in_list[".implode(",", array_keys($this->data['jenisjasaarr']))."]",
			);
		}*/

	/*	if($this->data['row']['jasa_material']=='2' or $this->data['row']['jasa_material']=='3' or $this->data['row']['jenis_jasa']=='2'){*/
			$return+=array(

			"vol"=>array(
				'field'=>'vol', 
				'label'=>'VOL', 
				'rules'=>"required|integer",
			),
			"satuan"=>array(
				'field'=>'satuan', 
				'label'=>'Satuan', 
				'rules'=>"required|max_length[100]|in_list[".implode(",", array_keys($this->data['mtuomarr']))."]",
			),
			"harga_satuan"=>array(
				'field'=>'harga_satuan', 
				'label'=>'Harga Satuan', 
				'rules'=>"numeric",
			),
			"kode_biaya"=>array(
				'field'=>'kode_biaya', 
				'label'=>'Kode Biaya', 
				'rules'=>"required|max_length[20]",
			),
			"durasi"=>array(
				'field'=>'durasi', 
				'label'=>'Durasi', 
				'rules'=>"integer",
			));
	/*	}*/

		return $return;
	}
	public function Index($id_rab=0, $page=0){

		$this->_beforeDetail($id_rab);

		$this->data['header']=$this->Header();
		$this->_setFilter("id_rab = ".$this->conn->escape($id_rab));

		$this->data['list']=$this->_getList($page);

		$this->data['page']=$page;

		$param_paging = array(
			'base_url'=>base_url("{$this->page_ctrl}/index/$id_rab"),
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

			$record['id_rab'] = $id_rab;

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

	protected function _afterDetail($id){

		if(!$this->data['row']['id_scope']){
			$this->data['row']['id_scope'] = $this->conn->GetList("select id_scope as key, id_scope as val
				from rab_scope_jasa_material where id_jasa_material = ".$this->conn->escape($id));
		}

		$rows = $this->conn->GetArray("select * from rab_scope where id_rab = ".$this->conn->escape($this->data['id_rab'])." order by nvl(id_scope_parent, id_scope), id_scope");

		$this->data['rows'] = array();
		$i = 0;
		// $this->GenerateTree($rows, "id_scope_parent", "id_scope", "equipment", $this->data['rows'], null, $i, 0, "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");

		if(!$this->data['row']['file']['id'] && $id){
			$rows = $this->conn->GetArray("select id_jasa_material_files as id, client_name as name
				from rab_jasa_material_files
				where jenis_file = 'file' and id_jasa_material = ".$this->conn->escape($id));

			foreach($rows as $r){
				$this->data['row']['file']['id'][] = $r['id'];
				$this->data['row']['file']['name'][] = $r['name'];
			}
		}
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
		
		$ret = true;

		if($ret)
			$ret = $this->_hitungSowParent($this->data['row']);

		if($ret)
			$ret = $this->_delsertScopeJasa($id);
		
		if($ret)
			$ret = $this->_delsertFiles($id);

		if($ret)
			$ret = $this->_updateTor($id);

		if($ret)
			$ret = $this->_hitungTotalRabParent();

		return $ret;
	}

	protected function _afterUpdate($id){
		return $this->_afterDelete($id);
	}

	protected function _afterInsert($id){
		return $this->_afterDelete($id);
	}

	private function _delsertFiles($id_jasa_material = null){
		$ret = true;

		if(!empty($this->post['file'])){
			foreach($this->post['file']['id'] as $k=>$v){
				if(!$ret)
					break;

				$this->_updateFiles(array('id_jasa_material'=>$id_jasa_material), $v);
			}
		}

		return $ret;
	}

	private function _updateTor($id_jasa_material){
		$is_tor = (int)$this->conn->GetOne("select 1 from rab_jasa_material_files where id_jasa_material = ".$this->conn->escape($id_jasa_material));

		return $this->model->Update(array('is_tor'=>$is_tor),"id_jasa_material = ".$this->conn->escape($id_jasa_material));
	}

	protected function _deleteFiles($id){
		
		$row = $this->modelfile->GetByPk($id);

		if(!$row)
			$this->Error404();

		$file_name = $row['file_name'];

		$return = $this->modelfile->Delete($this->modelfile->pk." = ".$this->conn->escape($id));

		if ($return) {
			$full_path = $this->data['configfile']['upload_path'].$file_name;
			@unlink($full_path);

			$ret = array("success"=>true);
		}else{
			$ret = array("error"=>"File ".$row['client_name']." gagal dihapus");
		}

		if($ret['success'])
			$ret['success'] = $this->_updateTor($row['id_jasa_material']);

		return $ret;
	}

	private function _delsertScopeJasa($id_jasa_material = null){
		$ret = $this->conn->Execute("delete from rab_scope_jasa_material where id_jasa_material = ".$this->conn->escape($id_jasa_material));

		if(is_array($this->post['id_scope']) && count($this->post['id_scope'])){
			foreach($this->post['id_scope'] as $k=>$v){
				if(!$ret)
					break;

				$record = array();
				$record['id_jasa_material'] = $id_jasa_material;
				$record['id_scope'] = $v;

				$ret = $this->conn->goInsert("rab_scope_jasa_material", $record);
			}
		}
		return $ret;
	}

	public function import_list($id_rab=null){

		$file_arr = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel','application/wps-office.xls','application/wps-office.xlsx');

		if(in_array($_FILES['importupload']['type'], $file_arr)){

			$this->_beforeDetail($id_rab);

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters("","");

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
		    	$record['id_rab'] = $id_rab;
		    	foreach($header as $r1){
		    		if($r1['type']=='list')
		           		$record[$r1['name']] = (string)$sheet->getCell($col.$row)->getValue();
		           	else
		           		$record[$r1['name']] = $sheet->getCell($col.$row)->getValue();
		           	
	           		$col++;
		    	}

		    	$this->data['row'] = $record;

		    	$error = $this->_isValidImport($record);
		    	if($error){
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
	    $this->_setFilter("id_rab = ".$this->conn->escape($id_rab));
		$respon = $this->model->SelectGrid(
			array(
			'limit' => -1,
			'order' => $this->_order(),
			'filter' => $this->_getFilter()
			)
		);
		$rows = $respon['rows'];

		$row = 2;
        foreach($rows as $r){
	    	$col = 'A';
	    	foreach($header as $r1){
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

	public function go_print($id_rab=0, $page=0){

		$this->_beforeDetail($id_rab);

		$this->_setFilter("a.id_rab = ".$this->conn->escape($id_rab));

		$this->data['sub_page_title'] = $this->data['rowheader']['nama_proyek'];
		$this->data['sub_page_title'] .= "<br/>".$this->data['rowheader1']['nama_pekerjaan'];
		$this->template = "panelbackend/main3";
		$this->layout = "panelbackend/layout4";

		$this->data['header']=$this->Header();

		$this->data['list']=$this->_getListPrint();

		$this->View($this->viewprint);
	}


}