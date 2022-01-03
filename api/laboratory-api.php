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
	$sql = "SELECT * FROM `laboratories";
	foreach ($pdo->query($sql) as $row){
		$jsonDizisi[$sayac]['id'] = $row["id"];
		$jsonDizisi[$sayac]['name'] = $row["name"];
		$sayac++;
	}
	echo json_encode($jsonDizisi);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
	$json = file_get_contents('php://input');
	$data = json_decode($json,true);

	$datasql = [
	    'name' => $data['name'],
	];

	$sql = "INSERT INTO laboratories (name) VALUES(:name)";
	$stmt= $pdo->prepare($sql);
	$stmt->execute($datasql);


	$count = $stmt->rowCount();


	$jsonDizisi = array();
	if($count =='0'){

	    $jsonDizisi["result"] = "Failed, Something went wrong...!";
	}
	else{
	    $jsonDizisi["result"] = "Labratory successfully created!";
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

	$sql = "DELETE FROM laboratories WHERE id=:id";
	$stmt= $pdo->prepare($sql);
	$stmt->execute($datasql);
	
	$count = $stmt->rowCount();


	$jsonDizisi = array();
	if($count =='0'){

	    $jsonDizisi["result"] = "Failed, something went wrong!";
	}
	else{
	    $jsonDizisi["result"] = "laboratory successfully deleted!";
	}
	unset($stmt);
	unset($db);
	echo json_encode($jsonDizisi);
}