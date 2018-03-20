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
for ($iTest=0; $iTest<$nbTests; $iTest++) {
    exec("timeout 3 ./temp/prog < ./temp/input$iTest 2>&1", $executionOutput, $res);

    $executionOutput = implode("\n", $executionOutput);

    if ($res == 124) { // Timeout
        $executionOutput = "[TIMEOUT]\n" . $executionOutput;
    }

    echo "\"output$iTest\": " . json_encode($executionOutput);

    if ($iTest < $nbTests-1) {
        echo ',';
    }
}

// Clean
exec('rm -r temp');

echo '}';