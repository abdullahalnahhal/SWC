<?php
/**
* 
*/
class Index extends Controller
{
	
	function __construct()
	{
		$this->view = new stdClass();
		$this->view->active = ['usr'=>'','type'=>'','tracks'=>'','articls'=>'','questions'=>''];
		$this->guest = new Model_Guest();
		$this->secure = new Lib_secure();
		$this->gen = new Lib_General();
		$this->table = new Lib_Table();
		$this->html = new Lib_Html();
		parent::__construct();//for consructing the controller default actions
	}
	public function index()
	{
		$this->view->render("guest/index");
	}
	public function trks()
	{
		$this->view->title = "Admin Panel - Tracks";
		$this->view->active['tracks'] = 'active-menu';
		$tracks = $this->guest->all_tracks();
		$this->view->render("guest/trks/index",['tracks'=>$tracks]);
	}
	public function articls_list()
	{
		$ids = $this->secure->T($_POST['trk']);
		$list = $this->guest->articls_list($ids);
		echo json_encode($list);
	}
	public function signup()
	{
		$name  = $this->secure->T($_POST['name']);
		$email = $this->secure->T($_POST['email']);
		$password = $this->secure->pass($_POST['password']);
		$list = $this->guest->addusr($name,$email,$password);
	}
	public function login()
	{
		$email = $this->secure->T($_POST['email']);
		$password = $this->secure->pass($_POST['password']);
		$check = $this->guest->check_login($email ,$password);
		if ($check) 
		{
			$this->secure->router("/SWC/user/home/".$check);
		}
	}
}