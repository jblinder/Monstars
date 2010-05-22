<?php
/*
	Revieves a json obejct of data and a parsing option. Parses the data correctly and retruns a json object of stats.

*/

class parser{
  
	private $output;
	private $json;
	private $user;
	
    public function __construct($_json) {
		this->$json = $_json;
		this->$user = getUser(this->$jsona);
    }

	public function init($_json, $_opt) {
		this->$json = $_json;
		switch($opt){
			case '0': //get user's stats
				this->getFreq();
				this->getTime();
				this->getTweetCount();
				break;

			case '1': // caclulate milliscobles
				this->getFreq();
				break;
				
			case '2': // calculate average time in between tweets
				this->getTime();
				break;
				
			case '3': // caclulate number of users tweets
				this->getTweetCount();
				break;
		}
	}

	private function query() {
		$url = "http://api.twitter.com/1/users/show.json?screen_name=" . this->$user;
		$ch  = curl_init();
		
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER,0);
	    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
	    this->$data = curl_exec($ch);
	    curl_close($ch);
	
		
		
	}
	
	private function getTime() {
		
	}
	
	private function getFreq() {
			
	}
	
	private function getTweetCount() {
	
	}
	
	private function getUser() {
			
	}
	
}

?>