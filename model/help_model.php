<?php
/**
* 
*/
class Help_Model extends Model
{
	
	function __construct()
	{
		parent::__construct();	//for consructing the Model default actions
	}
	public function test()
	{
		$this::$tableName="test";
		$sql = $this->select("*");
		$list =  $this->assoc($sql);
	}
}