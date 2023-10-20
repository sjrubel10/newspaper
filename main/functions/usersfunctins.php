<?php
/**
 * Created by PhpStorm.
 * User: Sj
 * Date: 10/9/2023
 * Time: 10:40 PM
 */
function var_test_die( $data ){
    var_dump($data);
    die();
}
function getUserIdByProfileKey( $profileKey ) {
    $conn = Db_connect();

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT id FROM users WHERE profile_key = ?";
    $stmt = $conn->prepare($sql);
    if( $stmt ) {
        $stmt->bind_param("s", $profileKey);
        $stmt->execute();
        $stmt->bind_result($userId);
        $stmt->fetch();
        $stmt->close();

        $conn->close();
    }else{
        $userId = false;
    }

    return $userId;
}
function getUserIdByusername( $username ) {
    $conn = Db_connect();

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT id FROM users WHERE `username` = ?";
    $stmt = $conn->prepare( $sql );
    if( $stmt ){
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($userId);
        $stmt->fetch();
        $stmt->close();

        $conn->close();
    }else{
        $userId = false;
    }


    return $userId;
}

function getUserDataById( $userId ) {
    $conn = Db_connect();
    $sql = "SELECT * FROM users WHERE id = $userId";
    $stmt = $conn->prepare($sql);
//    $stmt->bind_param("i", $userId);
    if( $stmt ){
        $stmt->execute();
        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
    }else{
        $userData = [];
    }

    return $userData;
}

function user_registration( $user_input_data ){
    $conn = Db_connect();
    $username = $user_input_data['username'];
    $email = $user_input_data['email'];
    $password = password_hash($user_input_data['password'], PASSWORD_DEFAULT);
    $firstName = $user_input_data['firstName'];
    $lastName = $user_input_data['lastName'];
    $age = $user_input_data['age'];
    $gender = $user_input_data['gender'];
    $userkey = substr(md5($username.$email), 0, 8);

    $result = 0;
// Prepare the SQL statement with placeholders
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } else if (!ctype_alnum($username)) { // Ensure username contains only letters and numbers
        echo "Username can only contain letters and numbers.";
    } else {
        $sql = "INSERT INTO users ( `username`, `mail`, `userkey`, `password`, `first_name`, `last_name`, `age`, `gender` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )";
        $stmt = $conn->prepare($sql);
        if( $stmt ){
            $stmt->bind_param("ssssssis", $username, $email, $userkey, $password, $firstName, $lastName, $age, $gender );
            if ( $stmt->execute() ) {
                $result = 'User Account Successfully Created';
            } else {
                $result = 'User Account Created Fail';
            }
            $stmt->close();
            $conn->close();
        }else{
            $result = 'Database Error';
        }

    }

    return $result;
}

function getUsersData($conn, $limit = 20 ) {
    $usersData = array();

    // SQL query to select data from the users table
    $sql = "SELECT * FROM users ORDER BY `id` LIMIT $limit";

    // Execute the query
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result->num_rows > 0) {
        // Fetch data from each row and store it in the $usersData array
        while($row = $result->fetch_assoc()) {
            unset( $row['password']);
            unset( $row['id']);
            $usersData[] = $row;
        }
    }

    // Return the array containing users' data
    return $usersData;
}