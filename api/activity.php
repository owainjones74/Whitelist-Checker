<?php
require_once "../functions/main.php";

header('Content-Type: application/json');

$id = $_GET['id'];
$job = $_GET['job'];

if (!$id) {
    echo json_encode(["error" => "No ID given."]);
    exit;
}
if (!$job) {
    echo json_encode(["error" => "No job given."]);
    exit;
}

$category = NULL;

$finder = [
    "pd" => "Police",
    "sd" => "Sheriff",
    "fbi" => "FBI",
    "swat" => "SWAT",
    "usms" => "Marshal",
    "firerescue" => "Firefighter",
    "terrorist" => "Terrorist ",
    "mafia" => "Mafia"
];

foreach($finder as $key => $value) {
    if (!(strpos($job, $value) === false)) {
        $category = $key;
        break;
    }
}

if (!$category) {
    echo json_encode(["error" => "Could not find category from job!"]);
    exit;
}


$activity = GetActivity($id, $category);

if (!$activity) {
    echo json_encode(["error" => "No activity found!"]);
    exit;
}

$activityTbl = json_encode($activity, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

echo $activityTbl;