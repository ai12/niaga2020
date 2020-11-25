<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Home extends _adminController{
	public $limit = 5;
	public $limit_arr = array('5','10','30','50','100');

	public function __construct(){
		parent::__construct();
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout";
		$this->load->helper('om_helper');
	}
	protected function init(){
		parent::init();

		$update_pembayaran = @file_get_contents("update_pembayaran");
		// if($update_pembayaran<>date('d-m-Y')){
		if(1!=1){
			$this->conn->Execute("delete from niaga_pembayaran");
			$rows = json_decode(@file_get_contents($this->config->item("url_pembayaran")), true);

			if($rows)
			foreach($rows as $r){
				foreach($r as $k=>$v){
					$r[strtolower($k)] = $v;
				}

				list($bln, $tgl, $thn) = explode("/", $r['tanggal_dokumen_ujp']);

				$r['nominal_ujp'] = str_replace(",",".",$r['nominal_ujp']);
				$r['tanggal_dokumen_ujp'] = $tgl.'-'.$bln.'-'.$thn;

				$this->conn->goInsert("niaga_pembayaran", $r);
			}

			$cek = $this->conn->GetOne("select 1 from all_tables where owner = '".strtoupper($this->conn->username)."' and table_name = 'RKAP'");

			if($cek)
				$this->conn->Execute("drop table RKAP");

			$this->conn->Execute("
			create table rkap as
			select a.*, b.nilai as actual_proj, c.actual as actual_keu
			from(
			select sum(est_rev)*-1 as target, a.full_period, substr(a.full_period,0,4) tahun, a.parent_proj4
			from v_niaga_estimate_rekap@keu a
			join (select parent_proj2, full_period, parent_proj4, max(budget_code) budget_code 
			from v_niaga_estimate_rekap@keu 
			group by parent_proj2, full_period, parent_proj4) b on 
			a.parent_proj2 = b.parent_proj2
			and a.full_period = b.full_period
			and a.parent_proj4 = b.parent_proj4
			and a.budget_code = b.budget_code
			group by a.full_period, a.parent_proj4) a
			join(
			select sum(act_rev)*-1 as actual, a.full_period, a.parent_proj4 
			from v_niaga_actual_rekap@keu a
			group by a.full_period, a.parent_proj4) c
			on a.full_period = c.full_period and a.parent_proj4 = c.parent_proj4
			join (
			select 
			sum(nilai) as nilai, tgl, jenis
			from (
			select 
			to_char(tanggal_dokumen_ujp, 'yyyymm') as tgl, 
			case when lower(jenis_tagihan_ujp) = 'proyek' then 'PR' else 'OM' end as jenis, 
			case when ppn_ujp = 'include' then nominal_ujp else nominal_ujp*1.1 end as nilai
			from niaga_pembayaran a) a
			group by tgl, jenis
			) b on a.parent_proj4 = b.jenis and a.full_period = b.tgl");

			@file_put_contents("update_pembayaran", date('d-m-Y'));
		}
	}



	function Index($page=0){
		if($this->post['act']=='get_task'){
			$this->load->model("Mt_tipe_kegiatan_taskModel","mttipekegiatantask");
			$this->data['mttipekegiatantaskarr'] = $this->mttipekegiatantask->GetCombo();

			if(strstr($this->post['id'],"task")!=false){
				$row = $this->conn->GetRow("select * from task where id_task = ".$this->conn->escape(str_replace("task_","",$this->post['id'])));

				$this->data['row'] = $row;

				$rows = $this->conn->GetArray("select *
					from task_files
					where jenis_file = 'file' and id_task = ".$this->conn->escape($row['id_task']));

				foreach($rows as $r){
					$this->data['row'][$r['jenis_file']]['id'] = $r['id_task_files'];
					$this->data['row'][$r['jenis_file']]['name'] = $r['client_name'];
				}
			}

			if(strstr($this->post['id'],"customer")!=false){
				$row = $this->conn->GetRow("select * from customer where id_customer = ".$this->conn->escape(str_replace("customer_","",$this->post['id'])));
				$this->data['row'] = array();
				$this->data['row']['nama'] = "Ulang tahun ".$row['nama'];
				$this->data['row']['id_tipe_kegiatan_task'] = 6;
				$this->data['row']['id_customer'] = $row['id_customer'];
			}

			if(strstr($this->post['id'],"contact")!=false){
				$row = $this->conn->GetRow("select * from customer_contacts where id_customer_contacts = ".$this->conn->escape(str_replace("contact_","",$this->post['id'])));
				$this->data['row'] = array();
				$this->data['row']['nama'] = "Ulang tahun ".$row['nama'];
				$this->data['row']['id_tipe_kegiatan_task'] = 6;
				$this->data['row']['id_customer'] = $row['id_customer'];
			}

			$this->data['customerarr'][$row['id_customer']] = $this->conn->GetOne("select nama from customer where id_customer = ".$this->conn->escape($row['id_customer']));

			echo "<div class='row'>";
			$this->PartialView("panelbackend/taskdetail");
			echo "</div>";
			exit();
		}

		if($this->get['act']=='get_events'){
			$range_start = parseDateTime($_GET['start'])->format('d-m-Y');
			$range_end = parseDateTime($_GET['end'])->format('d-m-Y');
			
			$rows = $this->conn->GetArray("select a.* 
				from task a 
				where (tgl_awal between '$range_start' and '$range_end' or tgl_akhir between '$range_start' and '$range_end')");

			$output_arrays = array();
			foreach($rows as $r){
				$r['allDay']=false;
				$r['id']="task_".$r['id_task'];
				$r['title'] = $r['nama'];
				$r['description'] = $r['nama'];
				$r['start'] = date("Y-m-d H:i:s",strtotime($r['tgl_awal']));
				$r['end'] = date("Y-m-d H:i:s",strtotime($r['tgl_akhir']));
				$output_arrays[] = $r;
			}

			$start = date("Ymd",strtotime($range_start));
			$end = date("Ymd",strtotime($range_end));
			$th1 = date("Y",strtotime($range_start));
			$th2 = date("Y",strtotime($range_end));
			$addf1 = "or '$th2'||to_char(tgl_berdiri,'MMDD') between '$start' and '$end'";
			$addf2 = "or '$th2'||to_char(tgl_lahir,'MMDD') between '$start' and '$end'";

			if($th1==$th2){
				$th2 = null;
				$addf1 = null;
				$addf2 = null;
			}

			$rows = $this->conn->GetArray("select a.*
			from customer a
			where ('$th1'||to_char(tgl_berdiri,'MMDD') between '$start' and '$end' $addf1) and tgl_berdiri is not null");


			foreach($rows as $r){
				$r['allDay']=true;
				$r['id']="customer_".$r['id_customer'];
				$r['title'] = "Ulang tahun ".$r['nama'];
				$r['description'] = "Ulang tahun ".$r['nama'];
				$r['start'] = $th1.date("-m-d H:i:s",strtotime($r['tgl_berdiri']));
				$r['end'] = $th1.date("-m-d H:i:s",strtotime($r['tgl_berdiri']));
				$output_arrays[] = $r;
				if($th2){
					$r1 = $r;

					$r1['start'] = $th2.date("-m-d H:i:s",strtotime($r['tgl_berdiri']));
					$r1['end'] = $th2.date("-m-d H:i:s",strtotime($r['tgl_berdiri']));

					$output_arrays[] = $r1;
				}
			}

			$rows = $this->conn->GetArray("select a.*, b.nama as nama_customer
			from customer_contacts a
			join customer b on a.id_customer = b.id_customer
			where ('$th1'||to_char(tgl_lahir,'MMDD') between '$start' and '$end' $addf2) and tgl_lahir is not null");

			foreach($rows as $r){
				$r['allDay']=true;
				$r['id']="contact_".$r['id_customer_contacts'];
				$r['title'] = "Ulang tahun ".$r['nama']." dari ".$r['nama_customer'];
				$r['description'] = "Ulang tahun ".$r['nama']." dari ".$r['nama_customer'];
				$r['start'] = $th1.date("-m-d H:i:s",strtotime($r['tgl_lahir']));
				$r['end'] = $th1.date("-m-d H:i:s",strtotime($r['tgl_lahir']));
				$output_arrays[] = $r;
				if($th2){
					$r1 = $r;

					$r1['start'] = $th2.date("-m-d H:i:s",strtotime($r['tgl_lahir']));
					$r1['end'] = $th2.date("-m-d H:i:s",strtotime($r['tgl_lahir']));

					$output_arrays[] = $r1;
				}
			}

			echo json_encode($output_arrays);
			exit();
		}

		$tahun = date('Y');

		if($this->post['tahun'])
			$_SESSION[SESSION_APP][$this->page_ctrl]['tahun'] = $this->post['tahun'];

		if($_SESSION[SESSION_APP][$this->page_ctrl]['tahun'])
			$tahun = $_SESSION[SESSION_APP][$this->page_ctrl]['tahun'];

		$this->data['tahun'] = $tahun;


		$this->load->model("Mt_kategori_keluhanModel","mtkategorikeluhan");
		$mtkategoriarr = $this->mtkategorikeluhan->GetCombo();
		$statusarr = array(''=>'','1'=>'Belum ditindak lanjuti','2'=>'Distribusi', '3'=>'Action', '4'=>'Close');

		$this->data['statuskeluhan'] = $this->conn->GetArray("select count(1) as value, status
			from keluhan 
			where to_char(tanggal, 'YYYY') = ".$this->conn->escape($tahun)."
			group by status");

		foreach ($this->data['statuskeluhan'] as &$r1) {
			$r1['label'] = $statusarr[$r1['status']];
		}

		$this->data['kategorikeluhan'] = $this->conn->GetArray("select count(1) value, id_kategori_keluhan
			from keluhan 
			where to_char(tanggal, 'YYYY') = ".$this->conn->escape($tahun)."
			group by id_kategori_keluhan");

		foreach ($this->data['kategorikeluhan'] as &$r1) {
			$r1['label'] = $mtkategoriarr[$r1['id_kategori_keluhan']];
		}


		$this->load->model("Mt_type_opportunitiesModel","mttypeopportunities");
		$mttypeopportunitiesarr = $this->mttypeopportunities->GetCombo();
		$this->load->model("Mt_jenis_opportunitiesModel","mtjenisopportunities");
		$mtjenisopportunitiesarr = $this->mtjenisopportunities->GetCombo();
		$statusarr = array(''=>'','0'=>'Belum ditindak lanjuti','1'=>'Sudah ditindak lanjuti');

		$this->data['tipeopp'] = $this->conn->GetArray("select count(1) value, id_tipe_opportunities
			from opportunities 
			where tahun_rencana = ".$this->conn->escape($tahun)."
			group by id_tipe_opportunities");

		foreach ($this->data['tipeopp'] as &$r1) {
			$r1['label'] = $mttypeopportunitiesarr[$r1['id_tipe_opportunities']];
		}

		$this->data['jenisopp'] = $this->conn->GetArray("select count(1) value, id_jenis_opportunities
			from opportunities 
			where tahun_rencana = ".$this->conn->escape($tahun)."
			group by id_jenis_opportunities");

		foreach ($this->data['jenisopp'] as &$r1) {
			$r1['label'] = $mtjenisopportunitiesarr[$r1['id_jenis_opportunities']];
		}

		$this->data['statusopp'] = $this->conn->GetArray("select count(1) value, status
			from opportunities 
			where tahun_rencana = ".$this->conn->escape($tahun)."
			group by status");

		foreach ($this->data['statusopp'] as &$r1) {
			$r1['label'] = $statusarr[$r1['status']];
		}

		$rows = $this->conn->GetArray("select tahun, full_period, parent_proj4, sum(actual_proj) actual_proj, sum(actual_keu) actual_keu, sum(target) target from rkap where tahun = ".$this->conn->escape($tahun)." group by tahun, full_period, parent_proj4 order by full_period");

		$this->data['row']=array();
		$this->data['project']=array();
		foreach($rows as $r){
			$r['full_period'] = get_bulan_mini(substr($r['full_period'], 4,3));
			$this->data['row'][$r['tahun']][$r['parent_proj4']]['target'] += $r['target'];
			$this->data['row'][$r['tahun']][$r['parent_proj4']]['actual_proj'] += $r['actual_proj'];
			$this->data['row'][$r['tahun']][$r['parent_proj4']]['actual_keu'] += $r['actual_keu'];
			$this->data['grafik'][$r['parent_proj4']][] = $r;
		}
		$this->layout = "panelbackend/layout2";
		$this->View("panelbackend/home");
	}


	function Loginasback(){
		if(!($_SESSION[SESSION_APP]['loginas']))
			redirect('panelbackend');

		$loginas = $_SESSION[SESSION_APP]['loginas'];
		unset($_SESSION[SESSION_APP]);
		$_SESSION[SESSION_APP] = $loginas;

		redirect('panelbackend');
	}

	function Profile(){
		$this->access_mode[]='save';
		$this->access_mode[]='batal';
		$this->data['page_title'] = 'Profile';

		$this->load->model("Public_sys_userModel","model");

		$id=$_SESSION[SESSION_APP]['user_id'];
		$this->data['edited'] = true;

		$this->data['row'] = $this->model->GetByPk($id);
		if (!$this->data['row'] && $id)
			$this->NoData();
		
		## EDIT HERE ##
		if ($this->post['act'] === 'save') {

			$valid = $this->_isValidProfile();
			if(!$valid){
				$this->View('panelbackend/profile');
				return;
			}

			$record = array();
			$record['name'] = $this->post['name'];

			if(!empty($this->post['password']))
			{
				$record['password']=sha1(md5($this->post['password']));
			}

            $this->_setLogRecord($record,$id);

			if ($id) {
				$return = $this->model->Update($record, "user_id = $id");
				if ($return) {
					SetFlash('suc_msg', $return['success']);
					redirect("panelbackend/home/profile");					
				}
				else {
					$this->data['row'] = $record;
					$this->data['err_msg'] = "Data gagal diubah";
				}
			}
		}
				
		$this->View('panelbackend/profile');
	}

	function _isValidProfile(){

		$rules = array(
		   array(
				 'field'   => 'name',
				 'label'   => 'Nama',
				 'rules'   => 'required'
			  )
		);
		if($isnew=="true"){
			$rules[]=array(
				'field'   => 'password',
				'label'   => 'Password',
				'rules'   => 'required'
			);
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules($rules);

		$error_msg = '';
		if ($this->form_validation->run() == FALSE)
		{
			$error_msg .= validation_errors();
		}

		if($this->post['password']<>$this->post['confirmpassword']){
			if($error_msg) $error_msg.="<br/>";
			
			$error_msg .= "Konfirmasi password salah";
		}

		if($error_msg){
			if(!$this->data['row'])
				$this->data['row'] = array();

			$this->data['row'] = array_merge($this->data['row'],$this->post);
			$this->data['err_msg'] = $error_msg;
			return false;
		}

		return true;
	}

	function ug(){
		if($_SESSION[SESSION_APP]['group_id']==1)
			$full_path = FCPATH."assets/doc/1.pdf";
		elseif($_SESSION[SESSION_APP]['group_id']==68)
			$full_path = FCPATH."assets/doc/68.pdf";
		elseif($_SESSION[SESSION_APP]['group_id']==48)
			$full_path = FCPATH."assets/doc/48.pdf";
		elseif($_SESSION[SESSION_APP]['group_id']==49)
			$full_path = FCPATH."assets/doc/49.pdf";
		elseif($_SESSION[SESSION_APP]['group_id']==50)
			$full_path = FCPATH."assets/doc/50.pdf";
		elseif($_SESSION[SESSION_APP]['group_id']==51)
			$full_path = FCPATH."assets/doc/51.pdf";
		elseif($_SESSION[SESSION_APP]['group_id']==52)
			$full_path = FCPATH."assets/doc/52.pdf";
		elseif($_SESSION[SESSION_APP]['group_id']==88)
			$full_path = FCPATH."assets/doc/88.pdf";

		header("Content-Type: application/pdf");
		header("Content-Disposition: inline; filename='ug.pdf'");
		echo file_get_contents($full_path);
		die();
	}

	function mon_settlement(){
		$this->layout = "panelbackend/proto_mon_settlement";
		$this->View("panelbackend/home");	
	}
	function mon_settlement_bruto(){
		$this->layout = "panelbackend/proto_settlement_bruto";
		$this->View("panelbackend/home");	
	}
	function mon_settlement_sla(){
		$this->layout = "panelbackend/proto_settlement_bruto";
		$this->View("panelbackend/home");	
	}
}
