
<?php 
session_start();


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../index.php");
    exit;
}


header('Content-type: application/json');
require '../db/config.php';

$db = $pdo;

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
     
	$json = file_get_contents('php://input');
	$data = json_decode($json,true);

	$datasql = [
	    'id' => $data['id'],
	    'role' => $data['role'],
	];

	$sql = "UPDATE users SET role=:role WHERE id=:id";
	$stmt= $pdo->prepare($sql);
	$stmt->execute($datasql);


	$count = $stmt->rowCount();


	$jsonDizisi = array();
	if($count =='0'){

	    $jsonDizisi["result"] = "Failed, User cannot update to own role!";
	}
	else{
	    $jsonDizisi["result"] = "User successfully updated!";
	}
	unset($stmt);
	unset($db);
	echo json_encode($jsonDizisi);
}
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
	$json = file_get_contents('php://input');
	$data = json_decode($json,true);

	$datasql = [
	    'id' => $data['id'],
	];

	$sql = "DELETE FROM users WHERE id=:id";
	$stmt= $pdo->prepare($sql);
	$stmt->execute($datasql);
	
	$count = $stmt->rowCount();


	$jsonDizisi = array();
	if($count =='0'){

	    $jsonDizisi["result"] = "Failed, something went wrong!";
	}
	else{
	    $jsonDizisi["result"] = "User successfully deleted!";
	}
	unset($stmt);
	unset($db);
	echo json_encode($jsonDizisi);
}

?>