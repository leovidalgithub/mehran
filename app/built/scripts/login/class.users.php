<?php
class USERS
{
	private $db;

	function __construct($DB_connect)
	{
		$this->db = $DB_connect;
	}
 
	public function registerNewUser($username, $password, $name, $address, $phone, $email, $type)
	{
		try
		{
			$stmt = $this->db->prepare("INSERT INTO users (`username`, `password`, `name`, `address`, `phone`, `email`, `type_id`) 
											VALUES(:username, :password, :name, :address, :phone, :email, :type);");

			$stmt->bindparam(":username", $username);
			$stmt->bindparam(":password", $password);
			$stmt->bindparam(":name", $name);
			$stmt->bindparam(":address", $address);
			$stmt->bindparam(":phone", $phone);
			$stmt->bindparam(":email", $email);
			$stmt->bindparam(":type", $type);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $error)
		{
			echo $error->getMessage();
		}
	}

	public function isUsernameAlreadyTaken($username)
	{
		try {
			$stmt = $this->db->prepare("SELECT * FROM users WHERE username=:username;");
			$stmt->bindparam(":username", $username);
			$stmt->execute();
			// $row = $stmt->fetch(PDO::FETCH_ASSOC);
			$rows = $stmt->fetchAll();
			return count($rows) > 0;
		} catch (PDOException $error) {
			echo 'error = ' . $error->getMessage();
		}
	}

	public function isLoginCorrect($username, $password)
	{
		try
		{
			$stmt = $this->db->prepare("SELECT * FROM users WHERE username=:username AND password=:password LIMIT 1;");
			$stmt->execute(array(':username'=>$username, ':password'=>$password));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);

			if($stmt->rowCount() > 0)
			{
				$_SESSION['username'] = $row["username"];
				$_SESSION['usertype'] = $row['type_id'];
				$_SESSION['start'] = time() + (30 * 60);
				return true;
			}
			return false;
		}
		catch(PDOException $error)
		{
			echo $error->getMessage();
		}
	}













   public function get_all_members()
   {
      $type_of_user = 'member';
      $stmt = $this->db->prepare("SELECT * FROM ad_members WHERE  type_of_user=:type_of_user ");
      $stmt->execute(array(':type_of_user'=>$type_of_user));
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

  public function delete_member($id)
  {
    try
       {
        $stmt = $this->db->prepare("DELETE FROM ad_members WHERE id=:id ");
        $stmt->execute(array(':id'=>$id));
        return true;
      } catch(PDOException $e) {
           echo $e->getMessage();
       }
  }

  public function update_member($name,$address,$city,$state,$phone,$status, $id)
  {
    try{
      $stmt = $this->db->prepare("UPDATE ad_members SET name=:name, address=:address, city=:city, state=:state, phone=:phone, status=:status WHERE id=:id ");
        $stmt->execute(array(':id'=>$id, ':name'=>$name, ':address'=>$address, ':city'=>$city, ':state'=>$state, ':phone'=>$phone, ':status'=>$status ));
        return true;

    } catch(PDOException $e)
       {
           echo $e->getMessage();
    }
  }

  public function is_loggedin()
  {
      if(isset($_SESSION['member_id']))
      {
         return true;
      }
  }
 
   public function redirect($url)
   {
       header("Location: $url");
   }
 
   public function logout()
   {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
   }
}
?>