<?php include("dbconn.php");?>
<?php

    session_name("PHPSESSID");
    session_start();

    $data   = array();
    $hotels = array();
    $users  = array();
    $pivots = array();

    $conn = dbConnect();
    if ($conn->connect_errno) {
        echo "Error connecting to db" . $conn->connect_error;
    } else {
        mysqli_set_charset($conn, 'utf8');

        // retrieving all hotels
        $sql = mysqli_query($conn, "SELECT * FROM hotels;");
        while ($row = mysqli_fetch_assoc($sql)) {
            $hotels[] = array(
                "id" => $row["id"],
                "name" => $row["name"],
                "price" => $row["price"],
                "booked" => false,
                "approved" => false,
                "currentUserId" => 0
            );
        }
        mysqli_free_result($sql);
        
        // retrieving pivot table user_hotel
        // $sql = mysqli_query($conn, "SELECT * FROM user_hotel WHERE user_id='" . $_SESSION['id'] . "';");
        $sql = mysqli_query($conn, "SELECT * FROM user_hotel;");
        while ($row = mysqli_fetch_assoc($sql)) {
            $pivots[] = array(
                "user_id" => $row["user_id"],
                "hotel_id" => $row["hotel_id"],
                "approved" => $row["approved"]
            );
        }
        mysqli_free_result($sql);

        // retrieving all users
        $sql = mysqli_query($conn, "SELECT * FROM user WHERE type='2';");
        while ($row = mysqli_fetch_assoc($sql)) {
            $users[] = array(
                "id" => $row["id"],
                "fullname" => $row["fullname"],
                "username" => $row["username"],
                "type" => $row["type"]
            );
        }
        mysqli_free_result($sql);

    } // fin $conn true
    mysqli_close($conn);

    $data['hotels'] = $hotels;
    $data['users'] = $users;
    $data['pivots'] = $pivots;

    echo json_encode($data);
?>
