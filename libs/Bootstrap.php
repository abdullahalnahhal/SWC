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
				$file = 'controller/'.$url[0].'.php';
				if (file_exists($file)) 
				{
					require $file;
					$controller = new $url[0];
					if (isset($url[1])) 
					{
						if (method_exists ($controller,$url[1])) 
						{
							if (isset($url[2])) 
							{
								
									$controller->{$url[1]}($url[2]);
								
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
				return false;
			}
		}
	}