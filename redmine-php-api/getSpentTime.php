<?php

require_once ('ActiveResource.php');
require_once ('config.php');
class TimeEntry extends ActiveResource {
	public $site = 'http://'.USERNAME.':'.PASSWORD.'@'.DB_HOST_NAME.'/'.REDMINE.'/';
      
	public $element_name = 'time_entry';

	function getSpentTime($issueId) {
	
		$spentTime = array();
		$projectId = $_POST['projectId'];
		$userId = $_POST['userId'];
		//$issueId = $_POST['issueId'];

		$spent = new TimeEntry ();

		// find spend time

		$options = array();

	
		if($issueId) {
			array_push($options["issue_id"] = $issueId);
		}
		
		$spents = $spent->find ('all', $options);

		//print_r($spents); exit;

		for ($i=0; $i < count($spents); $i++) {
			
			$spendTime = $spents[$i]->hours;
		}
		return $spendTime;
	}
}

?>
