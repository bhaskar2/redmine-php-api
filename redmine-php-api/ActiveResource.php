<?php

// Require the namespaced version
require_once dirname (__FILE__) . '/lib/ActiveResource.php';

// Alias it to the old name
class_alias ('\ActiveResource\ActiveResource', 'ActiveResource');

?>

