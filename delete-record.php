<?php // delete-record.php

require_once __DIR__ . "/inc/db/db_connect.inc.php";
require_once __DIR__ . "/inc/app/config.inc.php";

// check to see if id is in the query string
if (isset($_GET["id"])) {
    // Build SQL for delete with placeholder for id
    $sql = "DELETE FROM $db_table WHERE id=:id LIMIT 1";
    // Prepare the statement
    $stmt = $db->prepare($sql);
    // Execute the query
    $stmt->execute(["id" => $_GET["id"]]);
    // If you get a row back you successfully deleted the record
    $result = $stmt->rowCount();
    if ($result) {
        // if successfully, redirect the user to the display-records.php page with a parameter
        header('location: display-records.php?message=I%20 successfully%20deleted%20that%20record%20for%20you.');
    } else {
        echo '<h1 class="display-5">Please do not play with our site. GO AWAY!</h1>';
    }
}
