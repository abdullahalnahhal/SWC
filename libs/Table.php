<?php
	#############################################################
	# THIS LIbrary Is TO Drow Any HTML Table AS Fast As We like #
	#############################################################
	class Lib_Table
	{
		private $theader = "";
		private $tbody = "";
		private $tr = "";
		private $table = "";
		private $xta_col="";
		private $conf = array();
		private $data_source = "";
		private $ref = array();
		private $hidden = array();
		private $tclass = "table ";
		private $source_table = "";
		private $grid = "";
		public function thead($heads)
		{
			$thead = new Lib_Html();
			$thead->thead("mti");
			if (is_array($heads) == false) 
			{
				$th = new Lib_Html();
				$th->th("mti");
				$th->child($heads);
				$thead->child($th);
			}
			else
			{
				foreach ($heads as $head) 
				{
					$th = new Lib_Html();
					$th->th("mti");
					$th->child($head);
					$thead->child($th);
				}
			}
			$this->theader = $this->theader.$thead;
		}
		public function tr($tds)
		{
			$trow = new Lib_Html();
			$trow->tr("mti");
			if (is_array($tds) == false) 
			{
				$td = new Lib_Html();
				$td->td("mti");
				$td->child($tds);
				$trow->child($td);
			}
			else
			{
				$i=1;
				foreach ($tds as $tdata => $value) 
				{
					$this->ref[$tdata]= $value;
					if (in_array($tdata, $this->hidden) == false) 
					{
						$td = new Lib_Html();
						if ($this->grid != "") 
						{
							$td->id = $this->source_table."_".$tdata."_td_".$this->grid."_".$tds[$this->grid]."_".$i;
						}
						$td->td("mti");
						$value = $this->translate($value);
						$td->child($value);
						$td->class="edit";
						$trow->child($td);
						$i++;
					}
					
				}
			}
			$trow->child($this->translate($this->xta_col));
			$this->tr = $this->tr.$trow;
		}
		public function tbody()
		{
			$tbody = new Lib_Html();
			$tbody->tbody("mti");
			$tbody->child($this->tr);
			$this->tbody = $this->tbody.$tbody;
		}
		public function table()
		{
			$this->tbody();
			$head = $this->theader;
			$tbody = $this->tbody;
			$table = new Lib_Html();
			$table->table("mti");
			$table->child($head);
			$table->child($tbody);
			if ($this->grid != "") 
			{
				$this->tclass = $this->tclass." grid";
				$table->to=$this->source_table;
			}
			if ($this->conf) 
			{
				foreach ($this->conf as $cnfiguration=>$value) 
				{
					if ($cnfiguration == "dtable" || $cnfiguration == "search" || $cnfiguration == "paginate" ) 
					{
						$this->tclass = $this->tclass." ".$cnfiguration;
					}
					else
					{
						$table->{$cnfiguration}=$value;
					}
				}
			}
			$table->class = $this->tclass;
			$this->table = $this->table.$table;
		}
		public function data_source($data_source)
		{
			if (is_array($data_source)) 
			{
				foreach ($data_source as $key) 
				{
					$this->tr($key);					
				}
			}
			else
			{
				echo "<b> SIMPLER ERROR</B> : <a href='javascript:void(0)'>data_source method must has array as argument such as </a> [<u>\$object->data_source( array([tr0]=>array(td1,td2,...),...) )]</u> ";

			}
		}
		public function DS_extra_column($tdata)
		{
			$td = new Lib_Html();
			$td->td("mti");
			$td->child($tdata);
			$this->xta_col=$this->xta_col.$td;
		}
		public function translate($string)
		{
			$this->ref = array_unique($this->ref);
			foreach ($this->ref as $key=>$value ) 
			{
				$string = str_replace("@".$key, $value, $string);
			}
			return $string;
		}
		public function source_hide($column)
		{
			if (is_array($column)) 
			{
				$this->hidden = $column;
			}
			else
			{
				$this->hidden[]=$column;
			}
		}
		public function __set($name, $value)
		{
			if ($name == "source_table"  || $name == "grid" ) 
			{
				$this->{$name} = $value;
 			}
			else
			{
				$this->conf[$name] = $value; 
			}
		}
		public function __get($name)
		{
			$this->conf[$name]="true";
		}
		public function __toString()
		{
			$this->table();
			return $this->table;
		}

		##################################
		#I wanna to make data source table
		#  Paginator
		# Ajax Search
		# Ajax in line edit and delete
	}
?>