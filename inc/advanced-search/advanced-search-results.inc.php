<?php // advanced-search-results.inc.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<h2>Search Results</h2>";
    // basic string
    $sql = "SELECT * FROM $db_table WHERE ";
    $search_data = [];
    // data check
    if (!empty($_POST["first"])) {
        array_push($search_data, "first_name LIKE {$db->quote($_POST["first"] . '%')}");
    }
    if (!empty($_POST["last"])) {
        array_push($search_data, "last_name LIKE {$db->quote($_POST["last"] . '%')}");
    }
    if (!empty($_POST["student_id"])) {
        array_push($search_data, "student_id = {$_POST["student_id"]}");
    }
    if (!empty($_POST["email"])) {
        array_push($search_data, "email LIKE {$db->quote($_POST["email"] . '%')}");
    }
    if (!empty($_POST["phone"])) {
        array_push($search_data, "phone LIKE {$db->quote('%' .$_POST["phone"] . '%')}");
    }
    if (!empty($_POST["gpa"])) {
        array_push($search_data, "gpa = {$_POST["gpa"]}");
    }
    if (!empty($_POST["graduation"])) {
        array_push($search_data, "graduation_date = {$db->quote($_POST["graduation"])}");
    }
    // forced searches every time
    // change if time allows
    if ($_POST["degree"] == "CBAS") {
        $degree = "BAS Cybersecurity";
    } elseif ($_POST["degree"] == "AFASA") {
        $degree = "AFA Studio Arts";
    } elseif ($_POST["degree"] == "AATWD") {
        $degree = "AAT Web Development";
    } elseif ($_POST["degree"] == "AATDMA") {
        $degree = "AAT Digital Media Arts";
    } elseif ($_POST["degree"] == "AATCS") {
        $degree = "AAT Computer Support";
    } else {
        $degree = "Undeclared";
    }
    array_push($search_data, "degree_program = {$db->quote($degree)}");
    array_push($search_data, "financial_aid = {$db->quote($_POST["faid"])}");



    // create query
    $sql = $sql . implode(" and ", $search_data);
    // gather data and display
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();
    display_record_table($results);
} else {
    echo '<div class="alert alert-info">';
    echo '<h2>Search results will appear here</h2>';
    echo '</div>';
}
