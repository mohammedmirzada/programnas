<?php
$price_buy = $_POST['price_buy'];
$price_sell = $_POST['price_sell'];
$amount = $_POST['amount'];

$btc_profit = '';
if (isset($price_buy) && isset($price_sell) && isset($amount)) {
	$profit = (1/$price_buy - 1/$price_sell) * $amount;
	$btc_profit = '<h4>The Price that you buy in is $'.$price_buy.'</h4>';
	$btc_profit .= '<h4>The Price that you sell in is $'.$price_sell.'</h4>';
	$btc_profit .= '<h4>Amount that you bought is $'.$amount.'</h4>';
	$btc_profit .= '<h3 style="color: #478732;">The profit is $'.$profit * $price_sell.'</h3>';
	$btc_profit .= '<h2 style="color: #478732;">The exit amount is $'.(($profit * $price_sell) + $amount).'</h2>';
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<h1>Cryptocurrency Profit Calculator</h1>
	<?=$btc_profit?>
	<form method="POST">
		$ <input type="text" name="price_buy" placeholder="The Price that you buy in is ..."><br>
		$ <input type="text" name="price_sell" placeholder="The Price that you sell in is ..."><br>
		$ <input type="text" name="amount" placeholder="Amount that you bought is ..."><br>
		<input style="width: 276px;" type="submit" name="Calculate">
	</form>
	<style type="text/css">
		input {
			padding: 6px 12px 6px 12px;
		    margin: 2px 0px 2px 0px;
		    border: 1px solid #ddd;
		    border-radius: 6px;
		    width: 250px;
		}
	</style>
</body>
</html>