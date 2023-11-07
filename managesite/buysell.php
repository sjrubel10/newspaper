<!--<script src="adminassets/js/buysell.js"></script>
<link rel="stylesheet" href="adminassets/css/buysellstyles.css">-->
<?php

/*$create_table_sal = "CREATE TABLE `movie`.`buysell` ( `ID` INT(11) NOT NULL AUTO_INCREMENT , `send_method` VARCHAR(128) NOT NULL , `receive_method` VARCHAR(128) NOT NULL , `send_amount` INT(11) NOT NULL , `receive_amount` INT(11) NOT NULL , `bKash_number` INT(15) NOT NULL , `bKash_tRX _ID` INT(28) NOT NULL , `skrill_email` VARCHAR(128) NOT NULL , `contact_no` INT(15) NOT NULL , `user_id` INT(11) NOT NULL , `recorded` TINYINT(1) NOT NULL DEFAULT '1' , `is_transaction_done` TINYINT(1) NOT NULL DEFAULT '0' , `admin_id` INT(11) NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB";

ALTER TABLE `buysell` CHANGE `admin_id` `admin_id` INT(11) NOT NULL DEFAULT '0';
ALTER TABLE `buysell` ADD `transaction_type` VARCHAR(8) NULL DEFAULT NULL AFTER `user_id`;
ALTER TABLE `buysell` ADD `transaction_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `admin_id`;
*/

//echo "Here";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Form</title>
    <link rel="stylesheet" href="adminassets/css/buysellstyles.css">
</head>
<body>
<div class="form-container">
    <form id="transaction-form">

        <label for="send_method">Send Method:</label>
        <select id="send_method" name="send_method" required>
            <option value="">Select Send Method</option>
            <option value="method1">Method 1</option>
            <option value="method2">Method 2</option>
            <option value="method3">Method 3</option>
        </select><br>

        <label for="receive_method">Receive Method:</label>
        <select id="receive_method" name="receive_method" required>
            <option value="">Select Receive Method</option>
            <option value="method1">Method 1</option>
            <option value="method2">Method 2</option>
            <option value="method3">Method 3</option>
        </select><br>

        <label for="send_amount">Send Amount:</label>
        <input type="number" id="send_amount" name="send_amount" required><br>

        <label for="receive_amount">Receive Amount:</label>
        <input type="number" id="receive_amount" name="receive_amount" required><br>

        <label for="bKash_number">bKash Number:</label>
        <input type="text" id="bKash_number" name="bKash_number" required><br>

        <label for="bKash_tRX_ID">bKash Transaction ID:</label>
        <input type="text" id="bKash_tRX_ID" name="bKash_tRX_ID" required><br>

        <label for="skrill_email">Skrill Email:</label>
        <input type="email" id="skrill_email" name="skrill_email" required><br>

        <label for="contact_no">Contact Number:</label>
        <input type="tel" id="contact_no" name="contact_no" required><br>

        <button type="submit">Submit</button>
    </form>
    <div id="response"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="adminassets/js/buysell.js"></script>
</body>
</html>


