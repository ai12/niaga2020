<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _adminController extends _Controller{
	public $viewprint = "panelbackend/listprint";
	public $access_role = array();
	public $access_role_custom = array();
	public $page_escape = array('panelbackend/login','panelbackend/ws','panelbackend/publ1c','panelbackend/ajax');
	public $is_administrator = false;
	public $is_coordinator = false;
	public $is_owner = false;
	public $is_review = false;
	public $is_bod = false;
	public $list_order = '';
	public $private = true;
	public $limit = 10;
	public $limit_arr = array('5','10','30','50','100');
	public function __construct()
	{
		parent::__construct();

		$this->SetConfig();

		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";


		$this->load->model('AuthModel', 'auth');
		$this->load->model('om/Global_model');
		$this->load->library("UI");

		$this->sso = $this->config->item('sso');

		$this->helper("a");
		$this->helper("s");

		// $this->conn->debug = 1;

		if($_GET['debug']=='1'){
			$this->conn->debug = 1;
		}

		$this->SetAccessRole();

		$this->init();

		$this->InitAdmin();
	}

	protected function SetConfig(){
		$sql = "select * from public_sys_setting";
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

	protected function init(){
		$this->data['show_button'] = true;
		$this->data['sekarang'] = $this->conn->GetOne("select sysdate from dual");

		if($_SESSION[SESSION_APP]['group_id']==1){
			$this->is_administrator = true;
			$this->data['is_administrator'] = true;
		}
		if($_SESSION[SESSION_APP]['group_id']==2){
			$this->is_coordinator = true;
			$this->data['is_coordinator'] = true;
		}
		if($_SESSION[SESSION_APP]['group_id']==3){
			$this->is_owner = true;
			$this->data['is_owner'] = true;
		}
		if($_SESSION[SESSION_APP]['group_id']==24){
			$this->is_reviewer = true;
			$this->data['is_reviewer'] = true;
		}
		if($_SESSION[SESSION_APP]['group_id']==25){
			$this->is_bod = true;
			$this->data['is_bod'] = true;
		}
		if($_SESSION[SESSION_APP]['pic'])
			$this->data['owner'] = $_SESSION[SESSION_APP]['pic'];
		else
			$this->data['owner'] = '0';
	}


	private function InitAdmin(){

		$this->data['listjk'] = array(''=>'-pilih-','1'=>'Laki-laki','2'=>'Perempuan');

		$this->load->model("RabModel","rabrab");
		$this->data['count_task'] = $this->rabrab->GetCountTask();
		$this->data['rowsdead'] = $this->conn->GetArray("select nama_proyek, id_proyek,tgl_rencana_selesai, round(tgl_rencana_selesai-sysdate) as hari from proyek where id_status_proyek = 2 and tgl_rencana_selesai-sysdate < 30");
	}

	protected function SetAccess($pagearr=array()){
		if(!is_array($pagearr))
			$pagearr = array($pagearr);

		foreach ($pagearr as $v) {
			$this->access_role_custom[$v] = $this->auth->GetAccessRole($v);
		}
	}

	protected function View($view='')
	{
		if(!empty($this->layout)){
			$this->data['content1']=$this->PartialView($view,true);
			parent::View($this->layout);
		}else{
			parent::View($view);
		}
	}
	// set access for url and action
	protected function SetAccessRole($action=""){
		// ceck referer from host or not
		if(
		static::$referer == true and
		str_replace('/','',str_replace('panelbackend','',str_replace('index.php','',$_SERVER['HTTP_REFERER'])))
		<>
		str_replace('/','',str_replace('panelbackend','',str_replace('index.php','',base_url())))
		)
		{

			$this->Error404();
			exit();
		}

		if(in_array($this->page_ctrl, $this->page_escape))
			return true;

		if($this->page_ctrl=="panelbackend/home" && $this->mode=="loginasback")
			return true;

		// set private area
		if($this->private)
		{
			// ceck login
			if(!$_SESSION[SESSION_APP]['login']){
				if($this->post[date('Ymd')]){
					$token = $this->post[date('Ymd')];
					$token = base64_decode($token);
					list($menu, $group_id) = explode(md5(date('Ymdhi')), $token);
					$menu = base64_decode($menu);
					$_SESSION[SESSION_APP]['menu'] = json_decode($menu, true);
					$group_id = base64_decode($group_id);
					$_SESSION[SESSION_APP]['group_id'] = json_decode($group_id, true);
				}else{
					$_SESSION[SESSION_APP]['curr_page'] = uri_string();
					redirect('panelbackend/login','client');
				}
			}

			/*if($this->sso['auth_page'] && $_SESSION[SESSION_APP]['user_id']!=1){

				$username = $_SESSION[SESSION_APP]['username'];
				$credential = $_SESSION[SESSION_APP]['credential'];
            	$respon = $this->auth->autoAuthenticate($username,$credential);

            	if(!($respon->RESPONSE == "1" or $respon->RESPONSE == "PAGE")){

					unset($_SESSION[SESSION_APP]);

					$_SESSION[SESSION_APP]['curr_page'] = uri_string();

					redirect('panelbackend/login','client');
            	}
			}*/
		}

		if($_SESSION[SESSION_APP]['user_id']==1){
			$this->is_super_admin = true;
		}else{
			$this->is_super_admin = false;
		}

		if($this->page_ctrl=='panelbackend/page' or $this->page_ctrl=='panelbackend/pageone'){
			$this->access_role = $this->auth->GetAccessRole('panelbackend/page');
		}else{
			$this->access_role = $this->auth->GetAccessRole($this->page_ctrl);
		}
		
		$this->access_role_custom[$this->page_ctrl] = $this->access_role;
		// $this->access_role[$this->mode] = 1;
		
		
		/*	if($this->page_ctrl=='panelbackend/home' && !empty($_SESSION[SESSION_APP]['user_id']))
		return true;*/
		
		if($this->page_ctrl=='panelbackend/home' && $this->mode=='ug')
		return;
		
		if($this->page_ctrl=='panelbackend/proto')
		return;
		
		if(!$this->access_role[$this->mode]){
			$str = '';

			if(ENVIRONMENT=='development')
				$str = "akses : ".print_r($this->access_role,true);

			$this->Error403($str);
			exit();
		}
	}

	protected function _getList($page=0){
		$this->_resetList();

		$this->arrNoquote = $this->model->arrNoquote;

		$param=array(
			'page' => $page,
			'limit' => $this->_limit(),
			'order' => $this->_order(),
			'filter' => $this->_getFilter()
		);

		if(in_array($this->post['act'],array('list_sort','list_search','list_reset','list_limit','list_filter','list_search_filter'))){
			
			if($this->data['add_param']){
				$add_param = '/'.$this->data['add_param'];
			}
			redirect(str_replace(strstr(current_url(),"/index$add_param/$page"), "/index{$add_param}", current_url()));
		}

		$respon = $this->model->SelectGrid(
			$param
		);

		return $respon;
	}

	protected function _getListPrint(){
		$this->_resetList();

		$this->arrNoquote = $this->model->arrNoquote;

		$param=array(
			'order' => $this->_order(),
			'filter' => $this->_getFilter()
		);

		$respon = $this->model->SelectGridPrint($param);

		return $respon;
	}

	protected function _resetList(){
		if($this->post['act']=='list_reset'){
			unset($_SESSION[SESSION_APP][$this->page_ctrl]['list_limit']);
			unset($_SESSION[SESSION_APP][$this->page_ctrl]['list_sort']);
			unset($_SESSION[SESSION_APP][$this->page_ctrl]['list_filter']);
			unset($_SESSION[SESSION_APP][$this->page_ctrl]['list_search']);
			unset($_SESSION[SESSION_APP][$this->page_ctrl]['list_search_filter']);
			unset($_SESSION[SESSION_APP][$this->page_ctrl]['list_add']);
			unset($_SESSION[SESSION_APP][$this->page_ctrl]['list_edit']);
			unset($_SESSION[SESSION_APP][$this->page_ctrl]['key']);
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
			$order .= $_SESSION[SESSION_APP][$this->page_ctrl]['list_sort'];
		}

		if($_SESSION[SESSION_APP][$this->page_ctrl]['list_order'] && $order){
			$order .= ' '. $_SESSION[SESSION_APP][$this->page_ctrl]['list_order'];
		}

		$this->data['list_sort'] = $_SESSION[SESSION_APP][$this->page_ctrl]['list_sort'];
		$this->data['list_order'] = $_SESSION[SESSION_APP][$this->page_ctrl]['list_order'];

		replaceSingleQuote($this->list_order);

		if($this->list_order && $order)
			$this->list_order .= ", ".$order;
		elseif($order)
			$this->list_order = $order;

		if(!$this->list_order){
			if($this->model->order_default)
				return $this->model->order_default;
			else
				return $this->model->pk." desc ";
		}

		if($this->list_order)
			return $this->list_order;

		return null;
	}

	protected function _setFilter($filter=''){
		if($filter){
			$this->filter .= ' and '. $filter;
		}
	}

	protected function _getFilter(){
		$this->xss_clean = true;

		$this->FilterRequest();
		
		if(!$this->post && $this->get)
			$this->post = $this->get;

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
					$k=str_replace("_____", ".", $k);

					replaceSingleQuote($v);
					replaceSingleQuote($k);
					if(!($v==='' or $v===null or $v===false))
						$filter_arr1[] = 'a.'.$key ." = '$v'";
				}

				$filter_str = implode(' or ',$filter_arr1);

				if($filter_str){
					$filter_arr[]="($filter_str)";
				}
			}
		}

		if(!$_SESSION[SESSION_APP][$this->page_ctrl]['list_search_filter']){
			$_SESSION[SESSION_APP][$this->page_ctrl]['list_search_filter'] = array();
		}

		if($this->post['act']=='list_search' && $this->post['list_search_filter']){
			if(!$_SESSION[SESSION_APP][$this->page_ctrl]['list_search_filter']){
				$_SESSION[SESSION_APP][$this->page_ctrl]['list_search_filter'] = $this->post['list_search_filter'];
			}else{
				$_SESSION[SESSION_APP][$this->page_ctrl]['list_search_filter'] = array_merge($_SESSION[SESSION_APP][$this->page_ctrl]['list_search_filter'],$this->post['list_search_filter']);

			}
		}

		if($_SESSION[SESSION_APP][$this->page_ctrl]['list_search_filter']){
			foreach ($_SESSION[SESSION_APP][$this->page_ctrl]['list_search_filter'] as $k=>$v){
				$k=str_replace("_____", ".", $k);

				if(!($v==='' or $v===null or $v===false)){
					replaceSingleQuote($v);
					replaceSingleQuote($k);

					$filter_arr[]="$k='$v'";
				}
			}
		}




		if(!$_SESSION[SESSION_APP][$this->page_ctrl]['list_search']){
			$_SESSION[SESSION_APP][$this->page_ctrl]['list_search'] = array();
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
				$k=str_replace("_____", ".", $k);

				replaceSingleQuote($v);
				replaceSingleQuote($k);

				if(trim($v)!=='' && in_array($k, $this->arrNoquote)){
					$filter_arr[]="$k=$v";
				}else if($v!==''){
					$v = strtolower($v);
					$filter_arr[]="lower($k) like '%$v%'";
				}
			}
		}

		$this->data['filter_arr'] = array_merge($_SESSION[SESSION_APP][$this->page_ctrl]['list_search'],$_SESSION[SESSION_APP][$this->page_ctrl]['list_search_filter']);

		if(($filter_arr)){
			$this->filter .= ' and '.implode(' and ', $filter_arr);
		}

		return $this->filter;
	}

	protected function _setLogRecord(&$array,$is_update=true){
		$datenow = '{{'.$this->conn->sysTimeStamp.'}}';
		$user_id = $_SESSION[SESSION_APP]['user_id'];
		if(!$is_update){
			$array['created_date']=$datenow;
			$array['created_by']=$user_id;
			$array['created_by_desc']=$_SESSION[SESSION_APP]['name'];
		}
		$array['modified_date']=$datenow;
		$array['modified_by']=$user_id;
		$array['modified_by_desc']=$_SESSION[SESSION_APP]['name'];
	}

	public function Index($page=0){
		$this->data['header']=$this->Header();

		$this->data['list']=$this->_getList($page);

		$this->data['page']=$page;

		$param_paging = array(
			'base_url'=>base_url("{$this->page_ctrl}/index"),
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

	public function go_print(){
		$this->template = "panelbackend/main3";
		$this->layout = "panelbackend/layout3";

		$this->data['header']=$this->Header();

		$this->data['list']=$this->_getListPrint();

		$this->View($this->viewprint);
	}

	public function PrintDetail($id=null){

		$this->data['row'] = $this->model->GetByPk($id);

		$this->_getDetailPrint($id);

		if (!$this->data['row'])
			$this->NoData();

		$this->View($this->viewprintdetail);
	}

	public function Add(){
		$this->Edit();
	}

	protected function _isValid($record=array(), $show_error=true, $replace_post=false){
		$rules = array_values($this->data['rules']);

		if($record && $replace_post)
			$this->form_validation->set_data($record);

		$this->form_validation->set_rules($rules);

		if (count($rules) && $this->form_validation->run() == FALSE)
		{
			if($show_error){
				$this->data['err_msg'] = validation_errors();
			}

			$this->data['row'] = array_merge($this->data['row'],$record);

			$this->_afterDetail($this->data['row'][$this->pk]);

			$this->View($this->viewdetail);
			exit();
		}
	}

	protected function Halt($msg){
		if($msg){

			if($this->data['err_msg'])
				$this->data['err_msg'] .= "<br/>".$msg;
			else
				$this->data['err_msg'] = $msg;

			$this->_afterDetail($this->data['row'][$this->pk]);

			$this->View($this->viewdetail);
			exit();
		}

	}

	protected function _getDetailPrint($id){

	}

	public function Edit($id=null){

		if($this->post['act']=='reset'){
			redirect(current_url());
		}

		$this->_beforeDetail($id);

		$this->data['idpk'] = $id;

		$this->data['row'] = $this->model->GetByPk($id);

		if (!$this->data['row'] && $id)
			$this->NoData();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters("","");

		if($this->post && $this->post['act']<>'change'){
			if(!$this->data['row'])
				$this->data['row'] = array();

			$record = $this->Record($id);

			$this->data['row'] = array_merge($this->data['row'],$record);
			$this->data['row'] = array_merge($this->data['row'],$this->post);
		}

		$this->data['rules'] = $this->Rules();

		$this->_onDetail($id);

		## EDIT HERE ##
		if ($this->post['act'] === 'save') {
			$this->_isValid($record,true);

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

            $this->model->conn->CompleteTrans();

			if ($return['success']) {

				$this->_afterEditSucceed($id);

				SetFlash('suc_msg', $return['success']);
				redirect("$this->page_ctrl/detail/$id");

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

	public function Detail( $id=null){

		$this->_beforeDetail($id);

		$this->data['row'] = $this->model->GetByPk($id);

		if (!$this->data['row'])
			$this->NoData();

		$this->_afterDetail($id);

		$this->View($this->viewdetail);
	}

	public function Delete_all(){

		$return = true;

        $this->model->conn->StartTrans();

        $rows = $this->model->GArray();

        foreach($rows as $r){
        	if(!$return)
        		break;

        	$id = $r[$this->pk];

	        $this->_beforeDetail($id);

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
        }

        $this->model->conn->CompleteTrans();

		if ($return) {
			SetFlash('suc_msg', $return['success']);
			redirect("$this->page_ctrl/index");
		}
		else {
			SetFlash('err_msg',"Data gagal didelete");
			redirect("$this->page_ctrl/index");
		}
	}

	public function Delete( $id=null){

        $this->model->conn->StartTrans();

        $this->_beforeDetail($id);

		$this->data['row'] = $this->model->GetByPk($id);

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

		if ($return) {

			$this->log("menghapus ".json_encode($this->data['row']));

			SetFlash('suc_msg', $return['success']);
			redirect("$this->page_ctrl");
		}
		else {
			SetFlash('err_msg',"Data gagal didelete");
			redirect("$this->page_ctrl/detail/$id");
		}

	}

	protected function _beforeEdit(&$record=array(), $id){
	}

	protected function _afterEditSucceed($id=null){

	}

	protected function _afterEditFailed($id=null){

	}

	protected function _beforeDetail($id){

	}

	protected function _onDetail($id){

	}

	protected function _afterDetail($id){

	}

	protected function _beforeDelete($id){
		return true;
	}

	protected function _afterDelete($id){
		return true;
	}

	protected function _beforeUpdate($record, $id=null){
		return true;
	}

	protected function _afterUpdate($id){
		return true;
	}

	protected function _beforeInsert($id){
		return true;
	}

	protected function _afterInsert($id){
		return true;
	}

	protected function Header(){
		return array(
			array(
				'name'=>'nama',
				'label'=>'Kategori',
				'width'=>"auto"
			),
		);
	}

	protected function Record($id){
		return array(
			'nama'=>$this->post['nama']
		);
	}

	protected function Rules(){
		return array(
		   'nama'=>array(
				 'field'   => 'nama',
				 'label'   => 'Kategori',
				 'rules'   => 'required'
			  ),
		);
	}

	public function NoData($str='Data tidak ditemukan.'){
		$this->data['error_str']=$str;
		$this->layout = "panelbackend/layout1";
		$this->view("panelbackend/error404");
		exit();
	}

	public function Error404($str=''){
		$this->data['error_str']=$str;
		$this->layout = "panelbackend/layout1";
		$this->view("panelbackend/error404");
		exit();
	}

	public function Error403($str=''){
		$this->data['error_str']=$str;
		$this->layout = "panelbackend/layout1";
		$this->view("panelbackend/error403");
		exit();
	}

	function curlwait($q, $params=array(), $debug=false) {	
		$url = $q;
		$param_str = http_build_query($params);

		$ch = curl_init();
		
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 2000);
		curl_setopt($ch,CURLOPT_TIMEOUT, 2000);
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $param_str);
		curl_setopt($ch,CURLOPT_VERBOSE, true);
		curl_setopt($ch,CURLOPT_COOKIEJAR, '-'); 
		curl_setopt($ch,CURLOPT_COOKIEFILE, 'cookie.txt'); 
		curl_setopt($ch,CURLOPT_COOKIESESSION, true);

		$result = curl_exec($ch);
/*
		if($result)
			file_put_contents('logs/curl', $result."\n", FILE_APPEND);*/

		$info = curl_getinfo($ch);
		$err = curl_errno($ch);
		$msg = curl_error($ch);
		
		if($debug){
			echo $url;
			echo '<pre>PARAM :'."\n";
			print_r($params);
			echo ' ===>'.$result."\n";/*
			echo 'INFO : '."\n";
			print_r($info);
			echo 'ERR : '."\n";
			print_r($err);
			echo 'MSG : '."\n";
			print_r($msg);
			echo '</pre>';*/
			die();
		}
		
		curl_close($ch);
		
		return $result;	
	}

	function curlnowait($q, $params=array(), $debug=false) {	
		$url = $q;
		$param_str = http_build_query($params);

		$ch = curl_init();
		
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch,CURLOPT_TIMEOUT, 1);
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $param_str);
		curl_setopt($ch,CURLOPT_VERBOSE, true);
		curl_setopt($ch,CURLOPT_COOKIEJAR, '-'); 
		// curl_setopt($ch,CURLOPT_COOKIEFILE, 'cookie.txt'); 
		curl_setopt($ch,CURLOPT_COOKIESESSION, true);

		$result = curl_exec($ch);
/*
		if($result)
			file_put_contents('logs/curl', $result."\n", FILE_APPEND);*/

		$info = curl_getinfo($ch);
		$err = curl_errno($ch);
		$msg = curl_error($ch);
		
		if($debug){
			echo $url;
			echo '<pre>PARAM :'."\n";
			print_r($params);
			echo ' ===>'.$result."\n";
			echo 'INFO : '."\n";
			print_r($info);
			echo 'ERR : '."\n";
			print_r($err);
			echo 'MSG : '."\n";
			print_r($msg);
			echo '</pre>';
			die();
		}
		
		curl_close($ch);
		
		return $result;	
	}

	function curl($q, $params=array()) {	
		$url = site_url($q);
		$param_str = http_build_query($params);

		$ch = curl_init();
		
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($ch,CURLOPT_TIMEOUT, 2);
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $param_str);
		curl_setopt($ch,CURLOPT_VERBOSE, true);
		curl_setopt($ch,CURLOPT_COOKIEJAR, '-'); 
		curl_setopt($ch,CURLOPT_COOKIEFILE, 'cookie.txt'); 
		curl_setopt($ch,CURLOPT_COOKIESESSION, true);

		$result = curl_exec($ch);

		if($result)
			file_put_contents('logs/curl', $result."\n", FILE_APPEND);

		$info = curl_getinfo($ch);
		$err = curl_errno($ch);
		$msg = curl_error($ch);
		
		if(FALSE){
			echo $url;
			echo '<pre>PARAM :'."\n";
			print_r($params);
			echo ' ===>'.$result."\n";/*
			echo 'INFO : '."\n";
			print_r($info);
			echo 'ERR : '."\n";
			print_r($err);
			echo 'MSG : '."\n";
			print_r($msg);
			echo '</pre>';*/
		}
		
		curl_close($ch);
		
		return $result;	
	}

	function Access($mode, $page=null){
		if($page){
			if($this->access_role_custom[$page])
				$access_role = $this->access_role_custom[$page];
			else{
				$this->access_role_custom[$page] = $this->auth->GetAccessRole($page);
				$access_role = $this->access_role_custom[$page];
			}
		}
		else{
			$access_role = $this->access_role;
		}

		if($access_role[$mode])
			return true;
		else
			return false;
	}

	protected function checkExecute(){
		if(!$this->access_role['edit'] or !$this->access_role['add'])
			$this->Error403("Anda tidak mempunyai akses");
	}

	function upload_file($id=null){
		$jenis_file = key($_FILES);

		$ret = $this->_uploadFiles($jenis_file);		

		echo json_encode($ret);
	}

	function delete_file($id=null){
		$ret = $this->_deleteFiles($this->post['id']);
		
		echo json_encode($ret);
	}

	function open_file($id=null){
		$this->_openFiles($id);
	}

	protected function _updateFiles($record=array(), $id=null){
		return $this->modelfile->Update($record, $this->modelfile->pk."=".$this->conn->escape($id));
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

			return array("success"=>true);
		}else{
			return array("error"=>"File ".$row['client_name']." gagal dihapus");
		}
	}

	protected function _openFiles($id=null){
		$row = $this->modelfile->GetByPk($id);

		if($row ){
			$full_path = $this->data['configfile']['upload_path'].$row['file_name'];
			header("Content-Type: {$row['file_type']}");
			header("Content-Disposition: inline; filename='".str_replace(array(" ",","),"_",basename($row['client_name']))."'");
			echo file_get_contents($full_path);
			die();
		}else{
			$this->Error404();
		}
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

			$record = array();
			$record['client_name'] = $upload_data['client_name'];
			$record['file_name'] = $upload_data['file_name'];
			$record['file_type'] = $upload_data['file_type'];
			$record['file_size'] = $upload_data['file_size'];
			$record['jenis_file'] = str_replace("upload","",$jenis_file);
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

	protected function _onSuccess($id=null){
	}
	
	protected function _setGo($id=null){

	}

	protected function _isValidImport($record){
		$this->data['rules'] = $this->Rules();

		$rules = array_values($this->data['rules']);

		if($record){
			$this->form_validation->set_data($record);
		}

		$this->form_validation->set_rules($rules);
		
		if (count($rules) && $this->form_validation->run() == FALSE)
		{
			return validation_errors();
		}
	}

	public function import_list(){

		$file_arr = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel','application/wps-office.xls','application/wps-office.xlsx');

		if(in_array($_FILES['importupload']['type'], $file_arr)){

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
		    	foreach($header as $r1){
		    		if($r1['type']=='list')
		           		$record[$r1['name']] = (string)$sheet->getCell($col.$row)->getValue();
		           	elseif($r1['type']=='listinverst'){
		           		$rk = strtolower(trim((string)$sheet->getCell($col.$row)->getValue()));
		           		$arr =array();
		           		foreach ($r1['value'] as $key => $value) {
		           			$arr[strtolower(trim($value))] = $key;
		           		}
		           		$record[$r1['name_ori']] = (string)$arr[$rk];
		           	}
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

	public function export_list(){
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
	    		if($r1['type']=='listinverst'){
	    			$r[$r1['name']] = $r1['value'][$r[$r1['name_ori']]];
	    		}
           		$excelactive->setCellValue($col.$row,$r[$r1['name']]);
           		$col++;
	    	}
            $row++;
        }


	    $objWriter = Factory::createWriter($excel,'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$this->ctrl.date('Ymd').'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
		exit();
	}

	protected function _hitungSub($id_rab_detail=null){
		if(!$id_rab_detail)
			return;

		$id_rab_detail_parent = $this->conn->GetOne("select id_rab_detail from rab_e_detail where id_rab_detail_parent = ".$this->conn->escape($id_rab_detail));

		if($id_rab_detail_parent)
			$this->_hitungSub($id_rab_detail_parent);

		$total = $this->conn->GetOne("select 
			sum(nvl(nilai_satuan,0)*nvl(case 
			when sumber_nilai = 1 then 1 
			when satuan is not null and vol is null then 0 
			else vol end,1)*nvl(day,1))
			from rab_e_detail 
			where id_rab_detail_parent = ".$this->conn->escape($id_rab_detail));

		return $total;
	}

	protected function _hitungTotal(){

		if($this->data['id_rab_evaluasi'] && $this->data['id_proyek_pekerjaan']){
			$id_rab_evaluasi = $this->data['id_rab_evaluasi'];
			$id_proyek_pekerjaan = $this->data['id_proyek_pekerjaan'];
			$row = $this->conn->GetRow("select 
			sum(nvl(nilai_satuan,0)*nvl(vol,1)*nvl(day,1)) as total_rab, 
			sum(nvl(nilai_realisasi,0)) as total_realisasi
			from rab_e_detail 
			where id_rab_detail_parent is null
			and id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

			$total_rab = $row['total_rab'];
			$total_realisasi = $row['total_realisasi'];
			
			$this->conn->Execute("update proyek_pekerjaan set 
				nilai_rab = $total_rab,
				nilai_realisasi = $total_realisasi
				where id_proyek_pekerjaan = ".$this->conn->escape($id_proyek_pekerjaan));
		}

	}

	protected function _hitungSubParent($id_rab_detail_parent, $issumbertotal = false, &$inarray=array()){
		if(!$id_rab_detail_parent){

			$this->_hitungTotal();

			if(!$issumbertotal)
				return $this->_hitungTotalRabParent();
			
			return true;
		}

		if($inarray[$id_rab_detail_parent])
			return true;

		$row = $this->conn->GetRow("select id_rab_detail_parent, is_ppn, uraian
			from rab_e_detail 
			where sumber_nilai = 1 
			and id_rab_detail = ".$this->conn->escape($id_rab_detail_parent));

		$inarray[$id_rab_detail_parent] = $id_rab_detail_parent;

		if(!$row)
			return true;

		$total = $this->_hitungSub($id_rab_detail_parent);

		if($row['is_ppn'])
			$total = $total*1.1;

		if(!$total)
			$total = "null";

		$this->conn->Execute("update rab_e_detail 
			set nilai_satuan = $total 
			where id_rab_detail = ".$this->conn->escape($id_rab_detail_parent));

		if(!$row['id_rab_detail_parent']){
			$id_biaya_produksi = $this->conn->GetOne("select id_biaya_produksi from rab_e_biaya_produksi where id_rab_detail = ".$this->conn->escape($id_rab_detail_parent));

			if($total=='null')
				$total = '{{null}}';
			
			$rc = array("nilai"=>$total,"id_rab_detail"=>$id_rab_detail_parent);
			
			if($this->data['id_biaya_produksi_evaluasi'])
				$rc['id_biaya_produksi_parent'] = $this->data['id_biaya_produksi_evaluasi'];

			$rc['sumber_nilai'] = 2;
			$rc['id_rab_evaluasi'] = $this->id_rab_evaluasi;
			$rc['uraian'] = $row['uraian'];

			if($id_biaya_produksi)
				$this->conn->goUpdate("rab_e_biaya_produksi",$rc,"id_biaya_produksi = ".$this->conn->escape($id_biaya_produksi));
			else
				$this->conn->goInsert("rab_e_biaya_produksi",$rc);
		}

		return $this->_hitungSubParent($row['id_rab_detail_parent'], $issumbertotal, $inarray);
	}

	protected function _hitungSow($record=array()){

		$kode_biaya = $record['kode_biaya'];
		$id_pos_anggaran = $record['id_pos_anggaran'];
		$jasa_material = $record['jasa_material'];
		$id_rab_evaluasi = $this->data['id_rab_evaluasi'];

		$total = $this->conn->GetOne("select 
			sum(nvl(vol,1)*nvl(harga_satuan,0))
			from rab_e_jasa_material
			where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi)."
			and kode_biaya = ".$this->conn->escape($kode_biaya)."
			and id_pos_anggaran = ".$this->conn->escape($id_pos_anggaran)."
			and jasa_material = ".$this->conn->escape($jasa_material));

		return $total;
	}

	protected function _hitungSowParent($record){

		$kode_biaya = $record['kode_biaya'];
		$record['kode_biaya'] = $kode_biaya;
		$id_pos_anggaran = $record['id_pos_anggaran'];
		$jasa_material = $record['jasa_material'];
		$id_rab_evaluasi = $this->data['id_rab_evaluasi'];

		$rows = $this->conn->GetArray("select 
			id_rab_detail, id_rab_detail_parent, is_ppn
			from rab_e_detail
			where sumber_nilai = 3
			and id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi)."
			and kode_biaya = ".$this->conn->escape($kode_biaya)."
			and id_pos_anggaran = ".$this->conn->escape($id_pos_anggaran)."
			and jasa_material = ".$this->conn->escape($jasa_material));

		$ret = true;
		if(count($rows))
			foreach ($rows as $r) {
				if(!$ret)
					break;

				$id_rab_detail = $r['id_rab_detail'];
				$total = $this->_hitungSow($record);

				if($r['is_ppn'])
					$total = $total*1.1;

				if(!$total)
					$total = "null";
		
				$this->conn->Execute("update rab_e_detail set nilai_satuan = $total where id_rab_detail = ".$this->conn->escape($id_rab_detail));

				$ret = $this->_hitungSubParent($r['id_rab_detail_parent']);
		}

		return $ret;
	}

	protected function _hitungSowAll($id_rab_evaluasi = null){
		$rows = $this->conn->GetArray("select 
			id_rab_detail, is_ppn, kode_biaya, id_pos_anggaran, jasa_material
			from rab_e_detail
			where sumber_nilai = 3
			and id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

		$ret = true;
		if(count($rows))
			foreach ($rows as $r) {
				if(!$ret)
					break;

				$id_rab_detail = $r['id_rab_detail'];
				$total = $this->_hitungSow($r);

				if($r['is_ppn'])
					$total = (float)$total*1.1;

				if(!$total)
					$total = "null";
		
				$ret = $this->conn->Execute("update rab_e_detail set nilai_satuan = $total where id_rab_detail = ".$this->conn->escape($id_rab_detail));
		}

		return $ret;
	}

	protected function _hitungTotalAll($id_rab_evaluasi = null){
		$this->data['id_rab_evaluasi'] = $id_rab_evaluasi;

		$rows = $this->conn->GetArray("select 
			id_rab_detail_parent
			from rab_e_detail 
			where sumber_nilai <> 1 and id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

		$ret = true;
		if(count($rows))
			foreach ($rows as $r) {
				if(!$ret)
					break;

				$ret = $this->_hitungSubParent($r['id_rab_detail_parent'], true);
		}

		if($ret)
			$ret = $this->_hitungTotalRabParent();

		return $ret;
	}

	protected function _hitungTotalRab($id_rab_detail=null, $id_rab_detail_parent=null){
		$id_rab_evaluasi = $this->data['id_rab_evaluasi'];
		
		$this->conn->Execute("update rab_e_detail set nilai_satuan = null where id_rab_detail = ".$this->conn->escape($id_rab_detail));

		$ret = $this->_hitungSubParent($id_rab_detail_parent, true);

		if($ret){
			$total = $this->conn->GetOne("select sum(nvl(nilai_satuan,0)*nvl(vol,1)) from rab_e_detail where id_rab_detail_parent is null and id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));
		}

		return $total*(5/1000);
	}

	protected function _hitungTotalRabParent(){
		$id_rab_evaluasi = $this->data['id_rab_evaluasi'];

		$rows = $this->conn->GetArray("select id_rab_detail_parent, sumber_nilai, id_rab_detail, is_ppn from rab_e_detail where sumber_nilai = 5 and id_rab_evaluasi = ".$this->conn->escape($this->data['id_rab_evaluasi']));

		$ret = true;
		if(count($rows))
			foreach ($rows as $r) {
				if(!$ret)
					break;

				$id_rab_detail = $r['id_rab_detail'];
				$total = $this->_hitungTotalRab($id_rab_detail, $r['id_rab_detail_parent']);

				if($r['is_ppn'])
					$total = $total*1.1;

				if(!$total)
					$total = "null";
		
				$this->conn->Execute("update rab_e_detail set nilai_satuan = $total where id_rab_detail = ".$this->conn->escape($id_rab_detail));

				$ret = $this->_hitungSubParent($r['id_rab_detail_parent'], true);
		}

		return $ret;
	}

	protected function _hitungMd($record=array()){

		$id_sumber_pegawai = $this->post['id_sumber_pegawai'];
		$id_jabatan_proyek = $this->post['id_jabatan_proyek'];
		$jenis_mandays = $record['jenis_mandays'];
		$id_rab_evaluasi = $this->data['id_rab_evaluasi'];

		$add_filter = "";
		if(is_array($id_jabatan_proyek) && count($id_jabatan_proyek) && is_array($id_sumber_pegawai) && count($id_sumber_pegawai)){
			$this->conn->escape_string($id_jabatan_proyek);
			$add_filter .= " and a.id_jabatan_proyek in ('".implode("','", $id_jabatan_proyek)."')";
			$this->conn->escape_string($id_sumber_pegawai);
			$add_filter .= " and a.id_sumber_pegawai in ('".implode("','", $id_sumber_pegawai)."')";
		}

		if(!$add_filter)
			return 0;

		$row = $this->conn->GetRow("select 
			sum(mx) as mx, 
			sum(tot) as tot
			from (
				SELECT
		        MAX(b.jumlah) AS mx,
		        SUM(b.jumlah) as tot, a.id_manpower
				FROM
			    rab_e_manpower a
			    JOIN rab_e_mandays b ON a.id_manpower = b.id_manpower
				where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi)."
				$add_filter
				group by a.id_manpower
				) a");

		if($record['sumber_satuan']==3){
			if(!$record['pembagi'])
				$ret = $row['tot'];
			else
				$ret = ceil((float)$row['tot']/(float)$record['pembagi']);
		}else{
			if($jenis_mandays==1 or !$jenis_mandays)
				$ret = $row['mx'];
			else
				$ret = $row['tot'];
		}

		return $ret;
	}

	protected function _hitungMdPenawaranParent(){

		$id_rab_evaluasi = $this->data['id_rab_evaluasi'];
		$ret = true;
		$rows = $this->conn->GetArray("select * from rab_penawaran where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi)." and sumber_satuan in (2,3)");

		foreach ($rows as $r) {
			if(!$ret)
				break;

			$this->post['id_jabatan_proyek'] = $this->conn->GetList("select id_jabatan_proyek as val from rab_penawaran_jabatan_proyek where id_rab_penawaran = ".$this->conn->escape($r['id_rab_penawaran']));
			$this->post['id_sumber_pegawai'] = $this->conn->GetList("select id_sumber_pegawai as val from rab_penawaran_sumber_pegawai where id_rab_penawaran = ".$this->conn->escape($r['id_rab_penawaran']));
			
			$record = array();
			$record['vol'] = $this->_hitungMdPenawaran($r);

			$ret = $this->conn->goUpdate("rab_penawaran", $record, "id_rab_penawaran = ".$this->conn->escape($r['id_rab_penawaran']));
		}

		return $ret;
	}

	protected function _hitungMdPenawaran($record=array()){

		$id_sumber_pegawai = $this->post['id_sumber_pegawai'];
		$id_jabatan_proyek = $this->post['id_jabatan_proyek'];
		$jenis_mandays = $record['jenis_mandays'];
		$id_rab_evaluasi = $this->data['id_rab_evaluasi'];

		$add_filter = "";
		if(is_array($id_jabatan_proyek) && count($id_jabatan_proyek) && is_array($id_sumber_pegawai) && count($id_sumber_pegawai)){
			$this->conn->escape_string($id_jabatan_proyek);
			$add_filter .= " and a.id_jabatan_proyek in ('".implode("','", $id_jabatan_proyek)."')";
			$this->conn->escape_string($id_sumber_pegawai);
			$add_filter .= " and a.id_sumber_pegawai in ('".implode("','", $id_sumber_pegawai)."')";
		}

		if(!$add_filter)
			return 0;

		$row = $this->conn->GetRow("select 
			sum(mx) as mx, 
			sum(tot) as tot
			from (
				SELECT
		        MAX(b.jumlah) AS mx,
		        SUM(b.jumlah) as tot, a.id_manpower
				FROM
			    rab_e_manpower a
			    JOIN rab_penawaran_mandays b ON a.id_manpower = b.id_manpower
				where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi)."
				$add_filter
				group by a.id_manpower
				) a");

		if($record['sumber_satuan']==3){
			if(!$record['pembagi'])
				$ret = $row['tot'];
			else
				$ret = ceil((float)$row['tot']/(float)$record['pembagi']);
		}else{
			if($jenis_mandays==1 or !$jenis_mandays)
				$ret = $row['mx'];
			else
				$ret = $row['tot'];
		}

		return $ret;
	}

	protected function _hitungRabAll(){
		$id_rab_evaluasi = $this->data['id_rab_evaluasi'];
		$ret = true;
		$rows = $this->conn->GetArray("select * from rab_penawaran 
			where id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi)." 
			and (sumber_satuan = 4 or sumber_nilai=3)");

		foreach($rows as $r){
			if(!$ret)
				break;

			$record = array();
			if($r['sumber_nilai']==3){
				$id_rab_detail = $this->conn->GetOne("select id_rab_detail from rab_penawaran_rab where id_rab_penawaran = ".$this->conn->escape($r['id_rab_penawaran']));

				$record['nilai_satuan'] = $this->conn->GetOne("select nilai_satuan 
					from rab_e_detail 
					where id_rab_detail = ".$this->conn->escape($id_rab_detail)." 
					and id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));
			}elseif($r['sumber_satuan']==4){
				$id_rab_detailarr = $this->conn->GetList("select id_rab_detail as key, id_rab_detail as val from rab_penawaran_rab where id_rab_penawaran = ".$this->conn->escape($r['id_rab_penawaran']));

				$record['vol'] = $this->conn->GetOne("select sum(vol) from rab_e_detail where id_rab_detail in (".implode(", ",$this->conn->escape_string($id_rab_detailarr)).") and id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));
			}

			$ret = $this->conn->goUpdate("rab_penawaran", $record, "id_rab_penawaran = ".$this->conn->escape($r['id_rab_penawaran']));
		}

		return $ret;
	}

	protected function _reCalculationPenawaran($id_rab_evaluasi){

		$this->data['id_rab_evaluasi'] = $id_rab_evaluasi;

		$ret = $this->_hitungRabAll();

		if($ret)
			$ret = $this->_hitungMdPenawaranParent();

		return $ret;
	}

	protected function _hitungMdParent(){

		$id_rab_evaluasi = $this->data['id_rab_evaluasi'];

		$rows = $this->conn->GetArray("select 
			jenis_mandays, id_rab_detail, id_rab_detail_parent, pembagi, sumber_satuan
			from rab_e_detail
			where sumber_satuan = 2
			and id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi));

		$ret = true;
		if(count($rows))
			foreach ($rows as $r) {
				if(!$ret)
					break;

				$id_rab_detail = $r['id_rab_detail'];

				$this->post['id_jabatan_proyek'] = $this->conn->GetList("select id_jabatan_proyek as val
					from rab_e_detail_jabatan_proyek 
					where id_rab_detail = ".$this->conn->escape($id_rab_detail));

				$this->post['id_sumber_pegawai'] = $this->conn->GetList("select id_sumber_pegawai as val
					from rab_e_detail_sumber_pegawai 
					where id_rab_detail = ".$this->conn->escape($id_rab_detail));

				$vol = $this->_hitungMd($r);

				if(!$vol)
					$vol = "null";

				$this->conn->Execute("update rab_e_detail set vol = $vol where id_rab_detail = ".$this->conn->escape($id_rab_detail));

				$ret = $this->_hitungSubParent($r['id_rab_detail_parent']);
		}

		$id_biaya_produksi_parent = $this->conn->GetOne("select id_biaya_produksi 
			from rab_e_biaya_produksi 
			where sumber_nilai = 3 
			and id_rab_evaluasi = ".$this->conn->escape($this->id_rab_evaluasi));

		if($id_biaya_produksi_parent){
			$rows = $this->conn->GetArray("
			select b.id_jabatan_proyek, b.nama as uraian, a.mandays as vol, 'MD' as satuan, c.hpp as nilai 
			from(
				select c.id_jabatan_proyek, sum(d.jumlah) as mandays
				from rab_e_manpower c
				join rab_e_mandays d on c.id_manpower = d.id_manpower
				where c.id_rab_evaluasi = ".$this->conn->escape($id_rab_evaluasi)."
				and c.id_sumber_pegawai in (3,4)
				group by c.id_jabatan_proyek
			) a
			join mt_jabatan_proyek b on a.id_jabatan_proyek = b.id_jabatan_proyek
			join mt_manpower_rate c on a.id_jabatan_proyek = c.id_jabatan_proyek
			order by c.id_level_jabatan, b.id_jabatan_proyek");

			foreach($rows as $r){
				$id_biaya_produksi = $this->conn->GetOne("select id_biaya_produksi from rab_e_biaya_produksi where id_jabatan_proyek = ".$this->conn->escape($r['id_jabatan_proyek'])." and id_rab_evaluasi = ".$this->conn->escape($this->id_rab_evaluasi));

				$r['id_biaya_produksi_parent'] = $id_biaya_produksi_parent;
				$r['sumber_nilai'] = 3;
				$r['id_rab_evaluasi'] = $this->id_rab_evaluasi;

				if($id_biaya_produksi)	
					$this->conn->goUpdate("rab_e_biaya_produksi", $r, "id_biaya_produksi = ".$this->conn->escape($id_biaya_produksi));
				else
					$this->conn->goInsert("rab_e_biaya_produksi", $r);
			}
		}

		return $ret;
	}

	protected function _reCalculation($id_rab_evaluasi){

		$this->data['id_rab_evaluasi'] = $id_rab_evaluasi;

		$ret = $this->_hitungSowAll($id_rab_evaluasi);

		if($ret)
			$ret = $this->_hitungMdParent();;

		if($ret)
			$ret = $this->_hitungTotalAll($id_rab_evaluasi);

		return $ret;
	}

	protected function reqscm($action=null, $pos=array()){
		$pos['data_auth'] = $this->config->item("auth_hpe");
		return json_decode($this->curlwait($this->config->item("url_hpe")."$action", $pos),true);
	}

	protected function reqscmnowait($action=null, $pos=array()){
		$pos['data_auth'] = $this->config->item("auth_hpe");
		return json_decode($this->curlnowait($this->config->item("url_hpe")."$action", $pos),true);
	}

	protected function reqpromis($action=null, $pos=array(), $debug=false){
		$pos['data_auth'] = $this->config->item("auth_promis");
		return json_decode($this->curlwait($this->config->item("url_promis")."$action", $pos, $debug),true);
	}

	protected function reqpromisnowait($action=null, $pos=array(), $debug=false){
		$pos['data_auth'] = $this->config->item("auth_promis");
		return json_decode($this->curlnowait($this->config->item("url_promis")."$action", $pos, $debug),true);
	}

	public function HeaderExport(){
		return $this->Header();
	}
}
