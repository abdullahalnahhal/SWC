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
		$this->profile_pic = $this->secure->get_ses("profile_pic");
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
			$this->view->render("user/user/index",["information"=>$info,"profile_pic"=>$this->profile_pic ]);
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
		$this->view->render("user/tracks/index",["information"=>$info ,"profile_pic"=>$this->profile_pic ]);
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
		if ($id < $info['questions_id'] ) 
		{
			$this->view->render("user/questions/index",["information"=>$info,"not_here"=>true,"err"=>"You have already Answered these question","profile_pic"=>$this->profile_pic ]);
		}
		if ($id > $info['questions_id'] ) 
		{
			$this->view->render("user/questions/index",["information"=>$info,"not_here"=>true,"err"=>"You have to answer another questions before that to be here","profile_pic"=>$this->profile_pic ]);
		}
		if (isset($answers[0])) 
		{
			$this->view->render("user/questions/index",["information"=>$info,"answers"=>$answers,"profile_pic"=>$this->profile_pic ]);
		}
		else
		{
			$this->view->render("user/questions/index",["information"=>$info,"not_here"=>true,"err"=>"There No More Questions","profile_pic"=>$this->profile_pic ]);
		}
	}
	public function check($id)
	{
		$answers= "";
		$full_grade = false;
		if(isset($_POST['answer']))
		{
			$answers = $_POST['answer'];
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
		}
		$question = $_POST['q_id'];
		if ($full_grade) 
		{
			$new_question = $this->user->add_grade($id,$question);
		}
		$new_question = $this->user->next_ques($question,$id);
		if ($new_question) 
		{
			$this->secure->router("/SWC/user/$id/questions/$new_question");
		}
		else
		{
			$this->secure->router("/SWC/user/$id");
		}
		
	}
	public function upload_pic()
	{
		$seq = uniqid();
		$upload = $this->gen->upload_file("public/imgs/".$seq , $_FILES , "file" ,NULL,"ico");
		if ($upload ) 
		{
			$id = $this->secure->get_ses("id");
			$this->user->update_profile_pic($seq.$_FILES['file']['name'],$id);
			$this->secure->sesconf("profile_pic",PBLC."/imgs/".$seq.$_FILES['file']['name']);
		}
	} 
}