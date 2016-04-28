<?php
/**
* 
*/
class Admin extends Controller
{
	function __construct()
	{
		$this->view = new stdClass();
		$this->view->active = ['usr'=>'','type'=>'','tracks'=>'','articls'=>'','questions'=>''];
		$this->admin = new Model_admin();
		$this->secure = new Lib_secure();
		$this->gen = new Lib_General();
		$this->table = new Lib_Table();
		$this->html = new Lib_Html();
		$this->secure->sess();
		if (!$this->secure->sessCheck('user_type_id',2) && !$this->secure->sessCheck('user_type_id',3)) 
		{
			$this->secure->router("/SWC/");
		}
		parent::__construct();//for consructing the controller default actions
	}
	####################
	# Users Operations #
	####################
	public function index()
	{
		$this->view->title = "Admin Panel - All Users";
		$this->view->active['usr'] = 'active-menu';
		$users = $this->all_users();
		$this->view->render("admin/user/index",['users'=>$users]);
	}
	public function addusr()
	{
		$this->view->title = "Admin Panel - New User";
		$this->view->active['usr'] = 'active-menu';
		$usertype = $this->admin->get_user_type();
		$this->view->usertype = $usertype;
		$this->view->render("admin/user/addusr",[]);
	}
	public function add_user()
	{
		$name = $this->secure->T($_POST['username']);
		$email = $this->secure->T($_POST['email']);
		$password = $this->secure->pass($this->secure->T($_POST['password']));
		$type = $this->secure->T($_POST['type']);
		$insert = $this->admin->add_user($name , $password , $email,$type);
		$this->secure->router("/SWC/admin");
	}
	public function all_users()
	{
		$users = $this->admin->all_users();
		return $users;
	}
	#########################
	# Users Type Operations #
	#########################
	public function usrstype()
	{
		$this->view->title = "Admin Panel - Users Type";
		$this->view->active['type'] = 'active-menu';
		$types = $this->all_user_types();
		$this->view->render("admin/usrtype/usrstype",['types'=>$types]);
	}
	public function addusrtype()
	{
		$this->view->title = "Admin Panel - Add Users Type";
		$this->view->active['type'] = 'active-menu';
		$this->view->render("admin/usrtype/addusrtype",[]);
	}
	public function add_type()
	{
		$type = $this->secure->T($_POST['type']);
		$shortcut = $this->secure->T($_POST['shortcut']);
		$this->admin->add_type($type , $shortcut);
		$this->secure->router("/SWC/admin/usrstype/");
	}
	public function all_user_types()
	{
		$users = $this->admin->all_user_types();
		return $users;
	}
	#####################
	# Tracks Operations #
	#####################
	public function tracks()
	{
		$this->view->title = "Admin Panel - Tracks";
		$this->view->active['tracks'] = 'active-menu';
		$tracks = $this->all_tracks();
		$this->view->render("admin/tracks/index",['tracks'=>$tracks]);
	}
	public function addtrk()
	{
		$this->view->title = "Admin Panel - Tracks";
		$this->view->active['tracks'] = 'active-menu';
		$this->view->render("admin/tracks/addtrk",[]);
	}
	public function add_track()
	{
		$name = $this->secure->T($_POST['trkname']);
		$obj = $this->secure->Tarea($_POST['obj']);
		$this->admin->add_track($name , $obj);
		$this->secure->router("/SWC/admin/tracks/index");
	}
	public function all_tracks()
	{
		$users = $this->admin->all_tracks();
		return $users;
	}
	######################
	# Articls Operations #
	######################
	public function articls()
	{
		$this->view->title = "Admin Panel - Articles";
		$this->view->active['articls'] = 'active-menu';
		$rtc = $this->all_rtc();
		$this->view->render("admin/articls/index",['articls'=>$rtc]);
	}
	public function addrtc()
	{
		$this->view->title = "Admin Panel - Tracks";
		$this->view->active['articls'] = 'active-menu';
		$tracks = $this->admin->get_tracks();
		$this->view->tracks = $tracks;
		$this->view->render("admin/articls/addrtc",[]);
	}
	public function add_rtc()
	{
		$upload = $this->gen->upload_file("public/files/artcls/" , $_FILES , "file" ,NULL,"html");
		if ($upload) 
		{
			$title = $this->secure->T($_POST['title']);
			$track = $this->secure->Tarea($_POST['track']);
			$content = $_FILES['file']['name'];
			$this->admin->add_rtc($title , $track , $content);
			$this->secure->router("/SWC/admin/articls");
		}
	}
	public function all_rtc()
	{
		$users = $this->admin->all_rtc();
		return $users;
	}
	########################
	# Questions Operations #
	########################
	public function questions()
	{
		$this->view->title = "Admin Panel - Questions";
		$this->view->active['questions'] = 'active-menu';
		$questions = $this->all_ques();
		$this->view->render("admin/questions/index",['questions'=>$questions]);
	}
	public function addques()
	{
		$this->view->title = "Admin Panel - Questions";
		$this->view->active['questions'] = 'active-menu';
		$tracks = $this->admin->get_tracks();
		$this->view->tracks = $tracks;
		$this->view->render("admin/questions/addques",[]);
	}
	public function add_ques()
	{
		$question = $this->secure->T($_POST['question']);
		$grade = $this->secure->T($_POST['grade']);
		$track = $this->secure->T($_POST['track']);
		$ques_number = $this->secure->T($_POST['answers']);
		$answers=[];
		for ($i=1; $i <=$ques_number ; $i++) 
		{ 
			$answer = $this->secure->T($_POST['answer-'.$i]);
			if (isset($_POST['ans_check_'.$i])) 
			{
				$answers[]=["answer"=>$answer,"status"=>1];
			}
			else
			{
				$answers[]=["answer"=>$answer,"status"=>0];
			}
		}
		$question_id = $this->admin->add_ques($question,$grade,$track,$answers);
		$this->secure->router("/SWC/admin/questions");
	}
	public function all_ques()
	{
		$questions = $this->admin->all_ques();
		return $questions;
	}
}
