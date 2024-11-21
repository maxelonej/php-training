<?php
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $login = trim($_POST["login"]);
  $password = trim($_POST["password"]);

  if (!file_exists("users.json")) {
    require_once "seeder.php";
  }

  $dbUsers = json_decode(file_get_contents("users.json"), true);
  $authenticated = false;
  foreach ($dbUsers as $dbUser) {
    if ($dbUser["username"] === $login && $password === $dbUser["password"]) {
      $authenticated = true;
      break;
    }
  }

  if ($authenticated) {
    session_start();
    $_SESSION["login"] = $login;
    header("Location: about.php");
    exit();
  } else {
    // echo "Логин в инпуте: " . $login . "<br>";
    // echo "Пароль в инпуте: " . $password . "<br>";
    // foreach ($dbUsers as $dbUser) {
    //   echo "Логин в бд: " . $dbUser["username"] . "<br>";
    //   echo "Пароль в бд: " . $dbUser["password"] . "<br>";
    //   break;
    // }
    $error = "Неправильный логин или пароль";
  }
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Авторизация</title>
  <link rel="stylesheet" href="styles.css" />
</head>

<body>
  <main>
    <form action="index.php" method="post">
      <fieldset>
        <legend>Авторизация</legend>
        <input type="text" name="login" placeholder="Логин" />
        <div class="password-toggle">
          <input type="password" name="password" placeholder="Пароль" />
          <input type="checkbox" class="toggle-password" id="toggle-password" />
          <label for="toggle-password" class="icon"></label>
        </div>
        <p class="error"><?php echo $error; ?></p>
        <button class="button" type="submit">Войти</button>
      </fieldset>
    </form>
  </main>
</body>
<script>
  const passwordInput = document.querySelector("input[name='password']");
  const showPassword = document.querySelector("label.icon");
  showPassword.addEventListener("click", () => {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      showPassword.src = "hide-password.svg";
    } else {
      passwordInput.type = "password";
      showPassword.src = "show-password.svg";
    }
  });
</script>

</html>