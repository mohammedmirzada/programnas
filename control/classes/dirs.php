<?php

/**
 * Tekosher
 */
class dirs{

	private $_dir;
	
	public function __construct($path=null){
		$this->_dir = $_SERVER["DOCUMENT_ROOT"].$path;
	}

	public function CreateFolder($name){
		if (is_dir($this->_dir.$name) === false ) {
			mkdir($this->_dir.$name);
		}
	}

	public function CreateFile($name,$content='s'){
		$myfile = fopen($this->_dir.$name, "w") or die("Unable to open file!");
		fwrite($myfile, $content);
		fclose($myfile);
	}

	public function UpdateFile($name,$content){
		$file = $this->_dir.$name;
		$myfile = fopen($file, "w") or die("Unable to open file!");
		fwrite($myfile, $content);
		fclose($myfile);
	}

	public function DeleteFile($name){
		$file = $this->_dir.$name;
		unlink($file) or die("Couldn't delete file");
	}

	public function GetAllFiles($path){
		$data = array();
		if ($handle = opendir($_SERVER["DOCUMENT_ROOT"].$path)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
					array_push($data, $entry);
				}
			}
			closedir($handle);
		}
		return $data;
	}

}

?>