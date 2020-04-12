<?php
class ADS
{
	private $db;

	function __construct($DB_connect)
	{
		$this->db = $DB_connect;
	}

	public function getAllAds()
	{
		try {
			$query = "SELECT ads.*, categories.name AS cat_name, users.type_id FROM ads"
				. " INNER JOIN users ON users.id = ads.user_id"
				. " INNER JOIN categories ON categories.id = ads.cat_id"
				. " ORDER BY ads.name;";

			$statement = $this->db->prepare($query);
			$statement->execute();
			return $statement->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $error) {
			echo $error->getMessage();
		}
	}
}
?>
