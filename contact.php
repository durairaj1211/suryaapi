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
	
	// Get all or a single user from database
	if ($api == 'GET') {
	  if ($id != 0) {
	    $data = $user->contactfetch($id);
	  } else {
	    $data = $user->contactfetch();
	  }
	  if (count($data)>0) {
		echo json_encode(['status' => 1, 'message' => 'Success!', 'data' => $data]);
	  } else {
		echo json_encode(['status' => 0, 'message' => 'No Data!', 'data' =>[]]);
	  }
	}

	// Add a new user into database
	if ($api == 'POST') {
		
	  $name = $user->test_input($_POST['name']);
	  $email = $user->test_input($_POST['email']);
	  $description = $user->test_input($_POST['description']);


	  if ($user->insertcontact($name, $email, $description)) {
		echo json_encode(['status' => 1, 'message' => 'Request added successfully!', 'data' => []]);
	  } else {
	    echo json_encode(['status' => 0, 'message' => 'Failed', 'data' => []]);
	  }
	}

	

?>
