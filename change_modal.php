<?php

include 'TS3Admin.php';

/*-------SETTINGS-------*/
$ts3_ip = 'localhost';
$ts3_queryport = 10001;
$ts3_user = 'login';
$ts3_pass = 'password';
/*----------------------*/

$tsAdmin = new ts3admin($ts3_ip, $ts3_queryport);

if($tsAdmin->getElement('success', $tsAdmin->connect())) {
  $tsAdmin->login($ts3_user, $ts3_pass);

  $link = mysqli_connect("localhost","user","password","database") or die("Error " . mysqli_error($link));

  $query_mode = "SELECT * FROM server_properties WHERE value = '3' and ident = 'virtualserver_hostmessage_mode'";
  
  $query_msg = "SELECT * FROM server_properties WHERE value LIKE '%error%' or value LIKE '%plugin%' or value LIKE '%sound%' or value LIKE '%audio%' or value LIKE '%missing%' or value LIKE '%portal%' and ident = 'virtualserver_hostmessage'";
  
  $query_name = "SELECT * FROM server_properties WHERE value LIKE '%error%' or value LIKE '%plugin%' or value LIKE '%sound%' or value LIKE '%audio%' or value LIKE '%missing%' or value LIKE '%portal%' and ident = 'virtualserver_welcomemessage'";

// Hostmessage mode
	$result = $link->query($query_mode);
	
  	while($row = mysqli_fetch_array($result)) {

    $id = $row['server_id'];
    // echo "Selected server id = " . $id . PHP_EOL;

    $tsAdmin->selectServer($id,'serverId');
	$info = $tsAdmin->serverInfo();
	$data = array();
	$data['virtualserver_hostmessage_mode'] = '0';
	$tsAdmin->serverEdit($data);
	if(count($tsAdmin->getDebugLog()) > 0) {
		foreach($tsAdmin->getDebugLog() as $logEntry) {
			echo $logEntry . PHP_EOL;
		}
	}
  }
 
// Hostmessage
	$result = $link->query($query_msg);
  
    while($row = mysqli_fetch_array($result)) {

    $id = $row['server_id'];
    // echo "Selected server id = " . $id . PHP_EOL;

    $tsAdmin->selectServer($id,'serverId');
	$info = $tsAdmin->serverInfo();
	$data = array();
	$data['virtualserver_hostmessage'] = '';
	$tsAdmin->serverEdit($data);
	if(count($tsAdmin->getDebugLog()) > 0) {
		foreach($tsAdmin->getDebugLog() as $logEntry) {
			echo $logEntry . PHP_EOL;
		}
	}
  }
  
  // Welcome message
  	$result = $link->query($query_name);
  	
    while($row = mysqli_fetch_array($result)) {

    $id = $row['server_id'];
    // echo "Selected server id = " . $id . PHP_EOL;

    $tsAdmin->selectServer($id,'serverId');
	$info = $tsAdmin->serverInfo();
	$data = array();
	$data['virtualserver_welcomemessage'] = '';
	$tsAdmin->serverEdit($data);
	if(count($tsAdmin->getDebugLog()) > 0) {
		foreach($tsAdmin->getDebugLog() as $logEntry) {
			echo $logEntry . PHP_EOL;
		}
	}
  }
  

}else{

  echo 'Connection could not be established.';
}