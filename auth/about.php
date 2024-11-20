<?php
session_start();

if (isset($_SESSION["login"])) {
  $username = $_SESSION["login"]; // Получаем логин из сессии
  $helloMessage = "Добро пожаловать,  {$username}, на страницу \"О нас!\"";
}

// TODO: current date, time, any metainfo from $_SERVER
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>О нас</title>
  <link rel="stylesheet" href="styles.css" />
</head>

<body>
  <main>
    <h1><?php echo $helloMessage; ?></h1>
    <p>Вы успешно авторизованы!</p>
    <p class="server-info"></p>
    <a href="index.php">
      <button class="button">Выйти</button>
    </a>
  </main>
</body>

</html>