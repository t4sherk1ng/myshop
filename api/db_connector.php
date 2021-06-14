<?php

class db_connector 
{
	static private $db_host = 'localhost';
	static private $db_user = 'root';
	static private $db_password = '';
	static private $db_name = 'shop';
	static private $db;

	static public function connect() {
		self::$db = mysqli_connect(self::$db_host, self::$db_user, self::$db_password, self::$db_name);
		return self::$db;
	}

	static public function close_connection() {
		mysqli_close(self::$db);
	}

	static private function get_type_str($__params_arr) {
		$types = '';
		foreach ($__params_arr as $key => $value) {
			$types .= gettype($value)[0]; 
		}
		return $types;
	}

	static public function query($__sql, $__params_arr=null) {
		self::connect();
		$query = self::$db->prepare($__sql);
		if ($query) {
			if ($__params_arr) {
				$query->bind_param(self::get_type_str($__params_arr), ...$__params_arr);
			}
			$query->execute();
			if ($result=$query->get_result()) {
				return $result->fetch_all();
			}
			return True;
		}
		self::close_connection();
		return false;
	} 

	static public function create_table($__table_name, $__columns_arr) {
		//CREATE TABLE table (column_1 integer, column2 string)
		// [
		// 	column_name=>[datatype, ]
		// ]
		$columns = [];
		foreach ($__columns_arr as $column_name => $attribute_list) {
			$columns[] = $column_name.' '.implode(' ', $attribute_list);
		}
		$columns_str = '('.implode(', ', $columns).')';
		$sql = "CREATE TABLE ".$__table_name.' '.$columns_str.';';
		return self::query($sql);
	}

	static public function drop_table($__table_name) {
		$sql = "DROP TABLE ".$__table_name;
		return self::query($sql);
	}

	static public function insert_row($__table_name, $__values_arr) {
		$columns = '('.implode(', ', array_keys($__values_arr)).')';
		$params_arr = '('.implode(', ', array_fill(0, count($__values_arr), '?')).')';
		$sql = "INSERT INTO ".$__table_name.' '.$columns." VALUES ".$params_arr;
		$result = self::query($sql, array_values($__values_arr));
		return ($result) 
			? self::query("SELECT id FROM ".$__table_name." order by id desc limit 1")[0][0] 
			: false;
	}

	static public function update_table($__table_name, $__values_arr, $__condition_arr=null) {
		//UPDATE test SET field1 = value1, field2 = value2 WHERE id > 3 and id < 7
		//$__condition_arr = [">" => ["id", 3]]
		//$__values_arr = ["field1"]
		$arr = [];
		foreach ($__values_arr as $key => $value) {
			$arr[] = $key.'='.$value;
		}
		$set_arr = implode(', ', $arr);
		$sql = "UPDATE ".$__table_name." SET ".$set_arr;
	}

	static public function select_all($__table_name) {
		$sql = "SELECT * FROM ".$__table_name;
		return self::query($sql);
	}

	static public function get_table_head($__table_name) {
		$sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$__table_name."'";
		$table_head = self::query($sql);
		$result = [];
		foreach ($table_head as $array) {
			$result[] = $array[0];
		}
		return $result;
	}

	
}


