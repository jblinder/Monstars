<?php
/*
	Revieves a json obejct of data and a parsing option. Parses the data correctly and retruns a json object of stats	
*/

class parser{
  
	private $json;
	private $user;
	private $days;
	private $months;

    public function __construct() {
		
    }

	public function init($_user, $_opt) {
		$this->user = $_user;
		switch($_opt){
			case '0':  //get user's stats
				$scobbles =  0;//floor($this->getScobbles());
				$time     =  floor($this->getFreq());
				$follow_info = $this->getFollowers();
				$followers =  floor($follow_info["followers"]);
				$profile   =  $follow_info["icon"];
				$payload = array("user" => $this->user, "scobbles" => $scobbles, "time" => $time, "followers" => $followers, "image" => $profile, "bio" => $follow_info["bio"]);
				return $payload;
				break;
			case '1': // caclulate milliscobles
				$scobbles = 0; //$this->getScobbles();
				return $scobbles;
				break;
				
			case '2': // calculate average time in between tweets
				$freq = $this->getFreq();
				return $freq;
				break;
				
			case '3': // caclulate twitter followers
				$followers = $this->getFollowers();
				return $followers["followers"];
				break;
				
				
		}
	}
	
	

	private function query($url) {
		$ch  = curl_init();
		
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER,0);
	    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    
	    $data =  curl_exec($ch);
	    curl_close($ch);
		return $data;
	
	}
	
	private function getScobbles() {
		$url  = "http://followcost.com/" . $this->user . ".json";
		echo $url;
	 	$data = json_decode($this->query($url));
		$scobbles = $data->milliscobles_all_time;
		return $scobbles;
	}
	
	private function getFreq() {
		$url  = "http://api.twitter.com/1/statuses/user_timeline.json?screen_name=". $this->user ."&count=100";
		$data = json_decode($this->query($url));
		$total = 0;
		for($i = 0; $i < count($data); $i++){
			
			$ndate = date('Y-m-d H:i:s', strtotime($data[$i]->created_at));
			$tempdate = preg_split('/ /', $ndate);
			$monthly  = preg_split('/-/', $tempdate[0]);
			$daily    = preg_split('/:/', $tempdate[1]);
			
			$year   = $monthly[0];
			$month  = $monthly[1];
			$day    = $monthly[2];
			$hour   = $daily[0];
			$min    = $daily[1];
			$sec    = $daily[2];
			
			if($i >= 1){
				$secyear   = ( $pyear - $year ) * 31556926;
				$secmonths = ( $pmonth - $month ) * 2629743.83;
				$secdays   = ( $pday  -  $day ) *  86400;
				$sechour   = ( $phour -  $hour ) * 3600;
				$secmin    = ( $pmin  -  $min ) * 60;
				$total  += ($secyear + $secmonths + $secdays + $sechour + $secmin + $sec);

 			}
		  		$pyear  = $year;
		  		$pmonth = $month;		
		  		$pday   = $day;
		  		$phour  = $hour;
		  		$pmin   = $min;
		  		$psec   = $sec;
			
		}
		
		$total = floor($total / count($data));
		return $total;
	}
	
	private function getFollowers() {
		$url  = "http://api.twitter.com/1/users/show.json?screen_name=" . $this->user;
		$data = json_decode($this->query($url));
		$payload = array("followers" =>$data->followers_count, "icon" => $data->profile_image_url, "bio" => $data->description);
		return $payload;
	}
	
	
	

	
}

?>