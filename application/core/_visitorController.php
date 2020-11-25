<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class _visitorController extends _Controller{
	protected $layout = "";
	public $front;
	public $pk;
	public $limit = 6;
	public $limit_arr = array('5','10','15');
	protected $viewdetail = "";
	protected $viewlist = "";
	protected $filter = " 1=1 ";
	public function __construct()
	{
		parent::__construct();

		#$this->conn->debug = true;
		#
		
		$this->SetConfig();

		$this->load->library("UI");
		$this->helper("a");
		$this->helper("s");
		$this->_pageIndex();
	}

	protected function SetConfig(){
		$sql = "select * from public_sys_setting where is_show = '1'";
		$rows = $this->conn->GetArray($sql);

		$configarr = array();
		foreach($rows as $r){
			if(strstr($r['nama'],'.')!==false){
				list($nama, $nama1) = explode(".",$r['nama']);
				$configarr[$nama][$nama1] = trim($r['isi']);
			}else{
				$configarr[$r['nama']] = trim($r['isi']);
			}
		}

		foreach ($configarr as $key => $value) {
			$this->config->set_item($key, $value);
		}


		$this->data['collapse'] = $configarr['collapse'];
	}

	protected function _pageIndex(){
		$this->load->library('pagination');

		$this->data['sekarang'] = $this->conn->GetOne("select sysdate from dual");
	}

	protected function view($view='')
	{
		if(!empty($this->layout)){
			$this->data['content1']=$this->PartialView($view,true);
			parent::View($this->layout);
		}else{
			parent::View($view);
		}
	}

	protected function _getList($page=1){
		$this->_resetList();
		
		$param=array(
			'page' => $page,
			'limit' => $this->_limit(),
			'order' => $this->_order(),
			'filter' => $this->_getFilter()
		);

		if($this->post['act']){
			if($this->data['add_param']){
				$add_param = '/'.$this->data['add_param'];
			}
			URL::Redirect(str_replace("/index$add_param/$page", "/index{$add_param}", current_url()));
		}

		$respon = $this->model->SelectGrid(
			$param
		);
		
		return $respon;
	}

	protected function _resetList(){
		if($this->post['act']=='list_reset'){
			unset($_SESSION[SESSION_APP][$this->page_ctrl]['list_limit']);
			unset($_SESSION[SESSION_APP][$this->page_ctrl]['list_sort']);
			unset($_SESSION[SESSION_APP][$this->page_ctrl]['list_filter']);
			unset($_SESSION[SESSION_APP][$this->page_ctrl]['list_search']);
		}
	}

	protected function _limit(){
		if($this->post['act']=='list_limit' && $this->post['list_limit']){
			$_SESSION[SESSION_APP][$this->page_ctrl]['list_limit']=$this->post['list_limit'];
		}

		if($_SESSION[SESSION_APP][$this->page_ctrl]['list_limit']){
			$this->limit = $_SESSION[SESSION_APP][$this->page_ctrl]['list_limit'];
		}

		return $this->limit;
	}

	protected function _order(){

		if($this->post['act']=='list_sort' && $this->post['list_sort']){

			$_SESSION[SESSION_APP][$this->page_ctrl]['list_order']=$this->post['list_order'];
			$_SESSION[SESSION_APP][$this->page_ctrl]['list_sort']=$this->post['list_sort'];				
		}

		if($_SESSION[SESSION_APP][$this->page_ctrl]['list_sort']){
			$order = $_SESSION[SESSION_APP][$this->page_ctrl]['list_sort'];
		}

		if($_SESSION[SESSION_APP][$this->page_ctrl]['list_order'] && $order){
			$order .= ' '. $_SESSION[SESSION_APP][$this->page_ctrl]['list_order'];
		}

		$this->data['list_sort'] = $_SESSION[SESSION_APP][$this->page_ctrl]['list_sort'];
		$this->data['list_order'] = $_SESSION[SESSION_APP][$this->page_ctrl]['list_order'];

		replaceSingleQuote($order);

		if($order)
			return $order;

		return null;
	}

	protected function _resetFilter(){
		$this->filter = '1=1';
	}

	protected function _setFilter($filter=''){
		if($filter){
			$this->filter .= ' and '. $filter;
		}
	}

	protected function _getFilter(){
		$this->xss_clean = true;

		$this->FilterRequest();

		$filter_arr = array();

		if($this->post['act']=='list_filter' && $this->post['list_filter']){
			if(!$_SESSION[SESSION_APP][$this->page_ctrl]['list_filter']){
				$_SESSION[SESSION_APP][$this->page_ctrl]['list_filter'] = $this->post['list_filter'];
			}else{
				$_SESSION[SESSION_APP][$this->page_ctrl]['list_filter'] = array_merge($_SESSION[SESSION_APP][$this->page_ctrl]['list_filter'],$this->post['list_filter']);

			}
		}

		if($_SESSION[SESSION_APP][$this->page_ctrl]['list_filter']){
			foreach ($_SESSION[SESSION_APP][$this->page_ctrl]['list_filter'] as $r){
				$key = $r['key'];
				$filter_arr1 = array();

				foreach($r['values'] as $k=>$v){
					replaceSingleQuote($v);
					if(!empty($v))
						$filter_arr1[] = 'a.'.$key ." = '$v'";
				}

				$filter_str = implode(' or ',$filter_arr1);

				if($filter_str){
					$filter_arr[]="($filter_str)";
				}
			}
		}	


		if($this->post['act']=='search'){
			$_SESSION[SESSION_APP][$this->ctrl]['keyword'] = $this->post['keyword'];
		}

		if($_SESSION[SESSION_APP][$this->ctrl]['keyword']){
			$this->data['keyword'] = $keyword = strtolower($_SESSION[SESSION_APP][$this->ctrl]['keyword']);
			replaceSingleQuote($keyword);
			$filter_arr[]=" (lower(nama) like '%{$keyword}%' or lower(isi) like '%{$keyword}%')";
		}


		if($this->post['act']=='list_search' && $this->post['list_search']){
			if(!$_SESSION[SESSION_APP][$this->page_ctrl]['list_search']){
				$_SESSION[SESSION_APP][$this->page_ctrl]['list_search'] = $this->post['list_search'];
			}else{
				$_SESSION[SESSION_APP][$this->page_ctrl]['list_search'] = array_merge($_SESSION[SESSION_APP][$this->page_ctrl]['list_search'],$this->post['list_search']);

			}
		}

		if($_SESSION[SESSION_APP][$this->page_ctrl]['list_search']){
			foreach ($_SESSION[SESSION_APP][$this->page_ctrl]['list_search'] as $k=>$v){
				replaceSingleQuote($v);
				if(!empty($v))
					$filter_arr[]="lower($k) like '%$v%'";
			}
		}	

		$this->data['filter_arr'] = $_SESSION[SESSION_APP][$this->page_ctrl]['list_search'];

		if(count($filter_arr)){
			$this->filter .= ' and '.implode(' and ', $filter_arr);
		}


		return $this->filter;
	}

	protected function setLogRecord(&$array,$is_update=true){
		$datenow = '{{'.$this->conn->sysTimeStamp.'}}';
		$user_id = $_SESSION[SESSION_APP]['user_id'];
		if(!$is_update){
			$array['created_date']=$datenow;
			$array['created_by']=$user_id;
		}
		$array['modified_date']=$datenow;
		$array['modified_by']=$user_id;
	}


	public function FlashMsg(){
		if($this->session->Get($this->ctrl.'suc_msg')){
			$this->data['suc_msg']=$this->session->GetFlash($this->ctrl.'suc_msg');
		}
		if($this->session->Get($this->ctrl.'inf_msg')){
			$this->data['inf_msg']=$this->session->GetFlash($this->ctrl.'inf_msg');
		}
		if($this->session->Get($this->ctrl.'wrn_msg')){
			$this->data['wrn_msg']=$this->session->GetFlash($this->ctrl.'wrn_msg');
		}
		if($this->session->Get($this->ctrl.'err_msg')){
			$this->data['err_msg']=$this->session->GetFlash($this->ctrl.'err_msg');
		}

		if($this->data['suc_msg']){
			echo '<div class="modal fade" id="main-modal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
			<div class="modal-content" style="border-radius:0px">
			<div class="modal-body">';
			echo '
			<div class="alert alert-success" role="alert" style="margin:0px">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
			'.$this->data['suc_msg'].'
			</div>
			</div>
			</div>
			</div>
			</div>';
			echo "
			<script type='text/javascript'>
			$(function(){
			$('#main-modal').modal('show');
			});
			</script>";
		}
		if($this->data['inf_msg']){
			echo '<div class="modal fade" id="main-modal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
			<div class="modal-content" style="border-radius:0px">
			<div class="modal-body">';
			echo '
			<div class="alert alert-info" role="alert" style="margin:0px">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
			'.$this->data['inf_msg'].'
			</div>
			</div>
			</div>
			</div>
			</div>';
			echo "
			<script type='text/javascript'>
			$(function(){
			$('#main-modal').modal('show');
			});
			</script>";
		}
		if($this->data['wrn_msg']){
			echo '<div class="modal fade" id="main-modal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
			<div class="modal-content" style="border-radius:0px">
			<div class="modal-body">';
			echo '
			<div class="alert alert-warning" role="alert" style="margin:0px" style="margin:0px">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
			'.$this->data['wrn_msg'].'
			</div>
			</div>
			</div>
			</div>
			</div>';
			echo "
			<script type='text/javascript'>
			$(function(){
			$('#main-modal').modal('show');
			});
			</script>";
		}

		if($this->data['err_msg']){
			echo '<div class="modal fade" id="main-modal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
			<div class="modal-content" style="border-radius:0px">
			<div class="modal-body">';
			echo '
			<div class="alert alert-danger" role="alert" style="margin:0px">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
			'.$this->data['err_msg'].'
			</div>
			</div>
			</div>
			</div>
			</div>';
			echo "
			<script type='text/javascript'>
			$(function(){
			$('#main-modal').modal('show');
			});
			</script>";
		}
	}

	public function NoData($str='Data tidak ditemukan.'){
		$this->data['error_str']=$str;
		$this->view("error404");
		exit();
	}

	public function Error404($str=''){
		$this->data['error_str']=$str;
		$this->view("error404");
		exit();
	}

	public function Error403($str=''){
		$this->data['error_str']=$str;
		$this->view("error403");
		exit();
	}
}
?>
