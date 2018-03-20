<?php

include_once('../model/projects.php');

$name = $_POST['name'];
$code = $_POST['code'];

$project = getProject($name);
$project->init();
$project->setCode($code);

$nbTests = $_POST['nbTests'];

for ($iTest=0; $iTest<$nbTests; $iTest++) {
    $project->setTest($iTest, $_POST['test'.$iTest]);
}
