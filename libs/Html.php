<?php
	############################################################
	# THIS LIbrary Is TO Drow Any HTML Element Fast As We like #
	############################################################
	class Lib_Html
	{
		private $attributes =array(); // it handels all attributes
		private $element = ""; // it handels just one element for each object
		private $element_type =""; // it handels the element type (single tag element or multi tag element)
		private $child = ""; // it handels the child for the object it means the inner html element 
		public function __set($attribute , $value) // when declaring any property we take it as a html attribute and its value is the property value
		{
			$this->attributes[$attribute ] = $value;// save the attribute and its value into private property attributes as an indexed array;
		}
		public function __call($element , $value)// when declaring a method we take it as a html element which its type is the single arg. in it it must be ( sgl or mti ) and can be capital.
		{
			if (count($value) == 1) 
			{
				$this->element = $element;
				$this->element_type = strtoupper($value[0]);
			}
			else
			{ 
				return "<b> SIMPLER ERROR</B> : <a href='javascript:void(0)'>The element must has one arg in it no more than one , and it must be capital/small (sgl / mti) tou can do such like that :   </a> [<u>\$object->element_name( <i> sgl / mti </i> )]</u> ";
			}
		}
		public function __toString() // it builds the element and its inner childs on dealing with it as a string so it can be added like a string.
		{
			$element_type = $this->element_type;//take element type
			$element=$this->element;// take element name
			$tag="<";
			$attributes = $this->attributes ;// handle attributes
			$attribs = "";
			$child = $this->child; // take child as a string
			foreach ($attributes as $key => $value) // generate attributes
			{
				$attribs = $attribs.$key."=\"".$value."\"";
			}
			if ($element!="") 
			{
				if ($element_type == "SGL" ) // if it is a single tag element generate it as one line 
				{
					$tag = $tag.$element." ".$attribs.">";
				}
				elseif($element_type == "MTI" ) // if it is not single tag element generate it as two tags between them the elements child
				{
					$tag = $tag.$element." ".$attribs.">".$child."</".$element.">";
				}
				return $tag;
			}
			else
			{
				return "<b> SIMPLER ERROR</B> : <a href='javascript:void(0)'>There must be element to be set , so set element first such as </a> [<u>\$object->element_name( <i> sgl / mti </i> )]</u> ";
			}
		}
		public function child($child) // it is the inner html elements we take it as a string 
		{
			$this->child = $this->child.$child; // save the child on child handler
		}
	}
?>