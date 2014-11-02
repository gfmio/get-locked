<?php

class User {
	public $email;

	public static function getCurrentUser() {
		
		throw new Exception("Not logged in.");
	}


}
