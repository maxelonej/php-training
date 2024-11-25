<?php
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST['text'])) {
    $error = "Поле 'Текст' не может быть пустым";
  }
  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $error = "Неверный формат почты";
  }
  if (!is_numeric($_POST['number'])) {
    $error = "Неверный формат числа";
  }
  if (empty($_POST['choice'])) {
    $error = "Выберите один из трех пунктов";
  }
  if (empty($_POST['gender'])) {
    $error = "Выберите гендер";
  }
  if (!isset($_POST['checkbox'])) {
    $error = "Подтвердите согласие на обработку";
  }
  if (empty($_POST['password'])) {
    $error = "Поле 'Пароль' не может быть пустым";
  }

  if (!$error) {
    $newData = [
      'date_time' => date('Y-m-d H:i:s'),
      'text' => $_POST['text'],
      'email' => $_POST['email'],
      'number' => $_POST['number'],
      'choice' => $_POST['choice'],
      'gender' => $_POST['gender'],
      'checkbox' => isset($_POST['checkbox']) ? true : false,
      'password' => $_POST['password'],
    ];

    $filePath = 'data.json';
    if (file_exists($filePath) && filesize($filePath) > 0) {
      $currentData = json_decode(file_get_contents($filePath), true);
      if (!is_array($currentData)) {
        $currentData = [];
      }
    } else {
      $currentData = [];
    }
    $currentData[] = $newData;
    file_put_contents($filePath, json_encode($currentData, JSON_PRETTY_PRINT));

    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector(".popup").classList.add("active");
        });
    </script>';
  }
}


?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Все инпуты</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <form class="form" action="index.php" method="post">
    <h3 class="title">Введите данные для генерации их в json формате</h3>
    <input type="text" name="text" id="text" placeholder="Текст">
    <input type="email" name="email" id="email" placeholder="Почта">
    <input type="number" name="number" id="number" placeholder="Число">
    <select name="choice" id="choice">
      <option value="none"></option>
      <option value="first">Первый</option>
      <option value="second">Второй</option>
      <option value="third">Третий</option>
    </select>
    <fieldset>
      <input type="radio" name="gender" id="male">
      <label for="male">Мужской</label>
      <input type="radio" name="gender" id="female">
      <label for="female">Женский</label>
    </fieldset>
    <fieldset>
      <input type="checkbox" name="checkbox" id="checkbox">
      <label for="checkbox">Подтверждение согласия на обработку</label>
    </fieldset>
    <input type="password" name="password" id="password">
    <p class="error">
      <?php echo $error; ?>
    </p>
    <a href="#"><button type="submit">Сформировать</button></a>
  </form>

  <div class="popup">
    <div class="success">
      <h3>Данные успешно сохранены!</h3>
      <p>Вы можете получить ваши введенные данные в json формате ниже</p>
      <a href="data.php"><button><?php echo $filePath; ?></button></a>
    </div>
  </div>

  <script>
    document.querySelector('.popup').addEventListener('click', (event) => {
      event.target.classList.remove('active');
    });
  </script>

</body>

</html>