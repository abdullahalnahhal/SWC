<?php
/**
* 
*/
class Index extends Controller
{
	
	function __construct()
	{
		parent::__construct();//for consructing the controller default actions
		$this->view->render("guest/index");
	}
}