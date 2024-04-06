<?php
$body = '
<!DOCTYPE html>
<html>
<body style="font-family: -apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,sans-serif;padding: 0;margin: 0;">
<div style="padding: 8px;">
<div style="background: #fff;color: #555;border-radius: 0px 0px 6px 6px;box-shadow: -2px 4px 7px 5px #0000000d;border: 1px solid #dddddda3;">
	<div style="padding-bottom: 4px;">
	    <div align="center" style="border-radius: 0px 0px 20px 20px;">
	    	<div style="background-color: white;padding: 2px;" align="center">
	    	    <span style="background-image: url(https://programnas.com/control/template/media/png/logo.png);background-size: 300px;width: 550px;height: 56px;display: block;background-repeat: no-repeat;margin-top: 10px;margin-bottom: 10px;background-position: center;"></span>
	    	</div>
	    	<div style="margin-top: 18px;font-size: 18px;color: #000000b0;font-weight: bold;">Hi '.$name.'</div>
	    	<div style="padding: 20px;">Click this button to confirm your email address and start asking.</div>
	    	<a href="https://programnas.com/account/confirm?hash='.$confirm_hash.'" style="text-decoration: none;display: inline-block;padding: 12px 20px 12px 20px;color: #fff;background: #001946;margin: 14px 0px 14px 0px;border-radius: 50px;">Confirm your email</a>
	    	<div style="padding: 20px;">or Copy this Confirmation Code.</div>
	    	<div style="background: white;margin: 10px 0px 4px 0px;color: #666;padding: 6px 26px 6px 26px;font-size: 20px;font-weight: bold;display: inline-block;border-radius: 0px;border: 1px solid #66666629;">'.$confirm_code.'</div>
	    	<div style="margin-top: 14px;">
	    		If you didn\'t use this email, or if it\'s by a mistaken, You may <a href="https://programnas.com/support" style="color: #001946;">contact us</a>
	    	</div>
	    	<div style="border-top: 1px solid #eee;padding: 4px;margin-top: 30px;margin-bottom: 14px;">
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