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
if ($_SERVER['REQUEST_METHOD'] === 'GET'){
	$jsonDizisi = array();
	$sql = "SELECT * FROM `machines";
	foreach ($pdo->query($sql) as $row){
		$jsonDizisi[$sayac]['id'] = $row["id"];
		$jsonDizisi[$sayac]['name'] = $row["name"];
		$jsonDizisi[$sayac]['status'] = $row["status"];
		$sayac++;
	}
	echo json_encode($jsonDizisi);
}

if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
     
	$json = file_get_contents('php://input');
	$data = json_decode($json,true);

	$datasql = [
	    'labId' => $data['labId'],
	    'labName' => $data['labName'],
	    'machineId' => $data['machineId'],
	];

	$sql = "UPDATE machines SET laboratory_id=:labId, laboratory_name=:labName WHERE id=:machineId";
	$stmt= $pdo->prepare($sql);
	$stmt->execute($datasql);


	$count = $stmt->rowCount();


	$jsonDizisi = array();
	if($count =='0'){
	    $jsonDizisi["result"] = "Failed, Machine laboratory cannot update to own laboratory!";
	}
	else{
	    $jsonDizisi["result"] = "Machine successfully updated!";
	}
	unset($stmt);
	unset($db);
	echo json_encode($jsonDizisi);
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
     
	$json = file_get_contents('php://input');
	$data = json_decode($json,true);

	$datasql = [
	    'id' => $data['id'],
	    'status' => $data['status'],
	];

	$sql = "UPDATE machines SET status=:status WHERE id=:id";
	$stmt= $pdo->prepare($sql);
	$stmt->execute($datasql);


	$count = $stmt->rowCount();


	$jsonDizisi = array();
	if($count =='0'){

	    $jsonDizisi["result"] = "Failed, Machine status cannot update to own status!";
	}
	else{
	    $jsonDizisi["result"] = "Machine successfully updated!";
	}
	unset($stmt);
	unset($db);
	echo json_encode($jsonDizisi);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
	$json = file_get_contents('php://input');
	$data = json_decode($json,true);

	$datasql = [
	    'name' => $data['name'],
	];

	$sql = "INSERT INTO machines (name) VALUES(:name)";
	$stmt= $pdo->prepare($sql);
	$stmt->execute($datasql);


	$count = $stmt->rowCount();


	$jsonDizisi = array();
	if($count =='0'){

	    $jsonDizisi["result"] = "Failed, Something went wrong...!";
	}
	else{
	    $jsonDizisi["result"] = "Machine successfully created!";
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

	$sql = "DELETE FROM machines WHERE id=:id";
	$stmt= $pdo->prepare($sql);
	$stmt->execute($datasql);
	
	$count = $stmt->rowCount();


	$jsonDizisi = array();
	if($count =='0'){

	    $jsonDizisi["result"] = "Failed, something went wrong!";
	}
	else{
	    $jsonDizisi["result"] = "Machine successfully deleted!";
	}
	unset($stmt);
	unset($db);
	echo json_encode($jsonDizisi);
}