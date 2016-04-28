<?php
/**
* 
*/
class User extends Controller
{
	
	function __construct()
	{
		$this->view = new stdClass();
		$this->view->active = ['usr'=>'','type'=>'','tracks'=>'','articls'=>'','questions'=>''];
		$this->user = new Model_user();
		$this->secure = new Lib_secure();
		$this->gen = new Lib_General();
		$this->table = new Lib_Table();
		$this->html = new Lib_Html();
		$this->secure->sess();
		if (!$this->secure->sessCheck('user_type_id',4)) 
		{
			$this->secure->router("/SWC/");
		}
		parent::__construct();//for consructing the controller default actions
	}
	function index($id = NULL)
	{
		if (isset($id)) 
		{
			if (!$this->secure->sessCheck('id',$id)) 
			{
				echo "You are not authorized to see this";die;
			}
			$this->view->title = "SoftWare Competition";
			$this->view->active['usr'] = 'active-menu';
			$info = $this->user->user_info($id);
			$this->view->render("user/user/index",["information"=>$info]);
		}
		else
		{
			echo "404 Page Not Found";
			
		}
	}
	public function tracks($user_id)
	{
		if (!$this->secure->sessCheck('id',$user_id)) 
		{
			echo "You are not authorized to see this";die;
		}
		$this->view->title = "SoftWare Competition - Tracks";
		$this->view->active['tracks'] = 'active-menu';
		$info = $this->user->user_info($user_id);
		$tracks = $this->user->all_tracks();
		$this->view->render("user/tracks/index",["information"=>$info , "tracks"=>$tracks]);
	}
	public function questions($user_id,$id)
	{
		if (!$this->secure->sessCheck('id',$user_id)) 
		{
			echo "You are not authorized to see this";die;
		}
		$this->view->title = "SoftWare Competition - QUESTIONS";
		$this->view->active['questions'] = 'active-menu';
		$info = $this->user->user_info($user_id);
		$answers = $this->user->answers($id);
		if (isset($answers[0])) 
		{
			$this->view->render("user/questions/index",["information"=>$info,"answers"=>$answers]);
		}
		else
		{
			$this->view->render("user/questions/index",["information"=>$info,"not_here"=>true,"err"=>"There No More Questions"]);
		}
	}
	public function check($id)
	{
		$answers = $_POST['answer'];
		$question = $_POST['q_id'];
		$full_grade = false;
		foreach ($answers as $answer ) 
		{
		 	$check = $this->user->check($answer);
		 	if ($check['status']) 
		 	{
		 		$full_grade = true;
		 	}
		 	else
		 	{
		 		$full_grade = false;
		 	}
		}
		if ($full_grade) 
		{
			$new_question = $this->user->add_grade($id,$question);
			$this->secure->router("/SWC/user/$id/questions/$new_question");
		}
	}
}