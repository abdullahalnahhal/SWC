<?php
	###################################################################################
	# This Library Is To Do Some Important , Redundant And Non Categorized Operations #
	###################################################################################
	class Lib_General 
	{
		public function read_file($file_path)// take the file path and returns its data as a sttring
		{
			$file_handel = fopen($file_path, "r+");
			$file_size = filesize($file_path);
			$fdata = fread($file_handel,$file_size);
			fclose($file_handel);
			return $fdata;
		}
		public function overwrite_file($file_path,$text) // take the file path and the text to overwrite on 
		{
			$file_handel = fopen($file_path, "w");
			fwrite($file_handel,$text);
		    fclose($file_handel);
		}
		public function download_data($string,$filename) // take the string and the downloaded file name and returns the data
		{
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($filename).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Connection: close');
			echo $string;
		}
		public function download_file($file_path) // take the file path and download it
		{
			$file = $file_path;
			if (file_exists($file)) 
			{
			    header('Content-Description: File Transfer');
			    header('Content-Type: application/octet-stream');
			    header('Content-Disposition: attachment; filename="'.basename($file).'"');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($file));
			    readfile($file);
			}
			else
			{
				echo "There no file Like that in that path";
			}
		}
		public function upload_file($target_dir , $files , $file_name , $basename = NULL, $type = NULL )
		{
			$target_file = $target_dir . basename($files[$file_name]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if file already exists
			if (pathinfo($target_file, PATHINFO_EXTENSION) != "html" || file_exists($target_file) ) 
			{
				return false;
			}
			if (move_uploaded_file($files[$file_name]["tmp_name"], $target_file)) 
			{
					return true;
			} 
			else 
			{
				return false;
			}
		}
	}