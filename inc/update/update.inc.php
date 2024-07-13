<?php // update.inc.php

require_once __DIR__ . "/../db/db_connect.inc.php";
require_once __DIR__ . "/../functions/functions.inc.php";
require_once __DIR__ . "/../app/config.inc.php";

$first = null;
$last = null;
$student_id = null;
$email = null;
$phone = null;
$degree = null;
$gpa = null;
$faid = null;
$id = null;
$graduation = null;

$error_bucket = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    // First insure that all required fields are filled in
    if (empty($_POST["first"])) {
        array_push($error_bucket, "<p>A first name is required.</p>");
    } else {
        $first = $_POST["first"];
    }
    if (empty($_POST["last"])) {
        array_push($error_bucket, "<p>A last name is required.</p>");
    } else {
        $last = $_POST["last"];
    }
    if (empty($_POST["student_id"])) {
        array_push($error_bucket, "<p>A student ID is required.</p>");
    } else {
        $student_id = intval($_POST["student_id"]);
    }
    if (empty($_POST["email"])) {
        array_push($error_bucket, "<p>An email address is required.</p>");
    } else {
        $email = $_POST["email"];
    }
    if (empty($_POST["phone"])) {
        array_push($error_bucket, "<p>A phone number is required.</p>");
    } else {
        $phone = $_POST["phone"];
    }
    // add additional fields
    if (empty($_POST["faid"])) {
        $faid = 0;
    } else {
        $faid = intval($_POST["faid"]);
    }
    if (empty($_POST["gpa"])) {
        $gpa = 0;
    } else {
        $gpa = floatval($_POST["gpa"]);
    }
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
    // new optional field
    if (!empty($_POST["graduation"])) {
        $graduation = $_POST["graduation"];
    } else {
        $graduation = null;
    }
}
if (count($error_bucket) == 0) {
    // update order with no errors
    $sql = "UPDATE $db_table SET first_name = :first_name, last_name = :last_name, student_id = :student_id, email = :email, phone = :phone, financial_aid = :faid, gpa = :gpa, degree_program = :degree, graduation_date = :graduation WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute(["first_name" => $first, "last_name" => $last, "student_id" => $student_id, "email" => $email, "phone" => $phone, "faid" => $faid, "gpa" => $gpa, "degree" => $degree, "graduation" => $graduation, "id" => $id]);

    if ($stmt->rowCount() == 1) {
        header("Location: display-records.php?message=The record for has been updated for <ul class= \"mb-0\"><li>Student: $first $last</li><li>Student ID: $student_id</li></ul>");
    }
} else {
    display_error_bucket($error_bucket);
}

if (!isset($id)) {
    $id = $_GET["id"];
}
$sql = "SELECT * FROM $db_table WHERE id=:id";
$stmt = $db->prepare($sql);
$stmt->execute(["id" => $id]);
$student_records = $stmt->fetch();

$first = $student_records->first_name;
$last = $student_records->last_name;
$student_id = $student_records->student_id;
$email = $student_records->email;
$phone = $student_records->phone;
$degree = $student_records->degree_program;
$gpa = $student_records->gpa;
$faid = $student_records->financial_aid;
$graduation = $student_records->graduation_date;
