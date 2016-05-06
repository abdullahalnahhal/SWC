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
	
	public function user_info($id)
	{
		$this::$tableName = "v_users";
		$info = $this->select('*',"`id`=$id");
		$info = $this->assoc($info);
		if (!isset($info[0])) 
		{
			return NULL;
		}
		return $info[0];
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
	public function answers($ques_id)
	{
		$this::$tableName = "answers";
		$answers = $this->select('*',"`questions_id` = '$ques_id'");
		$answers = $this->assoc($answers);
		return $answers;
	}
	public function check($id)
	{
		$this::$tableName = "answers";
		$answers = $this->select('*',"`id` = '$id'");
		$answers = $this->assoc($answers);
		return $answers[0];	
	}
	public function add_grade($user_id,$q_id)
	{
		$this::$tableName = "questions";
		$question = $this->select('*',"`id` = '$q_id'");
		$question = $this->assoc($question);
		$grade = $question[0]['grade'];
		$this::$tableName = "users";
		$question = $this->freeQuery("UPDATE `users` SET `grade` = `grade`+$grade WHERE `id`= $user_id;");
		$next_question = $this->next_ques($q_id,$user_id);
		if ($next_question) 
		{
			return $next_question ;
		}
		return false;
	}
	public function next_ques($q_id ,$user_id)
	{
		$this::$tableName = "users";
		$question = $this->freeQuery("UPDATE `users` SET `questions_id` = `questions_id`+1 WHERE `id`= $user_id;");
		$next_question = $q_id+1;
		$this::$tableName = "questions";
		$question = $this->select('*',"`id` = '$next_question'");
		$question = $this->assoc($question);
		if (isset($question[0])) 
		{
			return $question[0]['id'];
		}
		return false;
	}
	public function update_profile_pic($name,$id)
	{
		
		$this::$tableName = "users";
		$this->update('profile_pic',$name,"id",$id);
	}
}