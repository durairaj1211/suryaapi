<?php
	// Include CORS headers
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('Access-Control-Allow-Headers: X-Requested-With');
	header('Content-Type: application/json');

	// Include action.php file
	include_once 'db.php';
	// Create object of Users class
	$user = new Database();

	// create a api variable to get HTTP method dynamically
	$api = $_SERVER['REQUEST_METHOD'];

	// get id from url
	$id = intval($_GET['id'] ?? '');

	// Add a new user into database
	if ($api == 'POST') {
	
	  $username = $user->test_input($_POST['username']);
	  $password = md5($user->test_input($_POST['password']));
	  $data = $user->login($username, $password);
	  if (count($data)>0) {
		//echo json_encode($data);
	    //echo $user->message('Login successfully!',false);
		echo json_encode(['status' => 1, 'message' => 'Login successfully!', 'datas' => $data]);
	  } else {
	    //echo $user->message('Invalid Login details!',true);
		echo json_encode(['status' => 0, 'message' => 'Invalid Login details!', 'datas' =>[]]);
	  }
	}

	



?>
