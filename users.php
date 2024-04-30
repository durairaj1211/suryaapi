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
	    $data = $user->fetch($id);
	  } else {
	    $data = $user->fetch();
	  }
	  if (count($data)>0) {
		echo json_encode(['status' => 1, 'message' => 'Success!', 'data' => $data]);
	  } else {
		echo json_encode(['status' => 0, 'message' => 'No Data!', 'data' =>[]]);
	  }
	}

	// Add a new user into database
	if ($api == 'POST') {
		
		if($id != null){
				if($_FILES['image']!=''){
					$img = $_FILES['image'];
					$imgn = $_FILES['image']['name'];
					$file_extt=explode('.',$imgn);
					$file_ext= end($file_extt);
					$dir = 'images/';
					$uId = uniqid();
					$dir_1 = $dir.$uId.".".$file_ext;
					move_uploaded_file($img['tmp_name'], $dir_1);
					$path = 'http://swaramtech.in/production/surya_valencia/api/images/';
					$imagename = $path.$uId.".".$file_ext;
				}else{
					$imagename = $_POST['oldimage'];
				}		
		
			  $name = $user->test_input($_POST['name']);
			  $description = $user->test_input($_POST['description']);
			  $category = $user->test_input($_POST['category']);
		  
			  if ($id != null) {
				if ($user->update($name, $description, $category, $imagename, $id)) {
					//unlink("$_POST['oldimage']");
				  echo json_encode(['status' => 1, 'message' => 'updated successfully!', 'data' => []]);
				} else {
				  echo json_encode(['status' => 0, 'message' => 'Failed to Update', 'data' => []]);
				}
			  } else {
				echo json_encode(['status' => 0, 'message' => 'Failed to Update', 'data' => []]);
			  }

		}else{
				if($_FILES['image']!=''){
					$img = $_FILES['image'];
					$imgn = $_FILES['image']['name'];
					$file_extt=explode('.',$imgn);
					$file_ext= end($file_extt);
					$dir = 'images/';
					$uId = uniqid();
					$dir_1 = $dir.$uId.".".$file_ext;
					move_uploaded_file($img['tmp_name'], $dir_1);
					$path = 'http://swaramtech.in/production/surya_valencia/api/images/';
					$imagename = $path.$uId.".".$file_ext;
					
				}else{
					$imagename = '';
				}		
				
			  $name = $user->test_input($_POST['name']);
			  $description = $user->test_input($_POST['description']);
			  $category = $user->test_input($_POST['category']);

			  if ($user->insert($name, $description, $category, $imagename)) {
				//echo $user->message('Image added successfully!',false);
				echo json_encode(['status' => 1, 'message' => 'Created successfully!', 'data' => []]);
			  } else {
				//echo $user->message('Failed to add an Image!',true);
				echo json_encode(['status' => 0, 'message' => 'Not Created', 'data' => []]);
			  }
			
		}
	}

	// Update an user in database
	if ($api == 'PUT') {
		
	  parse_str(file_get_contents('php://input'), $post_input);
	  
		if($_FILES['image']!=''){
			$img = $_FILES['image'];
			$imgn = $_FILES['image']['name'];
			$file_extt=explode('.',$imgn);
			$file_ext= end($file_extt);
			$dir = 'images/';
			$uId = uniqid();
			$dir_1 = $dir.$uId.".".$file_ext;
			move_uploaded_file($img['tmp_name'], $dir_1);
			$path = 'http://swaramtech.in/production/surya_valencia/api/images/';
			$imagename = $path.$uId.".".$file_ext;
			
		}else{
			$imagename = $post_input['oldimage'];
		}

	  $name = $user->test_input($post_input['name']);
	  $description = $user->test_input($post_input['description']);
	  $category = $user->test_input($post_input['category']);
	  
	  
	  if ($id != null) {
	    if ($user->update($name, $description, $category, $imagename, $id)) {
		  echo json_encode(['status' => 1, 'message' => 'updated successfully!', 'error' => false]);
	    } else {
		  echo json_encode(['status' => 0, 'message' => 'Failed to Update', 'error' => true]);
	    }
	  } else {
		  echo json_encode(['status' => 0, 'message' => 'Failed to Update', 'error' => true]);
	  }
	}

	// Delete an user from database
	if ($api == 'DELETE') {
	  if ($id != null) {
		if ($user->delete($id)) {
			echo json_encode(['status' => 1, 'message' => 'Deleted successfully!', 'data' => []]);
		} else {
			echo json_encode(['status' => 0, 'message' => 'Failed to delete!', 'data' =>[]]);
		}
	  } else {
	    echo json_encode(['status' => 0, 'message' => 'Failed to delete!', 'data' =>[]]);
	  }
	}

?>
