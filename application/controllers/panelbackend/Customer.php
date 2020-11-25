<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_adminController.php";
class Customer extends _adminController{

	public function __construct(){
		parent::__construct();
	}
	
	protected function init(){
		parent::init();
		$this->viewlist = "panelbackend/customerlist";
		$this->viewdetail = "panelbackend/customerdetail";
		$this->template = "panelbackend/main";
		$this->layout = "panelbackend/layout1";

		if ($this->mode == 'add') {
			$this->data['page_title'] = 'Tambah Customer';
			$this->data['edited'] = true;
		}
		elseif ($this->mode == 'edit') {
			$this->data['page_title'] = 'Edit Customer';
			$this->data['edited'] = true;	
			$this->layout = "panelbackend/layout_customer";
		}
		elseif ($this->mode == 'detail'){
			$this->data['page_title'] = 'Detail Customer';
			$this->data['edited'] = false;	
			$this->layout = "panelbackend/layout_customer";
		}else{
			$this->data['page_title'] = 'Daftar Customer';
		}

		$this->data['width'] = "3400px";

		$this->load->model("CustomerModel","model");
		$this->load->model("Mt_customer_kategoriModel","mtcustomerkategori");
		$this->data['mtcustomerkategoriarr'] = $this->mtcustomerkategori->GetCombo();

		
		$this->load->model("Mt_customer_typeModel","mtcustomertype");
		$this->data['mtcustomertypearr'] = $this->mtcustomertype->GetCombo();

		
		$this->pk = $this->model->pk;
		$this->data['pk'] = $this->pk;
		$this->plugin_arr = array(
			'datepicker'
		);
	}

	protected function Header(){
		$this->data['layout_header'] = '<a href="'.site_url('panelbackend/customer/export_list').'" class="btn btn-info">Export</a>';

		return array(
			array(
				'name'=>'nama', 
				'label'=>'Nama', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'pemilik', 
				'label'=>'Pemilik', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'tgl_berdiri', 
				'label'=>'Tgl. Berdiri', 
				'width'=>"auto",
				'type'=>"date",
			),
			array(
				'name'=>'industri', 
				'label'=>'Industri', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'id_kategori', 
				'label'=>'Kategori', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['mtcustomerkategoriarr'],
			),
			array(
				'name'=>'id_type', 
				'label'=>'Type', 
				'width'=>"auto",
				'type'=>"list",
				'value'=>$this->data['mtcustomertypearr'],
			),
		);
	}

	protected function _afterDetail($id=null){
		$this->data['rowheader'] = $this->data['row'];
	}

	public function HeaderExport(){
		return array(
			array(
				'name'=>'nama', 
				'label'=>'Cust Name', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'currency', 
				'label'=>'Currency', 
				'default'=>'IDR', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'country', 
				'label'=>'Country', 
				'default'=>'ID', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'cash_district', 
				'label'=>'Cash District', 
				'default'=>'PJBS', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'alamat', 
				'label'=>'Post Address1', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'kota', 
				'label'=>'Post Address2', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'negara', 
				'label'=>'Post Address3', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'kode_pos', 
				'label'=>'Post Code', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'telephone_1', 
				'label'=>'Contact', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'telephone_2', 
				'label'=>'Phone', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'fax', 
				'label'=>'Fax_No', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'email_1', 
				'label'=>'Email1', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'credit_terms', 
				'label'=>'Credit Terms', 
				'default'=>'U',
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'secured', 
				'label'=>'Secured', 
				'default'=>'N',
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'statement_required', 
				'label'=>'Statement Required', 
				'default'=>'Y',
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'statement_type', 
				'label'=>'Statement Type', 
				'default'=>'O',
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'medium', 
				'label'=>'Medium', 
				'default'=>'P', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'days_to_pay', 
				'label'=>'Days To Pay', 
				'default'=>'30', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'days_grace', 
				'label'=>'Days Grace', 
				'default'=>'5', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'accountno', 
				'label'=>'AccountNo', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'accountname', 
				'label'=>'AccountName', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'branch', 
				'label'=>'Branch', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
			array(
				'name'=>'upload_status', 
				'label'=>'UPLOAD STATUS', 
				'width'=>"auto",
				'type'=>"varchar2",
			),
		);
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
				'name'=>$this->model->pk,
				'label'=>'Cust No', 
			)
		);
		$header=array_merge($header,$this->HeaderExport());

		$row = 1;

