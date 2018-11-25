<?php
//error_reporting(0);

require_once ('viewIssueReport.php');
require_once ('getProjectList.php');
require_once ('getUserList.php');
//require_once ('getMembershipList.php');
require_once ('getTrackerList.php');
require_once ('getSpentTime.php');
//require_once ('getPriorityList.php');
require_once ('ActiveResource.php');

$projectlist = getProjects();
$userlist = getUsers();
$trackerlist = getTrackers();

function getProjects() {
	$project = new Project();
	$projectlist = $project->getProjectList();
	return $projectlist;
	//print_r($projectlist); exit;
}

function getUsers() {
	$user = new User();
	$userlist = $user->getUserList();
	return $userlist;
	//print_r($userlist); exit;
}

function getTrackers() {
	$tracker = new Tracker();
	$trackerlist = $tracker->getTrackerList();
	return $trackerlist;
	//print_r($trackerlist); exit;
}

?>

<html>
	<meta charset="UTF-8"> 
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
		<link rel="stylesheet" href="css/multiple-select.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="js/multiple-select.js"></script>
		<script src="js/dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script>
var myVar;

function myFunction() {
    myVar = setTimeout(showPage, 3000);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
}
</script>

<style>
/* Center the loader */
#loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
  text-align: center;
}
</style>
	</head>	

	<body onload="myFunction()" style="margin:0;">
		<div class="content-body">
			<div id="top-menu">
				<ul>
					<li><a class="home" href="#">Home</a></li>
					<li><a class="help" href="https://www.redmine.org/guide" target="_blank">Help</a></li>
				</ul>
			</div>

			<div id="header">
				<a href="#" class="mobile-toggle-button js-flyout-menu-toggle-button"></a>
				<h2><span class="current-project">Redmine Reports</span></h2>
			</div>
			
			<div class="scheduler-border">
				<fieldset class="form-body">
					<legend>Filters</legend>
					<form class="form-horizontal" method="POST" id="filter-form">
                                        
						<div class="col-md-12">
							<div class="col-md-3 input-field">
								<div class="form-group"> 
									<lable>Projects: </lable>
									<select name="projectId" id="projectId" multiple="multiple">

										<?php
										foreach ($projectlist as $projectId => $projectName) {
										?>

										<option value="<?php echo $projectId; ?>" ><?php echo $projectName; ?></option>
							
										<?php
										}
										?>
				
									</select>
									<input type="hidden" id="projectIds" name="projectIds" value="">
								</div>
							</div>

							<div class="col-md-3 input-field" id="subprocjectDiv">
								<div class="form-group"> 
									<lable>Sub Projects: </lable>
									<select name="subprojectId" id="subprojectId" class="form-control">
				
									</select>
									<input type="hidden" id="subprojectIds" name="subprojectIds" value="">
								</div>
							</div>

							<div class=" col-md-3 input-field">
								<div class="form-group">
									<lable>Authors: </lable>
									<select name="userId" id="userId" multiple="multiple">

										<?php
										foreach ($userlist as $userId => $userName) {
										?>

										<option value="<?php echo $userId; ?>" ><?php echo $userName; ?></option>
							
										<?php
										}
										?>

									</select>
									<input type="hidden" id="userIds" name="userIds" value="">
								</div>
							</div>
							<div class="col-md-3 input-field">
								<div class="form-group">
									<lable>Assigned Users: </lable>
									<select name="assigneduserId" id="assigneduserId" multiple="multiple">

										<?php
										foreach ($userlist as $userId => $userName) {
										?>

										<option value="<?php echo $userId; ?>" ><?php echo $userName; ?></option>
							
										<?php
										}
										?>

									</select>
									<input type="hidden" id="assigneduserIds" name="assigneduserIds" value="">
								</div>
							</div>
						</div>
						<div class="col-md-12">
						
							<div class="col-md-3 input-field">
								<div class="form-group">
									<lable>Tracker: </lable>
									<select name="trackerId" id="trackerId" class="form-control">

										<option value="">All</option>	
										<?php
										foreach ($trackerlist as $trackerId => $trackerName) {
										?>

										<option value="<?php echo $trackerId; ?>" ><?php echo $trackerName; ?></option>
							
										<?php
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-sm-3 input-field">
								<div class="form-group">
									<lable>From Date: </lable>
									<input type="date" name="startDate" id="startDate" class="form-control" style="background:#fff;">
								</div>
							</div>
							<div class="col-md-3 input-field">
								<div class="form-group">
									<lable>To Date: </lable>
									<input type="date" name="endDate" id="endDate" class="form-control" style="background:#fff;">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="col-md-6" style="text-align: left;">
								<div class="form-group">
								<input type="submit" name="getIssueLIst" value="Search »" class="btn-submit" />
								<input type="reset" onclick="resetForm()" value="Reset »" class="btn-reset"/>
								</div>
							</div>
						</div>

					</form>
				           <div>
                                             <ul>
                                               <li><a href="#summary">Summary of all tasks</a></li>
                                               <li><a href="#reportcount">Reports Count</a></li>
                                              </ul>
                                             </div>

				</fieldset>
			</div>	

	<div class="col-sm-12 padding0">
<?php

$result = "";
$sameUser = array();
$countsameUser = array();

if(isset($_POST['getIssueLIst'])) {
	//print_r($projectIds);exit;
	$projectIds = $_POST['projectIds'];
	$subprojectId = $_POST['subprojectId'];
	$userId = $_POST['userId'];
	$userIds = $_POST['userIds'];
	$aUserId = $_POST['assigneduserId'];
	$aUserIds = $_POST['assigneduserIds'];
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];
	$trackerId = $_POST['trackerId'];
	$priority = ""; //$_POST['priority'];

	$trackerName = "";
	if($trackerId) {
		$tracker = new Tracker();
		$trackerName = $tracker->getTrackerName($trackerId);	
	}

	$issue = new Issue();

	$results = $issue->viewSummaryFunction($projectIds, $subprojectId, $userIds, $aUserIds, $startDate, $endDate, $trackerId, $priority);
	$totalissueLists = (array) json_decode($results['totalissueList']);
	$tktCountResults = (array) json_decode($results['ticketsCount']);

	//print_r($tktCountResults);exit;
	$bugsList = (array) json_decode($results['bugs']);
	$featuresList = (array) json_decode($results['features']);
	$supportsList = (array) json_decode($results['supports']);
	

?>
			
		<div class="tasks-summary" id="tasks-summary">
			<div class="col-md-12 padding0">
				<div class="col-md-3 padding0" style="float:left;position:relative;bottom:20px;">
					<h3><span id="summary">Summary of all tasks:</span></h3>
				</div>
				<div class="col-md-9 padding0" style="float:left;">
					<span><strong>Display fields:</strong></span>
					<input type="checkbox" value="actual-start-date" class="actual-start-date checkbox" onchange="valueChanged()"><span class="check-title">Actual Start Date</span>
					<input type="checkbox" value="actual-end-date" class="actual-end-date checkbox" onchange="valueChanged()"><span class="check-title">Actual End Date</span>
					<input type="checkbox" value="time-difference-in-days" class="time-difference-in-days checkbox" onchange="valueChanged()"><span class="check-title">Time difference in days</span>
					<input type="checkbox" value="estimated-time" class="estimated-time checkbox" onchange="valueChanged()"><span class="check-title">Estimated Time</span>
					<input type="checkbox" value="spent-time" class="spent-time checkbox" onchange="valueChanged()"><span class="check-title">Spent Time</span>
					<input type="checkbox" value="time-difference-in-hours" class="time-difference-in-hours checkbox" onchange="valueChanged()">Time difference in hours
				</div>
			</div>
			<table id="ticketsAndSpentTime" class="table redmine-table" width=100%>
				<thead>
					<th>#</th>
					<th>Project Name</th>
					<th>Status</th>
					<th>Subject</th>
					<th>Priority</th>
					<th>Severity</th>
					<th>Tracker</th>
					<th>Author</th>
					<th>Assignee</th>
					<th>Estimated Start Date</th>
					<th>Estimated End Date</th>
					<th class="th-actual-start-date" style="display: none">Actual Start Date</th>
					<th class="th-actual-end-date" style="display: none">Actual End Date</th>
					<th class="th-time-difference-in-days" style="display: none">Time difference in days</th>
					<th class="th-estimated-time" style="display: none">Estimated Time</th>
					<th class="th-spent-time" style="display: none">Spent Time</th>
					<th class="th-time-difference-in-hours" style="display: none">Time difference in hours</th>
				</thead>
				<tbody>
				<?php
				
				if(count($totalissueLists) != 0) {
					foreach( $totalissueLists as $projectId => $issuesResult ) {

				?>
				<tr>
					<td width="10px"><a href="http://localhost:8081/redmine/issues/<?php echo $issuesResult->issueId; ?>" target="_blank"><?php echo $issuesResult->issueId; ?></a></td>
					<td><?php echo $issuesResult->projectName[0]; ?></td>
					<td><?php echo $issuesResult->statusName[0]; ?></td>
					<td width="30px" class="subject"><?php echo $issuesResult->subject; ?></td>
					<td><?php echo $issuesResult->priorityName[0]; ?></td>
					<td><?php echo $issuesResult->severityName[0]; ?></td>
					<td><?php echo $issuesResult->trackerName[0]; ?></td>
					<td><?php echo $issuesResult->authorName[0]; ?></td>
					<td><?php echo $issuesResult->assignedToName[0]; ?></td>
					<td><?php echo $issuesResult->startDate; ?></td>
					<td><?php echo $issuesResult->dueDate;?></td>
					<td class="td-actual-start-date" style="display: none"><?php echo $issuesResult->startDate; ?></td>
					<td class="td-actual-end-date" style="display: none"><?php echo $issuesResult->closedOn; ?></td>
					<td class="td-time-difference-in-days" style="display: none"><?php echo $issuesResult->timeDiff; ?></td>
					<td class="td-estimated-time" style="display: none"><?php echo $issuesResult->estimatedTime; ?></td>
					<td class="td-spent-time" style="display: none"><?php echo $issuesResult->spentTime; ?></td>
					<td class="td-time-difference-in-hours" style="display: none"><?php echo $issuesResult->timeDiffinHours; ?></td>
				</tr>
				<?php
					//}
					}
				} else {
				
				?>
				<tr>
					<td colspan="16"><?php echo "No Data"; ?></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
				</tr>
				<?php
				}
				?>
				</tbody>
			</table>
			<div class="download-section">
				<input type="button" onclick="downloadSummaryTasks('abc.csv','CSV')" value="" class="download-csv">
			
			</div>
			</div>

			<div style="position: relative; padding: 1em ; border: 1px solid #bbb;">
			
			<div class="col-md-12 padding0">
				<div class="col-md-6 padding0">
					<h3><span id="reportcount">Reports Count:</span></h3>
				</div>
			</div>
 
			<table id="bugsListCount" class="table redmine-table">
				<thead>
					<th>Project Name</th>
					<th>Assignee</th>
					<th>Tasks Count</th>
					<th>Open</th>
					<th>Closed</th>
				</thead>
				<tbody>
				<?php
				
					
					$countArrayCategory= array();
					$countArrayTotal= array();
					$countArrayOpen= array();
					$countArrayClose= array();
					
				if(count($tktCountResults) != 0) {
					$countsArray = array();
					$countArray = array();
					$totalTask = 0;
					$totalOpen = 0;
					$totalClose = 0;
					foreach( $tktCountResults as $projectId => $issuesResult ) {
					foreach( $issuesResult as $authorId => $issueResult ) {
						$countArray['projectName'] = $issueResult->projectName[0];
						$countArray['assignedUser'] = $issueResult->assignedToName[0];
						$countArray['ticketCount'] = $issueResult->ticketCount;
						$countArray['open'] = $issueResult->totalOpenCount;
						$countArray['closed'] = $issueResult->totalClosedCount;

						$countArrayTotal[] = $issueResult->ticketCount;
						$countArrayOpen[] =  $issueResult->totalOpenCount;
						$countArrayClose[] = $issueResult->totalClosedCount;
						$countArrayCategory[] = $issueResult->projectName[0];

						$totalTask = $totalTask + $issueResult->ticketCount;
						$totalOpen = $totalOpen + $issueResult->totalOpenCount;
						$totalClose = $totalClose + $issueResult->totalClosedCount;
						array_push($countsArray,$countArray);

						


						$url = "http://localhost:8081/redmine/projects/".$issueResult->projectName[0]."/issues?assigned_to_id=".$issueResult->assignedToId."&set_filter=1&status_id=%2A&subproject_id=%21%2A";
						$openurl = "http://localhost:8081/redmine/projects/".$issueResult->projectName[0]."/issues?assigned_to_id=".$issueResult->assignedToId."&set_filter=1&status_id=o&subproject_id=%21%2A";
						$closedurl = "http://localhost:8081/redmine/projects/".$issueResult->projectName[0]."/issues?assigned_to_id=".$issueResult->assignedToId."&set_filter=1&status_id=c&subproject_id=%21%2A";
		
				?>
				<tr>
					<td><?php echo $issueResult->projectName[0]; ?></td>
					<td><?php echo $issueResult->assignedToName[0]; ?></td>
					<td><a href="<?php echo $url; ?>" target="_blank"><?php echo $issueResult->ticketCount; ?></a></td>
					<td><a href="<?php echo $openurl; ?>" target="_blank"><?php echo $issueResult->totalOpenCount; ?></a></td>
					<td><a href="<?php echo $closedurl; ?>" target="_blank"><?php echo $issueResult->totalClosedCount; ?></a></td>


				</tr>
				<?php
					}
					}

				?>
					<tr>
					<td ></td>
					<td ></td>
					<td style="color:red"><a href="<?php echo $url; ?>" target="_blank" style="color:red" ><?php echo $totalTask; ?></a></td>
					<td><a href="<?php echo $openurl; ?>" target="_blank" style="color:red" ><?php echo $totalOpen; ?></a></td>
					<td><a href="<?php echo $closedurl; ?>" target="_blank" style="color:red" ><?php echo $totalClose; ?></a></td>

				</tr>
				<?php

				} else {
				
				?>
				<tr>
					<td colspan="4"><?php echo "No Data"; ?></td>	
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
					<td style="display: none"></td>
				</tr>
				<?php
				}
				?>
				
				</tbody>
			</table>
			
			
			<div class="download-section">
				<input type="button" onclick="downloadCount('abc.csv','CSV')" value="" class="download-csv">
				
			</div>

			</div>
			
			<br/><br/><br/>
			<div class="col-md-12">
				<div id="container" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>
			</div>
		</div>

		<script type="text/javascript">
			var retrievedData = localStorage.getItem("summaryTasks");
			//alert(retrievedData);
			var cvsArray = '<?php echo json_encode($totalissueLists); ?>';
			var countArray = '<?php echo json_encode($countsArray); ?>';

			localStorage.setItem("summaryTasks", JSON.stringify(cvsArray));
			localStorage.setItem("tasksCount", JSON.stringify(countArray));

            //$('#ticketsAndSpentTime').DataTable();

			var table = $('#ticketsAndSpentTime').DataTable({
				drawCallback: function(){

					      
				}
			});   


            $('#bugsListCount').DataTable({
            	order: [
   				 [0, 'des']
 				 ]
            });

		  	document.getElementById('projectIds').value = "<?php echo $_POST['projectIds']; ?>";
			document.getElementById('userIds').value = "<?php echo $_POST['userIds']; ?>";
			document.getElementById('startDate').value = "<?php echo $_POST['startDate']; ?>";
			document.getElementById('endDate').value = "<?php echo $_POST['endDate']; ?>";
			document.getElementById('trackerId').value = "<?php echo $_POST['trackerId']; ?>";
			document.getElementById('subprojectId').value = "<?php echo $_POST['subprojectId']; ?>";

			var subprojectId =  "<?php echo $_POST['subprojectId']; ?>";
			if(subprojectId) {
				$("#subprocjectDiv").show();
			}

			var projectIds = "<?php echo $_POST['projectIds']; ?>";
            var userIds = "<?php echo $_POST['userIds']; ?>";
			var assigneduserIds = "<?php echo $_POST['assigneduserIds']; ?>";
			
			if(projectIds) {

				projectIds = projectIds.split(",");

				$("#userId").empty();
	        	$("#subprojectId").empty();
	            
	            $("#subprocjectDiv").show();
	            var resultSubProject='<option value="">All</option>';

	            for(m=0;m < projectIds.length;m++) {

	                var projectId = projectIds[m];

	                if(projectId != "") { 

					    var selectUsers=true;

					    var data = {
						    "projectId": projectId,
						    "selectUsers": selectUsers
					    };
					
					    $.ajax({
						    url: "getUsersByProject.php",
						    type: "post",
						    data: data,
						    success: function (response) {
							    var resultUser='';
						        $.each( JSON.parse(response), function( key, value ) {
							    	if($("#userId option[value="+key+"]").length == 0)
									{
								    	resultUser +='<option value='+key+'>'+value+'</option>';
									}
							    });

							    $('#userId').append(resultUser).multipleSelect("refresh");
								$('#assigneduserId').append(resultUser).multipleSelect("refresh");

            					$("#userId").multipleSelect("setSelects", JSON.parse("[" + userIds + "]"));
								$("#assigneduserId").multipleSelect("setSelects", JSON.parse("[" + assigneduserIds + "]"));
            					$("#projectId").multipleSelect("setSelects", JSON.parse("[" + projectIds + "]"));
						    },
						    error: function(jqXHR, textStatus, errorThrown) {
						       	console.log(textStatus, errorThrown);		
							    $("#userId").empty();
						    }

					    });

					    $.ajax({
						    url: "getSubprojectsByProject.php",
						    type: "post",
						    data: data,
						    success: function (response) {

						    	if(jQuery.isEmptyObject(JSON.parse(response))) {

						        } else {
							
								    $.each( JSON.parse(response), function( key, value ) {
									    resultSubProject +='<option value='+key+'>'+value+'</option>';
								    });

								    $('#subprojectId').append(resultSubProject);

								    document.getElementById('subprojectId').value = "<?php echo $_POST['subprojectId']; ?>";
						        }
						    },
						    error: function(jqXHR, textStatus, errorThrown) {
						       	console.log(textStatus, errorThrown);		
							    $("#subprojectId").empty();
						    }
					    });
							
				    }
	            }

			}

			if(!projectIds && userIds) {
				$("#userId").multipleSelect();
				$("#userId").multipleSelect("setSelects", JSON.parse("[" + userIds + "]"));
			}

			if(!projectIds && assigneduserIds) {
				$("#assigneduserId").multipleSelect();
				$("#assigneduserId").multipleSelect("setSelects", JSON.parse("[" + assigneduserIds + "]"));
			}
            
            $("#projectId").multipleSelect({
            	filter: true,
	            width: '100%',
	            placeholder: "Select Projects",

				onCheckAll: function() {
					projectIds = $('#projectId').multipleSelect('getSelects');
            		$("#projectIds").val(projectIds);
            		
				},
				onUncheckAll: function() {
            		$("#projectIds").val("");

				},	

            	onClick: function(view) {

            		projectIds = $('#projectId').multipleSelect('getSelects');

            		$("#projectIds").val(projectIds);

	                if(projectIds != "") {

		                $("#userId").empty();
		                $("#subprojectId").empty();
		               

		                for(l=0; l < projectIds.length; l++) {

			                var projectId = projectIds[l];
					        var selectUsers=true;

					        var data = {
						        "projectId": projectId,
						        "selectUsers": selectUsers
					        };

					        $.ajax({
						        url: "getUsersByProject.php",
						        type: "post",
						        data: data,
						        success: function (response) {
							        var resultUser='';
							        $.each( JSON.parse(response), function( key, value ) {

								    	if($("#userId option[value="+key+"]").length == 0)
										{
									    	resultUser +='<option value='+key+'>'+value+'</option>';
										}
								    });

								    $('#userId').append(resultUser).multipleSelect("refresh");	
									$('#assigneduserId').append(resultUser).multipleSelect("refresh");	

								    $("#userId").multipleSelect("setSelects", JSON.parse("[" + userIds + "]"));
									$("#assigneduserId").multipleSelect("setSelects", JSON.parse("[" + assigneduserIds + "]"));
            						$("#projectId").multipleSelect("setSelects", JSON.parse("[" + projectIds + "]"));
            						
							                  
						        },
						        error: function(jqXHR, textStatus, errorThrown) {
						           	console.log(textStatus, errorThrown);		
							        $("#userId").empty();
						        }
			        	    });

					        $.ajax({
						        url: "getSubprojectsByProject.php",
						        type: "post",
						        data: data,
						        success: function (response) {

							        if(jQuery.isEmptyObject(JSON.parse(response))) {
										$("#subprojectId").empty();
								        //$("#subprocjectDiv").hide();
							        } else {
							        
								        var resultSubProjectOut='<option value="">All</option>';
								        $.each( JSON.parse(response), function( key, value ) {
									        resultSubProjectOut +='<option value='+key+'>'+value+'</option>';
								        });

								        $('#subprojectId').append(resultSubProjectOut);

							        }
						        },
						        error: function(jqXHR, textStatus, errorThrown) {
						           	console.log(textStatus, errorThrown);		
							        $("#subprojectId").empty();
						        }

			        			});
				        }
	                }
	            }
	        })

			if(projectIds && !userIds) {
				$("#projectId").multipleSelect();
				$("#projectId").multipleSelect("setSelects", JSON.parse("[" + projectIds + "]"));
				
			}
		
			$("#userId").multipleSelect({
            	filter: true,
	            width: '100%',
	            placeholder: "Select Users",

            	onClick: function(view) {
            		userIds = $('#userId').multipleSelect('getSelects');
                	$("#userIds").val(userIds);
                	
                }
			})
			
			$("#assigneduserId").multipleSelect({
            	filter: true,
	            width: '100%',
	            placeholder: "Select Users",

            	onClick: function(view) {
					assignee = $('#assigneduserId').multipleSelect('getSelects');
					$("#assigneduserIds").val(assignee);
					
                }
            })
           
		</script>
	</div>

	<?php
	}
	?>

	<script type="text/javascript">

		$(function() {
            var projectIds = "";
            
            $("#projectId").multipleSelect({
            	filter: true,
	            width: '100%',
	            placeholder: "Select Projects",

            	onClick: function(view) {
            		projectIds = $('#projectId').multipleSelect('getSelects');
            		

            		$("#projectIds").val(projectIds);

	                if(projectIds != ""){

		                $("#userId").empty();
		                $("#subprojectId").empty();

		                for(l=0; l < projectIds.length; l++){

			                var projectId = projectIds[l];
					        var selectUsers=true;

					        var data = {
						        "projectId": projectId,
						        "selectUsers": selectUsers
					        };

					        $.ajax({
						        url: "getUsersByProject.php",
						        type: "post",
						        data: data,
						        success: function (response) {
							        var resultUserOut='';
							        $.each( JSON.parse(response), function( key, value ) {

								    	if($("#userId option[value="+key+"]").length == 0)
										{	
									    	resultUserOut +='<option value='+key+'>'+value+'</option>';
										}
									
								    });

								    $('#userId').append(resultUserOut).multipleSelect("refresh");
							                  
						        },
						        error: function(jqXHR, textStatus, errorThrown) {
						           	console.log(textStatus, errorThrown);		
							        $("#userId").empty();
						        }

			        	    });

					        $.ajax({
						        url: "getSubprojectsByProject.php",
						        type: "post",
						        data: data,
						        success: function (response) {

							        if(jQuery.isEmptyObject(JSON.parse(response))) {
										$("#subprojectId").empty();
								        //$("#subprocjectDiv").hide();

							        } else {
								
								        
								        var resultSubProjectOut='<option value="">All</option>';
								        $.each( JSON.parse(response), function( key, value ) {
									        resultSubProjectOut +='<option value='+key+'>'+value+'</option>';
								        });

								        $('#subprojectId').append(resultSubProjectOut);
							        }
							               
						        },
						        error: function(jqXHR, textStatus, errorThrown) {
						           	console.log(textStatus, errorThrown);		
							        $("#subprojectId").empty();
						        }

			        			});
				        }

	                }

	            }
	        })

            var userIds = "";
            $('#userId').change(function() {
            	userIds = $(this).val();
                $("#userIds").val(userIds);
               
            }).multipleSelect({
                filter: true,
	            width: '100%',
	            placeholder: "Select Users",
            });

			var auserIds = "";
            $('#assigneduserId').change(function() {
            	auserIds = $(this).val();
                $("#assigneduserIds").val(auserIds);
                
            }).multipleSelect({
                filter: true,
	            width: '100%',
	            placeholder: "Select Users",
            });
		});

		function resetForm() {

    		document.getElementById("filter-form").reset();
			$('#projectId').multipleSelect('refresh');
			$('#userId').multipleSelect('refresh');
			$('#assigneduserId').multipleSelect('refresh');
			barChart();
		}


		function downloadSummaryTasks(args,type) { 

			var retrievedData = localStorage.getItem("summaryTasks");
			var reqData = JSON.parse(retrievedData);
			
			reqData = [reqData];
			var len = reqData.length;
			var dataArr = [];
			var parseObj;
			for(var i=0; i<len; i++){
				var obj = reqData[i];
				var parseObj = JSON.parse(obj);
				
				for(var j=0; j<parseObj.length; j++){
					var objData = parseObj[j];

					dataArr.push({
						IssueId: objData.issueId,
						ProjectName:objData.projectName[0],
						Status:objData.statusName[0],
						Subject:objData.subject,
						Priority:objData.priorityName[0],
						Severity:objData.severityName[0],
						Tracker:objData.trackerName[0],
						Author:objData.authorName[0],
						Assignee:objData.assignedToName[0],
						EstimatedStartDate:objData.startDate,
						EstimatedEndDate:objData.dueDate,
						ActualStartDate:objData.dueDate,
						ActualEndDate:objData.closedOn,
						TimeDifferenceInDays:objData.timeDiff,
						EstimatedTime:objData.estimatedTime,
						SpentTime:objData.spentTime,
						TimeDifferenceInHours:objData.timeDiffinHours

					});
				}
				
			}

			if(type == "XLS") {
				var data, filename, link;
				var xls = convertArrayOfObjectsToCSV({
					data: dataArr,
					columnDelimiter: '\t'
				});
				if (xls == null) return;

				filename = args.filename || 'export.xlsx';

				if (!xls.match(/^data:text\/xls/i)) {
					xls = 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; base64,' + xls;
				}
				data = encodeURI(xls);
				var a = document.createElement('a');
				a.setAttribute('href', data);
				a.setAttribute('target', '_blank');
				a.setAttribute('download', filename);
				a.style.display = 'none';
				document.body.appendChild(a);
				a.click();
				document.body.removeChild(a);
				
			} else {

				var data, filename, link;
				var csv = convertArrayOfObjectsToCSV({
					data: dataArr
				});

				if (csv == null) return;
				filename = args.filename || 'export.csv';
				if (!csv.match(/^data:text\/csv/i)) {
					csv = 'data:text/csv;charset=utf-8,' + csv;
				}

				data = encodeURI(csv);
				var a = document.createElement('a');
				a.setAttribute('href', data);
				a.setAttribute('target', '_blank');
				a.setAttribute('download', filename);
				a.style.display = 'none';
				document.body.appendChild(a);
				a.click();
				document.body.removeChild(a);

			}

    	}

		function downloadCount(args,type) { 
			//type="PDF"; 

			var retrievedData = localStorage.getItem("tasksCount");
			var reqData = JSON.parse(retrievedData);

			//console.log(reqData);
			reqData = [reqData];
			var len = reqData.length;
			var dataArr = [];
			var parseObj;

			for(var i=0; i<len; i++) {
				var obj = reqData[i];
				//console.log(obj);
				var parseObj = JSON.parse(obj);
				console.log(parseObj);
				//alert(parseObj.length)
				
				for(var j=0; j<parseObj.length; j++) { 
					var objData = parseObj[j];
					dataArr.push({
						ProjectName:objData.projectName,
						Assignee:objData.assignedUser,
						TasksCount:objData.ticketCount,
						Open:objData.open,
						Closed:objData.closed,
					
					});
				}
			}

			if(type == "XLS"){
				var data, filename, link;
				var xls = convertArrayOfObjectsToCSV({
					data: dataArr,
					columnDelimiter: '\t'
				});
				if (xls == null) return;

				filename = args.filename || 'export.xlsx';

				if (!xls.match(/^data:text\/xlsx/i)) {
					xls = 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; base64,' + xls;
				}
				data = encodeURI(xls);

				var a = document.createElement('a');
				a.setAttribute('href', data);
				a.setAttribute('target', '_blank');
				a.setAttribute('download', filename);
				//a.style.display = 'none';
				document.body.appendChild(a);
				a.click();
				document.body.removeChild(a);
			} else if(type == "PDF") {

				/*
				var data, filename, link;
				var pdf = convertArrayOfObjectsToCSV({
					data: dataArr
				});
				if (pdf == null) return;

				filename = args.filename || 'export.pdf';

				if (!pdf.match(/^data:text\/pdf/i)) {
					pdf = 'data:text/octet-stream;base64,' + pdf;
				}
				data = encodeURI(pdf);

				var a = document.createElement('a');
				a.setAttribute('href', data);
				a.setAttribute('target', '_blank');
				a.setAttribute('download', filename);
				//a.style.display = 'none';
				document.body.appendChild(a);
				a.click();
				document.body.removeChild(a);
				*/

				/*var employees = [
				{"firstName":"John", "lastName":"Doe"}, 
				{"firstName":"Anna", "lastName":"Smith"},
				{"firstName":"Peter", "lastName":"Jones"}
				]; */

				var doc = new jsPDF();
				employees.forEach(function(employee, i){
				doc.text(20, 10 + (i * 10), 
				"First Name: " + employee.firstName +
				"Last Name: " + employee.lastName);
				});
				doc.save('Test.pdf');


			} else {

				var data, filename, link;
				var csv = convertArrayOfObjectsToCSV({
					data: dataArr
				});
				if (csv == null) return;

				filename = args.filename || 'export.csv';

				if (!csv.match(/^data:text\/csv/i)) {
					csv = 'data:text/csv;charset=utf-8,' + csv;
				}
				data = encodeURI(csv);

				var a = document.createElement('a');
				a.setAttribute('href', data);
				a.setAttribute('target', '_blank');
				a.setAttribute('download', filename);
				//a.style.display = 'none';
				document.body.appendChild(a);
				a.click();
				document.body.removeChild(a);
				}



    	}


		function convertArrayOfObjectsToCSV(args) {  
			var result, ctr, keys, columnDelimiter, lineDelimiter, data;

			data = args.data || null;
			if (data == null || !data.length) {
				return null;
			}

			columnDelimiter = args.columnDelimiter || ',';
			lineDelimiter = args.lineDelimiter || '\n';

			keys = Object.keys(data[0]);

			result = '';
			result += keys.join(columnDelimiter);
			result += lineDelimiter;

			data.forEach(function(item) {
				ctr = 0;
				keys.forEach(function(key) {
					if (ctr > 0) result += columnDelimiter;

					result += item[key];
					ctr++;
				});
				result += lineDelimiter;
			});

			return result;
		}

		function demoFromHTML() {
			var pdf = new jsPDF('p', 'pt', 'letter');
			// source can be HTML-formatted string, or a reference
			// to an actual DOM element from which the text will be scraped.
			source = $('#tasks-summary')[0];

			// we support special element handlers. Register them with jQuery-style 
			// ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
			// There is no support for any other type of selectors 
			// (class, of compound) at this time.
			specialElementHandlers = {
				// element with id of "bypass" - jQuery style selector
				'#bypassme': function (element, renderer) {
					// true = "handled elsewhere, bypass text extraction"
					return true
				}
			};
			margins = {
				top: 100,
				bottom: 160,
				left: 60,
				width: 10000
			};
			// all coords and widths are in jsPDF instance's declared units
			// 'inches' in this case
			pdf.fromHTML(
				source, // HTML string or DOM elem ref.
				margins.left, // x coord
				margins.top, { // y coord
				'width': margins.width, // max width of content on PDF
				'elementHandlers': specialElementHandlers
				},

				function (dispose) {
				// dispose: object with X, Y of the last line add to the PDF 
				//          this allow the insertion of new lines after html
				pdf.save('Test.pdf');
			}, margins);
		}
	
	</script>
	<script type="text/javascript">

