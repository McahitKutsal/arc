<?php 
session_start();


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ....//index.php");
    exit;
}
header('Content-type: application/json');
require '../../db/config.php';

$db = $pdo;
$sayac = 0;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
	$json = file_get_contents('php://input');
	$data = json_decode($json,true);
	
	
	$datasql = [
	    'user_name' => $data['userName'],
	    'machine' => $data['machine'],
	    'appointment_date' => $data['date'],
	    'appointment_note' => $data['note'],
	    'time_array' => $data['timeArray']
	];
	$items = array();
	for ($i=0; $i < count($datasql['time_array']) ; $i++) { 
		$items[] = array(
	        "user_name"     => $datasql['user_name'], 
	        "machine"    => $datasql['machine'],
	        "appointment_date"    => $datasql['appointment_date']. " ".$datasql['time_array'][$i],
	        "appointment_note"    => $datasql['appointment_note']
    	);
	}
	$sqlString = "";
	for ($i=0; $i < count($items); $i++) {
		if ($i == count($items)-1) {
		 	$sqlString .= "('".$items[$i]['user_name']."', '".$items[$i]['machine']."', '".$items[$i]['appointment_date']."', '".$items[$i]['appointment_note']."')";
		 }else{
		 	$sqlString .= "('".$items[$i]['user_name']."', '".$items[$i]['machine']."', '".$items[$i]['appointment_date']."', '".$items[$i]['appointment_note']."'),";
		 }
		
	}
	
	$sqlString = "INSERT INTO appointments (appointment_user, appointment_machine, appointment_date, appointment_note) VALUES ".$sqlString;
	
	$stmt= $pdo->prepare($sqlString);
	$stmt->execute();


	$count = $stmt->rowCount();


	$jsonDizisi = array();
	if($count =='0'){
	    $jsonDizisi["result"] = "Failed, Something went wrong...!";
	}
	else{
	    $jsonDizisi["result"] = "Appointment successfully created!";
	}
	unset($stmt);
	unset($db);
	echo json_encode($jsonDizisi);
}
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
	$json = file_get_contents('php://input');
	$data = json_decode($json,true);

	$datasql = [
	    'user_name' => $data['userName'],
	    'machine_name' => $data['machineName'],
	];
	
	$sql = "DELETE FROM appointments WHERE appointment_user=:user_name AND appointment_machine=:machine_name AND appointment_date LIKE '".$data['date']."%'";
	
	$stmt= $pdo->prepare($sql);
	$stmt->execute($datasql);
	$count = $stmt->rowCount();


	$jsonDizisi = array();
	if($count =='0'){

	    $jsonDizisi["result"] = "Failed, something went wrong!";
	}
	else{
	    $jsonDizisi["result"] = "Appointment successfully canceled!";
	}
	unset($stmt);
	unset($db);
	echo json_encode($jsonDizisi);
}