<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Ajax extends _adminController{

	public function __construct(){
		parent::__construct();
	}

	public function set_toggle(){
		$_SESSION[SESSION_APP]['toggle'] = ($this->get['collapse']?0:1);
	}

	public function listpegawai($unit=null, $subdit=null){
		$data = array("results"=>array());

		$q = $this->conn->escape_str(strtolower($_GET['q']));
		$unit = $this->conn->escape(trim(urldecode($unit)));
		$subdit = $this->conn->escape(trim(urldecode($subdit)));

		if($this->is_pengadaan)
			$unit = $_SESSION[SESSION_APP]['unit'];

		if($q){
			$sql = "select nid as id, nama as text 
				from mt_pegawai 
				where 1=1 ";

			$sql .= " and  lower(nama) like '%$q%' and rownum <= 10";

			$data['results'] = $this->conn->GetArray($sql);
		}

		echo json_encode($data);
	}

	public function listpic($unit=null, $subdit=null){
		$data = array("results"=>array());

		$q = $this->conn->escape_str(strtolower($_GET['q']));
		$unit = $this->conn->escape(trim(urldecode($unit)));
		$subdit = $this->conn->escape(trim(urldecode($subdit)));

		if($this->is_pengadaan)
			$unit = $_SESSION[SESSION_APP]['unit'];

		if($q){
			$sql = "select nid as id, nama as text 
				from mt_pegawai 
				where 1=1 and nid in (select nid from public_sys_user) ";

			$sql .= " and  lower(nama) like '%$q%' and rownum <= 10";

			$data['results'] = $this->conn->GetArray($sql);
		}

		echo json_encode($data);
	}

	public function listcustomer(){
		$data = array("results"=>array());

		$q = $this->conn->escape_str(strtolower($_GET['q']));
		if($q){
			$sql = "select id_customer as id, nama as text 
				from customer 
				where 1=1 ";

			$sql .= " and  lower(nama) like '%$q%' and rownum <= 10";

			$data['results'] = $this->conn->GetArray($sql);
		}

		echo json_encode($data);
	}

	public function listproyek(){
		$data = array("results"=>array());

		$q = $this->conn->escape_str(strtolower($_GET['q']));
		if($q){
			$sql = "select id_proyek as id, nama_proyek as text 
				from proyek 
				where 1=1 ";

			$sql .= " and  lower(nama_proyek) like '%$q%' and rownum <= 10";

			$data['results'] = $this->conn->GetArray($sql);
		}

		echo json_encode($data);
	}
}