<?php

function createMap(): array
{
  $consonants = ['б', 'в', 'г', 'д', 'ж', 'з', 'к', 'л', 'м', 'н'];
  $mappedConsonants = ['щ', 'ш', 'ч', 'ц', 'х', 'ф', 'т', 'с', 'р', 'п'];

  $map = array_combine($consonants, $mappedConsonants);
  $keys = array_keys($map);
  $values = array_values($map);
  shuffle($values);
  $map = array_combine($keys, $values);

  $upperMap = array_combine(
    array_map('mb_strtoupper', $keys),
    array_map('mb_strtoupper', $values)
  );

  return array_merge($map, $upperMap);
}

function encrypt($originalText, $map): string
{
  $encryptedText = $originalText;

  foreach ($map as $consonant => $mappedConsonant) {
    $tempSymbol = uniqid();
    $encryptedText = str_replace($consonant, $tempSymbol, $encryptedText);
    $encryptedText = str_replace($mappedConsonant, $consonant, $encryptedText);
    $encryptedText = str_replace($tempSymbol, $mappedConsonant, $encryptedText);
  }

  return $encryptedText;
}

function decrypt($encryptedText, $map): string
{
  $reverseMapping = array_flip($map);

  $decryptedText = $encryptedText;

  foreach ($reverseMapping as $mappedConsonant => $consonant) {
    $tempSymbol = uniqid();
    $decryptedText = str_replace($mappedConsonant, $tempSymbol, $decryptedText);
    $decryptedText = str_replace($consonant, $mappedConsonant, $decryptedText);
    $decryptedText = str_replace($tempSymbol, $consonant, $decryptedText);
  }

  return $decryptedText;
}

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

  if ($originalText === $decryptedText) {
    echo "Тест: [✅ пройден]; Дешифрованный текст совпадает с исходным.\n";
  } else {
    echo "Тест: [❌ не пройден]; Дешифрованный текст НЕ совпадает с исходным.\n";
  }
  echo "-------------------------------\n";
}

$animal = "Крокодил";
testEncryptionDecryption($animal);
testEncryptionDecryption("Привет, Мир!");