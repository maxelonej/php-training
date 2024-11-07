<?php

function createMap(): array
{
  $consonants = ['б', 'в', 'г', 'д', 'ж', 'з', 'к', 'л', 'м', 'н'];

  $mappedConsonants = ['щ', 'ш', 'ч', 'ц', 'х', 'ф', 'т', 'с', 'р', 'п'];

  $map = array_combine($consonants, $mappedConsonants);
  $keys = array_keys($map);
  $values = array_values($map);
  shuffle($keys);
  $map = array_combine($keys, $values);

  return $map;
}

function encrypt($text, $map): string
{
  $encryptedText = mb_strtolower($text);

  foreach ($map as $consonants => $mappedConsonants) {
    $encryptedText = str_replace($consonants, $mappedConsonants, $encryptedText);
  }

  return $encryptedText;
}

function decrypt($encryptedText, $map): string
{
  $reverseMapping = array_flip($map);
  $decryptedText = mb_strtolower($encryptedText);

  foreach ($reverseMapping as $mappedConsonants => $consonants) {
    $decryptedText = str_replace($mappedConsonants, $consonants, $decryptedText);
  }

  return $decryptedText;
}

$encryption = createMap();

$text = "Крокодил";
$encryptedText = encrypt($text, $encryption);
$decryptedText = decrypt($encryptedText, $encryption);
var_dump("Текст: " . $text);
var_dump("Зашифрованный текст: " . $encryptedText);
var_dump("Дешифрованный текст: " . $decryptedText);