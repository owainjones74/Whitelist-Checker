<?php
require_once "..//functions/main.php";

header('Content-Type: application/json');

$name = GetName($_GET['id']);

if (!$name) {
    echo json_encode(["error" => "No user found with this ID"]);
    exit;
}

echo $name;