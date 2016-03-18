<?php
/**
* 
*/
class User extends Controller
{
	
	function __construct()
	{
		parent::__construct();//for consructing the controller default actions
		$this->view->render("user/index");
	}
}