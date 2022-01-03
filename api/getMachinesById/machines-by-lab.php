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
	$id = $_REQUEST['id'];
	$sql = "SELECT * FROM `machines` WHERE `laboratory_id`=".$id;
	foreach ($pdo->query($sql) as $row){
		$jsonDizisi[$sayac]['id'] = $row["id"];
		$jsonDizisi[$sayac]['name'] = $row["name"];
		$jsonDizisi[$sayac]['status'] = $row["status"];
		$jsonDizisi[$sayac]['laboratory_name'] = $row["laboratory_name"];
		$jsonDizisi[$sayac]['laboratory_id'] = $row["laboratory_id"];
		$sayac++;
	}
	echo json_encode($jsonDizisi);
}
