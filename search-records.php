<?php // search-records.php

$pageTitle = "Search Records";
require_once 'inc/layout/header.inc.php';
require_once 'inc/db/db_connect.inc.php';
require_once 'inc/functions/functions.inc.php';
require_once 'inc/app/config.inc.php';
?>

<div class="container">
    <div class="row">
        <div class="col-lg-12 mt-4">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (!empty($_POST["search"])) {
                    $sql = "SELECT * FROM $db_table WHERE :search IN (first_name, last_name) ORDER BY last_name ASC";
                    $stmt = $db->prepare($sql);
                    $stmt->execute(["search" => $_POST["search"]]);
                    $results = $stmt->fetchAll();

                    if ($stmt->rowCount() == 0) {
                        echo "<p class=\"display-4 mt-4 text-center\">No results found for \"<strong>{$_POST["search"]}</strong>\"</p>";
                        echo '<img class="mx-auto d-block mt-4" src="img/frown.png" alt="A sad face">';
                        echo "<p class=\"display-4 mt-4 text-center\">Please try again.</p>";
                        // echo "<h2 class=\"mt-4\">There are currently no records to display for <strong>last names</strong> starting with <strong>$filter</strong></h2>";
                    } else {
                        echo "<h2 class=\"mt-4 text-center\">{$stmt->rowCount()} record(s) found for \"" . $_POST["search"] . '"</h2>';
                        display_record_table($results);
                    }
                } else {
                    echo "<p class=\"display-4 mt-4 text-center\">I can't search if you don't give<br>me something to search for.</p>";
                    echo '<img class="mx-auto d-block mt-4" src="img/nosmile.png" alt="A face with no smile">';
                }
            }
            ?>
        </div>
    </div>
</div>

<?php require 'inc/layout/footer.inc.php'; ?>