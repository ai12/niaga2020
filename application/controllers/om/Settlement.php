<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settlement extends _Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('om_helper');
		$this->load->model("om/Global_model");
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
		$this->modul = 'settlement';
		$this->data['rowsdead'] = $this->conn->GetArray("select nama_proyek, id_proyek,tgl_rencana_selesai, round(tgl_rencana_selesai-sysdate) as hari from proyek where id_status_proyek = 2 and tgl_rencana_selesai-sysdate < 30");

	}

	public function monitoring()
	{
		$this->data['title'] 		= 'Monitoring Settlement OM';
		$this->data['subtitle'] 	= 'isi Settlement';
		$this->data['main'] 		= 'Home';	
		$this->data['link'] 		= $this->modul;
		$this->data['modul'] 		= $this->modul;
		$this->data['template'] 		= 'om/template/_list';
		$this->data['data']		= $this->data;
		
		$this->load->view('om/template/layout_utama', $this->data);
	}
}
