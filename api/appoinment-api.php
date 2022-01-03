<?php 
session_start();


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../index.php");
    exit;
}
header('Content-type: application/json');
require '../db/config.php';

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
	];

	$sql = "INSERT INTO appointments (appointment_user, appointment_machine, appointment_note, appointment_date) VALUES(:user_name, :machine, :appointment_note, :appointment_date)";
	$stmt= $pdo->prepare($sql);
	$stmt->execute($datasql);


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
	    'id' => $data['id'],
	];

	$sql = "DELETE FROM appointments WHERE id=:id";
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