<?php
function __autoload($classname) {
	$classnamearr = explode("_", $classname);
	if ($classnamearr[0] == ("Model")) 
	{
		$filename = "Model/". strtolower ($classnamearr[1]) .".php";
	}
    elseif ($classnamearr[0] == ("Lib")) 
    {
    	$filename = "libs/". strtolower ($classnamearr[1]) .".php";
    }
    else
    {
    	$filename = "controller/". strtolower ($classname) .".php";
    }
    include_once($filename);
}
	/**
	* 
	*/
	class Bootstrap
	{
		// public  $URL = "http://localhost:8444/simpler/";
		function __construct()
		{
			define('BASEURL', 'http://localhost/SWC');
			define('PBLC', BASEURL.'/public');
			define('STYLEURL', BASEURL .'/public/style');
			define('JSURL',BASEURL . '/public/js');
			define('CLIBURL',BASEURL . '/public/libs');
			define('BVIEW', BASEURL . '/views');
			define('FILES', BASEURL . '/public/files');
			


			if (isset($_GET['url'])) 
			{
				#################################
				# baseurl / controller / method #
				#################################
				$url = $_GET['url'];
				$url = rtrim($url,'/');
				$url = explode('/', $url);
				if ($url[0] == 'lang') 
				{
					$secure = new Lib_secure();
					$url = $secure->ref_checker();
					$secure->set_lang($url[1]);
					$secure->router($url);
				}
				$file = 'controller/'.$url[0].'.php';
				
				if (file_exists($file)) 
				{
					require $file;
					$controller = new $url[0];
					if (isset($url[1])) 
					{
						if (is_numeric($url[1])) 
						{
							if (isset($url[2])) 
							{
								$method = $url[2];
								$url[2] = $url[1];
								$url[1] = $method;
							}
							else
							{
								$url[2] = $url[1];
								$url[1] = "index";
							}
						}
						if (method_exists ($controller,$url[1])) 
						{
							if (isset($url[2])) 
							{
								if (isset($url[3])) 
								{

									$controller->{$url[1]}($url[2],$url[3]);
								}
								else
								{
									$controller->{$url[1]}($url[2]);
								}
							}
							else
							{
								$controller->{$url[1]}();
							}
						}
						else
						{
							echo("<br>The method : {$url[1] } is Not exist ");
						}
					}
					elseif (method_exists ($controller,'index')) 
					{
						$controller->index();
					}
					else
					{
						echo("<br>There No Index In Your Controller");
					}
				}
				else
				{
					echo("<br>The file : $file  is Not exist ");
					
				}
			}
			else
			{

				require_once 'controller/index.php';
				$controller = new Index();
				$controller->index();
				return false;
			}
		}
	}