	    foreach($header as $r){
	    	if(!$col)
	    		$col = 'A';
	    	else
	        	$col++;    

	        $excelactive->setCellValue($col.$row,$r['label']);
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

		foreach($rows as &$rw){
			$rw['alamat_full'] = $rw['alamat'];

			if($rw['kota'])
				$rw['alamat_full'] .= ", ".$rw['kota'];

			if($rw['negara'])
				$rw['alamat_full'] .= ", ".$rw['negara'];

			$arr = explode(",",$rw['alamat_full']);
			$j = 0;
			$str = '';
			$temp = array();

			foreach($arr as $v){
				$str .= $v.',';
				$j = strlen($str);

				if($j>32){
					$temp[] = $str;
					$str='';
				}
			}

			$rw['alamat'] = trim(trim($temp[0],','));
			$rw['kota'] = trim(trim($temp[1],','));
			$rw['negara'] = trim(trim($temp[2],','));
		}

		$row = 2;
        foreach($rows as $r){
	    	$col = 'A';
	    	foreach($header as $r1){
	    		if($r1['name']==$this->model->pk){
	    			$r[$r1['name']] = str_pad($r[$r1['name']], 6, '0', STR_PAD_LEFT);;
	    		}elseif($r1['default']){
	    			$r[$r1['name']] = $r1['default'];
	    		}elseif($r1['type']=='listinverst'){
	    			$r[$r1['name']] = $r1['value'][$r[$r1['name_ori']]];
	    		}
           		$excelactive->setCellValue($col.$row,$r[$r1['name']]);
           		$col++;
	    	}
            $row++;
        }
        /*nama, pemilik, industri, alamat_full*/
        $html = "<table width='100%' rules='all' border='1'>
        <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Pemilik</th>
        <th>Industri</th>
        <th>Alamat</th>
        </tr>";
        $no=1;
        foreach ($rows as $r) {
        	$alamat = trim($r['alamat']);
        	$html .= "<tr>
        		<td>$no</td>
        		<td>$r[nama]</td>
        		<td>$r[pemilik]</td>
        		<td>$r[industri]</td>
        		<td>$r[alamat_full]</td>
        	</tr>";
        	$no++;
        }
        $html .= "</table>";
        echo $html;
        // echo "<pre>";
        // print_r($rows);
	    // $objWriter = Factory::createWriter($excel,'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$this->ctrl.date('Ymd').'.xls"');
		header('Cache-Control: max-age=0');
		// $objWriter->save('php://output');
		exit();
	}

	protected function Record($id=null){
		return array(
			'nama'=>$this->post['nama'],
			'pemilik'=>$this->post['pemilik'],
			'tgl_berdiri'=>$this->post['tgl_berdiri'],
			'industri'=>$this->post['industri'],
			'id_kategori'=>Rupiah2Number($this->post['id_kategori']),
			'id_type'=>Rupiah2Number($this->post['id_type']),
			'website'=>$this->post['website'],
			'telephone_1'=>$this->post['telephone_1'],
			'telephone_2'=>$this->post['telephone_2'],
			'fax'=>$this->post['fax'],
			'email_1'=>$this->post['email_1'],
			'email_2'=>$this->post['email_2'],
			'alamat'=>$this->post['alamat'],
			'kota'=>$this->post['kota'],
			'kode_pos'=>$this->post['kode_pos'],
			'negara'=>$this->post['negara'],
			'deskripsi'=>$this->post['deskripsi'],
		);
	}

	protected function Rules(){
		return array(
			"nama"=>array(
				'field'=>'nama', 
				'label'=>'Nama', 
				'rules'=>"required|max_length[200]",
			),
			"pemilik"=>array(
				'field'=>'pemilik', 
				'label'=>'Pemilik', 
				'rules'=>"max_length[200]",
			),
			"industri"=>array(
				'field'=>'industri', 
				'label'=>'Industri', 
				'rules'=>"max_length[200]",
			),
			"id_kategori"=>array(
				'field'=>'id_kategori', 
				'label'=>'Kategori', 
				'rules'=>"in_list[".implode(",", array_keys($this->data['mtcustomerkategoriarr']))."]|max_length[10]",
			),
			"id_type"=>array(
				'field'=>'id_type', 
				'label'=>'Type', 
				'rules'=>"in_list[".implode(",", array_keys($this->data['mtcustomertypearr']))."]|max_length[10]",
			),
			"website"=>array(
				'field'=>'website', 
				'label'=>'Website', 
				'rules'=>"max_length[200]",
			),
			"telephone_1"=>array(
				'field'=>'telephone_1', 
				'label'=>'Telephone 1', 
				'rules'=>"max_length[20]",
			),
			"telephone_2"=>array(
				'field'=>'telephone_2', 
				'label'=>'Telephone 2', 
				'rules'=>"max_length[20]",
			),
			"fax"=>array(
				'field'=>'fax', 
				'label'=>'FAX', 
				'rules'=>"max_length[20]",
			),
			"email_1"=>array(
				'field'=>'email_1', 
				'label'=>'Email 1', 
				'rules'=>"email|max_length[200]",
			),
			"email_2"=>array(
				'field'=>'email_2', 
				'label'=>'Email 2', 
				'rules'=>"email|max_length[200]",
			),
			"alamat"=>array(
				'field'=>'alamat', 
				'label'=>'Alamat', 
				'rules'=>"max_length[2000]",
			),
			"kota"=>array(
				'field'=>'kota', 
				'label'=>'Kota', 
				'rules'=>"max_length[20]",
			),
			"kode_pos"=>array(
				'field'=>'kode_pos', 
				'label'=>'Kode POS', 
				'rules'=>"max_length[20]",
			),
			"negara"=>array(
				'field'=>'negara', 
				'label'=>'Negara', 
				'rules'=>"max_length[100]",
			),
			"deskripsi"=>array(
				'field'=>'deskripsi', 
				'label'=>'Deskripsi', 
				'rules'=>"max_length[2000]",
			),
		);
	}

}