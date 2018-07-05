<?PHP
function plugins_job($ts3,$mysqlcon,$lang,$dbname,$slowmode,$timezone,$grouptime,$boostarr,$resetbydbchange,$msgtouser,$currvers,$substridle,$exceptuuid,$exceptgroup,$allclients,$logpath,$rankupmsg,$ignoreidle,$exceptcid,$resetexcept,$phpcommand,$select_arr) {
	$nowtime = time();
	$sqlexec = '';

	if(empty($grouptime)) {
		enter_logfile($logpath,$timezone,1,"plugins_job:".$lang['wiconferr']."Shuttin down!\n\n");
		exit;
	}
	
	//If can't find it...
	if($mysqlcon->exec("CREATE TABLE `$dbname`.`plugins_job` (
	`module` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	`enable` tinyint(0) NOT NULL default '0')") === true) {
		enter_logfile($logpath,$timezone,1,"[x.x.1] Failed to create table plugins_job.");
		return;
	}
	

	$basedir = substr(__DIR__,0,-4).'plugins/';
	$dirs = glob($basedir.'*', GLOB_ONLYDIR);
	
	foreach ($dirs as $index=>$dir)
	{
		$dir = substr($dir, strlen($basedir));
		if($var = $mysqlcon->exec("SELECT * FROM `$dbname`.`plugins_job` WHERE `module`=`$dir`") == null)
		{
			if($mysqlcon->exec("INSERT INTO `$dbname`.`plugins_job` (`module`, `enable`) VALUES ('$dir', '0')") === true) 
			{
				enter_logfile($logpath,$timezone,5,"Plugin[ADD]: ". $dir);
				//SELECT * FROM `plugins_job` WHERE `module`="add2groupe"
			}
		}
	}
	


}
?>