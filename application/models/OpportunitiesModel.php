<?php class OpportunitiesModel extends _Model{
	public $table = "opportunities";
	public $pk = "id_opportunities";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}
}