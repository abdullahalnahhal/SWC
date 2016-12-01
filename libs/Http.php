<?php

/**
* 	These class made by Abdullah Al-Nahhal to use HTTP processes such as responds and request methods
*	@property array $status_List 
*	@property string $server_version 
*	@property string $request_method 
*	@property string|utf-8 $charset 
*	@property integer|200 $charset 
*	@method string getRequestMethod()
*	@method boolean isPost()
*	@method boolean isGet()
*	@method boolean isPut()
*	@method boolean isDelete()
*	@method boolean isHead()
*	@method boolean isOptions()
*	@method void statusResponse(integer $code)
*	@method boolean contentType(string $type)
*/
class Http extends Lib_General
{
	
	function __construct(){}
	private $status_List = [
		// 1xx Informational
		100 => 'Continue',
		101 => 'Switching Protocols',
		102 => 'Processing',
		// 2xx Success
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		207 => 'Multi-Status',
		// 3xx Redirection
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		306 => 'Switch Proxy',
		307 => 'Temporary Redirect',
		// 4xx Client Error
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
		418 => 'I\'m a teapot',
		422 => 'Unprocessable Entity',
		423 => 'Locked',
		424 => 'Failed Dependency',
		425 => 'Unordered Collection',
		426 => 'Upgrade Required',
		449 => 'Retry With',
		450 => 'Blocked by Windows Parental Controls',
		// 5xx Server Error
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		506 => 'Variant Also Negotiates',
		507 => 'Insufficient Storage',
		509 => 'Bandwidth Limit Exceeded',
		510 => 'Not Extended'
	];
	/**
	*	@var array $response_format contains list of all respond format in HTTP Content-type key is the string
	*/
	private $response_format=[
		"json" 				=> 	"application/json",
		"html"				=>	"text/html",
		"img-png" 			=> 	"image/png",
		"img-jpg" 			=> 	"image/jpeg",
		"img-gif" 			=> 	"image/gif",
		'zip' 				=> 	'application/zip',
		'xml'   			=> 	'text/xml',
		'css'    			=> 	'text/css',
		'mp3' 				=> 	'audio/mpeg3',
		'mp4' 				=> 	'audio/mpeg3',
		'word' 				=> 	'application/msword',
		'xls' 				=> 	'application/x-msexcel',
		'pdf' 				=> 	'application/pdf',
		'js' 				=> 	'application/x-javascript',
		'ppt' 				=> 	'application/powerpoint',
		'octet-stream'		=>	"application/octet-stream"
	];
	/**
	*	@var string $server_version should contain the HTTP server protocol 1.0 or 1.1
	*/
	private $server_version = $_SERVER['SERVER_PROTOCOL'];
	/**
	*	@var string $request_method should contain the HTTP request such as POST , GET , PUt , etc ..
	*/
	private $request_method = $_SERVER['REQUEST_METHOD'];
	/**
	*	@var string|utf-8 $charset contains the HTTP character set in the header response
	*/
	public $charset = "utf-8"
	/**
	*	@var integer|200 $charset contains the HTTP character set in the header response
	*/
	public $status_code = 200;
	/**
	*	Get the request method such as POST , GET , etc ...
	* 	@return string uppercase of the request method
	*/
	public function getRequestMethod(){
		return strtoupper($this->request_method) ;
	}
	/**
	*	Check if the request is POST
	* @return boolean based if it POST or not
	*/
	public function isPost(){
		if ($this->getRequestMethod() == "POST") {
			return TRUE;
		}
		return FALSE;
	}
	/**
	*	Check if the request is GET
	* 	@return boolean based if it GET or not
	*/
	public function isGet(){
		if ($this->getRequestMethod() == "GET" ) {
			return TRUE;
		}
		return FALSE;
	}
	/**
	*	Check if the request is PUT
	* 	@return boolean based if it PUT or not
	*/
	public function isPut(){
		if ($this->getRequestMethod() == "PUT" ) {
			return TRUE;
		}
		return FALSE;
	}
	/**
	*	Check if the request is DELETE
	* 	@return boolean based if it DELETE or not
	*/
	public function isDelete(){
		if ($this->getRequestMethod() == "DELETE" ) {
			return TRUE;
		}
		return FALSE;
	}
	/**
	*	Check if the request is HEAD
	*	@return boolean based if it HEAD or not
	*/
	public function isHead(){
		if ($this->getRequestMethod() == "HEAD" ) {
			return TRUE;
		}
		return FALSE;
	}
	/**
	*	Check if the request is OPTIONS
	* 	@return boolean based if it OPTIONS or not
	*/
	public function isOptions(){
		if ($this->getRequestMethod() == "OPTIONS" ) {
			return TRUE;
		}
		return FALSE;
	}
	/**
	*	Send the response status code
	*	@param int $code is the number of status code
	*/
	public function statusResponse($code){
		header($_SERVER['SERVER_PROTOCOL'].' '.$code.' '.$status_List[$code]); 
	}
	/**
	*	Send the response Content-Type format
	*	@param string $type is the type shortcut of the HTTP formats
	*	@return boolean based if the type is available or not
	*/
	public function contentType($type){
		if (in_array($type, $this->response_format)) {
			header("Content-Type: ".$this->response_format[$type]);
			return true;
		}
		else {
			return false;
		}
	}
}

?>