<?php include("dbconn.php");?>
<?php

    session_name("PHPSESSID");
    session_start();

    // $user_id = $_SESSION['id'];
    $hotel = json_decode($_POST['myData']);

    $conn = dbConnect();
    if ($conn->connect_errno) {
        echo "Error connecting to db" . $conn->connect_error;
    } else {
        mysqli_set_charset($conn, 'utf8');

        if($hotel->booked == false) {
            $sql = mysqli_query($conn, "DELETE FROM user_hotel WHERE user_id='" . $hotel->currentUserId ."' AND hotel_id='" . $hotel->id . "';");
        } else {
            $sql = mysqli_query($conn, "INSERT INTO user_hotel VALUES('" . $hotel->currentUserId . "', '" . $hotel->id . "', '0');");

            if ($hotel->approved == true) {
                $sql = mysqli_query($conn, "UPDATE user_hotel SET approved='1' WHERE user_id='" . $hotel->currentUserId . "' AND hotel_id='" . $hotel->id . "';");
            }
        }

    } // fin $conn true
    mysqli_close($conn);

    echo json_encode($hotel);
?>
