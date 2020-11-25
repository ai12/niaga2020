<?php class Task_filesModel extends _Model{
	public $table = "task_files";
	public $pk = "id_task_files";
	public $label = "nama";
	function __construct(){
		parent::__construct();
	}
}