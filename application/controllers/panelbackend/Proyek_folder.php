<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Proyek_folder extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/proyek_folderlist";
		$this->viewdetail = "panelbackend/proyek_folderdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout_proyek";

		if ($this->mode == 'add') {
			$this->data['width'] = "1200px";
			$this->data['page_title'] = 'Tambah Pekerjaan';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['width'] = "1200px";
			$this->data['page_title'] = 'Edit Pekerjaan';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['width'] = "1200px";
			$this->data['page_title'] = 'Detail Pekerjaan';
			$this->data['edited'] = false;	
		}else{
			unset($this->access_role['add']);
			$this->data['page_title'] = 'Daftar File';
		}

		$this->load->model("ProyekModel","proyek");
		$this->load->model("Proyek_filesModel","modelfile");
		$this->data['configfile'] = $this->config->item('file_upload_config');
		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'datepicker','select2','upload'
		);
	}

	private function _getParent($id_proyek_folder_parent=null){
		$row = $this->conn->GetRow("select * from proyek_folder where id_proyek_folder = ".$this->conn->escape($id_proyek_folder_parent));

		$ret = array();
		if($row['id_proyek_folder_parent'])
			$ret = $this->_getParent($row['id_proyek_folder_parent']);

		$ret[] = $row;

		return $ret;
	}

	public function Index($id_proyek=null, $id_proyek_folder_parent=null){
		$this->_beforeDetail($id_proyek);
		$this->data['id_proyek_folder'] = $id_proyek_folder_parent;

		$record = array();
		$record['nama'] = $this->post['nama'];
		$record['id_proyek_folder_parent'] = $id_proyek_folder_parent;
		$record['id_proyek'] = $id_proyek;
		if($this->post['act']=='save_edit'){
			$this->conn->goUpdate("proyek_folder",$record, "id_proyek_folder = ".$this->conn->escape($this->post['key']));
			redirect(current_url());
		}
		if($this->post['act']=='save_add'){
			$record['id_scm_rks'] = $id;
			$this->conn->goInsert("proyek_folder",$record);
			redirect(current_url());
		}
		if($this->post['act']=='delete'){
			$this->conn->Execute("delete from proyek_folder where id_proyek_folder = ".$this->conn->escape($this->post['key']));
			redirect(current_url());
		}

		$this->data['breadcrumb'] = $this->_getParent($id_proyek_folder_parent);

		$add_filter = " and id_proyek_folder_parent is null";
		$add_filter1 = " and id_proyek_folder is null";
		if($id_proyek_folder_parent){
			$add_filter = " and id_proyek_folder_parent = ".$this->conn->escape($id_proyek_folder_parent);

			$add_filter1 = " and id_proyek_folder = ".$this->conn->escape($id_proyek_folder_parent);
		}

		$this->data['rows'] = $this->conn->GetArray("select * from proyek_folder where id_proyek = ".$this->conn->escape($id_proyek).$add_filter." order by id_proyek_folder");


		$rows = $this->conn->GetArray("select jenis_file, id_proyek_files as id, client_name as name
			from proyek_files
			where id_proyek = ".$this->conn->escape($id_proyek).$add_filter1." order by id_proyek_files");

		$this->data['rowsfile'] = array();
		foreach($rows as $r){
			$this->data['rowsfile']['id'][] = $r['id'];
			$this->data['rowsfile']['name'][] = $r['name'];
		}


		$this->View($this->viewlist);
	}

	protected function _uploadFiles($jenis_file=null){

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

    		$jenis_file = str_replace("upload","",$jenis_file);
    		list($jenis_file1, $id_proyek, $id_proyek_folder) = explode("_",$jenis_file);

			$record = array();
			$record['client_name'] = $upload_data['client_name'];
			$record['file_name'] = $upload_data['file_name'];
			$record['file_type'] = $upload_data['file_type'];
			$record['file_size'] = $upload_data['file_size'];
			$record['id_proyek'] = $id_proyek;
			$record['id_proyek_folder'] = $id_proyek_folder;
			$record['jenis_file'] = $jenis_file1;
			$ret = $this->modelfile->Insert($record);
			if($ret['success'])
			{
				$return = array('file'=>array("id"=>$ret['data'][$this->modelfile->pk],"name"=>$upload_data['client_name']));
			}else{
				unlink($upload_data['full_path']);
				$return = array('errors'=>"File $name gagal upload (gagal input)");
			}

        }

        return $return;

	}

	protected function _beforeDetail($id_proyek=null, $id=null){
		$this->data['id_proyek'] = $id_proyek;
		$this->data['rowheader'] = $this->proyek->GetByPk($id_proyek);
		$this->data['rowheader1'] = $this->data['row'];
		$this->data['add_param'] .= $id_proyek;
	}
}