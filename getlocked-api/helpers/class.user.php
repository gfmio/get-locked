<?php

class User {
	static private $salt = '&2#NGKiszuAvq>%+JZs98}K8nN6G4wqRF>C?3=nE.ayRZH92Y7';

	protected $email;
	protected $locks = array();

	public static function encrypt($code) {
		return sha1($salt.$code);
	}

	public static function getCurrentUser() {
		throw new Exception("Not logged in.");
	}

	public static function login($email, $password) {

	}

	public static function logout() {

	}

	public function get($id) {

	}

	public function update($id) {

	}

}
