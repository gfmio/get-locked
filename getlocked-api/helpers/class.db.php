<?php

class DB {
	private $engine = 'mysql';
	private $host = "localhost";
	private $database = "db";
	private $user = "db_user";
	private $pass = "password";
	
	private $dns = null;
	private $pdo = null;

	protected $stmt = "";

	public function __construct() {
		$this->dns = $engine.':dbname='.$database.";host=".$host;
		$this->pdo = new PDO( $dns, $user, $pass );
	}

	public function prepareStatement($sql) {
		$this->stmt = $pdo->prepare($sql);
	}

	public function bindParam($parameter, $value, $type) {
		$this->stmt->bindParam($parameter, $value, $type);
	}

	public function executeStatement() {
		return $this->stmt->execute();
	}
}
