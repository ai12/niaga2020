<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Customer_task extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/customer_tasklist";
		$this->viewdetail = "panelbackend/taskdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout_customer";

		$this->data['width'] = "1000px";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Task';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Task';
			$this->data['edited'] = true;	
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Task';
			$this->data['edited'] = false;	
		}else{
			$this->data['width'] = "2000px";
			$this->data['page_title'] = 'Daftar Task';
		}

		$this->load->model("TaskModel","model");
		$this->load->model("Mt_tipe_kegiatan_taskModel","mttipekegiatantask");
		$this->data['mttipekegiatantaskarr'] = $this->mttipekegiatantask->GetCombo();
		unset($this->data['mttipekegiatantaskarr'][6]);
		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'select2','datepicker'
		);
	}
	public function Index($id_customer=0, $page=0){
		$this->_beforeDetail($id_customer);
		$this->data['header']=$this->Header();
		$this->_setFilter("id_customer = ".$this->conn->escape($id_customer));
		$this->data['list']=$this->_getList($page);

		$this->data['page']=$page;

		$param_paging = array(
			'base_url'=>base_url("{$this->page_ctrl}/index/$id_customer"),
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

	protected function _beforeDetail($id_customer=null, $id=null){
		$this->data['rowheader'] = $this->conn->GetRow("select * from customer where id_customer = ".$this->conn->escape($id_customer));

		$this->data['add_param'] .= $id_customer;
	}

	protected function Header(){
		$kegiatanarr = $this->data['mttipekegiatantaskarr'];
		unset($kegiatanarr[5]);
		return array(
			array(
				'name'=>'nama', 
				'label'=>'Kegiatan', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'id_tipe_kegiatan_task', 
				'label'=>'Tipe Kegiatan', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$kegiatanarr,
			),
			array(
				'name'=>'lokasi', 
				'label'=>'Lokasi', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'pegawai_nama', 
				'label'=>'Pegawai', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'tgl_awal', 
				'label'=>'Tgl. Awal', 
				'width'=>"auto",
				'type'=>"datetime",
			),
			array(
				'name'=>'tgl_akhir', 
				'label'=>'Tgl. Akhir', 
				'width'=>"auto",
				'type'=>"datetime",
			),
			array(
				'name'=>'nama_follow_up', 
				'label'=>'Follow Up', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'id_tipe_follow_up', 
				'label'=>'Tipe FU', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['mttipekegiatantaskarr'],
			),
		);
	}
}