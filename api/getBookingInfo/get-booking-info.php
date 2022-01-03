<?php 
session_start();


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../index.php");
    exit;
}


header('Content-type: application/json');


require '../../db/config.php';

$db = $pdo;
$sayac = 0;

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
	$jsonDizisi = array();
	$date = $_REQUEST['date'];
	$machineName = $_REQUEST['machineName'];
	$sql = "SELECT * FROM `appointments` WHERE `appointment_machine`='".$machineName. "' AND `appointment_date` LIKE '".$date."%' LIMIT 1";
	
	foreach ($pdo->query($sql) as $row){
		$jsonDizisi[$sayac]['id'] = $row["id"];
		$jsonDizisi[$sayac]['appointment_user'] = $row["appointment_user"];
		$jsonDizisi[$sayac]['appointment_machine'] = $row["appointment_machine"];
		$jsonDizisi[$sayac]['appointment_note'] = $row["appointment_note"];
		$jsonDizisi[$sayac]['appointment_date'] = $row["appointment_date"];
		$sayac++;
	}
	echo json_encode($jsonDizisi);
}
