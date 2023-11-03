<?php
/*$create_table_sal = "CREATE TABLE `movie`.`buysell` ( `ID` INT(11) NOT NULL AUTO_INCREMENT , `send_method` VARCHAR(128) NOT NULL , `receive_method` VARCHAR(128) NOT NULL , `send_amount` INT(11) NOT NULL , `receive_amount` INT(11) NOT NULL , `bKash_number` INT(15) NOT NULL , `bKash_tRX _ID` INT(28) NOT NULL , `skrill_email` VARCHAR(128) NOT NULL , `contact_no` INT(15) NOT NULL , `user_id` INT(11) NOT NULL , `recorded` TINYINT(1) NOT NULL DEFAULT '1' , `is_transaction_done` TINYINT(1) NOT NULL DEFAULT '0' , `admin_id` INT(11) NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB";*/

//echo "Here";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation</title>
    <link rel="stylesheet" href="adminassets/css/buysellstyles.css">
</head>
<body>
<div class="form-container">
    <form id="myForm" action="process.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="country">Country:</label>
        <select id="country" name="country" required>
            <option value="">Select Country</option>
            <option value="usa">USA</option>
            <option value="canada">Canada</option>
            <option value="uk">UK</option>
        </select><br>

        <button type="submit">Submit</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="script.js"></script>
</body>
</html>



