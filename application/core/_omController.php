<?php
defined('BASEPATH') or exit('No direct script access allowed');

class _omController extends _Controller
{
	
	public function __construct()
	{
		parent::__construct();

		//$this->SetConfig();
		$_SESSION['menu_id'] = 11;

		$this->template = "om/main";
		$this->layout = "om/layout1";


		$this->load->helper('om_helper');
		$this->load->model("om/Global_model");
		$this->load->model('AuthModel', 'auth');
		$this->sso = $this->config->item('sso');

		$this->helper("a");
		$this->helper("s");

		// $this->conn->debug = 1;

		if ($_GET['debug'] == '1') {
			$this->conn->debug = 1;
		}

		$this->load->helper('url');
		$this->load->helper('form');
		
		$this->modul;
		$this->tabel;
		$this->pk;

		$this->data['rowsdead'] = $this->conn->GetArray("select nama_proyek, id_proyek,tgl_rencana_selesai, round(tgl_rencana_selesai-sysdate) as hari from proyek where id_status_proyek = 2 and tgl_rencana_selesai-sysdate < 30");

		
	}

	function setting()
	{
		$data = $this->mod->column;
		return $data;
	}

	function _list_setting()
	{
		$set = $this->mod->_setting();
		return $set;
	}

	public function index()
	{
		
		$setting 			= $this->setting();

		$this->data['main'] 		= 'Home';	
		$this->data['link'] 		= $this->modul;
		$this->data['modul'] 		= $this->modul;
		$this->data['label'] 		= $setting;
		$this->data['label_setting'] 		= $this->_list_setting();
		$this->data['template'] 		= 'om/template/_list';
		$this->data['isi'] 		= 'om/' . $this->modul . '/list';
		$this->data['data']		= $this->data;

		$this->load->view('om/template/layout_utama', $this->data);
	}

	public function ajax_list()
	{

		$setting 	= $this->setting();
		$list_setting 	= $this->_list_setting();

		$list = $this->mod->dt_get_datatables();
		$data = array();
		$no = $_POST['start'];
		// print_r($list_setting);exit;
		foreach ($list as $rows) {

			$rows = (array) $rows;
			$no++;
			$row = array();
			foreach ($list_setting as $k => $val) {
				$isi = (!isset($val['value']))?$rows[$k]:$val['value'][$rows[$k]];
				$isi = (isset($val['class'])&&$val['class']=='rupiah')?formatRp($isi):$isi;
				$row[] = (!isset($val['url']))?$isi:'<a href="'.base_url().'om/'.$this->modul.'/'.$val['url'].'/'.$rows[$this->mod->pk].'">'.$isi.'</a>';
			}


			$row[] = linkToActionList($rows[$this->mod->pk],$this->modul);
			$data[] = $row;
		}

		$output = array(
			'draw' => $_POST['draw'],
			'recordsTotal' => $this->mod->dt_count_all(),
			'recordsFiltered' => $this->mod->dt_count_filtered(),
			'data' => $data,
		);
		//output to json format
		return json_encode($output);
	}

	public function form($kode = 0)
	{
		$setting = $this->setting();
		// $data['crud']  	  	= $this->crud; // untuk crud
		$this->data['row_id']		= $kode;
		$this->data['link'] 		=  $this->modul.'/form';
		$this->data['title_back']	=  $this->modul;
		$this->data['link_back'] 	=  $this->modul;
		$this->data['modul'] 		= $this->modul;
		$this->data['template'] 		= 'om/template/_form';
		$this->data['isi'] 		= 'om/' . $this->modul . '/form';
		$this->data['label'] 		= $setting;
		$this->data['label_setting'] 		= $this->_list_setting();
		$result 			= $this->mod->get_detail($kode);
		$this->data['row']		= $result;
		$this->data['data']		= $this->data;
		// debug($data);exit;
		$this->load->view('om/template/layout_utama', $this->data);
		
	}

	public function form_action(){
		
		$result = 0;
		$this->load->library('form_validation');
		$setting = $this->setting();
		$list_setting = $this->_list_setting();
		
		$this->form_validation->set_message('integer', '%s Hanya Boleh diisi Angka');
		$this->form_validation->set_message('numeric', '%s Hanya Boleh diisi Angka');
		$this->form_validation->set_message('matches', '%s Tidak sama dengan %s');
		$this->form_validation->set_message('required', '%s Wajib diisi');
		
		$kode	  = $this->input->post('row_id');
		
		foreach($list_setting as $k=>$rw){
			$required = ($rw['required']&&!$rw['hidden'])?'|required':'';
			$this->form_validation->set_rules($k,$rw['label'],'trim'.$required);
		}
		
		
		
		if ($this->form_validation->run() == FALSE) 
		{
			echo validation_errors('- ', ' ');exit;
		}
		
		
		foreach($list_setting as $k=>$rw){
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
		}
		
		// echo '<pre>';print_r($data_doc);exit;
		$result = $this->mod->save($kode,$data_doc);
		echo $result;
	}

	function delete()
	{
		$no		= $this->input->post('kode');
		$result 	= $this->mod->delete($no);

		echo $result;
	}

	
}
