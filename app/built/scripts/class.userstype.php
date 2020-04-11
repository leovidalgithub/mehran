<?php
	class USERSTYPE
	{
		private $db;

		function __construct($DB_connect)
		{
			$this->db = $DB_connect;
		}

		public function getAllUsersType()
		{
			try {
				$stmt = $this->db->prepare("SELECT * FROM usertype;");
				$stmt->execute();
				return $stmt;
			} catch (PDOException $error) {
				echo $error->getMessage();
			}
		}
	}
?>