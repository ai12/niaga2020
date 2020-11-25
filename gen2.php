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
		$file = getPath().'controllers/om/'.ucfirst($asal).".php";
		$tujuan = getPath().'controllers/om/'.ucfirst($nama).".php";
		$command = "copy $file $tujuan ";
		exec(str_replace('/','\\',$command));
		
		echo "> copy model \n";
		$file = getPath().'models/om/'.ucfirst($asal)."Model.php";
		$tujuan = getPath().'models/om/'.ucfirst($nama)."Model.php";
		$command = "copy $file $tujuan ";
		exec(str_replace('/','\\',$command));
		
		echo "> copy view \n";
		$file = getPath().'views/om/'.strtolower($asal)."/list.php";
		$tujuan = getPath().'views/om/'.strtolower($nama)."/list.php";
		$command = "copy $file $tujuan ";
		exec(str_replace('/','\\',$command));
		$file = getPath().'views/om/'.strtolower($asal)."/from.php";
		$tujuan = getPath().'views/om/'.strtolower($nama)."/form.php";
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
		$path = str_replace('gen2.php','application/',$_SERVER['SCRIPT_FILENAME']);
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
		$str = "
		<?php
		defined('BASEPATH') or exit('No direct script access allowed');

		include APPPATH . \"core/_omController.php\";
		class ".ucfirst($nama)." extends _omController
		{

			public function __construct()
			{
				parent::__construct();
				
				\$this->modul = '".$nama."';
				\$this->load->model('om/".$nama."_model', 'mod');

				\$this->menuarr = \$this->Global_model->GetComboMenu();
				\$this->visiblearr = array(''=>'','0'=>'not visible','1'=>'visible');
			}

			public function index()
			{
				\$this->data['title'] 		= 'Daftar ".ucfirst(str_replace('_',' ',$nama))."';		
				\$this->data['subtitle'] 	= 'isi ".ucfirst(str_replace('_',' ',$nama))."';	
				parent::index();
			}

			public function form(\$kode = 0)
			{
			
				\$this->data['title'] 		= 'Form ".ucfirst(str_replace('_',' ',$nama))."';		
				\$this->data['subtitle'] 	= 'isi ".ucfirst(str_replace('_',' ',$nama))."';	
				parent::form(\$kode);
				
			}
			public function detail(\$kode = 0)
			{
			
				\$this->data['title'] 		= 'Detail ".ucfirst(str_replace('_',' ',$nama))."';		
				\$this->data['subtitle'] 	= 'isi ".ucfirst(str_replace('_',' ',$nama))."';	
				\$this->data['readonly'] 	= true;	
				parent::form(\$kode);
				
			}
			

			public function ajax_list()
			{
				echo parent::ajax_list();
				
			}

			
			
			
		}
		";

		$file = getPath().'controllers/om/'.ucfirst($nama).".php";
		$txt  = print_r($str,TRUE);
		$myfile = file_put_contents($file, $txt.PHP_EOL);

		return $str;
	}
	function getModel($nama,$tabel)
	{
		$tables = getTable($tabel);
		$id = $tables[1]['name'];
		$cols = $tables[2]['name'];
		
		$str = "
		<?php
			require APPPATH.'/models/om/_omModel.php';
			class ".ucfirst($nama)."_model extends _omModel
			{

				//put your code here
				function __construct()
				{
					parent::__construct();
				}


				var \$table  = '".$tabel."';
				var \$pk 	= '".$id."';
				var \$column = [";
					foreach($tables as $k=>$tab){
						if($k==1)continue;
						$str .="'".strtolower($tab['name'])."'=>'".ucfirst(strtolower(str_replace('_',' ',$tab['name'])))."',";
					}
					$str.= "];
				var \$order  = ['".$id."' => 'asc']; // default order 

				public function _setting()
				{
					\$set = parent::_setting();

					//custom
					\$set['".$id."']['hidden'] 	= true;	
					\$set['".$id."']['width'] 	= '10px';
					\$set['".$id."']['url'] 	= 'detail';";
					
					foreach($tables as $k=>$tab){
						if($tab['type']=='number'){

							$str .="\$set['".strtolower($tab['name'])."']['type'] 	= ".$tab['type'].";";
							$str .="\$set['".strtolower($tab['name'])."']['align'] 		= 'right';
							";
						}
					}
					
					$str.= "
					
					return \$set;
				}
				
				
			}//END
		
		";

		$file = getPath().'models/om/'.ucfirst($nama)."_model.php";
		$txt  = print_r($str,TRUE);
		$myfile = file_put_contents($file, $txt.PHP_EOL);

		return $str;
	}
	function getList($nama,$tabel)
	{
		$str = "<table id='table' class='table table-striped table-hover'>
				<thead>
					<tr>
						<?php foreach (\$label_setting as \$k => \$row) { ?>
							<td>
								<?php if (!isset(\$row['value'])) { ?>
									<input type='text' class='form-control' id='<?php echo \$k; ?>' placeholder=\"Search <?php echo \$row['label'] ?>..\">
							</td>
					<?php } else {
									echo form_dropdown(\$k, \$row['value'], '', 'class=\"form-control\" id=\"' . \$k . '\"');
								}
							} ?>
					<td width='10'>
						<button type='button' id='btn-reset' class='btn  btn-xs btn-default'><span class=\"glyphicon glyphicon-refresh\"></span></button>
					</td>
					</tr>
					<tr style='background:#32C2CD;color:white;'>
						<?php foreach (\$label_setting as \$k => \$row) {
						?>
							<th><?php echo \$row['label']  ?></th>
						<?php
						} ?>
			
						<th width='10'></th>
					</tr>
			
				</thead>
				<tbody id='iBody'>
				</tbody>
			</table>
		";

		$path = getPath().'views/om/'.strtolower($nama);
		if(!is_dir($path)){
			mkdir($path);
		  }
		$file = $path."/list.php";
		$txt  = print_r($str,TRUE);
		$myfile = file_put_contents($file, $txt.PHP_EOL);

		return $str;
	}
	function getDetail($nama,$tabel)
	{
		$tables = getTable($tabel);
		$str = "
		<div class=\"row\">	
		<div class=\"col-sm-6\">
			<?php 
			//debug(\$label_setting);
			foreach(\$label_setting as \$k=>\$rw){
				?>
				<div class=\"form-group\" <?php echo (isset(\$rw['hidden']))?'style=\"display:none\"':'';?>>
					<label for=\"id_proposal\" class=\"col-sm-4 control-label\"><?php echo \$rw['label'] ?> <?php echo (\$rw['required']==true)?required_sign():'';?></label>
					<div class=\"col-sm-8\">
					<?php if (!isset(\$rw['value'])) { 
						
						?>
						<?php 
							echo formInput(\$k,\$row[\$k],\$rw, \$readonly);?>
					<?php }else{
							echo formSelect(\$k,\$row[\$k],\$rw['value'],\$rw , \$readonly);
					 }?>
					</div>
				</div>
				<?php
			}?>
		</div>
		</div>
		";

		$path = getPath().'views/om/'.strtolower($nama);
		if(!is_dir($path)){
			mkdir($path);
		  }
		$file = $path."/form.php";
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