<?php
include $_SERVER['DOCUMENT_ROOT']."/control/core/init.php";
include $_SERVER['DOCUMENT_ROOT']."/control/core/permission.php";
$db = db::getInstance();
$questions = new questions();
$user = new user();
$payment = new payment();

$actions = new actions();
$actions->GetData('admin_notes',array('user_id','=',$user->data()->id));
$note = (empty($actions->data()->note)) ? '' : $actions->data()->note ;

$pdf_book_link = '';

if (input_exists()) {
	if (input_get('submit') == "Save Note") {
		$note = input_get('note');
		if (actions::Count('admin_notes', array('user_id','=',$user->data()->id)) > 0) {
			$db->change('admin_notes', $actions->data()->id, array('note' => $note));
		}else{
			$db->insert('admin_notes', array('note' => $note, 'user_id' => $user->data()->id));
		}
	}elseif (input_get('submit') == "Update Tag") {
		$db->change('category_tags', input_get('id'), array('name' => input_get('name')));
	}elseif (input_get('submit') == "Add Tag") {
		$db->insert('category_tags', array('name' => input_get('name')));
	}elseif (input_get('submit') == "Delete Tag") {
		$db->delete('category_tags', array('id','=',input_get('id')));
	}elseif (input_get('submit') == "Send Email to subscribers") {
		$email_content = regular_input_get('email_content');
		if (!empty($email_content) && input_get('range') != "Select Range") {
			foreach ($db->get('subscribed_emails', array('id','>',0), input_get('range'), 'ASC')->results() as $m) {
				$body = '<!DOCTYPE html><html><body style="font-family: -apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,sans-serif;padding: 0;margin: 0;"><div style="padding: 8px;"><div style="background: #fff;color: #555;border-radius: 0px 0px 6px 6px;box-shadow: -2px 4px 7px 5px #0000000d;border: 1px solid #dddddda3;"><div style="padding-bottom: 4px;"><div style="border-radius: 0px 0px 20px 20px;margin: 0 auto;max-width: 800px;">';
				$body .= $email_content;
				$body .= '<div align="center" style="padding: 4px;margin-top: 14px;margin-bottom: 14px;"><a href="https://programnas.com/about" style="text-decoration: none;color: #555;padding: 6px 10px 6px 10px;display: inline-block;font-size: 14px;font-weight: bold;">About</a><a href="https://programnas.com/support" style="text-decoration: none;color: #555;padding: 6px 10px 6px 10px;display: inline-block;font-size: 14px;font-weight: bold;">Support</a><a href="https://programnas.com/help" style="text-decoration: none;color: #555;padding: 6px 10px 6px 10px;display: inline-block;font-size: 14px;font-weight: bold;">Help</a><a href="https://programnas.com/terms" style="text-decoration: none;color: #555;padding: 6px 10px 6px 10px;display: inline-block;font-size: 14px;font-weight: bold;">Terms</a><a href="https://programnas.com/library" style="text-decoration: none;color: #555;padding: 6px 10px 6px 10px;display: inline-block;font-size: 14px;font-weight: bold;">Library</a></div><div align="center" style="padding: 4px;margin-top: 14px;margin-bottom: 14px;"><a href="https://programnas.com/account/unsubscribe?hash='.$m->hash.'&email='.$m->email.'" style="text-decoration: none;color: #555;padding: 6px 10px 6px 10px;display: inline-block;font-size: 14px;font-weight: bold;"><u>Unsubscribe</u></a></div></div></div></div></div></body></html>';
	            email::SendIndividualEmail($m->email, "Programnas Newsletter", $body);
	            //echo $m->email."<br>";
	        }
	    }
	}elseif (input_get('submit') == "Upload PDF") {
		$fFile = $_FILES['fileToUpload']['name'];
		$tmp_dir = $_FILES['fileToUpload']['tmp_name'];
		$fExt = strtolower(pathinfo($fFile,PATHINFO_EXTENSION));
        $ext = array('pdf'); 
        $fi = rand(1000,1000000).'-'.uniqid().'-'.time().".".$fExt;
        $this_upload = $_SERVER['DOCUMENT_ROOT']."/control/files/";
	    if(in_array($fExt,$ext)){
	        if (move_uploaded_file($tmp_dir,$this_upload.$fi)) {
	            $pdf_book_link = $fi;
	        }else{
	            $pdf_book_link = "ERROR";
	        }
	    }else{
	        $pdf_book_link = "ERROR";
	    }
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/admin_assets/meta.php"; ?>
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT']."/control/template/admin_assets/header.php"; ?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
			</div>
		</div>
		<div class="panel panel-container">
			<div class="row">
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-teal panel-widget border-right">
						<div class="row no-padding">
							<div class="large"><?=actions::Count('users',array('id','>',0))?></div>
							<div class="text-muted">Users</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-blue panel-widget border-right">
						<div class="row no-padding">
							<div class="large"><?=actions::Count('questions',array('id','>',0))?></div>
							<div class="text-muted">Questions</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-orange panel-widget border-right">
						<div class="row no-padding">
							<div class="large"><?=actions::Count('answers',array('id','>',0))?></div>
							<div class="text-muted">Answers</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-red panel-widget ">
						<div class="row no-padding">
							<div class="large">$<?=$payment->GetAllUsersBalance()?></div>
							<div class="text-muted">All Users Balance</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default chat">
					<div class="panel-heading">Categories</div>
					<div class="panel-body">
						<form method="POST">
							<input type="text" name="name" placeholder="Tag Name" class="input_classss">
							<input type="submit" name="submit" value="Add Tag" class="button_save">
						</form>
						<?php
						$d_catego = '';
						foreach ($db->get('category_tags', array('id','>',0))->results() as $m) {
							$d_catego .= '
							<form method="POST">
								<input type="text" name="name" value="'.$m->name.'" class="input_classss">
								<input type="submit" name="submit" value="Update Tag" class="button_save">
								<input type="submit" style="background: #c77171;" name="submit" value="Delete Tag" class="button_save">
								<input type="hidden" name="id" value="'.$m->id.'">
							</form>';
						}
						echo($d_catego);
						?>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">Tools</div>
					<div class="panel-body">
						<button class="class_ddleting_robot" onclick="DeletePics('profile')">Delete Unused Profile Pictures</button>
	    				<button class="class_ddleting_robot" onclick="DeletePics('question')">Delete Unused Question Pictures</button>
	    				<button class="class_ddleting_robot" onclick="DeletePics('answer')">Delete Unused Answer Pictures</button>
	    				<?=actions::ProgressBar('pb_deleting',true)?>
	    				<div align="center" id="inner_result_delete" class="_Padd8 _GreenText"></div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default ">
					<div class="panel-heading">Notes</div>
					<div class="panel-body timeline-container">
						<form method="POST">
							<textarea placeholder="Note..." name="note" class="note_txtarea"><?=$note?></textarea>
							<input type="submit" name="submit" value="Save Note" class="button_save">
						</form>
					</div>
				</div>
				<div class="panel panel-default ">
					<div class="panel-heading">Emails</div>
					<div class="panel-body timeline-container">
						<button class="class_sending_robot" onclick="SendingEmail('unanswered')">Send unanswered questions to all users</button>
						<div id="loading_robot_sending" class="_Padd8" style="display: none;">Please wait...</div>
					</div>
				</div>
				<div class="panel panel-default ">
					<div class="panel-heading">Send Emails to all who subscribed</div>
					<div class="panel-body timeline-container">
						<form method="POST">
							<textarea placeholder="Content Data ex: <h1>Hi</h1>" name="email_content" class="note_txtarea"></textarea>
							<select name="range" class="_select_ranges">
								<option value="Select Range" selected disabled>Select Range</option>
								<?php
									$number_of_options = ceil($db->get('subscribed_emails',array('id','>',0))->count()/50);
									$results_per_send = 50;
									$start_limit = 0;
									$e = 1;
									$data = '';
									for ($i=0; $i < $number_of_options; $i++) { 
										$data .= '<option value="'.$start_limit.','.$results_per_send.'">'.$e++.'</option>';
										$start_limit += 50;
									}
								?>
								<?=$data?>
							</select>
							<input type="submit" name="submit" class="class_sending_robot" value="Send Email to subscribers">
							<h3><code>Before you start:</code></h3>
							<div><code>Change <u>memory_limit</u> to -1 </code></div>
							<div><code>Change <u>post_max_size</u> to 100000M </code></div>
							<div><code>Change <u>max_execution_time</u> to 0 </code></div>
							<div><code>Change <u>Cloudflare</u> cache to (no query string) </code></div>
							<div><code>Enable Cloudflare mode (Development Mode)</code></div>
						</form>
					</div>
				</div>
				<div class="panel panel-default ">
					<div class="panel-heading">Upload File <small>(PDF)</small></div>
					<div class="panel-body timeline-container">
						<form method="POST" enctype="multipart/form-data">
							<label for="js_jq">
								<span class="upload_doc">Upload</span>
								<input type="file" name="fileToUpload" accept="application/pdf" class="_None">
							</label>
							<input type="submit" value="Upload PDF" name="submit" class="button_save">
						</form>
						<div class="img_lib_up_text"><?=$pdf_book_link?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>