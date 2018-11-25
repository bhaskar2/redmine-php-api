<?php

require_once ('ActiveResource.php');
require_once ('config.php');
require_once ('getSpentTime.php');

class Issue extends ActiveResource {

	public $site = 'http://'.USERNAME.':'.PASSWORD.'@'.DB_HOST_NAME.'/'.REDMINE.'/';
      
        public $element_name = 'issue';
	//public $request_format = 'xml'; // REQUIRED!
	

    function viewSummaryFunction($projectIds, $subprojectId, $userIds, $aUserIds, $startDate, $endDate, $trackerId, $priority) {

        $result = [];
		$issueOpen = new Issue ();
		$options = array();
		$issues = array();
	
		if(($projectIds && $userIds) || ($projectIds && $aUserIds)) {	

			//array_push($options["project_id"] = $projectIds);
			$pId = explode(",",$projectIds);
			for($k=0;$k<count($pId);$k++) {
				$id = $pId[$k];
				array_push($options["project_id"] = $id);
				if($subprojectId) {
					array_push($options["project_id"] = $subprojectId);
				}
				if($userIds) {
					$userIds = str_replace(",", "|" ,$userIds);
					array_push($options["author_id"] = $userIds);
				}
				if($aUserIds) {
					$aUserIds = str_replace(",", "|" ,$aUserIds);
					array_push($options["assigned_to_id"] = $aUserIds);
				}
				
				if($startDate) {
					$givenStartDate = $startDate;
				}
				if($endDate) {
					$givenEndDate = $endDate;
				}

				//print_r($options); exit;
	
				$issue = $issueOpen->find('all', $options);

				$issues = array_merge($issues, $issue);
				//array_push($issues, $issue);
			}
			
		} elseif ($projectIds) {

			//array_push($options["project_id"] = $projectIds);
			$pId = explode(",",$projectIds);
			for($k=0;$k<count($pId);$k++) {
				$id = $pId[$k];
				array_push($options["project_id"] = $id);
				if($subprojectId) {
					array_push($options["project_id"] = $subprojectId);
				}
				if($userIds) {
					$userIds = str_replace(",", "|" ,$userIds);
					array_push($options["author_id"] = $userIds);
				}
				if($aUserIds) {
					$aUserIds = str_replace(",", "|" ,$aUserIds);
					array_push($options["assigned_to_id"] = $aUserIds);
				}
				if($trackerId) {
					array_push($options["tracker_id"] = $trackerId);
				}
				if($startDate) {
					$givenStartDate = $startDate;
				}
				if($endDate) {
					$givenEndDate = $endDate;
				}
				array_push($options["group"] = "tracker_id");
				array_push($options["status_id"] = '*');
	
				//print_r($options); exit;
	
				$issue = $issueOpen->find('all', $options);
	
				$issues = array_merge($issues, $issue);
			}	

		} else if($userIds || $aUserIds) {
			
			if($userIds) {
				$userIds = str_replace(",", "|" ,$userIds);
				array_push($options["author_id"] = $userIds);
			}
			if($aUserIds) {
				$aUserIds = str_replace(",", "|" ,$aUserIds);
				array_push($options["assigned_to_id"] = $aUserIds);
			}
			if($trackerId) {
				array_push($options["tracker_id"] = $trackerId);
			}
			if($startDate) {
				$givenStartDate = $startDate;
			}
			if($endDate) {
				$givenEndDate = $endDate;
			}
			array_push($options["group"] = "tracker_id");
			array_push($options["status_id"] = '*');
	
	
			$issue = $issueOpen->find('all', $options);
			
			$issues = array_merge($issues, $issue);

		} else {
			if($userIds) {
				$userIds = str_replace(",", "|" ,$userIds);
				array_push($options["author_id"] = $userIds);
			}
			if($aUserIds) {
				$aUserIds = str_replace(",", "|" ,$aUserIds);
				array_push($options["assigned_to_id"] = $aUserIds);
			}
			if($trackerId) {
				array_push($options["tracker_id"] = $trackerId);
			}
			if($startDate) {
				$givenStartDate = $startDate;
			}
			if($endDate) {
				$givenEndDate = $endDate;
			}
			array_push($options["group"] = "tracker_id");
			array_push($options["status_id"] = '*');

			$issue = $issueOpen->find('all', $options);
			
			$issues = array_merge($issues, $issue);
		}
	//print_r($issues);exit;
	
	$resArray = [];
	$sameCount = [];
	$totalissueLists = [];
	$sameUserCount = [];
	$sameCountTwo = [];
	$sameTrackerBugs = [];
	$sameTrackerFeatures = [];
	$sameTrackerSupports = [];

	for ($i=0; $i < count($issues); $i++) {

		$issueObj = $issues[$i];
		//print_r($issueObj);exit;

		// echo 'spentlist';
		$timeEntry = new TimeEntry();

		$spentTimeNew = $timeEntry->getSpentTime($issueObj->id);
		$estimatedTimeNew = json_decode($issueObj->estimated_hours);

		if (!empty($spentTimeNew) && !empty($estimatedTimeNew)) {
			$time1 = $estimatedTimeNew * 60; //in minutes
			$time2 = $spentTimeNew * 60; //in minutes
			$totaltimeDiff = $time1 - $time2;
			$timeDiffinHours = $totaltimeDiff / 60;
		} else {
			$timeDiffinHours = "NA";
		}

		if(!empty($spentTimeNew)) {
			$spentTime = $spentTimeNew;
		} else {
			$spentTime = 'NA';
		}

		if(!empty($estimatedTimeNew)) {
			$estimatedTime = $estimatedTimeNew;
		} else {
			$estimatedTime = 'NA';
		}

		$issueId = $issueObj->id;
		$projectId = json_decode($issueObj->project['id']);
		$projectName = (array) $issueObj->project['name'];
		$trackerId = json_decode($issueObj->tracker['id']);
		$trackerName = (array) $issueObj->tracker['name'];
		$statusId = json_decode($issueObj->status['id']);
		$statusName = (array) $issueObj->status['name'];
		$priorityId = json_decode($issueObj->priority['id']);
		$priorityName = (array) $issueObj->priority['name'];
		$authorId = json_decode($issueObj->author['id']);
		$authorName = (array) $issueObj->author['name'];

		$severitiId = (array) $issueObj->custom_fields['id'];
		$severityName = (array) $issueObj->custom_fields->custom_field->value;

		if($severityName == null || $severityName == '') {
			$severityName = array('NA');
		}

		$assignedToId = json_decode($issueObj->assigned_to['id']);
		$assignedToName = (array) $issueObj->assigned_to['name'];
		$subject = $issueObj->subject;
		$description = json_decode($issueObj->description);
		$startDateForIf = $issueObj->start_date;
		$startDate = date("d/m/Y" , strtotime($issueObj->start_date));

		$dueDateNew = $issueObj->due_date;
		
		if(!empty($dueDateNew)) {
			$dueDate = date("d/m/Y" , strtotime($dueDateNew));
		}else {
			$dueDate = 'NA';
		}

		$closedOnNew = $issueObj->closed_on;

		if(!empty($closedOnNew)) {
			$closedOn = date("d/m/Y H:m" , strtotime($closedOnNew));
		} else {
			$closedOn = 'NA';
		}
		
		$createOn = json_decode($issueObj->created_on);
		$updatedOn = json_decode($issueObj->updated_on);

		//time diff in days,hours, min and seconds
		if (!empty($closedOnNew) && !empty($dueDateNew)) {
			$date1 = new DateTime($closedOnNew);
			$date2 = $date1->diff(new DateTime($dueDateNew));
			$timeDiff = $date2->days." days";
		} else {
			$timeDiff = "0 days";
		}

		$ticketCount = 0;
		$bugClosedCount = 0;
		$totalOpenCount = 0;
		$totalClosedCount = 0;
			
		if(($givenStartDate && !$givenEndDate && $startDateForIf && $startDateForIf >= $givenStartDate) 
		|| (!$givenStartDate && $givenEndDate && $startDateForIf && $startDateForIf <= $givenEndDate) 
		|| ($givenStartDate && $givenEndDate && $startDateForIf && ($startDateForIf >= $givenStartDate && $startDateForIf <= $givenEndDate)) 
		|| (!$givenStartDate && !$givenEndDate)) {

			$totalissueLists[$i] = array("issueId"=>$issueId, "projectId"=>$projectId, "projectName"=>$projectName, "trackerId"=>$trackerId, "trackerName"=>$trackerName, 
				"statusId"=>$statusId, "statusName"=>$statusName, "priorityId"=>$priorityId, "priorityName"=>$priorityName, "authorId"=>$authorId, "authorName"=>$authorName, 
				"assignedToId"=>$assignedToId, "assignedToName"=>$assignedToName,"subject"=>$subject, "description"=>$description, "startDate"=>$startDate, "dueDate"=>$dueDate, 
				"closedOn"=>$closedOn, "createOn"=>$createOn, "updatedOn"=>$updatedOn, "ticketCount"=>$ticketCount,"severityName"=>$severityName,"estimatedTime"=>$estimatedTime,
				"timeDiff"=>$timeDiff,"timeDiffinHours"=>$timeDiffinHours,"spentTime"=>$spentTime);

			//$sameUserCount[$projectId][$authorId]['ticketCount']++;	
			$result['totalissueList'] = json_encode($totalissueLists);

			//get data for tickets count. 
			if(!in_array($assignedToId, $sameUserCount[$projectId][$assignedToId])) {
				$issueidList = array();
				if($ticketCount > 1) {
					array_push($issueidList,$issueId); 
				}	

				//print_r($issueidList);echo $issueId;
				$sameUserCount[$projectId][$assignedToId] = array("issueId"=>$issueId, "projectId"=>$projectId, "projectName"=>$projectName, "trackerId"=>$trackerId, "trackerName"=>$trackerName, 
					"statusId"=>$statusId, "statusName"=>$statusName, "priorityId"=>$priorityId, "priorityName"=>$priorityName, "authorId"=>$authorId, "authorName"=>$authorName, 
					"assignedToId"=>$assignedToId, "assignedToName"=>$assignedToName,"subject"=>$subject, "description"=>$description, "startDate"=>$startDate, "dueDate"=>$dueDate, 
					"closedOn"=>$closedOn, "createOn"=>$createOn, "updatedOn"=>$updatedOn, "ticketCount"=>$ticketCount,"totalOpenCount"=>$totalOpenCount,"totalClosedCount"=>$totalClosedCount);
			}

			if($statusName[0] != "Closed") { $sameUserCount[$projectId][$assignedToId]['totalOpenCount']++; }
			if($statusName[0] == "Closed") { $sameUserCount[$projectId][$assignedToId]['totalClosedCount']++; }

			$sameUserCount[$projectId][$assignedToId]['ticketCount']++;	
			$result['ticketsCount'] = json_encode($sameUserCount);

			}

        }	
	
		//print_r($result); exit;
        return $result;
    }
}

?>
