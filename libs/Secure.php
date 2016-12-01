<?php
class Lib_Secure extends Lib_General
{
	function __construct(){}
	public function T($text) //validate any text input
	{
		$text = trim($text);
		$text = htmlentities($text);
		$text = mysql_real_escape_string($text);
		return $text;
	}
	public function Tarea($text) // validate any textarea intput
	{
		$text = trim($text);
		$text = htmlentities($text);
		$text = str_replace("\r\n", "<br>", $text);
		$text = str_replace("\r", "<br>", $text);
		$text = str_replace("\n", "<br>", $text);
		$text = mysql_real_escape_string($text);
		return $text;
	}
	public function Tarear($text) // validate any text area output
	{
		$text = str_replace("<br>", "\r\n", $text);
		return $text;
	}
	public function Aen($link) // encode any link
	{
		$link = convert_uuencode($link);
		$link = base64_encode($link);
		return $link;
	}
	public function Ade($link) // decode any link
	{
		$link = base64_decode($link);
		$link = convert_uudecode($link);
		return $link;
	}
	public function pass($password) // Hashing password
	{
		return hash_hmac("sha512", $password, "");
	}
	public function sess() // Session Start
	{
		session_start();
	}
	public function sese() // Session end
	{
		session_unset();
		session_destroy();
	}
	public function sesconf( $vars , $vals ) // for setting session variables and values 
	{
		if (is_array($vars)) 
		{
			$count = count($vars);
			for ($i=0; $i < $count; $i++) 
			{ 
				$_SESSION[$vars[$i]] = $vals[$i];
			}
		}
		else
		{
			$_SESSION[$vars] = $vals;
		}
	}
	public function sessCheck($vars , $vals) // for checking session variables
	{
		if (is_array($vars)) 
		{
			$count = count($vars);
			for ($i=0; $i < $count; $i++) 
			{ 
				if ($_SESSION[$vars[$i]] != $vals[$i]) 
				{
					return false;
				}
			}
		}
		else
		{
			if ($_SESSION[$vars] != $vals) 
			{
				return false;
			}
		}
		return true;
	}
	public function get_ses($var)
	{
		return $_SESSION[$var];
	}
	public function set_ses($var , $val)
	{
		$_SESSION[$var] = $val;
		return $_SESSION[$var];
	}
	public function session_checker($sess_var , $sess_val) // it takes the imortant session variables and its value to compare if it true or not
	{
		if ($_SESSION[$sess_var] == $sess_val) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	private function encrypt_key_generator() // Generating the encryption key
	{
		###############################################
		# These function is private for more security.#
		###############################################
		// make a unix time stamp
		$key = time();
		// hash the time stamp
		$key = $this->hashing_strings($key);
		//take just 32 characters to be a key
		if (strlen($key)<=32)  
		{
			$key = $key;
		}
		else
		{
			$key = substr($key, 0,32); 
		}
		// return encryption key
		return $key;
	}
	public function encrypt_file($file_path) // encrypting the file ( entire data ) return the encryption key
	{
		//get they encryption key
		$key = $this->encrypt_key_generator();
		//read the file we want to encrypt
		$value = $this->read_file($file_path);
		$text = $value;
		//encrypt
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
		//write the encrypted text on the file
		$this->write_file($file_path,$crypttext);
		//return the key to store it into the database
		return $key;
	}
	public function decrypt_file($file_path , $key) // decrepting the file (entire data)
	{
		$value = $this->read_file($file_path);
	   	$crypttext = $value;
	   	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	   	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	   	$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $iv);
	   	$decrypttext = $this->write_file($file_path,$decrypttext);
	   	// return $decrypttext;
	}
	public function encrypt_text($text) // encrypting Original text and return encrypted text and the encryption key
	{
		//encrypt
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
		//return the key and the encrypted text
		return array("enc_key"=>$key,"enc_text"=>$crypttext);
	}
	public function decrypt_text($text , $key) // decrepting text and return original text
	{
	   	$crypttext = $text;
	   	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	   	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	   	$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $iv);
	   	return $decrypttext;
	}
	public function ref_checker($accepted_page=NULL) // it takes the accepted page(s) [full path] and compare it/them with the hreferer then return true or false
	{
		$ref_page = $_SERVER["HTTP_REFERER"];
		if (!$accepted_page) 
		{
			return $ref_page;
		}
		elseif (is_array($accepted_page)) 
		{
			if (in_array($ref_page, $accepted_page)) 
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		elseif ($ref_page == $accepted_page) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function Qsvarnum_checker($qstring_val_number)// it takes the number of values in query string then checks if it true or not the return true or false
	{
		$var_number = count($_REQUEST);
		if ($var_number == $qstring_val_number) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function Qstring_checker($original_qstring) // it takes a query string compares the real qstring and the original one then return true or false
	{
		$qstring = $_SERVER['QUERY_STRING'];
		if ($qstring == $original_qstring) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function router($dir_page) // it redirect the page to another one
	{
		header("location:".$dir_page);
	}
	public function sec_cookie($name , $value , $expiration = 0 , $path ="" , $domain = "" , $secure = false, $httponly = false)
	{
		setcookie($name, $value, time() + (86400 * 30), "/"); // 86400 = 1 day
	}
	public function set_lang($lang)//set language as a cookie
	{
		setcookie("lang", $lang);
	}
}