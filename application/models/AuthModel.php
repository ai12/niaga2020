<?php class AuthModel extends _Model
{
	function __construct()
	{
		parent::__construct();
	}
	public function Login($usernamea = "", $passworda = "")
	{
		$username = $this->conn->qstr($usernamea);
		$password = $this->conn->qstr(sha1(md5($passworda)));
		$data = $this->GetRow("
		select * from public_sys_user
        where username=$username
        and password=$password
		and is_active = '1'
        ");
       
        if(!is_null($data)){

            $this->SetLogin($data);
        }
        
		if ($data['user_id'] != 1) {
			return $this->autoLogin($usernamea, $passworda);
		} elseif ($data) {
			$this->SetLogin($data);
			return array('success' => 'login berhasil');
        }
        
        return $this->autoLogin($usernamea, $passworda);
		// return array('error' => 'login gagal');
	}

	public function LoginWs($usernamea = "", $passworda = "")
	{
		$username = $this->conn->qstr($usernamea);
		$password = $this->conn->qstr($passworda);
		$data = $this->GetRow("
		select * from public_sys_user
		where username=$username and password=$password
		and is_active = '1'
		");
		if ($data) {
			$this->SetLoginWs($data);
			return array('success' => 'login berhasil');
		}
		return array('error' => 'login gagal');
	}

	private function SetLoginWs($data = array(), $tokenarr = array())
	{
		$data = (array) $data;

		$data['login'] = true;
		unset($data['password']);

		if ($data['KODE_GROUP']) {
			$data['group_id'] = $data['KODE_GROUP'];
		}

		if ($data['PEGAWAI']) {
			$data['name'] = $data['PEGAWAI'];
		}

		$data['nama_group'] = $this->conn->GetOne("select name from public_sys_group where group_id = " . $this->conn->escape($data['group_id']));

		$temp = $data;
		foreach ($temp as $k => $v) {
			$k = strtolower($k);
			$data[$k] = $v;
			$_SESSION[SESSION_APP][$k] = $v;
		}

		$datenow = $this->conn->sysTimeStamp;
		$this->conn->Execute("
		update public_sys_user
		set last_ip = '{$_SERVER['REMOTE_ADDR']}', last_login = $datenow
		where username = '{$data['username']}'");
	}

	public function autoLogin($username = null, $password = null)
	{
		ini_set('soap.wsdl_cache_enabled', 0);
		$wsdl = 'http://portal.pjbservices.com/index.php/portal_login?wsdl';
       
		$cl = new SoapClient($wsdl);

        $rv = $cl->loginAplikasi(58, $username, $password);
       
		$credential = $cl->getToken($username);

		if (!$credential)
			return array("error" => "Login gagal pastikan username dan password sama dengan di portal.pjbservices.com");

		if ($rv->RESPONSE == "1") {

			$tokenarr = array(
				'username' => $username,
				'credential' => $credential,
			);
			$this->SetLogin($rv, $tokenarr);

			return array('success' => 'login berhasil');
		} elseif ($rv->RESPONSE == "PAGE") {
			return array(
				'success' => 'login berhasil',
				'link' => "http://portal.pjbservices.com/" . $rv->RESPONSE_LINK . "/?reqNID=" . $rv->NID . "&reqAplikasiId=" . $rv->APLIKASI_ID
			);
		} else
			return array('success' => 'login berhasil');
	}

	private function SetLogin($data = array(), $tokenarr = array())
	{
		$data = (array) $data;

		$data['login'] = true;
		unset($data['password']);

		if ($data['KODE_GROUP']) {
			$data['group_id'] = $data['KODE_GROUP'];
		}

		if ($data['PEGAWAI']) {
			$data['name'] = $data['PEGAWAI'];
		}

		$temp = $data;
		foreach ($temp as $k => $v) {
			$k = strtolower($k);
			$data[$k] = $v;
			$_SESSION[SESSION_APP][$k] = $v;
		}

		foreach ($tokenarr as $k => $v) {
			$_SESSION[SESSION_APP][$k] = $v;
		}

		$menuarr = $this->GetMenuArr();

		$_SESSION[SESSION_APP]['menu'] = $menuarr;

		$datenow = $this->conn->sysTimeStamp;
		$this->conn->Execute("
		update public_sys_user
		set last_ip = '{$_SERVER['REMOTE_ADDR']}', last_login = $datenow
		where username = '{$data['username']}'");
	}

	function deleteAfter($url,$key='')
	{
		$pos = strpos($url, $key);
		if ($pos !== false){
			
			$rs = substr($url, 0, $pos);
		}else{
			
			$rs = $url;
		}
		

		return $rs;
	}	
	function deleteAfterPlus($url,$key='')
	{
		$pos = strpos($url, $key);
		if ($pos !== false){
			
			$rs = substr($url, 0, $pos).$key;
		}else{
			
			$rs = $url;
		}
		

		return $rs;
	}	

	public function GetMenu($data = null, $ul = "<ul class=\"nav navbar-nav\">", &$child_active = '', $ischild = false, $level = 1)
	{

		$level++;

		if (!$data) {
			$start = true;
			// $data = $_SESSION[SESSION_APP]['menu'];
			$data = $this->GetMenuArr();
		}

		if ($data) {
			$fulluri = current_url();
			$ret .= "\n $ul \n ";
			foreach ($data as $row) {

				$url = $row['url'];
				if (!$ischild)
					$icon = $row['icon'];


				$active = "";
				// $str = str_replace(array('/index', '/detail', '/edit', '/add'), '', $fulluri);
				$str = $this->deleteAfter($fulluri,'/index');
				$str = $this->deleteAfter($str,'/detail');
				$str = $this->deleteAfter($str,'/edit');
				$str = $this->deleteAfter($str,'/add');
				$str = $this->deleteAfter($str,'/radir');
				$str = $this->deleteAfterPlus($str,'/biaya');
				$str = $this->deleteAfterPlus($str,'/lap_lr');
				$str = $this->deleteAfterPlus($str,'/lap_sla');
				$str = $this->deleteAfterPlus($str,'/bruto');
				
				if (strpos($url, "proyek_pekerjaan") !== false) {

					$find = str_replace(array('/detail', '/index'), '', $url);

					if (strpos($str, $find) !== false)
						$child_active = $active = "active";

					$find = str_replace(array('/detail', '/index'), '', "panelbackend/rab");

					if (strpos($str, $find) !== false)
						$child_active = $active = "active";

					$find = str_replace(array('/detail', '/index'), '', "panelbackend/rab_manpower");

					if (strpos($str, $find) !== false)
						$child_active = $active = "active";
				}
				elseif (strpos($url, "/laporan_om") !== false) {
					$find = str_replace(array('/detail', '/index'), '', $url);
					if ($str==$find)
						$child_active = $active = "active";
				}
				elseif (strpos($url, "mon_settlement_proyek") !== false) {
					$find = str_replace(array('detail', 'index'), '', $url);
					if (strpos($str, $find) !== false)
						$child_active = $active = "active";
				}
				elseif (strpos($url, "mon_settlement") !== false) {
					$find = str_replace(array('/detail', '/index', '/radir'), '', $url);
					if ($str==$find)
						$child_active = $active = "active";
				}
				// elseif (strpos($url, "t_kontrak") !== false) {
				// 	$find = str_replace(array('detail', 'index'), '', $url);
				// 	if ($str==$find)
				// 		$child_active = $active = "active";
				// }
				else {

					$find = str_replace(array('/detail', '/index'), '', $url);
					if (strpos($str, $find) !== false)
						$child_active = $active = "active";
				}
				//  echo 'cek:'.$str.'|'.$find."\n";
				//  echo 'cek:'.$fulluri.'|'.strstr($fulluri,'index',true)."\n";
				//  echo 'cek2:'.$fulluri.'|'.substr($fulluri, 0, strpos($fulluri, 'biaya'))."\n";
				//  echo 'cek2:'.$fulluri.'|'.strtok($fulluri, 'biaya') ."\n";

				$child_active1 = '';
				$sub = '';
				if (count($row['sub'])) {
					$sub = $this->GetMenu($row['sub'], "<ul class=\"dropdown-menu\" role=\"menu\">", $child_active1, 1, $level);
				}
				

				if ($sub) {
					if ($level > 2) {
						if ($child_active1)
							$child_active = $child_active1;

						$ret .= "<li class=\"$child_active1 dropdown-submenu\">\n";
					} else {
						$ret .= "<li class=\"$child_active1\">\n";
					}
					$ret .= "<a href='" . $url . "' class=\"dropdown-toggle\" data-toggle=\"dropdown\">\n<span class='fa fa-{$icon} '></span> " . $row['label'] . "<span class=\"caret\"></span>\n</a>\n";
					$ret .= $sub;
				} else {
					$ret .= "<li class=\"$active\">\n";
					$ret .= "<a href='" . $url . "'><span class='fa fa-{$icon} '></span> " . $row['label'] . "</a>\n";
				}
				$ret .= "</li>\n";
			}

			$ret .= "</ul>";
		}
		return $ret;
	}

	public function GetTabProyek($id = null, $id_proyek_pekerjaan, $id_rab = null, $is_approve = false)
	{

		$data = array();

		if ($id) {
			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/proyek']) {
				$data += array(
					"proyek" => array("url" => site_url("panelbackend/proyek/detail/$id"), "label" => "DETAIL PROYEK", "icon" => "angle-right"),
				);
			}

			if (!$id_rab) {
				if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/proyek_pekerjaan']) {
					$data += array(
						"proyek_pekerjaan" => array("url" => site_url("panelbackend/proyek_pekerjaan/index/$id"), "label" => "DAFTAR PEKERJAAN", "icon" => "angle-right"),
					);
				}
			}
		}

		if ($id_proyek_pekerjaan) {
			if ($id_rab) {
				$data += array(
					"proyek_pekerjaan" => array("url" => site_url("panelbackend/proyek_pekerjaan/detail/$id/$id_proyek_pekerjaan"), "label" => "DETAIL PEKERJAAN", "icon" => "angle-right"),
				);
			}

			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/rab_detail']) {
				$data += array(
					"rab_detail" => array("url" => site_url("panelbackend/rab_detail/index/$id_rab"), "label" => "RAB RENDAL", "icon" => "angle-right"),
				);
			}

			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/rab_detail']) {
				$data += array(
					"rab_e_detail" => array("url" => site_url("panelbackend/rab_e_detail/index/$id_rab"), "label" => "RAB EVALUASI", "icon" => "angle-right"),
				);
			}

			$data += array(
				"rab_penawaran" => array("url" => site_url("panelbackend/rab_penawaran/index/$id_rab"), "label" => "PRICING", "icon" => "angle-right"),
			);
		}

		if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/proyek_keluhan']) {
			$data += array(
				"proyek_keluhan" => array("url" => site_url("panelbackend/proyek_keluhan/index/$id"), "label" => "KELUHAN", "icon" => "angle-right"),
			);
		}

		if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/proyek_folder']) {
			$data += array(
				"proyek_folder" => array("url" => site_url("panelbackend/proyek_folder/index/$id"), "label" => "FILE PROYEK", "icon" => "angle-right"),
			);
		}
		if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/mon_proyekselesai']) {
			$data += array(
				"mon_proyekselesai" => array("url" => site_url("panelbackend/mon_proyekselesai/edit/$id"), "label" => "FINISHING KONTRAK", "icon" => "angle-right"),
			);
		}

		$curr_url = current_url();

		$curr_url = str_replace(array("rab_jasa_material", "rab_manpower"), "rab_detail", $curr_url);
		$curr_url = str_replace(array("rab_e_jasa_material", "rab_e_manpower"), "rab_e_detail", $curr_url);

		$ret .= "<ul class='nav nav-tabs'>";
		
		foreach ($data as $page => $row) {

			$url = $row['url'];

			$active = "";
			
			if (str_replace("panelbackend/", "", $this->page_ctrl) == $page)
				$active = "active";

			$ret .= "<li class=\"$active\">\n";
			$ret .= "<a href='" . $url . "'> <i class='fa fa-{$icon} '></i> " . $row['label'] . " </a>\n";
			$ret .= "</li>\n";
		}
		
		$ret .= "</ul>";

		return $ret;
	}

	public function GetTabRab($id = null, $id_proyek_pekerjaan, $id_rab = null, $is_approve = false)
	{

		$data = array();

		if ($id_proyek_pekerjaan) {

			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/rab_jasa_material']) {
				$data += array(
					"rab_jasa_material" => array("url" => site_url("panelbackend/rab_jasa_material/index/$id_rab"), "label" => "JASA MATERIAL", "icon" => "angle-right"),
				);
			}

			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/rab_manpower']) {
				$data += array(
					"rab_manpower" => array("url" => site_url("panelbackend/rab_manpower/index/$id_rab"), "label" => "TENAGA KERJA", "icon" => "angle-right"),
				);
			}

			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/rab_detail']) {
				$data += array(
					"rab_detail" => array("url" => site_url("panelbackend/rab_detail/index/$id_rab"), "label" => "KOMPONEN BIAYA", "icon" => "angle-right"),
				);
			}
		}

		$curr_url = current_url();

		$ret .= "<ul class='nav nav-tabs'>";


		foreach ($data as $page => $row) {

			$url = $row['url'];

			$active = "";

			if (str_replace("panelbackend/", "", $this->page_ctrl) == $page)
				$active = "active";

			$ret .= "<li class=\"$active\">\n";
			$ret .= "<a href='" . $url . "'> <i class='fa fa-{$icon} '></i> " . $row['label'] . " </a>\n";
			$ret .= "</li>\n";
		}

		$ret .= "</ul>";

		return $ret;
	}

	public function GetCustomer($id_customer = null)
	{

		$data = array();

		if ($id_customer) {

			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/customer']) {
				$data += array(
					"customer" => array("url" => site_url("panelbackend/customer/detail/$id_customer"), "label" => "INFORMASI", "icon" => "angle-right"),
				);
			}

			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/customer_office']) {
				$data += array(
					"customer_office" => array("url" => site_url("panelbackend/customer_office/index/$id_customer"), "label" => "OFFICE/SITE", "icon" => "angle-right"),
				);
			}

			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/customer_contacts']) {
				$data += array(
					"customer_contacts" => array("url" => site_url("panelbackend/customer_contacts/index/$id_customer"), "label" => "CONTACTS", "icon" => "angle-right"),
				);
			}

			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/customer_task']) {
				$data += array(
					"customer_task" => array("url" => site_url("panelbackend/customer_task/index/$id_customer"), "label" => "TASK", "icon" => "angle-right"),
				);
			}
		}

		$curr_url = current_url();

		$ret .= "<ul class='nav nav-tabs'>";


		foreach ($data as $page => $row) {

			$url = $row['url'];

			$active = "";

			if (str_replace("panelbackend/", "", $this->page_ctrl) == $page)
				$active = "active";

			$ret .= "<li class=\"$active\">\n";
			$ret .= "<a href='" . $url . "'> <i class='fa fa-{$icon} '></i> " . $row['label'] . " </a>\n";
			$ret .= "</li>\n";
		}

		$ret .= "</ul>";

		return $ret;
	}

	public function GetTabRabEvaluasi($id = null, $id_proyek_pekerjaan, $id_rab = null, $is_approve = false)
	{

		$data = array();

		if ($id_proyek_pekerjaan) {

			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/rab_e_jasa_material']) {
				$data += array(
					"rab_e_jasa_material" => array("url" => site_url("panelbackend/rab_e_jasa_material/index/$id_rab"), "label" => "JASA MATERIAL", "icon" => "angle-right"),
				);
			}

			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/rab_e_manpower']) {
				$data += array(
					"rab_e_manpower" => array("url" => site_url("panelbackend/rab_e_manpower/index/$id_rab"), "label" => "TENAGA KERJA", "icon" => "angle-right"),
				);
			}

			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/rab_e_detail']) {
				$data += array(
					"rab_e_detail" => array("url" => site_url("panelbackend/rab_e_detail/index/$id_rab"), "label" => "KOMPONEN BIAYA", "icon" => "angle-right"),
				);
			}


			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/rab_e_biaya_produksi']) {
				$data += array(
					"rab_e_biaya_produksi" => array("url" => site_url("panelbackend/rab_e_biaya_produksi/index/$id_rab"), "label" => "CASH OUT", "icon" => "angle-right"),
				);
			}
		}

		$curr_url = current_url();

		$ret .= "<ul class='nav nav-tabs'>";

		foreach ($data as $page => $row) {

			$url = $row['url'];

			$active = "";

			if (str_replace("panelbackend/", "", $this->page_ctrl) == $page)
				$active = "active";

			$ret .= "<li class=\"$active\">\n";
			$ret .= "<a href='" . $url . "'> <i class='fa fa-{$icon} '></i> " . $row['label'] . " </a>\n";
			$ret .= "</li>\n";
		}

		$ret .= "</ul>";

		return $ret;
	}

	public function GetTabPricing($id = null, $id_proyek_pekerjaan, $id_rab = null, $is_approve = false)
	{

		$data = array();

		if ($id_proyek_pekerjaan) {

			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/rab_penawaran_mandays']) {
				$data += array(
					"rab_penawaran_mandays" => array("url" => site_url("panelbackend/rab_penawaran_mandays/index/$id_rab"), "label" => "TENAGA KERJA", "icon" => "angle-right"),
				);
			}

			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/rab_penawaran']) {
				$data += array(
					"rab_penawaran" => array("url" => site_url("panelbackend/rab_penawaran/index/$id_rab"), "label" => "KOMPONEN BIAYA", "icon" => "angle-right"),
				);
			}
		}

		$curr_url = current_url();

		$ret .= "<ul class='nav nav-tabs'>";

		foreach ($data as $page => $row) {

			$url = $row['url'];

			$active = "";

			if (str_replace("panelbackend/", "", $this->page_ctrl) == $page)
				$active = "active";

			$ret .= "<li class=\"$active\">\n";
			$ret .= "<a href='" . $url . "'> <i class='fa fa-{$icon} '></i> " . $row['label'] . " </a>\n";
			$ret .= "</li>\n";
		}

		$ret .= "</ul>";

		return $ret;
	}

	public function LoginAs($username = "")
	{
		$username = $this->conn->qstr($username);
		$data = $this->GetRow("
		select * from public_sys_user
		where username=$username
		and is_active = '1'
		");
		if ($data) {

			$loginas = $_SESSION[SESSION_APP];
			unset($_SESSION[SESSION_APP]);

			$data['login'] = true;
			unset($data['password']);

			foreach ($data as $k => $v) {
				$_SESSION[SESSION_APP][$k] = $v;
			}

			if ($data['nid']) {
				$datakaryawan = $this->GetRow("select * from mt_pegawai where nid='{$data['nid']}'");

				foreach ($datakaryawan as $k => $v) {
					$_SESSION[SESSION_APP][$k] = $v;
				}
			}

			$_SESSION[SESSION_APP]['loginas'] = $loginas;

			$menuarr = $this->GetMenuArr();
			$_SESSION[SESSION_APP]['menu'] = $menuarr;

			$datenow = $this->conn->sysTimeStamp;
			$this->conn->Execute("
			update public_sys_user
			set last_ip = '{$_SERVER['REMOTE_ADDR']}', last_login = $datenow
			where username = '{$data['username']}'");
			return array('success' => 'login success');
		}
		return array('error' => 'login filed');
	}

	private function GetMenuArr($parent_id = null)
	{
        $ret = '';
        // var_dump($_SESSION);
		$group_id = $_SESSION[SESSION_APP]['group_id'];
		$user_id = $_SESSION[SESSION_APP]['user_id'];
		$filter = ($parent_id == null) ? 'b.parent_id is null' : 'b.parent_id = ' . $parent_id;
		if ($user_id == 1) {
			$strSQL = " SELECT b.*
						FROM public_sys_menu b
						WHERE $filter
						ORDER BY b.sort";
		} else {
			$filter .= " and a.group_id =" . $group_id;
			$strSQL = "	SELECT b.*
						FROM public_sys_group_menu a
						LEFT JOIN public_sys_menu b ON a.menu_id = b.menu_id
						WHERE $filter
						ORDER BY b.sort";
		}

		$data = $this->GetArray($strSQL);

		$ret = array();
		if ($data) {
			foreach ($data as $row) {

				$_SESSION[SESSION_APP]['access_menu'][$row['url']] = 1;

				//if($row['label']=='Setting')
				//	$ret=array_merge($ret,$this->GetMenuCmsArr());

				$url = '#';
				if ($row['url'] != '') {
					$url = base_url($row['url']);
				}

				$icon = 'folder';
				if ($row['iconcls']) {
					$icon = $row['iconcls'];
				}

				$sub = $this->GetMenuArr($row['menu_id']);

				if ($row['visible']) {
					$ret[] = array(
						"label" => $row["label"],
						"icon" => $icon,
						"url" => $url,
						"sub" => $sub,
					);
				}
			}
		}
		return $ret;
	}

	public function GetAction($url, $type)
	{
		$group_id = $_SESSION[SESSION_APP]['group_id'];
		$user_id = $_SESSION[SESSION_APP]['user_id'];
		if ($user_id == 1) {
			$strSQL = "
				SELECT b.name
				from public_sys_action b
				LEFT JOIN public_sys_menu d ON b.menu_id=d.menu_id
				WHERE type = '$type' and b.visible = '1' AND d.url='$url'";
		} else {
			$strSQL = "
				SELECT b.name
				FROM public_sys_group_action a
				LEFT JOIN public_sys_action b ON a.action_id=b.action_id
				LEFT JOIN public_sys_group_menu c ON a.group_menu_id=c.group_menu_id
				LEFT JOIN public_sys_menu d ON c.menu_id=d.menu_id
				WHERE type = '$type'  and b.visible = '1' AND c.group_id = $group_id AND d.url='$url'";
		}

		$respons = $this->GetArray($strSQL);
		$respon = array();
		foreach ($respons as $row) {
			$respon[] = $row['name'];
		}
		return $respon;
	}

	public function GetAccessRole($url = "")
	{
		$group_id = $_SESSION[SESSION_APP]['group_id'];

		if ($_SESSION[SESSION_APP]['user_id'] == 1) {
			$sql = "
				SELECT
				    nvl(b.name,'index') as name
				FROM
				    public_sys_menu d
				    left join
				    public_sys_action b ON b.menu_id = d.menu_id
				WHERE d.url='$url'";
		} else {
			$sql = "
				SELECT
				    nvl(b.name,'index') as name
				FROM
				    public_sys_menu d
				        LEFT JOIN
				    public_sys_group_menu c ON c.menu_id = d.menu_id
				        left join
				    public_sys_group_action a ON a.group_menu_id = c.group_menu_id
				        LEFT JOIN
				    public_sys_action b ON a.action_id = b.action_id
				WHERE c.group_id = '$group_id' AND d.url='$url'";
		}
		
		$data = $this->GetArray($sql);
		$return = array();
		foreach ($data as $key => $value) {
			# code...
			$return[$value['name']] = 1;
		}

		if ($user_id == 1) {
			$return['add'] = 1;
			$return['edit'] = 1;
			$return['delete'] = 1;
		}

		if (count($return)) {

			$return['index'] = 1;
			$return['detail'] = 1;
			$return['lst'] = 1;
			$return['reset'] = 1;
			$return['preview_file'] = 1;
			$return['preview'] = 1;
			// $return['print']=1;
			$return['selesai'] = 1;
			$return['go_print'] = 1;
			$return['download_pdf'] = 1;
			$return['go_print_detail'] = 1;
			$return['open_file'] = 1;
			$return['logo_customer'] = 1;

			if ($return['add'] or $return['edit']) {
				$return['save'] = 1;
				$return['batal'] = 1;
				$return['import'] = 1;
				$return['download_template'] = 1;
				$return['upload_file'] = 1;
				$return['delete_file'] = 1;
				$return['logo_customer'] = 1;
				$return['import_list'] = 1;
				$return['eksport_list'] = 1;
				$return['export_list'] = 1;
			}

			if ($return['delete']) {
				$return['delete_file'] = 1;
				$return['delete_all'] = 1;
			}
		}

		return $return;
	}

	public function GetAccessRole1($url = "", $action = "")
	{
		$group_id = $_SESSION[SESSION_APP]['group_id'];
		$user_id = $_SESSION[SESSION_APP]['user_id'];
		if ($user_id == 1) {
			return true;
		}
		$return = false;
		$action = strtolower(str_replace("_action", "", $action));
		if ($action == 'index') {
			$filter_action = '';
		} else {
			$filter_action = " AND b.name='$action'";
		}
		if (preg_match("/index/", $action)) $filter_action = "";
		$sql = "
			SELECT 1
			FROM public_sys_group_action a
			LEFT JOIN public_sys_action b ON a.action_id=b.action_id
			LEFT JOIN public_sys_group_menu c ON a.group_menu_id=c.group_menu_id
			LEFT JOIN public_sys_menu d ON c.menu_id=d.menu_id
			WHERE c.group_id = '$group_id' AND d.url='$url' $filter_action";
		$return = $this->GetOne($sql);
		return (bool) $return;
	}

	public function statistikVisitor($limit = 30)
	{
		$sql = "select * from (select * 
		from contents_statistik_pengunjung 
		order by tanggal desc limit $limit) a order by tanggal asc";
		$rows = $this->conn->GetArray($sql);

		$data = array();
		$ticks = array();
		foreach ($rows as $key => $value) {
			# code...
			$data[] = array($key, $value['jumlah']);
			$ticks[] = array($key, Eng2Ind($value['tanggal']));
		}

		$ret['data'] = json_encode($data);
		$ret['ticks'] = json_encode($ticks);
		return $ret;
	}

	#active directory sso PJBS
	public function autoAuthenticate($username, $credential)
	{
		ini_set('soap.wsdl_cache_enabled', 0);
		$wsdl = 'http://portal.pjbservices.com/index.php/portal_login?wsdl';
		$CI = &get_instance();

		$cl = new SoapClient($wsdl);
		$rv = $cl->loginToken(58, $username, $credential);
		if ($rv->RESPONSE == "1") {
			$tokenarr = array(
				'username' => $username,
				'credential' => $credential,
			);
			$this->SetLogin($rv, $tokenarr);
			return $rv;
		} else
			return $rv;
	}

	public function autoGroupAuthenticate($username, $credential, $groupId)
	{
		ini_set('soap.wsdl_cache_enabled', 0);
		$wsdl = 'http://portal.pjbservices.com/index.php/portal_login?wsdl';
		$CI = &get_instance();

		$cl = new SoapClient($wsdl);
		$rv = $cl->loginGroup(58, $username, $credential, $groupId);
		if ($rv->RESPONSE == "1") {
			$tokenarr = array(
				'username' => $username,
				'credential' => $credential,
			);
			$this->SetLogin($rv, $tokenarr);
			return $rv;
		} else
			return $rv;
	}

	public function GetTabKontrak($id = null, $is_approve = false)
	{

		$data = array();

		if ($id) {
			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/t_kontrak']) {
				$data += array(
					"t_kontrak" => array("url" => site_url("panelbackend/t_kontrak/detail/$id"), "label" => "DETAIL KONTRAK", "icon" => "angle-right"),
				);
			}
		}



		if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/t_kontrak_dokumentasi']) {
			$data += array(
				"t_kontrak_dokumentasi" => array("url" => site_url("panelbackend/t_kontrak_dokumentasi/index/$id"), "label" => "DOKUMEN PENGADAAN", "icon" => "angle-right"),
			);
		}

		// if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/proyek_keluhan']) {
		// 	$data += array(
		// 		"kontrak_identitas" => array("url" => site_url("panelbackend/proyek_keluhan/index/$id"), "label" => "IDENTITAS PROYEK", "icon" => "angle-right"),
		// 	);
		// }

		if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/t_kontrak_hist']) {
			$data += array(
				"t_kontrak_hist" => array("url" => site_url("panelbackend/t_kontrak_hist/index/$id"), "label" => "HISTORY KONTRAK", "icon" => "angle-right"),
			);
		}

		if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/t_kontrak_nilai']) {
			$data += array(
				"t_kontrak_nilai" => array("url" => site_url("panelbackend/t_kontrak_nilai/index/$id"), "label" => "NILAI KONTRAK", "icon" => "angle-right"),
			);
		}

		if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/t_kontrak_isu']) {
			$data += array(
				"t_kontrak_isu" => array("url" => site_url("panelbackend/t_kontrak_isu/index/$id"), "label" => "ISU KONTRAK", "icon" => "angle-right"),
			);
		}



		$curr_url = current_url();

		$ret = "<ul class='nav nav-tabs'>";

		foreach ($data as $page => $row) {

			$url = $row['url'];

			$active = "";

			if (str_replace("panelbackend/", "", $this->page_ctrl) == $page)
				$active = "active";

			$ret .= "<li class=\"$active\">\n";
			$ret .= "<a href='" . $url . "'> <i class='fa fa-{$icon} '></i> " . $row['label'] . " </a>\n";
			$ret .= "</li>\n";
		}

		$ret .= "</ul>";

		return $ret;
	}

	public function GetTabKontrakProyek($id = null, $is_approve = false)
	{

		$data = array();

		if ($id) {
			if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/t_kontrak']) {
				$data += array(
					"mon_proyekselesai" => array("url" => site_url("panelbackend/mon_proyekselesai/detail/$id"), "label" => "DETAIL KONTRAK", "icon" => "angle-right"),
				);
			}
		}


		if ($_SESSION[SESSION_APP]['access_menu']['panelbackend/t_kontrak_pekerjaan']) {
			$data += array(
				"mon_proyekselesai_edit" => array("url" => site_url("panelbackend/mon_proyekselesai/edit/$id"), "label" => "FINISHING KONTRAK", "icon" => "angle-right"),
			);
		}


		$curr_url = current_url();

		$ret = "<ul class='nav nav-tabs'>";

		foreach ($data as $page => $row) {

			$url = $row['url'];

			$active = "";

			if (str_replace("panelbackend/", "", $this->page_ctrl) == $page)
				$active = "active";

			$ret .= "<li class=\"$active\">\n";
			$ret .= "<a href='" . $url . "'> <i class='fa fa-{$icon} '></i> " . $row['label'] . " </a>\n";
			$ret .= "</li>\n";
		}

		$ret .= "</ul>";

		return $ret;
	}

	public function GetTabSimRab() // all as rab id
	{

		$data = array();

		$data += array(
			"t_simrab_jasa_material" => array("url" => site_url("panelbackend/t_simrab_jasa_material/index/".$_SESSION['simrab_id']), "label" => "ITEM", "icon" => "angle-right"),
		);

		$data += array(
			"t_simrab_tenaga_kerja" => array("url" => site_url("panelbackend/t_simrab_tenaga_kerja/index/".$_SESSION['simrab_id']), "label" => "TENAGA KERJA", "icon" => "angle-right"),
		);

		/*$data += array(
			"t_simrab_detail" => array("url" => site_url("panelbackend/t_simrab_detail/index/".$_SESSION['simrab_id']), "label" => "KOMPONEN BIAYA", "icon" => "angle-right"),
		);*/

		$curr_url = current_url();

		$ret .= "<ul class='nav nav-tabs'>";


		foreach ($data as $page => $row) {

			$url = $row['url'];

			$active = "";

			if (str_replace("panelbackend/", "", $this->page_ctrl) == $page)
				$active = "active";

			$ret .= "<li class=\"$active\">\n";
			$ret .= "<a href='" . $url . "'> <i class='fa fa-{$icon} '></i> " . $row['label'] . " </a>\n";
			$ret .= "</li>\n";
		}
		/*$ret .= "<li class='active'>\n";
		$ret .= "<a href='" . site_url('panelbackend/panelbackend/t_simrab_detail/index/'.$komponenBiaya) . "'> <i class='fa fa-angke-right '></i> KOMPONEN BIAYA </a>\n";
		$ret .= "</li>\n";
		$ret .= "</ul>";*/

		return $ret;
	}
}