function valueChanged()
{

    if($('.actual-start-date').is(":checked")) {   
        $(".th-actual-start-date").show();
		$(".td-actual-start-date").show();
	} else {
		$(".th-actual-start-date").hide();
		$(".td-actual-start-date").hide();
	}

	
	if($('.actual-end-date').is(":checked")) {   
        $(".th-actual-end-date").show();
		$(".td-actual-end-date").show();
	} else {
	$(".th-actual-end-date").hide();
		$(".td-actual-end-date").hide();
	}

	if($('.time-difference-in-days').is(":checked")) {   
        $(".th-time-difference-in-days").show();
		$(".td-time-difference-in-days").show();
	} else {
		$(".th-time-difference-in-days").hide();
		$(".td-time-difference-in-days").hide();
	}
	//estimated-time
	if($('.estimated-time').is(":checked")) {   
        $(".th-estimated-time").show();
		$(".td-estimated-time").show();
	} else {
		$(".th-estimated-time").hide();
		$(".td-estimated-time").hide();
	}
	//Spent Time
	if($('.spent-time').is(":checked")) {   
        $(".th-spent-time").show();
		$(".td-spent-time").show();
	} else {
		$(".th-spent-time").hide();
		$(".td-spent-time").hide();
	}
	//Time difference in hours
	if($('.time-difference-in-hours').is(":checked")) {   
        $(".th-time-difference-in-hours").show();
		$(".td-time-difference-in-hours").show();
	} else {
		$(".th-time-difference-in-hours").hide();
		$(".td-time-difference-in-hours").hide();
	}
	
}


