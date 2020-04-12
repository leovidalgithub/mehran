<?php
class CATEGORIES
{
	private $db;

	function __construct($DB_connect)
	{
		$this->db = $DB_connect;
	}

	public function getAllCategories()
	{
		try {
			$query = "SELECT * FROM categories ORDER BY name;";

			$statement = $this->db->prepare($query);
			$statement->execute();
			return $statement->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $error) {
			echo $error->getMessage();
		}
	}
}
?>
