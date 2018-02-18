<?php

include_once('../model/projects.php');

$name = $_POST['name'];
$code = $_POST['code'];

$project = getProject($name);
$project->init();
$project->setCode($code);
