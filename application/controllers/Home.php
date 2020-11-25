<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH."core/_visitorController.php";
class Home extends _visitorController{

	public function __construct(){
		parent::__construct();
	}

	function Index(){

		redirect("panelbackend/home");
	}
}
