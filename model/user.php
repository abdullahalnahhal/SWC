<?php
/**
* 
*/
class Model_User extends Model
{
	
	function __construct()
	{
		parent::__construct();	//for consructing the Model default actions
	}
	/* get and check the username and user password 
	if they are correct return user information if not return false*/
	public function login($uname , $upass)
	{
		$this::$tableName="users";
		$sql = $this->select("*"," `uname`='".$uname."' AND `upass`='".$upass."'");
		$list = $this->assoc($sql);
		if (count($list)>0) 
		{
			return $list[0];
		}
		else
		{
			return false;
		}
	}
	public function get_module($mod_id)
	{
		$this::$tableName="module";
		$sql = $this->select("*"," `id`='".$mod_id."'");
		$list =  $this->assoc($sql);
		if (count($list)>0) 
		{
			return $list[0];
		}
		else
		{
			return false;
		}
	}
}