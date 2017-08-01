<?php

include('class.password.php');

class User extends Password{

    private $db;
	
	function __construct($db){
		parent::__construct();
	
		$this->_db = $db;
	}

	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}		
	}

	private function get_user_hash($username){	

		try {

			$stmt = $this->_db->prepare('SELECT password FROM blog_members WHERE username = :username');
			$stmt->execute(array('username' => $username));
			
			$row = $stmt->fetch();
			return $row['password'];

		} catch(PDOException $e) {
		    echo '<p class="error">'.$e->getMessage().'</p>';
		}
	}

	
	public function login($username,$password){	

		$hashed = $this->get_user_hash($username);
		
		if($this->password_verify($password,$hashed) == 1){
		    
		    $_SESSION['loggedin'] = true;
		    return true;
		}		
	}
	public function check_exsistence($username)
	{
		try {
			
			$stmt = $this->_db->prepare('SELECT username FROM blog_members WHERE username = :username');
			$stmt->execute(array('username' => $username));
			
			
		
			
			if ( $stmt->rowCount() > 0)
			{
				
				return true;
			}
			
			else {return false;}
			
			
			
		}catch(PDOException $e) 
		{}
	}
	public function register($name,$username,$password,$email)
	{
		try {
			$stmt = $this->_db->prepare('INSERT INTO blog_members (username,password,email,name) VALUES (:username, :password, :email, :name)') ;
				$stmt->execute(array(
					':username' => $username,
					':password' => $password,
					':email' => $email,
					':name' => $name
				));
			$message = '<p class="error">Registration successful please login</p>';
			echo $message;
			
			
			
			
		}
		
		
	catch(PDOException $e) 
		{ }
		

	}

	
	
	
		
	public function logout(){
		session_destroy();
	}
	
}


?>