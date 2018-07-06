<?PHP
function plugins_job($ts3,$mysqlcon,$lang,$dbname,$slowmode,$timezone,$grouptime,$boostarr,$resetbydbchange,$msgtouser,$currvers,$substridle,$exceptuuid,$exceptgroup,$allclients,$logpath,$rankupmsg,$ignoreidle,$exceptcid,$resetexcept,$phpcommand,$select_arr) 
{
	$basedir = substr(__DIR__,0,-4).'plugins/';
	$dirs = glob($basedir.'*', GLOB_ONLYDIR);
	
	$path = substr($basedir, 0, -1);
	if(!file_exists($path)) 
	{
		if( !mkdir($path, 0777, true) )
		{
			enter_logfile($logpath,$timezone,3,"Plugin: Can't create directory, please give me the rights... :) (".basename(__FILE__, '.php')." 0777)");
			return;
		}
	}
	
	//If can't find it...
	if($mysqlcon->exec("CREATE TABLE `$dbname`.`plugins_job` (
	`module` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci PRIMARY KEY,
	`enable` tinyint(0) NOT NULL default '0')") === true) {
		enter_logfile($logpath,$timezone,1,"[x.x.1] Failed to create table plugins_job.");
		return;
	}
	
	foreach ($dirs as $index=>$dir)
	{
		$dir = substr($dir, strlen($basedir));
		if($mysqlcon->exec("INSERT INTO `$dbname`.`plugins_job` SET `module`='$dir'"))
		{
			enter_logfile($logpath,$timezone,5,"Plugin[ADD]: ". $dir);
		}
	}
	
	$dbdata = $mysqlcon->query("SELECT module FROM `$dbname`.`plugins_job` WHERE `enable`=1")->fetchAll();	
	foreach ($dbdata as $index=>$data)
	{
		try 
		{
			include $basedir.$data[0].'/background.php';
		} 
		catch (Exception $e) 
		{
			enter_logfile($logpath,$timezone,3,"Plugin[Exception]: " . print_r($e->getMessage(), true));
		}
	}

	//enter_logfile($logpath,$timezone,5,"Plugin[RUN]: " );
	//include $basedir."$dir/index.php";
	unset($basedir, $dirs, $path, $dbdata);
}

//TODO: Remove function for the plugins
/*function plugins_job_remove($ts3,$mysqlcon,$lang,$dbname,$slowmode,$timezone,$grouptime,$boostarr,$resetbydbchange,$msgtouser,$currvers,$substridle,$exceptuuid,$exceptgroup,$allclients,$logpath,$rankupmsg,$ignoreidle,$exceptcid,$resetexcept,$phpcommand,$select_arr) {	
}*/
?>