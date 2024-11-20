<?php

function generateUniqueUser(int $count): array
{
  $names = [];
  for ($i = 1; $i <= $count; $i++) {
    $names[] = "user" . $i;
  }
  return $names;
}

$numberOfUsers = 10000;
$jsonFile = "users.json";

$users = [];
$plainPassword = "qwerty1234";
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

if (file_exists($jsonFile)) {
  $existingUsers = json_decode(file_get_contents($jsonFile), true);
  $existingCount = count($existingUsers);

  if ($existingCount >= $numberOfUsers) {
    // echo "В $jsonFile уже есть $numberOfUsers пользователей. Отмена создания.\n";
    exit;
  }

  $users = $existingUsers;
  $numberOfUsers -= $existingCount;
}

$logins = generateUniqueUser($numberOfUsers);
foreach ($logins as $login) {
  $users[] = [
    'username' => $login,
    'password' => $hashedPassword
  ];
  // echo $login . " " . $password . "\n";
}

file_put_contents($jsonFile, json_encode($users, JSON_PRETTY_PRINT));

// echo "Создано $numberOfUsers пользователей в $jsonFile\n";
