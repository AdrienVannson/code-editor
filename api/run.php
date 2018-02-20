<?php

$code = $_POST['code'];
$nbTests = $_POST['nbTests'];

// Save
mkdir('temp');

$sourceFile = fopen('temp/main.cpp', 'w');
fwrite($sourceFile, $code);
fclose($sourceFile);

for ($iTest=0; $iTest<$nbTests; $iTest++) {
    $inputFile = fopen('temp/input'.$iTest, 'w');
    fwrite($inputFile, $_POST['input'.$iTest]);
    fclose($inputFile);
}

echo '{';

// Compile
exec('g++ -Wall -Wextra temp/main.cpp -o temp/prog 2>&1', $compilationOutput);
echo '"compilationErrors": ' . json_encode(implode("\n", $compilationOutput)) . ',';

// Run
exec('timeout 3 ./temp/prog < ./temp/input0', $executionOutput, $res);

$executionOutput = implode("\n", $executionOutput);

if ($res == 124) { // Timeout
    $executionOutput = "[TIMEOUT]\n" . $executionOutput;
}

echo '"output": ' . json_encode($executionOutput);

// Clean
exec('rm -r temp');

echo '}';