function barChart(){
	var totalArray = <?php echo json_encode($countArrayTotal); ?>;
	var openArray = <?php echo json_encode($countArrayOpen); ?>;
	var closeArray = <?php echo json_encode($countArrayClose); ?>;
	var categoryArray = <?php echo json_encode($countArrayCategory); ?>;
	
	Highcharts.chart('container', {
		chart: {
			type: 'column'
		},
		title: {
			text: 'Redmine Reports Count Chart'
		},
		subtitle: {
			text: 'Source: Redmine'
		},
		xAxis: {
			categories: categoryArray,
			tickmarkPlacement: 'on',
			title: {
				enabled: false
			}
		},

		yAxis: {
			allowDecimals:false,
			title: {
				text: 'Percent'
			}
		},
		
		tooltip: {
			pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}%</b> ({series.datass})<br/>',
			split: true
		},
		plotOptions: {
			area: {
				stacking: 'normal',
				lineColor: '#ffffff',
				lineWidth: 1,
				dataLabels: {
                	enabled: true,
                	color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
           		},
			
			}
		},


		series: [{
			type: 'column',
			name: 'Project Name',
			datass: 'gvs'
		}, {
			name: 'Total',
			data:totalArray
		}, {
			name: 'Open',
			data: openArray
		}, {
			name: 'Close',
			data: closeArray
		}]
	});
}

$(document).ready(function () {

barChart();

	
	
});
</script>
	<script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>

	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/series-label.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>

<div id="loader"></div>

<div style="display:none;" id="myDiv" class="animate-bottom">

</div>
    </body>
</html>

