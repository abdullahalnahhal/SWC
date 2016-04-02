<?php
class Model
{
	#####################
	# Now its For Mysql #
	#####################
	//for selecting the table we are warking with now
	public static $tableName;
	//connecting to the data base
	#########################################################################################
	#	-It must take the database name at least .											#
	#	-If you don't enter the host name , user name ,Or password;							#
	#	-The default will be host name:loclhost , user name: root , and password is empty . #
	#########################################################################################
	private $dbName = "swc";
	private $host="localhost";
	private $userName="root";
	private $password="";
	function __construct()
	{
		$conn = mysql_connect($this->host,$this->userName,$this->password);
		mysql_select_db($this->dbName);
		return "<br>connected<br>";
		mysql_set_charset('utf8',$conn);
		mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'",mysql_connect($this->host,$this->userName,$this->password));
		mb_internal_encoding("UTF-8");
		mb_regex_encoding("UTF-8");
		mysql_query("SET NAMES utf8",$conn);
		mysql_query("SET CHARACTER_SET utf8",$conn);
		mysql_query("SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT",$conn);
		mysql_query("set SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS",$conn);
		mysql_query("SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION",$conn);
		mysql_query("SET @OLD_TIME_ZONE=@@TIME_ZONE",$conn);
		mysql_query("set character_set_server='utf8'",$conn);
		mysql_query("set character_set_server='utf8'",$conn);
	}
	//closing the database .
	public function dbClose()
	{
		mysql_close();
		return "closed database";
	}
	public function insert($columns,$values)
	{
			$tableName=self::$tableName;
			$query="INSERT INTO `$tableName` (";
			if (is_array($columns)==false&&is_array($values)==false) 
			{
				$query=$query."`".$columns."`) VALUES ('".$values."')";
			}
			else
			{
				if (count($columns)!=count($values)) 
				{
					return "Plese eanter true number of columns that ecual true values";
				}
				else
				{
					$cols="";
					$vals="";
					$iterator=1;
					foreach ($columns as $key => $value) 
					{
						if ($iterator==1) 
						{
							$cols="`".$value;
							$vals="".$values[$key];
						}
						else
						{
							$cols=$cols."`,`".$value;
							$vals=$vals."','".$values[$key];
						}
						$iterator++;
					}
					$query=$query.$cols."`) VALUES ('".$vals."')";
				}
			}
			// echo "<br>".print_r($columns)."<br>".print_r($values);die;
			mysql_query($query);
			// echo $query;
			return $query;
	}
	public function update($column,$value,$condColumn,$condValue)
	{
			$tableName=self::$tableName;
			mysql_query("SELECT * FROM $tableName");
			if (mysql_affected_rows()<1) 
			{
				echo "The table is empty";
			}
			else
			{
				$sql="UPDATE `$tableName` SET `$column` = '$value' WHERE $condColumn='$condValue' ";
				mysql_query($sql);
				if(mysql_affected_rows()<1)
				{
					return $sql;//"there is no item like that.";
				}
			}
	}
	public function select($column,$freeCond=NULL)
	{
			$tableName=self::$tableName;
			$query="";
			if (is_array($column)==false) 
			{
				if ($column!="*") 
				{
					$column="`".$column."`";
				}
				if ($freeCond!=NULL) 
				{
					$query="SELECT $column From `$tableName` WHERE $freeCond";
					$sql=mysql_query($query);
				}
				else
				{
					$query="SELECT $column From `$tableName`";
					$sql=mysql_query($query);
				}
			}
			else
			{
				$columnSet="";
				$iterator=1;
				foreach ($column as $value) 
				{
					if ($iterator==1) 
					{
						$columnSet="`".$value;
					}
					else
					{
						$columnSet=$columnSet."`,`".$value/*."`"*/;
					}
					$iterator++;
				}
				// $columnSet = $columnSet."`";
				if ($freeCond!=NULL) 
				{
					$query="SELECT $columnSet From `$tableName` WHERE ($freeCond)";
					$sql=mysql_query($query);

				}
				else
				{
					$query="SELECT $columnSet From `$tableName`";
					$sql=mysql_query($query);
				}
			}
			// echo $query;
			return $sql;		
	}
	public function delete($condition)
	{
			$tableName=self::$tableName;
			mysql_query("DELETE FROM $tableName WHERE $condition");
	}
	public function assoc($sql)
	{
		$list = array();
		if ($sql) 
		{
			while($result = mysql_fetch_assoc($sql))
			{
				$list[] = $result;
			}
		}
		
		return $list;
	}
	public function freeQuery($query)
	{
		$query  = mysql_query($query);
		return $query;
	}
	public function last($col_name)
	{
		$tableName=self::$tableName;
		$last = $this->freeQuery("SELECT `".$col_name."` FROM `".$tableName."` ORDER BY `".$col_name."` DESC LIMIT 1");
		
		$last = $this->assoc($last);
		if ($last) 
		{
			$last = $last[0][$col_name];
		}
		else
		{
			$last = NULL;
		}
		return $last ; 
	}
}