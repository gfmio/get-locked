<?php

class User {
	static private $salt = '&2#NGKiszuAvq>%+JZs98}K8nN6G4wqRF>C?3=nE.ayRZH92Y7';

	protected $id; public function id() { return $this->id; }
	protected $email; public function email() { return $this->id; } public function setEmail($email) { $this->email = $email; }
	protected $password; public function password() { return $this->password; } public function setPassword($password) { $this->password = self::encrypt($password); }
	protected $locks = array();
	
	public static function encrypt($code) {
		return sha1(self::$salt.$code);
	}

	public static function getCurrentUser() {
		if (isset($_SESSION["id"])) {
			$currentUser = new User();
			$currentUser->get($_SESSION["id"]);
			return $currentUser;
		}
		throw new Exception("Not logged in.");
	}

	public function login() {
		$db = new DB();
		echo "c";
		$db->prepareStatement("SELECT `id` FROM `users` WHERE email=:email AND password=:password");
		echo "c";
		$db->bindParam(':email', $this->email, PDO::PARAM_STR);
		echo "c";
		$db->bindParam(':password', $this->password, PDO::PARAM_STR);
		echo "c";
		$db->executeStatement();
		echo "c";
		$result = $db->stmt->fetch(PDO::FETCH_OBJ);
		echo "c";
		if (!$result) {
			echo "d";
			throw new Exception("wrong credentials");
		}

		$this->id = $result->id;
		echo "c";
		$_SESSION["id"] = $this->id;
	}

	public static function logout() {
		session_destroy();
	}

	public function get($id) {
		$db = new DB();
		$db->prepareStatement("SELECT `id`, `email`, `password` FROM `users` WHERE id=:id");
		$db->bindParam(':id', $id, PDO::PARAM_INT);
		$db->executeStatement();
		
		$result = $db->stmt->fetch();
		if (!$result) {
			throw new Exception("user not found");
		}
		
		$this->id = $result->id;
		$this->email = $result->email;
		$this->password = $result->password;
	}

	public function update() {
		$db = new DB();
		$db->prepareStatement("UPDATE `users` SET `email`=:email,`password`=:password WHERE `id`=:id");
		$db->bindParam(':id', $this->id, PDO::PARAM_INT);
		$db->bindParam(':email', $this->email, PDO::PARAM_STR);
		$db->bindParam(':password', $this->password, PDO::PARAM_STR);
		$db->executeStatement();
		
		if ($db->stmt->rowCount() == 0) {
			throw new Exception("user not found");
		}
	}

	public function insert() {
		$db = new DB();
		echo "b";
		$db->prepareStatement("INSERT INTO `users`(`email`, `password`) VALUES (:email,:password)");

		echo "b";
		$db->bindParam(':email', $this->email, PDO::PARAM_STR);

		echo "b";
		$db->bindParam(':password', $this->password, PDO::PARAM_STR);

		echo "b";
		$db->executeStatement();

		echo "b";
		$this->login();
	}

	public function delete() {
		$db = new DB();
		$db->prepareStatement("DELETE FROM `users` WHERE `id`=:id");
		$db->bindParam(':id', $this->id, PDO::PARAM_INT);
		$db->executeStatement();
		
		if ($db->stmt->rowCount() == 0) {
			throw new Exception("user not found");
		}
	}
}
