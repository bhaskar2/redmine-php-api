<?php

require_once ('ActiveResource.php');
require_once ('config.php');

class Project extends ActiveResource {
	
	public $site = 'http://'.USERNAME.':'.PASSWORD.'@'.DB_HOST_NAME.'/'.REDMINE.'/';
        public $element_name = 'project';
}

$projectArray = [];
$projectId = $_POST['projectId'];

$project = new Project ();

// find issues
$projects = $project->find ("all");
//echo "<pre>";
//print_r($projects); exit;

for ($i = 0; $i < count($projects); $i++) {

	//print_r($projects);
	//echo $projects[$i]->project['id']; echo $projectId;

	if($projects[$i]->parent['id'] == $projectId){
		array_push($projectArray[$projects[$i]->id] = $projects[$i]->name);
	}

}

echo json_encode($projectArray);

?>

