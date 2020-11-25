<?php class T_simulasi_rabModel extends _Model{
	public $table = "t_simrab";
	public $pk = "id";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}
	/*public function Insert($value='')
	{
		$_POST['id'] = uuid();
		// echo  $this->db->last_query();
		
		// print_r($this->input->post());
		// exit();
	}*/
}