<?php

namespace App;

class Connection {

	public static function getDb() {
		try {

			$conn = new \PDO( //Quando se utiliza de recursos nativos do php, precisa indicar com a '\'
				"mysql:host=localhost;dbname=mvc;charset=utf8",
				"root",
				"" 
			);

			return $conn;

		} catch (\PDOException $e) {
			//.. tratar de alguma forma ..//
		}
	}
}
