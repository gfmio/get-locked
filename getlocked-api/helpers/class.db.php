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
		$this->dns = $this->engine.':dbname='.$this->database.";host=".$this->host;
		$this->pdo = new PDO( $this->dns, $this->user, $this->pass );
	}

	public function prepareStatement($sql) {
		$this->stmt = $this->pdo->prepare($sql);
	}

	public function bindParam($parameter, $value, $type) {
		$this->stmt->bindParam($parameter, $value, $type);
	}

	public function executeStatement() {
		$this->stmt->execute();
		return $this->stmt;
	}
}
