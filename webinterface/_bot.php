		<div id="page-wrapper">
<?PHP if(isset($err_msg)) error_handling($err_msg, $err_lvl); ?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">
							<?PHP echo $lang['wibot4']; ?>
						</h1>
					</div>
				</div>
				
				
				<table class="status" style="border:none!important;">
				  <tr>
					<td class="status-info">
						<?PHP 
						echo "<pre>Running on OS:\t\t".php_uname("s")." ".php_uname("r") . "<br>";
						echo "Using PHP Version:\t".phpversion(). "<br>";
						echo "Database Version:\t".$mysqlcon->getAttribute(PDO::ATTR_SERVER_VERSION) . "</pre>";
						?>
					</td>
					
					<td class="status-start">
						<form class="form-horizontal" name="start" method="POST">
							<input type="hidden" name="csrf_token" value="<?PHP echo $_SESSION[$rspathhex.'csrf_token']; ?>">
							<div class="row">
								<div class="text-center">
									<button type="submit" class="btn btn-success" name="start"<?PHP if($disabled == 1) echo " disabled"; ?>>
									<i class="fa fa-fw fa-power-off"></i>&nbsp;<?PHP echo $lang['wibot5']; ?>
									</button>
								</div>
							</div>
						</form>
					</td>
					<td class="status-Todo:">
						ToDo:<br>
						 <ul>
						  <li>UI => php verschachteln</li>
						  <li>Event Manager?</li>
						  <li></li>
						</ul> 
					</td>
				  </tr>
				  <tr>
					<td class="status-yw4l"></td>
					<td class="status-stop">
						<form class="form-horizontal" name="stop" method="POST">
							<input type="hidden" name="csrf_token" value="<?PHP echo $_SESSION[$rspathhex.'csrf_token']; ?>">
							<div class="row">
								<div class="text-center">
									<button type="submit" class="btn btn-danger" name="stop">
									<i class="fa fa-fw fa-close"></i>&nbsp;<?PHP echo $lang['wibot6']; ?>
									</button>
								</div>
							</div>
						</form>
					</td>
					<td class="status-lqy6"></td>
				  </tr>
				  <tr>
					<td class="status-yw4l"></td>
					<td class="status-restart">
						<form class="form-horizontal" name="restart" method="POST">
							<input type="hidden" name="csrf_token" value="<?PHP echo $_SESSION[$rspathhex.'csrf_token']; ?>">
							<div class="row">
								<div class="text-center">
									<button type="submit" class="btn btn-warning" name="restart"<?PHP if($disabled == 1) echo " disabled"; ?>>
									<i class="fa fa-fw fa-refresh"></i>&nbsp;<?PHP echo $lang['wibot7']; ?>
									</button>
								</div>
							</div>
						</form>
					</td>
					<td class="status-lqy6"></td>
				  </tr>
				</table>

				
				<div class="row">&nbsp;</div>
				<div class="row">
					<div class="col-lg-2">
						<h4>
							<?PHP echo $lang['wibot8']; ?>
						</h4>
					</div>
					<form class="form-horizontal" name="logfilter" method="POST">
					<input type="hidden" name="csrf_token" value="<?PHP echo $_SESSION[$rspathhex.'csrf_token']; ?>">
					<div class="col-lg-2">
						<div class="col-sm-12">
							<?PHP if($filter2!=NULL) { ?>
								<input type="text" class="form-control" name="logfilter[]" value="<?PHP echo $filter2; ?>" data-switch-no-init onchange="this.form.submit();">
							<?PHP } else { ?>
								<input type="text" class="form-control" name="logfilter[]" placeholder="filter the log entries..." data-switch-no-init onchange="this.form.submit();">
							<?PHP } ?>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="checkbox">
							<label><input id="switch-create-destroy" type="checkbox" name="logfilter[]" value="critical" data-switch-no-init onchange="this.form.submit();"
							<?PHP if(in_array('CRITICAL', $filters)) { echo "checked"; } ?>
							>Critical</label>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="checkbox">
							<label><input id="switch-create-destroy" type="checkbox" name="logfilter[]" value="error" data-switch-no-init onchange="this.form.submit();"
							<?PHP if(in_array('ERROR', $filters)) { echo "checked"; } ?>
							>Error</label>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="checkbox">
							<label><input id="switch-create-destroy" type="checkbox" name="logfilter[]" value="warning" data-switch-no-init onchange="this.form.submit();"
							<?PHP if(in_array('WARNING', $filters)) { echo "checked"; } ?>
							>Warning</label>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="checkbox">
							<label><input id="switch-create-destroy" type="checkbox" name="logfilter[]" value="notice" data-switch-no-init onchange="this.form.submit();"
							<?PHP if(in_array('NOTICE', $filters)) { echo "checked"; } ?>
							>Notice</label>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="checkbox">
							<label><input id="switch-create-destroy" type="checkbox" name="logfilter[]" value="info" data-switch-no-init onchange="this.form.submit();"
							<?PHP if(in_array('INFO', $filters)) { echo "checked"; } ?>
							>Info</label>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="checkbox">
							<label><input id="switch-create-destroy" type="checkbox" name="logfilter[]" value="debug" data-switch-no-init onchange="this.form.submit();"
							<?PHP if(in_array('DEBUG', $filters)) { echo "checked"; } ?>
							>Debug</label>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="col-sm-8 pull-left">
							<select class="selectpicker show-tick form-control" id="number" name="number" onchange="this.form.submit();">
							<?PHP
							echo '<option value="20"'; if($number_lines=="20") echo " selected=selected"; echo '>20</option>';
							echo '<option value="50"'; if($number_lines=="50") echo " selected=selected"; echo '>50</option>';
							echo '<option value="100"'; if($number_lines=="100") echo " selected=selected"; echo '>100</option>';
							echo '<option value="200"'; if($number_lines=="200") echo " selected=selected"; echo '>200</option>';
							echo '<option value="500"'; if($number_lines=="500") echo " selected=selected"; echo '>500</option>';
							echo '<option value="9999"'; if($number_lines=="9999") echo " selected=selected"; echo '>9999</option>';
							?>
							</select>
						</div>
					</div>
					</form>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<pre><?PHP foreach ($logoutput as $line) { echo $line; } ?></pre>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>			