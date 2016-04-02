<?php
/**
* 
*/
class View
{
	public function render ($name,$vars = FALSE)
	{
		if ($vars) 
		{
			foreach ($vars as $key => $value) 
			{
				$this->{$key} = $value;
			}
		}
		$secure = new Lib_secure();
		require_once 'lang/en.php';
		$this->text = $lang;
		require_once "views/".$name.".php";
	}
	public function tmpl($tmpl)
	{
		require_once "views/tmpl/".$tmpl.".tmpl";
	}
}