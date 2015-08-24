<?php

include 'TS3Admin.php';

/*-------SETTINGS-------*/
$ts3_ip = 'localhost';
$ts3_queryport = 10001;
$ts3_user = 'serveradmin';
$ts3_pass = 'password';
/*----------------------*/

$tsAdmin = new ts3admin($ts3_ip, $ts3_queryport);

if($tsAdmin->getElement('success', $tsAdmin->connect())) {
  $tsAdmin->login($ts3_user, $ts3_pass);

  $link = mysqli_connect("localhost","user","password","database") or die("Error " . mysqli_error($link));

  $query = "SELECT * FROM server_properties WHERE value = '3' and ident = 'virtualserver_hostmessage_mode'";

  $result = $link->query($query);

  while($row = mysqli_fetch_array($result)) {
    //echo $row['chan_id'];

    $id = $row['server_id'];

    $tsAdmin->selectServer($id,'serverId');
	$info = $tsAdmin->serverInfo();
	$data = $info['data'];
	$info['virtualserver_hostmessage_mode'] = '2';
	$tsAdmin->serverEdit($info);
	if(count($tsAdmin->getDebugLog()) > 0) {
		foreach($tsAdmin->getDebugLog() as $logEntry) {
			echo $logEntry . PHP_EOL;
		}
	}
  }

}else{

  echo 'Connection could not be established.';
}
