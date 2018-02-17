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

echo '{';

// Compile
exec('g++ -Wall -Wextra temp/main.cpp -o temp/prog 2>&1', $output);
echo '"compilationErrors": ' . json_encode(implode("\n", $output)) . ',';

// Run
exec('timeout 3 ./temp/prog < ./temp/test.in', $output, $res);
echo '"output": ' . json_encode(implode("\n", $output));

/*if ($res == 124) { // Timeout
    echo "[TIMEOUT]\n";
}*/

// Clean
exec('rm -r temp');

echo '}';