<?php
	//$ts3,$mysqlcon,$lang,$dbname,$slowmode,$timezone,$grouptime,$boostarr,$resetbydbchange,$msgtouser,$currvers,$substridle,$exceptuuid,$exceptgroup,$allclients,$logpath,$rankupmsg,$ignoreidle,$exceptcid,$resetexcept,$phpcommand,$select_arr
	
	
	
	
	/*if($mysqlcon->exec("CREATE TABLE `$dbname`.`plugins_job` (
	`module` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci PRIMARY KEY,
	`enable` tinyint(0) NOT NULL default '0')") === true) {
		enter_logfile($logpath,$timezone,1,"[x.x.1] Failed to create table plugins_job.");
		return;
	}*/
	
	$set_groups = 69;
	foreach($allclients as $client) 
	{
		if($client['cid'] != 40) continue;
		
		$sgroups = array_flip(explode(",", $client['client_servergroups']));
		if (!array_key_exists($set_groups, $sgroups)) 
		{	
			try 
			{
				$cuid = htmlspecialchars($client['client_unique_identifier'], ENT_QUOTES);
				if ($mysqlcon->exec("INSERT INTO `$dbname`.`addon_assign_groups` SET `uuid`='$cuid',`grpids`='$set_groups'") === false) {
					throw new Exception(print_r($mysqlcon->errorInfo(), true));
				}
			}
			catch (Exception $e) 
			{
				enter_logfile($logpath,$timezone,2,"addon_assign_groups:".$e->getCode().': '."Error while adding group: ".$e->getMessage());
			}
		}
	}
?>