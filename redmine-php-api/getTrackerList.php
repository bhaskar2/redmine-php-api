<?php

require_once ('ActiveResource.php');
require_once ('config.php');

class Tracker extends ActiveResource {
	
	public $site = 'http://'.USERNAME.':'.PASSWORD.'@'.DB_HOST_NAME.'/'.REDMINE.'/';
     
	public $element_name = 'tracker';

	function getTrackerList() {

		$trackerArray = [];

		$tracker = new Tracker ();

		// find issues
		$trackers = $tracker->find ('all');

		for ($i=0; $i < count($trackers); $i++) {
			array_push($trackerArray[$trackers[$i]->id] = $trackers[$i]->name);
		}

		return $trackerArray;
	}
	
	function getTrackerName($trackerId) {

		$trackerName = "";

		$tracker = new Tracker ();

		// find issues
		$trackers = $tracker->find ('all');

		for ($i=0; $i < count($trackers); $i++) {
			if($trackers[$i]->id == $trackerId) {
				$trackerName = $trackers[$i]->name;
			}

		}

		return $trackerName;
	}
}

?>

