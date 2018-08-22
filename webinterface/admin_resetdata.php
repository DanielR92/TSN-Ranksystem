<?PHP
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
if(in_array('sha512', hash_algos())) {
	ini_set('session.hash_function', 'sha512');
}
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
	ini_set('session.cookie_secure', 1);
	header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload;");
}
session_start();

require_once('../other/config.php');

function getclientip() {
	if (!empty($_SERVER['HTTP_CLIENT_IP']))
		return $_SERVER['HTTP_CLIENT_IP'];
	elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	elseif(!empty($_SERVER['HTTP_X_FORWARDED']))
		return $_SERVER['HTTP_X_FORWARDED'];
	elseif(!empty($_SERVER['HTTP_FORWARDED_FOR']))
		return $_SERVER['HTTP_FORWARDED_FOR'];
	elseif(!empty($_SERVER['HTTP_FORWARDED']))
		return $_SERVER['HTTP_FORWARDED'];
	elseif(!empty($_SERVER['REMOTE_ADDR']))
		return $_SERVER['REMOTE_ADDR'];
	else
		return false;
}

if (isset($_POST['logout'])) {
	echo "logout";
    rem_session_ts3($rspathhex);
	header("Location: //".$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\'));
	exit;
}

if (!isset($_SESSION[$rspathhex.'username']) || $_SESSION[$rspathhex.'username'] != $webuser || $_SESSION[$rspathhex.'password'] != $webpass || $_SESSION[$rspathhex.'clientip'] != getclientip()) {
	header("Location: //".$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\'));
	exit;
}

if (isset($_POST['update']) && $_POST['csrf_token'] != $_SESSION[$rspathhex.'csrf_token']) {
	echo $lang['errcsrf'];
	rem_session_ts3($rspathhex);
	exit;
}

require_once('nav.php');

if(!isset($_POST['number']) || $_POST['number'] == "yes") {
	$_SESSION[$rspathhex.'showexcepted'] = "yes";
	$filter = " `except`='0'";
} else {
	$_SESSION[$rspathhex.'showexcepted'] = "no";
	$filter = "";
}


if (isset($_POST['update']) && $_SESSION[$rspathhex.'username'] == $webuser && $_SESSION[$rspathhex.'password'] == $webpass && $_SESSION[$rspathhex.'clientip'] == getclientip() && $_POST['csrf_token'] == $_SESSION[$rspathhex.'csrf_token']) {
	$setontime = 0;
	
		$succmsg = '';
				
		$tables = array("user_snapshot", 
		"user_iphash", 
		"user", 
		"stats_versions", 
		"stats_user", 
		"stats_server", 
		"stats_platforms", 
		"stats_nations", 
		"server_usage");
		
		foreach($tables as $table) 
		{
			if($mysqlcon->exec("TRUNCATE TABLE $table;") === false) {
				$err_msg = $lang['isntwidbmsg'].print_r($mysqlcon->errorInfo(), true); $err_lvl = 3;
			} else {
				$err_msg = substr($succmsg,0,-4); $err_lvl = NULL;
			}
		}
		
		exec($phpcommand." ".substr(__DIR__,0,-12)."worker.php restart");
	
}

$_SESSION[$rspathhex.'csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
?>
		<div id="page-wrapper">
<?PHP if(isset($err_msg)) error_handling($err_msg, $err_lvl); ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">
							<?php echo $lang['wihladm3']; ?>
						</h1>
					</div>
				</div>
				<form name="post" method="POST">
				<input type="hidden" name="csrf_token" value="<?PHP echo $_SESSION[$rspathhex.'csrf_token']; ?>">
				<div class="form-horizontal">
					<div class="row">
						<div class="col-md-3">
						</div>
						<div class="col-md-6">
							<div class="panel panel-default">
								<div class="panel-body">
									<label class="col-sm-4 control-label" data-toggle="modal" data-target="#userresettime">Info:<i class="glyphicon help-hover glyphicon-question-sign"></i> Alle User werden aus der Datenbank gelöscht!</label>
									
								</div>
							</div>
						</div>
					</div>
					<div class="row">&nbsp;</div>
					<div class="row">
						<div class="text-center">
							<button type="submit" class="btn btn-primary" name="update">Reset all!</button>
						</div>
					</div>
					<div class="row">&nbsp;</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	

<div class="modal fade" id="userresettime" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $lang['wihladm3']; ?></h4>
      </div>
      <div class="modal-body">
        <?php echo $lang['userresettime']; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?PHP echo $lang['stnv0002']; ?></button>
      </div>
    </div>
  </div>
</div>

</body>
</html>