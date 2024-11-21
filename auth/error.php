<?php
header('HTTP/1.1 404 Not Found');
http_response_code(404);
?>

<!DOCTYPE html>
<html lang="ru">

<l>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ошибка 404</title>
  <link rel="stylesheet" href="styles.css">
</l>

<body>
  <h1>404 Не найдено</h1>
  <p>Запрашиваемая страница не найдена</p>
  <a href="index.php">
    <button class="button">Вернуться на главную страницу</button>
  </a>
</body>

</html>