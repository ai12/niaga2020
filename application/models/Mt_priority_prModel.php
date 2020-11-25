<?php class Mt_priority_prModel extends _Model{
	public $table = "mt_priority_pr";
	public $pk = "prior_code";
	public $label = "prior_desc";
	function __construct(){
		parent::__construct();
	}
}