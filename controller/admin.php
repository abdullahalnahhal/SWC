<?php
/**
* 
*/
class Admin extends Controller
{
	
	function __construct()
	{
		parent::__construct();//for consructing the controller default actions
		$this->view->render("admin/index");
	}
}