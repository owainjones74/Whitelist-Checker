<?php
require_once "..//functions/main.php";

header('Content-Type: application/json');

$job = GetWhitelists($_GET['job']);

if (!$job) {
    echo json_encode(["error" => "No job found with this name"]);
    exit;
}

$jobTbl = json_encode($job, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

echo str_replace(" ", "", $jobTbl);