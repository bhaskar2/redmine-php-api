<?php

require_once ('ActiveResource.php');
require_once ('config.php');

class User extends ActiveResource {
	
	  public $site = 'http://'.USERNAME.':'.PASSWORD.'@'.DB_HOST_NAME.'/'.REDMINE.'/';
        
	public $element_name = 'user';

	function getUserList() {
	
		$userArray = [];
		$user = new User ();
		// find issues
		$users = $user->find('all');
               // echo "<pre>";
		//print_r($users);exit;

		for ($i=0; $i < count($users); $i++) {
			$name = $users[$i]->firstname. " " . $users[$i]->lastname;
			array_push($userArray[$users[$i]->id] = $name);
		}
		return $userArray;
	}
}

?>
