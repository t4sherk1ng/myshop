<?php
require_once("db_connector.php");
class Shop_db extends db_connector {
	public static function sign_up($__login, $__password) {
		$result = '';
		if (self::query('SELECT * FROM users where login = ?', [$__login])) {
			$result = ['error' => ['code' => 0, 'text' => 'User already exists']];
		}
		else {
			$result = (self::insert_row('users', ['login' => $__login, 'password' => sha1($__password)]))
				? ["ok"] 
				: ["error" => ['code' => 1]];
		}
		return json_encode($result);
	}

	public static function sign_in($__login, $__password) {
		return self::query("SELECT * FROM users where login = ? and password = ?", [$__login, sha1($__password)]);
	}
}