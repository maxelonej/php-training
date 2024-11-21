<?php
session_start();

if (isset($_SESSION["login"])) {
  $login = $_SESSION["login"];
  $helloMessage = "Добро пожаловать,  {$login}, на страницу 'О нас!'";

  $currentDateTime = date('Y-m-d H:i:s');

  $serverName = $_SERVER['SERVER_NAME'];
  $requestMethod = $_SERVER['REQUEST_METHOD'];
  $userAgent = $_SERVER['HTTP_USER_AGENT'];
  $remotePort = $_SERVER['REMOTE_PORT'];
  $clientIP = $_SERVER['REMOTE_ADDR'];
  $requestURI = $_SERVER['REQUEST_URI'];
  $protocol = $_SERVER['SERVER_PROTOCOL'];
  $scriptName = $_SERVER['SCRIPT_NAME'];
  $hostName = $_SERVER['HTTP_HOST'];
  $httpStatus = http_response_code();
  $serverPort = $_SERVER['SERVER_PORT'];
  $phpVersion = phpversion();

  $metaInfo = [
    "Сервер" => $serverName,
    "Метод запроса" => $requestMethod,
    "User-Agent" => $userAgent,
    "IP-адрес клиента" => $clientIP,
    "Удаленный порт" => $remotePort,
    "URI запроса" => $requestURI,
    "Протокол" => $protocol,
    "Имя скрипта" => $scriptName,
    "Имя хоста" => $hostName,
    "HTTP статус" => $httpStatus,
    "Порт сервера" => $serverPort,
    "Текущая дата и время" => $currentDateTime,
    "Версия PHP" => $phpVersion,
  ];
}
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

    <?php
    if (!empty($metaInfo)) {
      echo "<table class='meta-table'>";
      echo "<tr><th>Параметр</th><th>Значение</th></tr>";

      foreach ($metaInfo as $key => $value) {
        echo "<tr><td>{$key}</td><td>{$value}</td></tr>";
      }

      echo "</table>";
    }
    ?>

    <a href="index.php">
      <button class="button">Выйти</button>
    </a>
  </main>
</body>

</html>