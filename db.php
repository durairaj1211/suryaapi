<?php
	// Include config.php file
	include_once 'config.php';

	// Create a class gallery
	class Database extends Config {
	  // Fetch all or a single image from database
	  public function fetch($id = 0) {
	    $sql = 'SELECT * FROM gallery';
	    if ($id != 0) {
	      $sql .= ' WHERE id = :id';
		  $stmt = $this->conn->prepare($sql);
		  $stmt->execute(['id' => $id]);
	    }else{
		  $stmt = $this->conn->prepare($sql);
	      $stmt->execute();	
		}
	    $rows = $stmt->fetchAll();
	    return $rows;
	  }
	  
	  // Admin Login
	  public function login($username, $password) {
	    $sql = 'SELECT * FROM admin';
		$sql .= ' WHERE username = :username AND password = :userpassword';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['username' => $username, 'userpassword' => $password]);
	    $rows = $stmt->fetchAll();
	    return $rows;
	  }

	  // Insert an user in the database
	  public function insert($name, $description, $category, $imagename) {
	    $sql = 'INSERT INTO gallery (name, description, category, image) VALUES (:name, :description, :category, :imagename)';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['name' => $name, 'description' => $description, 'category' => $category, 'imagename' => $imagename]);
	    return true;
	  }
	  
	  // Update an user in the database
	  public function update($name, $description, $category, $imagename,$id) {
	    $sql = 'UPDATE gallery SET name = :name, description = :description, category = :category, image = :imagename WHERE id = :id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['name' => $name, 'description' => $description, 'category' => $category, 'imagename' => $imagename, 'id' => $id]);
	    return true;
	  }

	  // Delete an user from database
	  public function delete($id) {
	    $sql = 'DELETE FROM gallery WHERE id = :id';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['id' => $id]);
	    return true;
	  }
	  
	  //contactus Part
	  
	  
	  // Fetch all or a contact us from database
	  
	  public function contactfetch($id = 0) {
	    $sql = 'SELECT * FROM contactus';
	    if ($id != 0) {
	      $sql .= ' WHERE id = :id';
	    }
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute();
	    $rows = $stmt->fetchAll();
	    return $rows;
	  }
	  
	  // Insert contact Us in the database
	  public function insertcontact($name, $email, $description) {
	    $sql = 'INSERT INTO contactus (name, description, email) VALUES (:name, :description, :email)';
	    $stmt = $this->conn->prepare($sql);
	    $stmt->execute(['name' => $name, 'description' => $description, 'email' => $email]);
	    return true;
	  }
	}

?>