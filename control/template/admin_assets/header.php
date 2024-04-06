	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></button>
				<a class="navbar-brand" href="/publicdashboard" style="font-size: 14px;"><span>Programnas</span> Dashboard</a>
			</div>
		</div>
	</nav>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="<?=$user->ImageIcon()?>" class="img-responsive" alt="">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name"><?=$user->data()->username?></div>
				<div class="profile-usertitle-status"><?=ucfirst($user->data()->permission)?></div>
			</div>
			<div class="clear"></div>
		</div>
		<ul class="nav menu">
			<?php
			$a_a = '';
			$a_a_transactions = '';
			$a_a_reports = '';
			$a_a_answers = '';
			$a_a_points = '';
			$a_a_questions = '';
			$a_a_requests = '';
			$a_a_users = '';
			$a_a_admins = '';
			$a_a_referrals = '';
			$a_a_library = '';
			if (FindUrl("reports")) {
				$a_a_reports = 'active';
			}elseif (FindUrl("transactions")) {
				$a_a_transactions = 'active';
			}elseif (FindUrl("answers")) {
				$a_a_answers = 'active';
			}elseif (FindUrl("points")) {
				$a_a_points = 'active';
			}elseif (FindUrl("questions")) {
				$a_a_questions = 'active';
			}elseif (FindUrl("requests")) {
				$a_a_requests = 'active';
			}elseif (FindUrl("users")) {
				$a_a_users = 'active';
			}elseif (FindUrl("admins")) {
				$a_a_admins = 'active';
			}elseif (FindUrl("referrals")) {
				$a_a_referrals = 'active';
			}elseif (FindUrl("library")) {
				$a_a_library = 'active';
			}else{
				$a_a = 'active';
			}
			?>
			<li class="<?=$a_a?>"><a href="/publicdashboard">Dashboard</a></li>
			<?php if($user->data()->permission == "super"){ ?>
				<li class="parent <?=$a_a_reports?>">
					<a data-toggle="collapse" href="#sub-item-1">Reports <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span></a>
					<ul class="children collapse" id="sub-item-1">
						<li>
							<a href="/publicdashboard/reports?type=answers">Answers</a>
						</li>
						<li>
							<a href="/publicdashboard/reports?type=replies">Replies</a>
						</li>
					</ul>
				</li>
				<li class="<?=$a_a_questions?>"><a href="/publicdashboard/questions">Questions</a></li>
				<li class="<?=$a_a_answers?>"><a href="/publicdashboard/answers">Answers</a></li>
				<li class="<?=$a_a_users?>"><a href="/publicdashboard/users">Users</a></li>
				<li class="<?=$a_a_points?>"><a href="/publicdashboard/points">Points</a></li>
				<li class="<?=$a_a_requests?>"><a href="/publicdashboard/requests">Verifying requests</a></li>
				<li class="<?=$a_a_transactions?>"><a href="/publicdashboard/transactions">Transactions</a></li>
				<li class="<?=$a_a_admins?>"><a href="/publicdashboard/admins">Admins</a></li>
				<li class="<?=$a_a_referrals?>"><a href="/publicdashboard/referrals">Referrals</a></li>
				<li class="<?=$a_a_library?>"><a href="/publicdashboard/library">Library</a></li>
			<?php }elseif ($user->data()->permission == "review") { ?>
				<li class="parent <?=$a_a_reports?>">
					<a data-toggle="collapse" href="#sub-item-1">Reports <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span></a>
					<ul class="children collapse" id="sub-item-1">
						<li>
							<a href="/publicdashboard/reports?type=answers">Answers</a>
						</li>
						<li>
							<a href="/publicdashboard/reports?type=replies">Replies</a>
						</li>
					</ul>
				</li>
				<li class="<?=$a_a_questions?>"><a href="/publicdashboard/questions">Questions</a></li>
				<li class="<?=$a_a_answers?>"><a href="/publicdashboard/answers">Answers</a></li>
				<li class="<?=$a_a_users?>"><a href="/publicdashboard/users">Users</a></li>
				<li class="<?=$a_a_points?>"><a href="/publicdashboard/points">Points</a></li>
				<li class="<?=$a_a_requests?>"><a href="/publicdashboard/requests">Verifying requests</a></li>
				<li class="<?=$a_a_transactions?>"><a href="/publicdashboard/transactions">Transactions</a></li>
				<li class="<?=$a_a_referrals?>"><a href="/publicdashboard/referrals">Referrals</a></li>
				<li class="<?=$a_a_library?>"><a href="/publicdashboard/library">Library</a></li>
			<?php }elseif ($user->data()->permission == "transactions") { ?>
				<li class="<?=$a_a_transactions?>"><a href="/publicdashboard/transactions">Transactions</a></li>
			<?php }elseif ($user->data()->permission == "library") { ?>
				<li class="<?=$a_a_library?>"><a href="/publicdashboard/library">Library</a></li>
			<?php }elseif ($user->data()->permission == "reports") { ?>
				<li class="parent <?=$a_a_reports?>">
					<a data-toggle="collapse" href="#sub-item-1">Reports <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span></a>
					<ul class="children collapse" id="sub-item-1">
						<li>
							<a href="/publicdashboard/reports?type=answers">Answers</a>
						</li>
						<li>
							<a href="/publicdashboard/reports?type=replies">Replies</a>
						</li>
					</ul>
				</li>
			<?php } ?>
		</ul>
	</div>