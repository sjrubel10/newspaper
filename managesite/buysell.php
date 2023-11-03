<?php
/*$create_table_sal = "CREATE TABLE `movie`.`buysell` ( `ID` INT(11) NOT NULL AUTO_INCREMENT , `send_method` VARCHAR(128) NOT NULL , `receive_method` VARCHAR(128) NOT NULL , `send_amount` INT(11) NOT NULL , `receive_amount` INT(11) NOT NULL , `bKash_number` INT(15) NOT NULL , `bKash_tRX _ID` INT(28) NOT NULL , `skrill_email` VARCHAR(128) NOT NULL , `contact_no` INT(15) NOT NULL , `user_id` INT(11) NOT NULL , `recorded` TINYINT(1) NOT NULL DEFAULT '1' , `is_transaction_done` TINYINT(1) NOT NULL DEFAULT '0' , `admin_id` INT(11) NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB";*/

//echo "Here";
function insertData(  $conn ){
    $sendMethod = $_POST['send_method'];
    $receiveMethod = $_POST['receive_method'];
    $sendAmount = $_POST['send_amount'];
    $receiveAmount = $_POST['receive_amount'];
    $bKashNumber = $_POST['bKash_number'];
    $bKashTransactionID = $_POST['bKash_tRX_ID'];
    $skrillEmail = $_POST['skrill_email'];
    $contactNumber = $_POST['contact_no'];
    $userID = $_POST['user_id'];
    $recorded = $_POST['recorded'];

// Prepare the SQL statement
    $sql = $conn->prepare("INSERT INTO `buysell` (`send_method`, `receive_method`, `send_amount`, `receive_amount`, `bKash_number`, `bKash_tRX_ID`, `skrill_email`, `contact_no`, `user_id`, `recorded`) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Bind parameters
    $sql->bind_param("ssssssssss", $sendMethod, $receiveMethod, $sendAmount, $receiveAmount, $bKashNumber, $bKashTransactionID, $skrillEmail, $contactNumber, $userID, $recorded);

// Execute the statement
    if ($sql->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql->error;
    }
// Close the statement and connection
    $sql->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="form-container">
    <form id="myForm">
        <label for="sendMethod">Send Method:</label>
        <input type="text" id="sendMethod" name="send_method" required><br>

        <label for="receiveMethod">Receive Method:</label>
        <input type="text" id="receiveMethod" name="receive_method" required><br>

        <label for="sendAmount">Send Amount:</label>
        <input type="number" id="sendAmount" name="send_amount" required><br>

        <label for="receiveAmount">Receive Amount:</label>
        <input type="number" id="receiveAmount" name="receive_amount" required><br>

        <label for="bKashNumber">bKash Number:</label>
        <input type="text" id="bKashNumber" name="bKash_number" required><br>

        <label for="bKashTransactionID">bKash Transaction ID:</label>
        <input type="text" id="bKashTransactionID" name="bKash_tRX_ID" required><br>

        <label for="skrillEmail">Skrill Email:</label>
        <input type="email" id="skrillEmail" name="skrill_email" required><br>

        <label for="contactNumber">Contact Number:</label>
        <input type="tel" id="contactNumber" name="contact_no" required><br>

        <label for="userID">User ID:</label>
        <input type="text" id="userID" name="user_id" required><br>

        <label for="recorded">Recorded:</label>
        <input type="text" id="recorded" name="recorded" required><br>

        <button type="submit">Submit</button>
    </form>
</div>

<script src="script.js"></script>
</body>
</html>




