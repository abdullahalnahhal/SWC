<?php
/**
* 
*/
class Model_Admin extends Model
{
	
	function __construct()
	{
		parent::__construct();	//for consructing the Model default actions
	}
	##########################
	# Users Types Operations #
	##########################
	public function add_type($type , $shortcut)
	{
		$this::$tableName = "user_type";
		$insert = $this->insert(['type','shortcut'],[$type,$shortcut]);
		return $insert;
	}
	public function get_user_type()
	{
		$this::$tableName = "user_type";
		$usertype = $this->select('*');
		$usertype = $this->assoc($usertype);
		return $usertype;
	}
	public function all_user_types()
	{
		$this::$tableName = "user_type";
		$user_types = $this->select('*');
		$user_types = $this->assoc($user_types);
		return $user_types;
	}
	####################
	# Users Operations #
	####################
	public function add_user($name , $password , $email ,$type)
	{
		$this::$tableName = "users";
		$identifier = "usr-".uniqid();
		$insert = $this->insert(['name','password','mail','user_type_id','identifier'],[$name,$password,$email,$type,$identifier]);
		return $insert;
	}
	public function all_users()
	{
		$this::$tableName = "v_all_users";
		$users = $this->select('*');
		$users = $this->assoc($users);
		return $users;
	}
	#####################
	# Tracks Operations #
	#####################
	public function add_track($name , $obj)
	{
		$this::$tableName = "track";
		$identifier = "trk-".uniqid();
		$insert = $this->insert(['name','identifier','objectives'],[$name,$identifier,$obj]);
		return $insert;
	}
	public function get_tracks()
	{
		$this::$tableName = "track";
		$tracks = $this->select('*');
		$tracks = $this->assoc($tracks);
		return $tracks;
	}
	public function all_tracks()
	{
		$this::$tableName = "track";
		$tracks = $this->select('*');
		$tracks = $this->assoc($tracks);
		return $tracks;
	}
	######################
	# Articls Operations #
	######################
	public function add_rtc($title , $track , $content)
	{
		$this::$tableName = "track_aticls";
		$identifier = "rtc-".uniqid();
		$insert = $this->insert(['title','identifier','content' ,'track_id'],[$title,$identifier,$content , $track]);
		return $insert;
	}
	public function all_rtc()
	{
		$this::$tableName = "v_articles";
		$users = $this->select('*');
		$users = $this->assoc($users);
		return $users;
	}
}