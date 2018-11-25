<?php
require_once ('config.php');

if(isset( $_POST['projectId'] ) && isset( $_POST['selectUsers'])) {
	
	if($_POST['projectId'] != ""){ $selectedProjectId = $_POST['projectId']; }
	//echo $selectedProjectId; exit;

	
	$host = "http://".DB_HOST_NAME."/".REDMINE;
	
	$xml_string = file_get_contents($host."/projects/".$selectedProjectId."/memberships.xml");

	$xml = simplexml_load_string($xml_string);
	$json = json_encode($xml);
	$membershiplist = json_decode($json, TRUE);
	//print_r($membershiplist);exit;

	$membershipArray = [];

	foreach ($membershiplist['membership'] as $key => $membershipObj) {

		//print_r($membershipObj); exit;
		$membershipId = $membershipObj['id'];
		$projectId = $membershipObj['project']['@attributes']['id'];
		$projectName = $membershipObj['project']['@attributes']['name'];
		$userId = $membershipObj['user']['@attributes']['id'];
		$userName = $membershipObj['user']['@attributes']['name'];

		array_push($membershipArray[$userId] = $userName);

		//$membershipArray[$projectId][$userId] = array("membershipId"=>$membershipId, "projectId"=>$projectId, "projectName"=>$projectName, "userId"=>$userId, "userName"=>$userName);
	}

	$userlist = json_encode($membershipArray);

	echo $userlist;
}

?>
