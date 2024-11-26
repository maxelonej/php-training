<?php
session_start();

require_once("validate.php");
$filePath = 'data.json';

function generateData(): array
{
  return [
    'date_time' => date('Y-m-d H:i:s'),
    'text' => $_POST['text'],
    'email' => $_POST['email'],
    'number' => $_POST['number'],
    'choice' => $_POST['choice'],
    'gender' => $_POST['gender'],
    'agree' => isset($_POST['agree']),
    'password' => $_POST['password'],
  ];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  isValid($errors);
  // if valid then it means there is no errors and then we redirect to data.php
  // otherwise we show error messages by session
  if (!isset($_SESSION['errors'])) {
    $newData = generateData();
    $filePath = 'data.json';

    if (file_exists($filePath) && filesize($filePath) > 0) {
      $currentData = json_decode(file_get_contents($filePath), true);
      if (!is_array($currentData)) {
        $currentData = [];
      }
    } else {
      file_put_contents($filePath, json_encode([]));
      $currentData = [];
    }

    $currentData[] = $newData;
    file_put_contents($filePath, json_encode($currentData, JSON_PRETTY_PRINT));

    echo '<script> document.addEventListener("DOMContentLoaded", () => { document.querySelector(".popup").classList.add("active"); }); </script>';
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
      <input type="radio" name="gender" id="male" value="male">
      <label for="male">Мужской</label>
      <input type="radio" name="gender" id="female" value="female">
      <label for="female">Женский</label>
    </fieldset>
    <fieldset>
      <input type="checkbox" name="agree" id="agree">
      <label for="agree">Подтверждение согласия на обработку</label>
    </fieldset>
    <input type="password" name="password" id="password">
    <p class="error">
      <?php
      if (isset($_SESSION['errors'])) {
        echo implode('<br>', $_SESSION['errors']);
        unset($_SESSION['errors']);
      }
      ?>
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