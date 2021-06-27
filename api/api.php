<?php
require_once("db.php");
$request = $_REQUEST;
$print = "";
switch ($request["method"]) {
	case 'sign_in':
		if (Shop_db::sign_in($request['login'], $request['password'])) {
			session_start();
			$print = json_encode(['ok', $request['login']]);
		}
		else {
			$print = json_encode(['error']);
		}
		break;
	case 'sign_up':
		$print = Shop_db::sign_up($request['login'], $request['password']);
		break;
	case 'get_all_products':
		$print = json_encode(Shop_db::get_goods());
		break;
	case 'buy':
		$print = Shop_db::add_good_to_order($request['login'], $request['good_id']);
		break;
	case 'get_trash':
		$print = json_encode(Shop_db::get_goods_from_order(Shop_db::get_alive_order_id_by_user($request['login'])));
		break;

	default:
		$print = json_encode(["Default"]);
		break;
}
print($print);