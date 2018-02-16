<?php

$code = $_POST['code'];
$input = $_POST['input'];

// Save
mkdir('temp');

$sourceFile = fopen('temp/main.cpp', 'w');
fwrite($sourceFile, $code);
fclose($sourceFile);

$inputFile = fopen('temp/test.in', 'w');
fwrite($inputFile, $input);
fclose($inputFile);


// Compile
exec('g++ -Wall -Wextra temp/main.cpp -o temp/prog');

// Run
exec('./temp/prog < ./temp/test.in', $output);
echo implode('\n', $output);

// Clean
exec('rm -r temp');