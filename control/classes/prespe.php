<?php

/**
 * Tekosher 
 */
class prespe {

    private $_data_location;

    public function __construct($user_ip){
        //$this->_data_location = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=".$user_ip));
    }

    public function GetIpInfo($data){
        /* request, status, credit, city, region, areaCode, dmaCode, countryCode, countryName, continentCode, latitude, longitude, regionCode, regionName, currencyCode, currencySymbol, currencySymbol_UTF8, currencyConverter*/
        return $this->_data_location["geoplugin_".$data];
    }

	public static function GetOS($user_agent) { 
		$os_platform  = "Unknown OS Platform";
		$os_array     = array(
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );
        foreach ($os_array as $regex => $value)
        	if (preg_match($regex, $user_agent))
        		$os_platform = $value;
        return $os_platform;
    }

    public static function GetBrowser($user_agent) {
    	$browser = "Unknown Browser";
    	$browser_array = array(
            '/msie/i'      => 'Internet Explorer',
            '/firefox/i'   => 'Firefox',
            '/safari/i'    => 'Safari',
            '/chrome/i'    => 'Chrome',
            '/edge/i'      => 'Edge',
            '/opera/i'     => 'Opera',
            '/netscape/i'  => 'Netscape',
            '/maxthon/i'   => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i'    => 'Handheld Browser'
        );
        foreach ($browser_array as $regex => $value)
        	if (preg_match($regex, $user_agent))
        		$browser = $value;
        return $browser;
    }

    public static function GetUserIP() {
        return (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']);
    }

    /*
    public static function GetUserLocations($loc=null){
        $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=".self::GetUserIP()));
        $l = json_decode(file_get_contents('http://ipinfo.io/'.self::GetUserIP().'/json'));

        $city = $geo["geoplugin_city"];
        $region = $geo["geoplugin_regionName"];
        $country = $geo["geoplugin_countryName"];
        $address = $l->loc;

        if($loc == "city"){
            return $city;
        }else if($loc == "country"){
            return $country;
        }else if($loc == "address"){
            return $l->loc;
        }else if($loc == "region"){
            return $region;
        }
    }

    public static function GetCountryName($ip){
        $country = json_decode(FullResponseURL('http://api.hostip.info/get_json.php?ip='.$ip));
        return $country->country_name;
    }

    public static function GetCountryCode($ip){
        return FullResponseURL('http://api.hostip.info/country.php?ip='.$ip);
    }*/

}

?>