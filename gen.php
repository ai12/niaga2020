<?php 
	
	echo "masukkan nama modul :";
	$path = fopen("php://stdin","r");
	$nama = trim(fgets($path));
	echo "masukkan nama tabel :";
	$path = fopen("php://stdin","r");
	$tabel = trim(fgets($path));
	echo "masukkan nama asal :";
	$path = fopen("php://stdin","r");
	$asal = trim(fgets($path));

	$nama = (isset($_GET['nama']))?$_GET['nama']:$nama;
	$tabel = (isset($_GET['tabel']))?$_GET['tabel']:$tabel;
	$asal = (isset($_GET['asal']))?$_GET['asal']:$asal;

	// echo '<pre>';print_r (getTable($tabel));exit;

	if($nama!='' && $asal !='')
	{
		echo "> copy controller \n";
		$file = getPath().'controllers/panelbackend/'.ucfirst($asal).".php";
		$tujuan = getPath().'controllers/panelbackend/'.ucfirst($nama).".php";
		$command = "copy $file $tujuan ";
		exec(str_replace('/','\\',$command));
		
		echo "> copy model \n";
		$file = getPath().'models/'.ucfirst($asal)."Model.php";
		$tujuan = getPath().'models/'.ucfirst($nama)."Model.php";
		$command = "copy $file $tujuan ";
		exec(str_replace('/','\\',$command));
		
		echo "> copy view \n";
		$file = getPath().'views/panelbackend/'.strtolower($asal)."detail.php";
		$tujuan = getPath().'views/panelbackend/'.strtolower($nama)."detail.php";
		$command = "copy $file $tujuan ";
		exec(str_replace('/','\\',$command));
		$file = getPath().'views/panelbackend/'.strtolower($asal)."list.php";
		$tujuan = getPath().'views/panelbackend/'.strtolower($nama)."list.php";
		$command = "copy $file $tujuan ";
		exec(str_replace('/','\\',$command));

		//getSql($nama,'');
	}
	
	if($nama!='' && $tabel !='')
	{

		echo "> copy controller \n";
		getController($nama,$tabel);
		echo "> create model  \n";
		getModel($nama,$tabel);
		echo "> create list  \n";
		getList($nama,$tabel);
		echo "> create detail  \n";
		getDetail($nama,$tabel);
		echo "> create sql  \n";
		getSql($nama,$tabel);
	}

	function getPath()
	{
		$path = str_replace('gen.php','application/',$_SERVER['SCRIPT_FILENAME']);
		return $path;
	}
	
	function getTable($tabel)
	{
		$DB = '//localhost:1521/orcl';
		$DB_USER = 'niaga_dev';
		$DB_PASS = 'niaga_dev';

		$conn = oci_connect($DB_USER, $DB_PASS, $DB);

		//check for errors
		if (!$conn)
		{
			$e = oci_error();
			print htmlentities($e['message']);
			exit;
		}

		$sql = "select * from  ".$tabel;
		$stid = oci_parse($conn, $sql);
		oci_execute($stid,OCI_DESCRIBE_ONLY);
		$ncols = oci_num_fields($stid);

		for ($i = 1; $i <= $ncols; $i++) {
			$column_name  = oci_field_name($stid, $i);
			$column_type  = oci_field_type($stid, $i);
			$column_size  = oci_field_size($stid, $i);

			$cols[$i]['name'] = $column_name;
			$cols[$i]['type'] = $column_type;
			$cols[$i]['size'] = $column_size;
		}

		oci_free_statement($stid);
		oci_close($conn);

		return $cols;
	}

	function getController($nama,$tabel)
	{
		$tables = getTable($tabel);
		$str = "<?php
		defined('BASEPATH') OR exit('No direct script access allowed');
		
		include APPPATH.\"core/_adminController.php\";
		class ".ucfirst($nama)." extends _adminController{
		
			public function __construct(){
				parent::__construct();
			}

			protected function init(){
				parent::init();
				\$this->viewlist = \"panelbackend/".$nama."list\";
				\$this->viewdetail = \"panelbackend/".$nama."detail\";
				\$this->template = \"panelbackend/main\";
				\$this->layout = \"panelbackend/layout1\";
		
				if (\$this->mode == 'add') {
					\$this->data['page_title'] = 'Tambah ".ucfirst(str_replace('_',' ',$nama))."';
					\$this->data['edited'] = true;
				}
				elseif (\$this->mode == 'edit') {
					\$this->data['page_title'] = 'Edit ".ucfirst(str_replace('_',' ',$nama))."';
					\$this->data['edited'] = true;	
				}
				elseif (\$this->mode == 'detail'){
					\$this->data['page_title'] = 'Detail ".ucfirst(str_replace('_',' ',$nama))."';
					\$this->data['edited'] = false;	
				}else{
					\$this->data['page_title'] = 'Daftar ".ucfirst(str_replace('_',' ',$nama))."';
				}
		
				\$this->data['width'] = \"100%\";
		
				\$this->load->model(\"".ucfirst($nama)."Model\",\"model\");
		
				\$this->pk = \$this->model->pk;
				\$this->data['pk'] = \$this->pk;
				\$this->plugin_arr = array(
					''
				);
			}

			protected function Header(){
				return array(";
					
				foreach($tables as $k=>$tab){

					if($k==1)continue;
					$str .="array(
						'name'=>'".strtolower($tab['name'])."', 
						'label'=>'".ucfirst(strtolower(str_replace('_',' ',$tab['name'])))."', 
						'width'=>\"auto\",
						'type'=>\"".strtolower($tab['type'])."\",
					),";
				}

				$str.= ");
			}

			protected function Record(\$id=null){
				return array(";
					
				foreach($tables as $k=>$tab){
					if($k==1)continue;
					$str .="'".strtolower($tab['name'])."'=>\$this->post['".strtolower($tab['name'])."'],";
				}

				$str.= ");
			}

			protected function Rules(){
				return array(";
					
				foreach($tables as $k=>$tab){
					if($k==1)continue;
					if($tab['type']=='NUMBER')
					{
						$rules = "required|numeric";
					}else{
						$rules = "required|max_length[".strtolower($tab['size'])."]";
					}
					$str .="\"".strtolower($tab['name'])."\"=>array(
						'field'=>'".strtolower($tab['name'])."', 
						'label'=>'".ucfirst(strtolower(str_replace('_',' ',$tab['name'])))."', 
						'rules'=>\"".$rules."\",
					),";
				}

				$str.= ");
			}
		}
		";

		$file = getPath().'controllers/panelbackend/'.ucfirst($nama).".php";
		$txt  = print_r($str,TRUE);
		$myfile = file_put_contents($file, $txt.PHP_EOL);

		return $str;
	}
	function getModel($nama,$tabel)
	{
		$tables = getTable($tabel);
		$id = $tables[1]['name'];
		$cols = $tables[2]['name'];
		
		$str = "<?php class ".ucfirst($nama)."Model extends _Model{
			public \$table = \"".$tabel."\";
			public \$pk = \"".$id."\";
			public \$label = \"".$cols."\";
			function __construct(){
				parent::__construct();
			}
		}
		";

		$file = getPath().'models/'.ucfirst($nama)."Model.php";
		$txt  = print_r($str,TRUE);
		$myfile = file_put_contents($file, $txt.PHP_EOL);

		return $str;
	}
	function getList($nama,$tabel)
	{
		$str = "<table class=\"table table-striped table-hover dataTable\">
				<thead>
				<?=UI::showHeader(\$header, \$filter_arr, \$list_sort, \$list_order)?>
				</thead>
				<tbody>
				<?php
				\$i = \$page;
				foreach(\$list['rows'] as \$rows){
					\$i++;
					echo \"<tr>\";
					echo \"<td>\$i</td>\";
					foreach(\$header as \$rows1){
						\$val = \$rows[\$rows1['name']];
						if(\$rows1['name']=='nama'){
							if(\$add_param)
								echo \"<td><a href='\".(\$url=base_url(\$page_ctrl.\"/detail/\$add_param/\$rows[\$pk]\")).\"'>\$val</a></td>\"; 
							else  
								echo \"<td><a href='\".(\$url=base_url(\$page_ctrl.\"/detail/\$rows[\$pk]\")).\"'>\$val</a></td>\";   
						}else{
							switch (\$rows1['type']) {
								case 'list':
									echo \"<td>\".\$rows1[\"value\"][\$val].\"</td>\";
									break;
								case 'number':
									echo \"<td style='text-align:right'>\$val</td>\";
								break;
								case 'date':
									echo \"<td>\".Eng2Ind(\$val,false).\"</td>\";
									break;
								case 'datetime':
									echo \"<td>\".Eng2Ind(\$val).\"</td>\";
									break;
								default :
									echo \"<td>\$val</td>\";
									break;
							}
						}
					}
					echo \"<td style='text-align:right'>
					\".UI::showMenuMode('inlist', \$rows[\$pk]).\"
					</td>\";
					echo \"</tr>\";
				}
				if(!count(\$list['rows'])){
					echo \"<tr><td colspan='\".(count(\$header)+2).\"'>Data kosong</td></tr>\";
				}
				?>
				</tbody>
			</table>
			<?=UI::showPaging(\$paging,\$page, \$limit_arr,\$limit,\$list)?>
		";

		$file = getPath().'views/panelbackend/'.strtolower($nama)."list.php";
		$txt  = print_r($str,TRUE);
		$myfile = file_put_contents($file, $txt.PHP_EOL);

		return $str;
	}
	function getDetail($nama,$tabel)
	{
		$tables = getTable($tabel);
		$str = "<div class=\"col-sm-6\">
		";

		foreach($tables as $k=>$tab){
			if($k==1)continue;
			
			if($tab['type']=='NUMBER')
					{
						$str .="<?php 
						\$from = UI::createTextNumber('".strtolower($tab['name'])."',\$row['".strtolower($tab['name'])."'],'200','100',\$edited,'form-control ',\"style='text-align:right; width:190px' min='0' max='10000000000' step='1'\");
						echo UI::createFormGroup(\$from, \$rules[\"".strtolower($tab['name'])."\"], \"".strtolower($tab['name'])."\", \"".ucfirst(strtolower($tab['name']))."\");
						?>";
					}else{
						$str .="<?php 
						\$from = UI::createTextBox('".strtolower($tab['name'])."',\$row['".strtolower($tab['name'])."'],'200','100',\$edited,'form-control ',\"style='width:100%'\");
						echo UI::createFormGroup(\$from, \$rules[\"".strtolower($tab['name'])."\"], \"".strtolower($tab['name'])."\", \"".ucfirst(strtolower($tab['name']))."\");
						?>";
					}
		}

		$str .="</div>
		<div class=\"col-sm-6\">
						
		
		<?php 
		\$from = UI::showButtonMode(\"save\", null, \$edited);
		echo UI::createFormGroup(\$from, null, null, null, true);
		?>
		</div>
		";

		$file = getPath().'views/panelbackend/'.strtolower($nama)."detail.php";
		$txt  = print_r($str,TRUE);
		$myfile = file_put_contents($file, $txt.PHP_EOL);

		return $str;
	}

	function getSql($nama,$tabel)
	{
		$tables = getTable($tabel);
		$id = $tables[1]['name'];
		$cols = $tables[2]['name'];
		
		$str = "insert into PUBLIC_SYS_MENU (MENU_ID,PARENT_ID,LABEL,ICONCLS,URL,VISIBLE,STATE,SORT) 
				values (1094,5,'Menu',NULL,'panelbackend/".$nama."',1,'closed',5);
				insert into PUBLIC_SYS_ACTION (MENU_ID,NAME,TYPE,VISIBLE) 
				values (1094,'index',NULL,1);
				insert into PUBLIC_SYS_ACTION (MENU_ID,NAME,TYPE,VISIBLE) 
				values (1094,'add',2,1);
				insert into PUBLIC_SYS_ACTION (MENU_ID,NAME,TYPE,VISIBLE) 
				values (1094,'edit',2,1);
				insert into PUBLIC_SYS_ACTION (MENU_ID,NAME,TYPE,VISIBLE) 
				values (1094,'delete',2,1);
		";

		$file = "update_table.sql";
		$txt  = print_r($str,TRUE);
		$myfile = file_put_contents($file, $txt.PHP_EOL,FILE_APPEND | LOCK_EX);

		return $str;
	}
	?>