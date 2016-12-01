<?php
	/**
	* 	This Library Is To Do Some Important , Redundant And Non Categorized Operations
	*	@method string read_file(string $file_path)
	*	@method void overwrite_file(string $file_path, string $text)
	*	@method void download_data(string $string,string $filename)
	*	@method void download_file(string $file_path)
	*	@method boolean upload_file(string $target_dir , array|mix $files , string $file_name , string|NULL $basename , string|NULL $type )
	*/
	class Lib_General 
	{
		/**
		*	Take the file path and returns its data as a string
		*	@param string $file_path the full file destination
		*	@return string file content
		*/
		public function read_file($file_path){
			$file_handel = fopen($file_path, "r+");
			$file_size = filesize($file_path);
			$fdata = fread($file_handel,$file_size);
			fclose($file_handel);
			return $fdata;
		}
		/**
		*	take the file path and the text to overwrite on it
		*	@param string $file_path the full file destination
		*	@param string $text the text that wanted to write
		*/
		public function overwrite_file($file_path,$text){
			$file_handel = fopen($file_path, "w");
			fwrite($file_handel,$text);
		    fclose($file_handel);
		}
		/**
		*	Take the string and the downloaded file name and returns the data
		*	@param string $string represents the data we want to download
		*	@param string $filename the full name of the file we want to download with
		*	@return string file content
		*/
		public function download_data($string,$filename){
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($filename).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Connection: close');
			echo $string;
		}
		/**
		*	Take the file path and download it
		*	@param string $file_path the full file destination
		*/
		public function download_file($file_path){
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
		/**
		*	Upload file
		*	@param string $target_dir represents the directory we want to upload in
		*	@param array|mix $files the FILES array
		*	@param string $file_name the file attribute name that sent with FILES array
		*	@param string|null $basename 
		*	@param string|null $type 
		*	@return boolean based on the file is uploaded or not
		*/
		public function upload_file($target_dir , $files , $file_name , $basename = NULL, $type = NULL )
		{
			$target_file = $target_dir . basename($files[$file_name]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if file already exists
			if (file_exists($target_file) ) 
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