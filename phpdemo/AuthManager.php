<?php

class AuthManager
{
	public $error;
	private $postArray;

	public function __construct($postArray)
	{
		$this->postArray = $postArray;
	}
	public function validate($postArray=null)
	{
		if($postArray != null)
			$this->postArray = $postArray;
		
		if(!isset($this->postArray['verify']) || !isset($this->postArray['appid']) || !isset($this->postArray['uid']) || !isset($this->postArray['ch']) || !isset($this->postArray['time']))
		{
			$this->error = "invalid input";
			return false;
		}

		$verify = $this->postArray['verify'];

		$hash = md5($GLOBALS['appid'].$this->postArray['uid'].$this->postArray['ch']."1".$this->postArray['time'].sha1($GLOBALS['key']));
		
		if($verify != $hash)
		{
			$this->error = "hash comparison failed";
                        return false;
		}
	
		return $this->validateTime($this->postArray['time']);

	}
	private function validateTime($timeString)
	{
		$date = substr($timeString, 0, 8);

		$time = substr($timeString, 8);		
	
		$currentTime = strtotime($date."t".$time);
		
		if(time() < $currentTime + 120 && time() > $currentTime - 120)
			return true;
	
		$this->error = "time is not with legal range";
		
		return false;
	}
	public function redirect($url)
	{
		echo "op_ret=1&effurl=".base64_encode($url);	
	}
}

?>
