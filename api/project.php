<?php
include_once('../model/Project.php');

$name = $_GET['name'];
$path = '../projects/' . $name;

$project = new Project($path);

echo '{';

echo '"code": ' . json_encode($project->getCode()) . ',';
echo '"tests": [';

$tests = $project->getTests();

foreach ($tests as $key => $test) {
    echo json_encode($test);

    if ($key < count($tests)-1) {
        echo ',';
    }
}

echo ']';

echo '}';