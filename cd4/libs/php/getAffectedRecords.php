<?php
	// example use from browser
	// http://localhost/companydirectory/libs/php/insertDepartment.php?name=New%20Department&locationID=1
	// remove next two lines for production
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);
	$executionStartTime = microtime(true);
	include("config.php");
	// header('Content-Type: application/json; charset=UTF-8');
	$conn = new mysqli($cd_host, $cd_user, $cd_password, $cd_dbname, $cd_port, $cd_socket);
	if (mysqli_connect_errno()) {
		$output['status']['code'] = "300";
		$output['status']['name'] = "failure";
		$output['status']['description'] = "database unavailable";
		$output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
		$output['data'] = [];
		mysqli_close($conn);
		echo json_encode($output);
		exit;
	}	
	// $_REQUEST used for development / debugging. Remember to change to $_POST for production
    $type = $_POST['type'];
    $id = $_POST['id'];

    if ($type == "department") {

        $query0 = "SELECT COUNT(id) AS AffectedNumbers FROM personnel WHERE departmentID = '$id'";
        $result = $conn->query($query0);

        while ($warning = $result->fetch_assoc()){
        echo $warning['AffectedNumbers'] . " rows in 'personnel' table will be affected. Are you sure?";
        }
    }

    if ($type == "location") {
        $query0 = "SELECT COUNT(id) AS AffectedNumbers FROM department WHERE locationID = '$id'";
        $result = $conn->query($query0);

        while ($warning = $result->fetch_assoc()){
        echo $warning['AffectedNumbers'] . " rows in 'department' table will be affected. Are you sure?";
        }        
    }

	if (!$result) {
		$output['status']['code'] = "400";
		$output['status']['name'] = "executed";
		$output['status']['description'] = "query failed";	
		$output['data'] = [];
		mysqli_close($conn);
		echo json_encode($output); 
		exit;
	}
	// $output['status']['code'] = "200";
	// $output['status']['name'] = "ok";
	// $output['status']['description'] = "success";
	// $output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
	// $output['data'] = [];
	mysqli_close($conn);
	// echo json_encode($output); 
?>