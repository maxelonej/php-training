<?php

// Создание мапы для шифра
function createMap(): array
{
  $consonants = ['б', 'в', 'г', 'д', 'ж', 'з', 'к', 'л', 'м', 'н'];
  $mappedConsonants = ['щ', 'ш', 'ч', 'ц', 'х', 'ф', 'т', 'с', 'р', 'п'];

  // Мапа ("согласная":"зашифрованная согласная согласно простой литореи")
  $map = array_combine($consonants, $mappedConsonants);
  $keys = array_keys($map); // Согласные
  $values = array_values($map); // Зашифрованные согласные
  // Перемешивание зашифрованных согласных, вместо простой литореи - рандом
  shuffle($values);
  // Мапа ("согласная":"рандом зашифрованная согласная")
  $map = array_combine($keys, $values);

  /*
    Добавление в мапу согласных и к ним
    зашифрованных согласных в виде верхнего регистра
  */
  $upperMap = array_combine(
    array_map('mb_strtoupper', $keys),
    array_map('mb_strtoupper', $values)
  );

  return array_merge($map, $upperMap);
}

// Шифрование
function encrypt($originalText, $map): string
{
  /*
  echo "Исходный текст: $text\n";
  echo "Карта шифрования: ";
  print_r($map);
  */

  $encryptedText = $originalText;

  // Проход по карте шифрования и замена символов
  foreach ($map as $consonant => $mappedConsonant) {
    // Генерирование уникального символа
    $tempSymbol = uniqid();
    // Замена согласной на уникальный символ
    $encryptedText = str_replace($consonant, $tempSymbol, $encryptedText);
    // Замена зашифрованной согласной на уникальный символ
    $encryptedText = str_replace($mappedConsonant, $consonant, $encryptedText);
    // Шифрование согласной
    $encryptedText = str_replace($tempSymbol, $mappedConsonant, $encryptedText);
  }

  return $encryptedText;
}

// Дешифрование
function decrypt($encryptedText, $map): string
{
  $reverseMapping = array_flip($map);
  /*
  echo "Зашифрованный текст: $encryptedText\n";
  echo "Карта дешифрования: ";
  print_r($reverseMapping);
  */

  $decryptedText = $encryptedText;

  // Проход по карте дешифрования и замена символов
  foreach ($reverseMapping as $mappedConsonant => $consonant) {
    // Генерирование уникального символа
    $tempSymbol = uniqid();
    // Замена зашифрованной согласной на уникальный символ
    $decryptedText = str_replace($mappedConsonant, $tempSymbol, $decryptedText);
    // Замена согласной на уникальный символ
    $decryptedText = str_replace($consonant, $mappedConsonant, $decryptedText);
    // Расшифрование
    $decryptedText = str_replace($tempSymbol, $consonant, $decryptedText);
  }

  return $decryptedText;
}

// Тестирование шифрования, дешифрования
function testEncryptionDecryption($originalText)
{
  $encryptionMap = createMap();
  $encryptedText = encrypt($originalText, $encryptionMap);
  $decryptedText = decrypt($encryptedText, $encryptionMap);

  echo "\n-------------------------------";
  echo "\n\t\t\tТестирование текста '$originalText' на шифр и дешифр!\n";
  printf("Исходный текст: %s\n", $originalText);
  printf("Зашифрованный текст: %s\n", $encryptedText);
  printf("Дешифрованный текст: %s\n", $decryptedText);

  // Оригинальный текст совпадает с дешифром, тогда/иначе
  if ($originalText === $decryptedText) {
    echo "Тест: [✅ пройден]; Дешифрованный текст совпадает с исходным.\n";
  } else {
    echo "Тест: [❌ не пройден]; Дешифрованный текст НЕ совпадает с исходным.\n";
  }
  echo "-------------------------------\n";
}

$animal = "Крокодил"; // Пример текста для шифра
testEncryptionDecryption($animal); // Тестирование шифра, дешифра
testEncryptionDecryption("Привет, Мир!");