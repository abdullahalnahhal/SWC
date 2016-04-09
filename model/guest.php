<?php
/**
* 
*/
class Model_Guest extends Model
{
	
	function __construct()
	{
		parent::__construct();	//for consructing the Model default actions
	}
	
	public function all_tracks()
	{
		$this::$tableName = "track";
		$tracks = $this->select('*');
		$tracks = $this->assoc($tracks);
		return $tracks;
	}
	public function articls_list($ids)
	{
		$this::$tableName = "track_aticls";
		$rtcs = $this->select('*',"`track_id` = '$ids'");
		$rtcs = $this->assoc($rtcs);
		return $rtcs;
	}
	public function addusr($name,$email,$password)
	{
		$this::$tableName = "users";
		$identifier = "usr-".uniqid();
		$insert = $this->insert(['name','password','mail','user_type_id','identifier'],[$name,$password,$email,4,$identifier]);
		return $insert;
	}
	public function check_login($email ,$password)
	{
		$this::$tableName = "users";
		$users = $this->select('*',"`mail`='$email' AND `password`='$password'");
		$users = $this->assoc($users);
		if (isset($users[0])) 
		{
			return $users[0]['identifier'];
		}
		else
		{
			return false;
		}
	}
}