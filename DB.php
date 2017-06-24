<?php 

class DB {
 	// Connect to database
	private static function connect() {

		$pdo = new PDO('mysql:host=localhost;dbname=SocialNetwork;charset=utf8', 'drupaluser', '');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;

	}
 	// Interaction with database
	public static function query($query, $params = array()) {

		// Prepare query with variables (Anti SQL injection)
		$statement = self::connect()->prepare($query);

		// Execute account while defining variables 
		$statement->execute($params);

		// Get only the select queries and return fetched data
		if (explode(' ', $query)[0] == 'SELECT') {
			$data = $statement->fetchAll();
			return $data;
		}
	}	
}




