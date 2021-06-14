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
	
	public static function get_goods() {
		return self::select_all('goods');
	}

	public static function get_orders_by_user($__user_login) {
		return self::query("SELECT orders.id FROM orders LEFT OUTER JOIN users on orders.user_id = users.id where login = ?", [$__user_login]);
	}

	public static function get_alive_order_id_by_user($__user_login) {
		$result = self::query("SELECT orders.id FROM orders LEFT OUTER JOIN users on orders.user_id = users.id where login = ? and is_alive = 1", [$__user_login]);
		return ($result) ? $result[0][0] : false;
	}

	public static function get_userid_by_login($__login) {
		return self::query("SELECT id FROM users where login = ?", [$__login])[0][0];
	}

	public static function add_user_order($__user_id) {
		return self::insert_row("orders", ["user_id" => $__user_id, "is_alive" => 1]);
	}

	public static function add_good_to_order($__user_login, $__good_id) {
		$alive_order = self::get_alive_order_id_by_user($__user_login);
		$order_id = ($alive_order) 
			? $alive_order
			: self::add_user_order(self::get_userid_by_login($__user_login));
		return self::insert_row("orders_goods", ["order_id" => $order_id, "good_id" => $__good_id]);
	}


}