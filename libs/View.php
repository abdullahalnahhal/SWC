<?php
/**
* 
*/
class View
{
	public $title;
	public function render ($name,$vars = FALSE)
	{
		if ($vars) 
		{
			foreach ($vars as $key => $value) 
			{
				$$key = $value;
			}
		}
		
		require_once "views/".$name.".php";
	}
	public function tmpl($tmpl)
	{
		require_once "views/tmpl/".$tmpl.".tmpl";
	}
}