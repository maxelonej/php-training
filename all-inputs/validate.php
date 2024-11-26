<?php

// TODO: Add more validation logic

function isValid(array $errors): bool
{
  if (empty($_POST['text'])) {
    $errors[] = "Поле 'Текст' не может быть пустым";
  }
  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Неверный формат почты";
  }
  if (!is_numeric($_POST['number'])) {
    $errors[] = "Неверный формат числа";
  }
  if (empty($_POST['choice'])) {
    $errors[] = "Выберите один из трех пунктов";
  }
  if (empty($_POST['gender'])) {
    $errors[] = "Выберите гендер";
  }
  if (!isset($_POST['agree'])) {
    $errors[] = "Подтвердите согласие на обработку";
  }
  if (empty($_POST['password'])) {
    $errors[] = "Поле 'Пароль' не может быть пустым";
  }

  if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
  }

  return empty($errors);
}

?>