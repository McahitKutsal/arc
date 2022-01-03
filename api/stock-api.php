<?php 
session_start();


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../index.php");
    exit;
}


header('Content-type: application/json');
require '../db/config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
	$json = file_get_contents('php://input');
	$data = json_decode($json,true);

	$datasql = [
	    'name' => $data['name'],
	    'number' => $data['number'],
	    'description' => $data['description'],
	];

	$sql = "INSERT INTO stock (name, number, description) VALUES(:name, :number, :description)";
	$stmt= $pdo->prepare($sql);
	$stmt->execute($datasql);


	$count = $stmt->rowCount();


	$jsonDizisi = array();
	if($count =='0'){

	    $jsonDizisi["result"] = "Failed, Something went wrong...!";
	}
	else{
	    $jsonDizisi["result"] = "Stock request has sent successfully!";
	}
	unset($stmt);
	unset($db);
	echo json_encode($jsonDizisi);
}
if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
     
	$json = file_get_contents('php://input');
	$data = json_decode($json,true);

	$datasql = [
	    'id' => $data['id'],
	];

	$sql = "UPDATE stock SET is_approved=!is_approved WHERE id=:id";
	$stmt= $pdo->prepare($sql);
	$stmt->execute($datasql);


	$count = $stmt->rowCount();


	$jsonDizisi = array();
	if($count =='0'){
	    $jsonDizisi["result"] = "Failed, Something went wrong!";
	}
	else{
	    $jsonDizisi["result"] = "Stock successfully updated!";
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
	    'value' => $data['value'],
	];

	$sql = "UPDATE stock SET number=:value WHERE id=:id";
	$stmt= $pdo->prepare($sql);
	$stmt->execute($datasql);


	$count = $stmt->rowCount();


	$jsonDizisi = array();
	if($count =='0'){
	    $jsonDizisi["result"] = "Failed, Something went wrong!";
	}
	else{
	    $jsonDizisi["result"] = "Stock successfully updated!";
	}
	unset($stmt);
	unset($db);
	echo json_encode($jsonDizisi);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
	$json = file_get_contents('php://input');
	$data = json_decode($json,true);

	$datasql = [
	    'Id' => $data['id'],
	];

	$sql = "DELETE FROM stock WHERE id=:Id";
	
	$stmt= $pdo->prepare($sql);
	$stmt->execute($datasql);
	
	$count = $stmt->rowCount();
	

	$jsonDizisi = array();
	if($count =='0'){

	    $jsonDizisi["result"] = "Failed, something went wrong!";
	}
	else{
	    $jsonDizisi["result"] = "Stock successfully deleted!";
	}
	unset($stmt);
	unset($db);
	echo json_encode($jsonDizisi);
}