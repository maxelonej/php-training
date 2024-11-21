<?php

header('Content-Type: application/json');

$dbUsers = file_get_contents('users.json');
$accounts = json_decode($dbUsers, true);

$count = isset($_GET['count']) ? $_GET['count'] : 5;
$count = min($count, count($accounts));

$slicedAccounts = array_slice($accounts, 0, $count);

echo json_encode($slicedAccounts);
