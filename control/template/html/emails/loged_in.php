<?php
$body = '
<!DOCTYPE html>
<html>
<body style="font-family: -apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,sans-serif;padding: 0;margin: 0;">
<div style="padding: 8px;">
<div style="background: #fff;color: #555;border-radius: 0px 0px 6px 6px;box-shadow: -2px 4px 7px 5px #0000000d;border: 1px solid #dddddda3;">
	<div style="padding-bottom: 4px;">
	    <div style="border-radius: 0px 0px 20px 20px;margin: 0 auto;max-width: 800px;">
	    	<div style="background-color: white;padding: 2px;">
	    	    <span style="background-image: url(https://programnas.com/control/template/media/png/logo.png);background-size: 300px;width: 326px;height: 52px;display: block;background-repeat: no-repeat;margin-top: 10px;margin-bottom: 10px;"></span>
	    	</div>
	    	<div style="margin-top: 18px;font-size: 18px;color: #000000b0;">Someone is logged into your account. <a href="'.$link.'" target="_blank" style="color: #001946;"><u>Reset your password</u></a> if it wasn\'t you.</div>
	    	<div style="line-height: 30px;margin-top: 14px;padding: 12px;background: #2caebf03;border: 1px solid #dddddd69;border-radius: 4px;">
	    		<div>Account: <u>'.$this->_user_email.'</u></div>
	    		<div>Time: <u>'.date("Y-m-d H:i:s").'</u></div>
	    		<div>IP address: <u>'.prespe::GetUserIP().'</u></div>
	    		<div>Browser: <u>'.prespe::GetBrowser($_SERVER['HTTP_USER_AGENT']).'</u></div>
	    		<div>OS: <u>'.prespe::GetOS($_SERVER['HTTP_USER_AGENT']).'</u></div>
	    	</div>
	    	<div align="center" style="padding: 4px;margin-top: 14px;margin-bottom: 14px;">
	    		<a href="https://programnas.com/about" style="text-decoration: none;color: #555;padding: 6px 10px 6px 10px;display: inline-block;font-size: 14px;font-weight: bold;">About</a>
	    		<a href="https://programnas.com/support" style="text-decoration: none;color: #555;padding: 6px 10px 6px 10px;display: inline-block;font-size: 14px;font-weight: bold;">Support</a>
	    		<a href="https://programnas.com/help" style="text-decoration: none;color: #555;padding: 6px 10px 6px 10px;display: inline-block;font-size: 14px;font-weight: bold;">Help</a>
	    		<a href="https://programnas.com/terms" style="text-decoration: none;color: #555;padding: 6px 10px 6px 10px;display: inline-block;font-size: 14px;font-weight: bold;">Terms</a>
	    		<a href="https://programnas.com/library" style="text-decoration: none;color: #555;padding: 6px 10px 6px 10px;display: inline-block;font-size: 14px;font-weight: bold;">Library</a>
	    	</div>
	    </div>
    </div>
</div>
</div>
</body>
</html>';
?>